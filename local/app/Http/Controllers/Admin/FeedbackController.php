<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class FeedbackController extends AdminController
{
    public function getIndex()
    {
        return view('admin.feedback.index');
    }

    public function listings()
    {
        $feedbacks = \App\Models\Feedbacks::select('*');
        return \DataTables::of($feedbacks)
            ->editColumn('created_at', function ($query) {
                return formatTimestamp($query->created_at, 'Y-m-d H:i:s');
            })
            ->make();
    }
    public function getDelete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $feedback = \App\Models\Feedbacks::find($request->id);
            if ($feedback) {
                $feedback->delete();
            }
            \DB::commit();
            return successMessage('feedback_deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
