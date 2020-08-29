<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController as AdminMainController;
use Illuminate\Http\Request;

class AdminController extends AdminMainController
{
    public function getIndex()
    {
        $departments = \App\Models\Departments::all();
        return view('admin.admin.index', compact(['departments']));
    }
    public function listings(Request $request)
    {
        $admin = \App\Models\Admins::select(['*'])
            ->where(function ($where) use ($request) {
                if ($request->id) {
                    $where->where([
                        'department_id' => $request->id,
                    ]);
                }
            });
        return \DataTables::of($admin)
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
        $departments = \App\Models\Departments::all();
        return view('admin.admin.create', compact(['departments']));
    }
    public function postCreate(Request $request)
    {
        $dataArr = arrayFromPost(['admin_name', 'en_admin_name', 'admin_email', 'username', 'password', 'account_access_id', 'account_status', 'profile_image', 'mobile']);
        $this->validate($request, [
            'admin_name' => 'required',
            'en_admin_name' => 'required',
            'admin_email' => 'nullable|email',
            'mobile' => 'nullable|numeric|digits_between:5,15',
            'username' => 'required|unique:admins',
            'password' => 'required',
            'account_access_id' => 'required',
            'account_status' => 'required',
            'profile_image' => 'nullable|' . config('app.allowed_mimes'),
        ]);
        try {
            \DB::beginTransaction();
            $admins = new \App\Models\Admins();
            $admins->department_id = $dataArr->account_access_id;
            $admins->name = $dataArr->admin_name;
            $admins->en_name = $dataArr->en_admin_name;
            $admins->mobile = $dataArr->mobile;
            $admins->username = $dataArr->username;
            $admins->email = $dataArr->admin_email;
            $admins->password = \Hash::make($dataArr->password);
            $admins->status = $dataArr->account_status;
            if ($request->hasFile('profile_image')) {
                $filename = uploadFile('profile_image', 'image', 'admin');
                if ($filename) {
                    $admins->profile_image = $filename;
                } else {
                    \DB::rollBack();
                    errorMessage('file_uploading_failed');
                }
            }
            $admins->save();
            \DB::commit();
            return successMessage('admin_account_created');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getUpdate(Request $request)
    {
        $admin = \App\Models\Admins::findOrFail($request->id);
        $admin->profile_image = $admin->profile_image ? buildFileLink($admin->profile_image, 'admin') : '';
        $departments = \App\Models\Departments::all();
        return view('admin.admin.update', compact(['admin', 'departments']));
    }
    public function delete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $admin = \App\Models\Admins::findOrFail($request->id);
            if ($admin) {
                $admin->delete();
            }
            \DB::commit();
            return successMessage('admin_account_deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }

    }
    public function view(Request $request)
    {
        $admin = \App\Models\Admins::select([
            'admins.*', 'departments.name as department_name',
        ])
            ->leftJoin("departments", 'departments.id', '=', 'admins.department_id')
            ->where(['admins.id' => $request->id])
            ->first();
        if (!$admin) {
            return redirect()->route('admin.admin.index')->with(['fail' => __('validation.no_record_found')]);
        }
        $admin->profile_image = $admin->profile_image ? buildFileLink($admin->profile_image, 'admin') : '';
        return view('admin.admin.view', compact(['admin']));
    }
    public function postUpdate(Request $request)
    {
        $dataArr = arrayFromPost(['admin_name', 'en_admin_name', 'admin_email', 'username', 'password', 'account_access_id', 'account_status', 'profile_image', 'mobile']);
        $this->validate($request, [
            'admin_name' => 'required',
            'en_admin_name' => 'required',
            'admin_email' => 'nullable|email',
            'username' => 'required|unique:admins,username,' . $request->id,
            'mobile' => 'nullable|numeric|digits_between:5,15',
            'account_access_id' => 'required',
            'account_status' => 'required',
            'profile_image' => 'nullable|' . config('app.allowed_mimes'),
        ]);
        try {
            \DB::beginTransaction();
            $admins = \App\Models\Admins::find($request->id);
            $admins->department_id = $dataArr->account_access_id;
            $admins->name = $dataArr->admin_name;
            $admins->en_name = $dataArr->en_admin_name;
            $admins->mobile = $dataArr->mobile;
            $admins->username = $dataArr->username;
            $admins->email = $dataArr->admin_email;
            $admins->status = $dataArr->account_status;
            if ($request->hasFile('profile_image')) {
                $filename = uploadFile('profile_image', 'image', 'admin');
                if ($filename) {
                    $admins->profile_image = $filename;
                } else {
                    \DB::rollBack();
                    errorMessage('file_uploading_failed');
                }
            }
            $admins->save();
            \DB::commit();
            return successMessage('admin_account_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getUpdateProfile(Request $request)
    {
        $admin = \App\Models\Admins::findOrFail($request->id);
        $admin->profile_image = $admin->profile_image ? buildFileLink($admin->profile_image, 'admin') : '';
        return view('admin.admin.update-profile', compact(['admin']));
    }
    public function postUpdateProfile(Request $request)
    {
        $dataArr = arrayFromPost(['admin_name', 'en_admin_name', 'admin_email', 'username', 'profile_image']);
        $this->validate($request, [
            'admin_name' => 'required',
            'en_admin_name' => 'required',
            'admin_email' => 'nullable|email',
            'username' => 'required|unique:admins,username,' . $request->id,
        ]);
        try {
            \DB::beginTransaction();
            $admins = \App\Models\Admins::find($request->id);
            $admins->name = $dataArr->admin_name;
            $admins->en_name = $dataArr->en_admin_name;
            $admins->username = $dataArr->username;
            $admins->email = $dataArr->admin_email;
            if ($request->hasFile('profile_image')) {
                $filename = uploadFile('profile_image', 'image', 'admin');
                if ($filename) {
                    $admins->profile_image = $filename;
                } else {
                    \DB::rollBack();
                    errorMessage('file_uploading_failed');
                }
            }
            $admins->save();
            \DB::commit();
            return successMessage('admin_account_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getChangePassword(Request $request)
    {
        $admin = \App\Models\Admins::findOrFail($request->id);
        return view('admin.admin.change-password', compact(['admin']));
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
            $admins = \App\Models\Admins::find($request->id);
            $admins->password = \Hash::make($dataArr->password);
            $admins->save();
            \DB::commit();
            return successMessage('new_password_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getPermission(Request $request)
    {
        $admin = \App\Models\Admins::findOrFail($request->id);
        $navigations = getGroupNavigation(true);
        $adminPermissions = getAdminPermission($request->id);
        return view('admin.admin.permission', [
            'admin' => $admin,
            'navigations' => $navigations,
            'adminPermissions' => $adminPermissions,
        ]);
    }
    public function postPermission(Request $request)
    {
        $dataArr = arrayFromPost(['navigation_id']);
        $this->validate($request, [
            'navigation_id' => 'required|array',
        ]);
        try {
            \DB::beginTransaction();
            \DB::table('admin_permissions')->where(['admin_id' => $request->id])->delete();
            if (count($dataArr->navigation_id)) {
                foreach ($dataArr->navigation_id as $navigation_id) {
                    $adminPermissions = new \App\Models\AdminPermissions();
                    $adminPermissions->admin_id = $request->id;
                    $adminPermissions->navigation_id = $navigation_id;
                    $adminPermissions->save();
                }
            }
            \DB::commit();
            return successMessage('permission_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getChangeLang(Request $request)
    {
        try {
            \DB::beginTransaction();
            $admin = auth()->user();
            $admin->locale = $request->lang;
            $admin->save();
            \DB::commit();
            \App::setLocale($admin->locale);
            if (\Session::exists('locale')) {
                \Session::remove('locale');
            }
            \Session::put('locale', $admin->locale);
            \Session::save();
            return successMessage('success');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
