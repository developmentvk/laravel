<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class DepartmentController extends AdminController
{
    public function getIndex()
    {
        return view('admin.department.index');
    }
    public function listings()
    {
        $department = \App\Models\Departments::select('*');
        return \DataTables::of($department)
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
        return view('admin.department.create');
    }
    public function postCreate(Request $request)
    {
        $dataArr = arrayFromPost(['department_name', 'en_department_name', 'department_status']);
        $this->validate($request, [
            'en_department_name' => 'required|unique:departments,en_name',
            'department_name' => 'required|unique:departments,name',
            'department_status' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $departments = new \App\Models\Departments();
            $departments->name = $dataArr->department_name;
            $departments->en_name = $dataArr->en_department_name;
            $departments->status = $dataArr->department_status;
            $departments->save();
            \DB::commit();
            return successMessage('department_created');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getUpdate(Request $request)
    {
        $departments = \App\Models\Departments::findOrFail($request->id);
        return view('admin.department.update', ['department' => $departments]);
    }
    public function postUpdate(Request $request)
    {
        $dataArr = arrayFromPost(['department_name', 'en_department_name', 'department_status']);
        $this->validate($request, [
            'department_name' => 'required|unique:departments,name,' . $request->id,
            'en_department_name' => 'required|unique:departments,en_name,' . $request->id,
            'department_status' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $departments = \App\Models\Departments::find($request->id);
            $departments->name = $dataArr->department_name;
            $departments->en_name = $dataArr->en_department_name;
            $departments->status = $dataArr->department_status;
            $departments->save();
            \DB::commit();
            return successMessage('department_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function delete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $department = \App\Models\Departments::findOrFail($request->id);
            if ($department) {
                $department->delete();
            }
            \DB::commit();
            return successMessage('department_deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getPermission(Request $request)
    {
        $navigations = getGroupNavigation(true);
        $departmentPermissions = getDepartmentPermission($request->id);
        return view('admin.department.permission', [
            'navigations' => $navigations,
            'departmentPermissions' => $departmentPermissions,
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
            \DB::table('department_permissions')->where(['department_id' => $request->id])->delete();
            if (count($dataArr->navigation_id)) {
                foreach ($dataArr->navigation_id as $navigation_id) {
                    $departmentPermissions = new \App\Models\DepartmentPermissions();
                    $departmentPermissions->department_id = $request->id;
                    $departmentPermissions->navigation_id = $navigation_id;
                    $departmentPermissions->save();
                }
            }
            \DB::commit();
            return successMessage('permission_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
