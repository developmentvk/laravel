<?php
namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

class UserController extends APIController
{
    public function __construct()
    {
        $this->tokenUser = parseToken(true);
    }

    public function cdnInfo(Request $request)
    {
        try {
            $output = new \stdClass;
            $output->AWS_ACCESS_KEY_ID = env('AWS_ACCESS_KEY_ID');
            $output->AWS_SECRET_ACCESS_KEY = env('AWS_SECRET_ACCESS_KEY');
            $output->AWS_DEFAULT_REGION = env('AWS_DEFAULT_REGION');
            $output->AWS_BUCKET = env('AWS_BUCKET');
            $output->AWS_URL = env('AWS_URL');
            return successMessage('success', 200, $output);
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function completeProfile(Request $request)
    {
        $dataArr = arrayFromPost(['name', 'email', 'dial_code', 'mobile', 'dob', 'gender', 'password', 'image']);
        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|email',
            'dob' => 'required|date|date_format:Y-m-d|before_or_equal:' . \Carbon::now()->subYears(1)->format('Y-m-d'),
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:5,15',
            'gender' => 'required|in:male,female',
            'image' => 'nullable',
        ]);
        try {
            if ($this->tokenUser->is_returner) {
                errorMessage('profile_setup_completed');
            }
            $user = \App\Models\User::where([
                'dial_code' => $dataArr->dial_code,
                'mobile' => $dataArr->mobile,
                'is_deleted' => 0,
            ])
                ->where('id', '<>', $this->tokenUser->id)
                ->first();
            if ($user) {
                errorMessage('mobile_registered');
            }

            $user = \App\Models\User::where([
                'email' => $dataArr->email,
                'is_deleted' => 0,
            ])
                ->where('id', '<>', $this->tokenUser->id)
                ->first();
            if ($user) {
                errorMessage('email_registered');
            }

            \DB::beginTransaction();
            $user = \App\Models\User::find($this->tokenUser->id);
            $user->name = $dataArr->name;
            $user->email = $dataArr->email;
            $user->username = generateUsername($dataArr->name, $this->tokenUser->id);
            $user->dob = $dataArr->dob ? date('Y-m-d', strtotime($dataArr->dob)) : null;
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->gender = $dataArr->gender;
            $user->is_returner = 1;
            if ($dataArr->password) {
                $user->password = \Hash::make($dataArr->password);
            }
            $user->save();
            \DB::commit();
            unset($user->is_deleted, $user->deleted_at, $user->login_log_id, $user->updated_at, $user->status, $user->otp,$user->last_token);
            return successMessage('profile_updated', 200, $user);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $user = \App\Models\User::select(\DB::raw("id,username,image,gender,name,dial_code,mobile,dob,email,last_status,last_connected_at,created_at"))->where('is_deleted', 0)->find($this->tokenUser->id);
            return successMessage('success', 200, $user);
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function updateProfile(Request $request)
    {
        $dataArr = arrayFromPost(['name', 'email', 'dial_code', 'mobile', 'dob', 'gender']);
        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|email',
            'dob' => 'required|date|date_format:Y-m-d|before_or_equal:' . \Carbon::now()->subYears(1)->format('Y-m-d'),
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:5,15',
            'gender' => 'required|in:male,female',
        ]);
        try {
            $user = \App\Models\User::where([
                'dial_code' => $dataArr->dial_code,
                'mobile' => $dataArr->mobile,
                'is_deleted' => 0,
            ])
                ->where('id', '<>', $this->tokenUser->id)
                ->first();
            if ($user) {
                errorMessage('mobile_registered');
            }

            $user = \App\Models\User::where([
                'email' => $dataArr->email,
                'is_deleted' => 0,
            ])
                ->where('id', '<>', $this->tokenUser->id)
                ->first();
            if ($user) {
                errorMessage('email_registered');
            }

            \DB::beginTransaction();
            $user = \App\Models\User::find($this->tokenUser->id);
            $user->name = $dataArr->name;
            $user->email = $dataArr->email;
            $user->dob = $dataArr->dob ? date('Y-m-d', strtotime($dataArr->dob)) : null;
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->gender = $dataArr->gender;
            $user->save();
            \DB::commit();
            unset($user->login_log_id, $user->updated_at, $user->status, $user->otp);
            return successMessage('profile_updated', 200, $user);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
    public function updateProfileImage(Request $request)
    {
        $dataArr = arrayFromPost(['image']);
        $this->validate($request, [
            'image' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $user = \App\Models\User::find($this->tokenUser->id);
            $user->image = $dataArr->image;
            $user->save();
            \DB::commit();
            return successMessage('profile_image_updated');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function changePassword(Request $request)
    {
        $dataArr = arrayFromPost(['password', 'confirm_password']);
        $this->validate($request, [
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
        ]);
        try {
            \DB::beginTransaction();
            $user = \App\Models\User::find($this->tokenUser->id);
            $user->password = \Hash::make($dataArr->password);
            $user->save();
            \DB::commit();
            return successMessage('password_changed', 200);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function checkUsername(Request $request)
    {
        $dataArr = arrayFromPost(['username']);
        $this->validate($request, [
            'username' => 'required|regex:/^[A-Za-z0-9_]+$/',
        ]);
        try {
            $user = \App\Models\User::where('username', $dataArr->username)->where('is_deleted', 0)->where('id', '<>', $this->tokenUser->id)->count();
            if ($user) {
                errorMessage('username_not_available', false, ['attribute' => $dataArr->username]);
            } else {
                return successMessage('username_available', 200, null, ['attribute' => $dataArr->username]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function changeUsername(Request $request)
    {
        $dataArr = arrayFromPost(['username']);
        $this->validate($request, [
            'username' => 'required|regex:/^[A-Za-z0-9_]+$/',
        ]);
        try {
            $user = \App\Models\User::where('username', $dataArr->username)->where('is_deleted', 0)->where('id', '<>', $this->tokenUser->id)->count();
            if ($user) {
                errorMessage('username_not_available', false, ['attribute' => $dataArr->username]);
            } else {
                \DB::beginTransaction();
                $user = \App\Models\User::find($this->tokenUser->id);
                $user->username = $dataArr->username;
                $user->save();
                \DB::commit();
                return successMessage('username_changed');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
