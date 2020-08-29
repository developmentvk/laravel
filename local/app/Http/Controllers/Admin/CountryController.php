<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class CountryController extends AdminController
{
    public function getIndex()
    {
        return view('admin.country.index');
    }
    public function listings()
    {
        $country = \App\Models\Country::select([
            'id', 'flag', 'name', 'en_name', 'dial_code', 'status', 'created_at',
        ]);
        return \DataTables::of($country)
            ->editColumn('created_at', function ($query) {
                return formatTimestamp($query->created_at, 'Y-m-d H:i:s');
            })
            ->editColumn('status', function ($query) {
                return @cpTrans('action_status')[$query->status];
            })
            ->editColumn('flag', function ($query) {
                return $query->flag ? buildFileLink($query->flag, 'country_flags') : '';
            })
            ->make();
    }
    public function getCreate()
    {
        return view('admin.country.create');
    }
    public function postCreate(Request $request)
    {
        $dataArr = arrayFromPost(['country_name', 'en_country_name', 'status', 'country_flag', 'dial_code']);
        $this->validate($request, [
            'country_name' => 'required|unique:countries,name',
            'en_country_name' => 'required|unique:countries,en_name',
            'status' => 'required',
            'dial_code' => 'required|nullable',
            'country_flag' => 'nullable|' . config('app.allowed_mimes'),
        ]);
        try {
            \DB::beginTransaction();
            $country = new \App\Models\Country();
            $country->name = $dataArr->country_name;
            $country->en_name = $dataArr->en_country_name;
            $country->dial_code = $dataArr->dial_code;
            $country->status = $dataArr->status;
            if ($request->hasFile('country_flag')) {
                $filename = uploadFile('country_flag', 'image', 'country_flags');
                if ($filename) {
                    $country->flag = $filename;
                } else {
                    \DB::rollBack();
                    errorMessage('file_uploading_failed');
                }
            }
            $country->save();
            \DB::commit();
            return successMessage('country_added');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function getUpdate(Request $request)
    {
        $country = \App\Models\Country::findOrFail($request->id);
        $country->flag = $country->flag ? buildFileLink($country->flag, 'country_flags') : '';
        return view('admin.country.update', compact(['country']));
    }
    public function getDelete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $country = \App\Models\Country::find($request->id);
            if ($country) {
                $country->delete();
            }
            \DB::commit();
            return successMessage('country_deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function postUpdate(Request $request)
    {
        $dataArr = arrayFromPost(['country_name', 'en_country_name', 'status', 'country_flag', 'dial_code']);
        $this->validate($request, [
            'country_name' => 'required|unique:countries,name,' . $request->id,
            'en_country_name' => 'required|unique:countries,en_name,' . $request->id,
            'status' => 'required',
            'dial_code' => 'required|numeric',
            'country_flag' => 'nullable|' . config('app.allowed_mimes'),
        ]);
        try {
            \DB::beginTransaction();
            $country = \App\Models\Country::find($request->id);
            $country->name = $dataArr->country_name;
            $country->en_name = $dataArr->en_country_name;
            $country->dial_code = $dataArr->dial_code;
            $country->status = $dataArr->status;
            if ($request->hasFile('country_flag')) {
                $filename = uploadFile('country_flag', 'image', 'country_flags');
                if ($filename) {
                    $country->flag = $filename;
                } else {
                    \DB::rollBack();
                    errorMessage('file_uploading_failed');
                }
            }
            $country->save();
            \DB::commit();
            return successMessage('country_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
