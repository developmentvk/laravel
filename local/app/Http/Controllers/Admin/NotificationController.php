<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class NotificationController extends AdminController
{
    public function getIndex()
    {
        return view('admin.notification.index');
    }
    public function getListings()
    {
        $notification = \App\Models\Notifications::select('*');
        return \DataTables::of($notification)
            ->editColumn('created_at', function ($query) {
                return formatTimestamp($query->created_at, 'Y-m-d H:i:s');
            })
            ->addColumn('limit_title', function ($query) {
                return \Str::limit($query->title, 30);
            })
            ->addColumn('limit_message', function ($query) {
                return \Str::limit($query->message, 145);
            })
            ->make();
    }
    public function getSend()
    {
        return view('admin.notification.send');
    }
    public function postSend(Request $request)
    {
        $dataArr = arrayFromPost(['title', 'message', 'send_notification', 'user_id']);
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required',
            'send_notification' => 'required|in:0,1',
            'user_id' => 'nullable|array',
        ]);
        try {
            \DB::beginTransaction();

            $notification = new \App\Models\Notifications();
            $notification->notification_type = 'admin';
            $notification->title = $dataArr->title;
            $notification->message = $dataArr->message;
            $notification->save();

            $notifyArr = new \stdClass;
            $notifyArr->store_notification = 0;
            $notifyArr->from_id = null;
            $notifyArr->notify_type = $notification->notification_type;
            $notifyArr->attribute = null;
            $notifyArr->value = null;
            $notifyArr->title = $notification->title;
            $notifyArr->message = $notification->message;

            $notification_id = $notification->id;

            $toUserID = array();
            if (is_array($dataArr->user_id) && count($dataArr->user_id)) {
                $toUserID = $dataArr->user_id;
            } else {
                $toUserID = \App\Models\User::where(["status" => 'Active'])->where('is_deleted', 0)->pluck('id')->toArray();
            }

            if ($notification_id && count($toUserID)) {
                foreach ($toUserID as $user_id) {
                    $userNotifications = new \App\Models\UserNotifications();
                    $userNotifications->notification_id = $notification_id;
                    $userNotifications->user_id = $user_id;
                    $userNotifications->save();
                }
            }
            $notifyArr->to_id = $toUserID;
            \Event::dispatch(new \App\Events\TriggerNotification($notifyArr));

            \DB::commit();
            return successMessage('notification_saved');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getDelete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $notification = \App\Models\Notifications::find($request->id);
            if ($notification) {
                $notification->delete();
            }
            \DB::commit();
            return successMessage('notification_deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function filterNotificationUsers(Request $request)
    {
        try {
            $output = new \stdClass();
            $output->incomplete_results = false;
            $output->items = array();
            $output->total_count = 0;
            $query = \App\User::select(['id', 'name'])
                ->where(["status" => 'Active']);
            if (!is_null($request->term)) {
                $query->where(function ($where) use ($request) {
                    $where->where('name', 'like', "%{$request->term}%");
                });
            }
            $response = $query->paginate(10)->toArray();
            if (count($response['data'])) {
                $output->total_count = $response['total'];
                foreach ($response['data'] as $value) {
                    $items = new \stdClass();
                    $items->id = $value['id'];
                    $full_name = $value['name'];
                    $items->full_name = $full_name;
                    $output->items[] = $items;
                }
            }
            echo json_encode($output);
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function viewReceivers(Request $request)
    {
        return view('admin.notification.receivers', [
            'id' => $request->id,
        ]);
    }
    public function getReceiversListings(Request $request)
    {
        $notification = \App\Models\UserNotifications::select([
            'user_notifications.id', 'user_notifications.user_id', 'user_notifications.is_read', 'users.name', 'user_notifications.read_at',
        ])
            ->leftJoin('users', 'users.id', '=', 'user_notifications.user_id')
            ->where('users.is_deleted', 0)
            ->where(['user_notifications.notification_id' => $request->id]);
        return \DataTables::of($notification)
            ->editColumn('read_at', function ($query) {
                return $query->read_at ? formatTimestamp($query->read_at, 'Y-m-d H:i:s') : '';
            })
            ->editColumn('is_read', function ($query) {
                return @cpTrans('is_ready_display_array')[$query->is_read];
            })->make();
    }
}
