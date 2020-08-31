<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class NavigationController extends AdminController
{
    public function getIndex()
    {
        return view('admin.navigation.index');
    }
    public function listings()
    {
        $navigation = \App\Models\Navigations::select('*')->where('is_visible', 'Yes');
        return \DataTables::of($navigation)
            ->editColumn('parent_id', function ($query) {
                return $query->parent_id ? @cpTrans('yes') : @cpTrans('no');
            })
            ->editColumn('status', function ($query) {
                return @cpTrans('action_status')[$query->status];
            })
            ->editColumn('show_in_menu', function ($query) {
                return @cpTrans('action_array')[$query->show_in_menu];
            })
            ->editColumn('show_in_permission', function ($query) {
                return @cpTrans('action_array')[$query->show_in_permission];
            })
            ->make();
    }
    public function getCreate()
    {
        $navigations = \App\Models\Navigations::whereNull('parent_id')->where(['status' => 'Active'])->get();
        return view('admin.navigation.create', ['navigations' => $navigations]);
    }
    public function postCreate(Request $request)
    {
        $dataArr = arrayFromPost(['navigation_name', 'en_navigation_name', 'action_path', 'navigation_icon', 'navigation_priority', 'parent_navigation', 'navigation_status', 'show_in_menu', 'show_in_permission']);
        $this->validate($request, [
            'navigation_name' => 'required',
            'en_navigation_name' => 'required',
            'action_path' => 'required',
            'navigation_priority' => 'required|numeric',
            'navigation_status' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $navigations = new \App\Models\Navigations();
            $navigations->name = $dataArr->navigation_name;
            $navigations->en_name = $dataArr->en_navigation_name;
            $navigations->action_path = $dataArr->action_path;
            $navigations->icon = $dataArr->navigation_icon;
            $navigations->priority = $dataArr->navigation_priority;
            $navigations->parent_id = $dataArr->parent_navigation ? $dataArr->parent_navigation : null;
            $navigations->status = $dataArr->navigation_status; 
            $navigations->show_in_menu = $dataArr->show_in_menu; 
            $navigations->show_in_permission = $dataArr->show_in_permission; 
            $navigations->save();
            \DB::commit();
            navigationMenuListing();
            return successMessage('navigation_created');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getUpdate(Request $request)
    {
        $navigation = \App\Models\Navigations::findOrFail($request->id);
        $navigations = \App\Models\Navigations::where(function ($where) use ($navigation) {
            $where->whereNull('parent_id')->orWhere(['id' => $navigation->parent_id]);
        })
            ->where(['status' => 'Active'])
            ->where('id', '!=', $navigation->id)
            ->get();
        return view('admin.navigation.update', [
            'navigation' => $navigation,
            'navigations' => $navigations,
        ]);
    }
    public function delete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $navigation = \App\Models\Navigations::findOrFail($request->id);
            if ($navigation) {
                $navigation->delete();
                navigationMenuListing();
            }
            \DB::commit();
            return successMessage('navigation_deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function postUpdate(Request $request)
    {
        $dataArr = arrayFromPost(['navigation_name', 'en_navigation_name', 'action_path', 'navigation_icon', 'navigation_priority', 'parent_navigation', 'navigation_status', 'show_in_menu', 'show_in_permission']);
        $this->validate($request, [
            'navigation_name' => 'required',
            'en_navigation_name' => 'required',
            'action_path' => 'required',
            'navigation_priority' => 'required|numeric',
            'navigation_status' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $navigations = \App\Models\Navigations::find($request->id);
            $navigations->name = $dataArr->navigation_name;
            $navigations->en_name = $dataArr->en_navigation_name;
            $navigations->action_path = $dataArr->action_path;
            $navigations->icon = $dataArr->navigation_icon;
            $navigations->priority = $dataArr->navigation_priority;
            $navigations->parent_id = $dataArr->parent_navigation ? $dataArr->parent_navigation : null;
            $navigations->status = $dataArr->navigation_status; 
            $navigations->show_in_menu = $dataArr->show_in_menu; 
            $navigations->show_in_permission = $dataArr->show_in_permission; 
            $navigations->save();
            \DB::commit();
            navigationMenuListing();
            return successMessage('navigation_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
