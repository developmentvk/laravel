<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class SettingsController extends AdminController
{
    public function getIndex()
    {
        $settings = \App\Models\Settings::select(['*'])->orderBy('display_order')->get();
        return view('admin.settings.index', compact(['settings']));
    }
    public function postUpdate(Request $request)
    {
        $dataArr = arrayFromPost(['field']);
        $this->validate($request, [
            'field' => 'required|array',
            'field.*.*' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            if (is_array($dataArr->field) && count($dataArr->field)) {
                foreach ($dataArr->field as $id => $row) {
                    $setting = \App\Models\Settings::find($id);
                    if ($setting) {
                        $setting->value = $dataArr->{"field"}[$id][$setting->attribute];
                        $setting->save();
                    }
                }
            }
            \DB::commit();
            return successMessage('setting_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
