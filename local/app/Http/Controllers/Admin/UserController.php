<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    public function getIndex()
    {
        return view('admin.user.index');
    }

    public function listings(Request $request)
    {
        $users = \App\Models\User::select('*')->where('is_deleted', 0);
        if ($request->start_date && $request->end_date) {
            $users->where(\DB::raw('DATE(created_at)'), '>=', $request->start_date)
                ->where(\DB::raw('DATE(created_at)'), '<=', $request->end_date);
        }
        return \DataTables::of($users)
            ->editColumn('created_at', function ($query) {
                return formatTimestamp($query->created_at, 'Y-m-d H:i:s');
            })
            ->editColumn('status', function ($query) {
                return @cpTrans('action_status')[$query->status];
            })
            ->make();
    }

    public function getCreate()
    {
        $country = \App\Models\Country::all();
        return view('admin.user.create', compact(['country']));
    }

    public function postCreate(Request $request)
    {
        // dd($request->all());
        $dataArr = arrayFromPost(["name", "email", "dial_code", "mobile", "password", "dob", "username", "gender", "status"]);
        $this->validate($request, [
            "name" => "required",
            "email" => "nullable|email|required_without_all:mobile",
            "dial_code" => "nullable|numeric|digits_between:1,5",
            "mobile" => "nullable|numeric|digits_between:5,15|required_without_all:email",
            "password" => "nullable|min:6",
            "dob" => "nullable|date|date_format:m/d/Y|before_or_equal:" . ("Y-m-d"),
            "username" => "nullable|regex:/^[A-Za-z0-9_]+$/",
            "gender" => "required",
            "status" => "required",
            'profile_image' => 'nullable|' . config('app.allowed_mimes'),
        ]);
        // dd($dataArr);
        try {
            if ($dataArr->username) {
                $user = \App\Models\User::where('username', $dataArr->username)->where('is_deleted', 0)->count();
                if ($user) {
                    errorMessage('username_not_available', false, ['attribute' => $dataArr->username]);
                }
            }

            if ($dataArr->mobile) {
                $user = \App\Models\User::where([
                    'dial_code' => $dataArr->dial_code,
                    'mobile' => $dataArr->mobile,
                    'is_deleted' => 0,
                ])
                    ->first();
                if ($user) {
                    errorMessage('mobile_registered');
                }
            }
            if ($dataArr->email) {
                $user = \App\Models\User::where([
                    'email' => $dataArr->email,
                    'is_deleted' => 0,
                ])
                    ->first();
                if ($user) {
                    errorMessage('email_registered');
                }

            }
            \DB::beginTransaction();
            $user = new \App\Models\User();
            $user->name = $dataArr->name;
            $user->email = $dataArr->email;
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            if ($dataArr->password) {
                $user->password = \Hash::make($dataArr->password);
            }

            $user->dob = $dataArr->dob ? date("Y-m-d", strtotime($dataArr->dob)) : null;
            $user->username = $dataArr->username;
            $user->gender = $dataArr->gender;
            $user->status = $dataArr->status;
            $user->remember_token = hashToken();
            if ($request->hasFile('profile_image')) {
                $filename = uploadFile('profile_image', 'image', 'users');
                if ($filename) {
                    $user->image = $filename;
                } else {
                    \DB::rollBack();
                    errorMessage('file_uploading_failed');
                }
            }
            $user->save();
            \DB::commit();
            return successMessage('user_created');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function getUpdate(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->id);
        $user->image = $user->image ? buildFileLink($user->image, 'users') : '';
        $country = \App\Models\Country::all();
        return view('admin.user.update', compact(['user', 'country']));
    }

    public function postUpdate(Request $request)
    {
        $dataArr = arrayFromPost(["name", "email", "dial_code", "mobile", "dob","username", "gender", "status"]);
        $this->validate($request, [
            "name" => "required",
            "email" => "nullable|email|required_without_all:mobile",
            "dial_code" => "nullable|numeric|digits_between:1,5",
            "mobile" => "nullable|numeric|digits_between:5,15|required_without_all:email",
            "dob" => "nullable|date|date_format:m/d/Y|before_or_equal:" . date("m/d/Y"),
            "username" => "nullable|regex:/^[A-Za-z0-9_]+$/",
            "gender" => "required",
            "status" => "required",
            'profile_image' => 'nullable|' . config('app.allowed_mimes'),
        ]);
        try {
            if ($dataArr->username) {
                $user = \App\Models\User::where('username', $dataArr->username)->where('id', '<>', $request->id)->where('is_deleted', 0)->count();
                if ($user) {
                    errorMessage('username_not_available', false, ['attribute' => $dataArr->username]);
                }
            }

            if ($dataArr->mobile) {
                $user = \App\Models\User::where([
                    'dial_code' => $dataArr->dial_code,
                    'mobile' => $dataArr->mobile,
                ])
                    ->where('is_deleted', 0)
                    ->where('id', '<>', $request->id)
                    ->first();
                if ($user) {
                    errorMessage('mobile_registered');
                }
            }
            if ($dataArr->email) {
                $user = \App\Models\User::where([
                    'email' => $dataArr->email,
                ])
                    ->where('is_deleted', 0)
                    ->where('id', '<>', $request->id)
                    ->first();
                if ($user) {
                    errorMessage('email_registered');
                }
            }

            \DB::beginTransaction();
            $user = \App\Models\User::find($request->id);
            $user->name = $dataArr->name;
            $user->email = $dataArr->email;
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->dob = $dataArr->dob ? date("Y-m-d", strtotime($dataArr->dob)) : null;
            $user->username = $dataArr->username;
            $user->gender = $dataArr->gender;
            $user->status = $dataArr->status;
            $user->remember_token = hashToken();
            if ($request->hasFile('profile_image')) {

                $filename = uploadFile('profile_image', 'image', 'users');
                if ($filename) {
                    $user->image = $filename;
                } else {
                    \DB::rollBack();
                    errorMessage('file_uploading_failed');
                }
            }
            $user->save();
            \DB::commit();
            return successMessage('user_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function getDelete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $user = \App\Models\User::find($request->id);
            if ($user) {
                $user->is_deleted = 1;
                $user->deleted_at = date("Y-m-d H:i:s");
                $user->save();
            }
            \DB::commit();
            return successMessage('user_deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function getChangePassword(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->id);
        return view('admin.user.change-password', compact(['user']));
    }
    public function postChangePassword(Request $request)
    {
        $dataArr = arrayFromPost(['password', 'password_confirmation']);
        $ruleArr = [
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
        ];
        $this->validate($request, $ruleArr);
        try {
            \DB::beginTransaction();
            $users = \App\Models\User::find($request->id);
            $users->password = \Hash::make($dataArr->password);
            $users->save();
            \DB::commit();
            return successMessage('new_password_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function postChart(Request $request)
    {
        $dateArr = createDateRange($request->start_date, $request->end_date);
        $users = array();
        $users = \App\Models\User::select([
            \DB::raw('DATE(created_at) as created_at'), \DB::raw('COUNT(id) as total'),
        ])
            ->where('is_deleted', 0)
            ->where(\DB::raw('DATE(created_at)'), '>=', $request->start_date)
            ->where(\DB::raw('DATE(created_at)'), '<=', $request->end_date)
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->get();
        if ($users->isNotEmpty()) {
            foreach ($users as $value) {
                $users[date('Y-m-d', strtotime($value->created_at))] = $value->total;
            }
        }
        $data = [];
        $output = new \stdClass;
        $output->label = array();
        $output->datasets = array();
        if (count($dateArr)) {
            foreach ($dateArr as $date) {
                $output->label[] = date('d-M', strtotime($date));
                $data[] = isset($users[$date]) ? $users[$date] : 0;
            }
        }
        $output->datasets[] = array(
            'label' => @cpTrans('user'),
            'data' => $data,
            'borderColor' => '#0C68A9',
            'backgroundColor' => '#0C68A9',
            'borderWidth' => 1,
        );
        // dd($output);
        return successMessage('success', 200, $output);
    }

    public function getView(Request $request)
    {
        $user = \App\Models\User::where('is_deleted', 0)->findOrFail($request->id);
        $user->image = $user->image ? buildFileLink($user->image, 'users') : '';
        return view('admin.user.view', compact(['user']));
    }
}
