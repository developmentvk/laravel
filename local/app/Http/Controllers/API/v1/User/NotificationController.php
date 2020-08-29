<?php
namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

class NotificationController extends APIController
{
    public function __construct()
    {
        $this->tokenUser = parseToken(true);
    }

    public function unreadNotificationCount(Request $request)
    {
        try {
            $notifications = \App\Models\Notifications::where('to_user_id', $this->tokenUser->id)
                ->where('is_read', 0)
                ->count();
            return successMessage('success', 200, ['count' => $notifications]);
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function notificationListings(Request $request)
    {
        $dataArr = arrayFromPost(['created_at', 'order_by']);
        $this->validate($request, [
            'order_by' => 'required|in:newest,oldest',
            'created_at' => 'nullable|required_if:order_by,newest|date|date_format:Y-m-d\TH:i:s.u\Z',
        ]);
        try {
            $notifications = \App\Models\Notifications::select(\DB::raw("notifications.id,notifications.is_read,notifications.notification_type,notifications.title,notifications.en_title,notifications.description,notifications.en_description,notifications.attribute,notifications.value,notifications.created_at,notifications.from_user_id,users.name,users.gender,users.image"))
                ->leftJoin('users', 'users.id', '=', 'notifications.from_user_id')
                ->where('notifications.to_user_id', '=', $this->tokenUser->id)
                ->where(function ($where) use ($dataArr) {
                    if ($dataArr->created_at) {
                        $where->where('notifications.created_at', ($dataArr->order_by == "oldest" ? "<" : ">"), date('Y-m-d H:i:s', strtotime($dataArr->created_at)));
                    }
                })
                ->orderBy('notifications.created_at', ($dataArr->order_by == 'oldest' ? 'desc' : 'asc'))
                ->limit(10)
                ->get();
            if ($notifications->isNotEmpty()) {
                foreach ($notifications as $value) {
                    if ($value->is_read == 0) {
                        $value->is_read = 1;
                        $value->read_at = date('Y-m-d H:i:s');
                        $value->save();
                    }
                }
            }
            return successMessage('success', 200, $notifications);
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function deleteNotification(Request $request)
    {
        $dataArr = arrayFromPost(['notification_id']);
        $this->validate($request, ['notification_id' => 'required|exists:notifications,id']);
        try {
            \DB::beginTransaction();
            $notifications = \App\Models\Notifications::find($dataArr->notification_id);
            if ($notifications) {
                $notifications->delete();
            }
            \DB::commit();
            return successMessage('notification_deleted', 200);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
