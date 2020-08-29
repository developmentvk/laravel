<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class ReportListController extends AdminController
{
    public function getIndex()
    {
        $reportLists = \App\Models\ReportLists::select(\DB::raw("id, {$this->ql}report_list as report_list, show_remarks"))->orderBy('display_order')->get();
        return view('admin.reportLists.index', compact('reportLists'));
    }

    public function updateFieldOrder(Request $request)
    {
        $dataArr = arrayFromPost(['order']);
        $this->validate($request, ['order' => 'required|array']);
        try {
            \DB::beginTransaction();
            if (count($dataArr->order)) {
                foreach ($dataArr->order as $key => $id) {
                    $reportLists = \App\Models\ReportLists::find($id);
                    $reportLists->display_order = $key + 1;
                    $reportLists->save();
                }
            }
            \DB::commit();
            return successMessage('success');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function getCreate()
    {
        return view('admin.reportLists.create');
    }
    public function postCreate(Request $request)
    {
        $dataArr = arrayFromPost(['report_list', 'en_report_list', 'show_remarks']);
        $this->validate($request, [
            'report_list' => 'required|unique:report_lists,report_list',
            'en_report_list' => 'required|unique:report_lists,en_report_list',
            'show_remarks' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $reportLists = new \App\Models\ReportLists();
            $reportLists->report_list = $dataArr->report_list;
            $reportLists->en_report_list = $dataArr->en_report_list;
            $reportLists->show_remarks = $dataArr->show_remarks;
            $reportLists->display_order = \App\Models\ReportLists::max('display_order') + 1;
            $reportLists->save();
            \DB::commit();
            return successMessage('report_list_added');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getUpdate(Request $request)
    {
        $reportList = \App\Models\ReportLists::findOrFail($request->id);
        return view('admin.reportLists.update', compact('reportList'));
    }
    public function getDelete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $reportLists = \App\Models\ReportLists::find($request->id);
            if ($reportLists) {
                $reportLists->delete();
            }
            \DB::commit();
            return redirect()->route('admin.report-list.index')->with(['success' => __('validation.report_list_deleted')]);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            return redirect()->route('admin.report-list.index')->with(['fail' => $e->errorInfo[2]]);
        }
    }
    public function postUpdate(Request $request)
    {
        $dataArr = arrayFromPost(['report_list', 'en_report_list', 'show_remarks']);
        $this->validate($request, [
            'report_list' => 'required|unique:report_lists,report_list,' . $request->id,
            'en_report_list' => 'required|unique:report_lists,en_report_list,' . $request->id,
            'show_remarks' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $reportLists = \App\Models\ReportLists::find($request->id);
            $reportLists->report_list = $dataArr->report_list;
            $reportLists->en_report_list = $dataArr->en_report_list;
            $reportLists->show_remarks = $dataArr->show_remarks;
            $reportLists->save();
            \DB::commit();
            return successMessage('report_list_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
