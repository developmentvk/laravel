<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

class AuthController extends APIController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tokenUser = parseToken(false, true);
    }

    public function siteConfig(Request $request)
    {
        try {
            // \Cache::forget('settings');
            $settings = \Cache::rememberForever('settings', function () {
                $output = new \stdClass;
                $settings = \App\Models\Settings::select([
                    'attribute', 'value',
                ])->get();
                if ($settings->isNotEmpty()) {
                    foreach ($settings as $value) {
                        $output->{$value->attribute} = $value->value;
                    }
                }
                return $output;
            });
            return successMessage('success', 200, $settings);
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function country(Request $request)
    {
        try {
            // \Cache::forget('country');
            $country = \Cache::rememberForever('country', function () {
                return \App\Models\Country::select([
                    "id", "name", "en_name", "dial_code", "flag",
                ])->where(['status' => 'Active'])->orderBy("en_name")->get();
            });
            return successMessage('success', 200, $country);
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function login(Request $request)
    {
        $rules = array();
        $rules['is_mobile'] = 'required|in:Yes,No';
        $rules['is_otp_login'] = 'required|in:Yes,No';
        if ($request->is_mobile == "Yes") {
            $rules['dial_code'] = 'required|numeric|digits_between:1,5';
            $rules['username'] = 'required|numeric|digits_between:5,15';
        } else {
            $rules['username'] = 'required|email';
        }
        if ($request->is_otp_login == "No") {
            $rules['password'] = 'required';
        }
        $this->validate($request, $rules);
        $dataArr = arrayFromPost(['is_otp_login', 'is_mobile', 'dial_code', 'username', 'password', 'fcm_id']);
        // dd($rules);
        try {
            if ($request->is_mobile == "Yes") {
                $dataArr->username = ltrim($dataArr->username, '0');
            }
            if ($request->is_otp_login == "No") {
                $conditionArr = array();
                if ($request->is_mobile == "Yes") {
                    $conditionArr['dial_code'] = $dataArr->dial_code;
                    $conditionArr['mobile'] = $dataArr->username;
                } else {
                    $conditionArr['email'] = $dataArr->username;
                }
                $user = \App\Models\User::where($conditionArr)->where('is_deleted', 0)->first();
                if (!$user) {
                    $user = new \App\Models\User();
                    if ($request->is_mobile == "Yes") {
                        $user->dial_code = $dataArr->dial_code;
                        $user->mobile = $dataArr->username;
                    } else {
                        $user->email = $dataArr->username;
                    }
                    $user->username = generateUsername($dataArr->username);
                    $user->password = \Hash::make($dataArr->password);
                    $user->status = 'Active'; //1.Active. 0.Inactive
                    $user->save();
                }

                $attemptArr = array();
                $attemptArr['password'] = $dataArr->password;
                if ($request->is_mobile == "Yes") {
                    $attemptArr['dial_code'] = $dataArr->dial_code;
                    $attemptArr['mobile'] = $dataArr->username;
                } else {
                    $attemptArr['email'] = $dataArr->username;
                }

                try {
                    if (!$token = auth('api')->attempt($attemptArr)) {
                        if ($request->is_mobile == "Yes") {
                            errorMessage('invalid_mobile_login_credentials');
                        } else {
                            errorMessage('invalid_email_login_credentials');
                        }
                    }
                } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                    errorMessage('could_not_create_token');
                }

                $user = auth('api')->setToken($token)->user();
                if ($user->status != 'Active') {
                    auth('api')->invalidate($token);
                    if ($user->status == 'Inactive') {
                        errorMessage('account_inactive');
                    } else {
                        errorMessage('account_blocked');
                    }
                }
                $output = generateToken($request, $dataArr, $user);
                return successMessage('credential_verified', 200, $output);
            } else {
                $conditionArr = array();
                if ($request->is_mobile == "Yes") {
                    $conditionArr['dial_code'] = $dataArr->dial_code;
                    $conditionArr['mobile'] = $dataArr->username;
                } else {
                    $conditionArr['email'] = $dataArr->username;
                }
                $conditionArr['is_deleted'] = 0;
                // dd($conditionArr);
                $user = \App\Models\User::where($conditionArr)->where('is_deleted', 0)->first();
                if (!$user) {
                    $user = new \App\Models\User();
                    if ($request->is_mobile == "Yes") {
                        $user->dial_code = $dataArr->dial_code;
                        $user->mobile = $dataArr->username;
                    } else {
                        $user->email = $dataArr->username;
                    }
                    $user->status = 'Active'; //1.Active. 0.Inactive
                    $user->save();
                }
                $user->otp = generateOTP();
                $user->remember_token = hashToken();
                $user->save();

                $notifyArr = new \stdClass;
                $notifyArr->otp = 1;
                if ($request->is_mobile == "Yes") {
                    $notifyArr->dial_code = $user->dial_code;
                    $notifyArr->mobile = $user->mobile;
                } else {
                    $notifyArr->send_email = 1;
                    $notifyArr->email = $user->email;
                    $notifyArr->locale = $dataArr->locale;
                }
                $notifyArr->device_id = $dataArr->device_id;
                $notifyArr->user_id = $user->id;
                $notifyArr->title = __('sms.otp_title');
                $notifyArr->message = __('sms.otp', [
                    'attribute' => $user->otp,
                ]);
                \Event::dispatch(new \App\Events\TriggerNotification($notifyArr));

                $output = new \stdClass;
                $output->id = $user->id;
                $output->token = $user->remember_token;
                return successMessage('otp_generated', 200, $output);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function resendOTP(Request $request)
    {
        // dd($request->all());
        $dataArr = arrayFromPost(['id', 'hash_token']);
        $this->validate($request, [
            'id' => 'required|exists:users',
            'is_mobile' => 'required|in:Yes,No',
            'hash_token' => 'required|exists:users,remember_token',
        ]);
        try {
            \DB::beginTransaction();
            $user = \App\Models\User::where([
                'id' => $dataArr->id,
                'remember_token' => $dataArr->hash_token,
                'is_deleted' => 0,
            ])->first();
            if (!$user) {
                return errorMessage('unauthorized_access', false, [], 401);
            }
            $user->remember_token = hashToken();
            if ($user->otp == null) {
                $user->otp = generateOTP();
            }
            $user->save();
            \DB::commit();

            $notifyArr = new \stdClass;
            $notifyArr->otp = 1;
            if ($request->is_mobile == "Yes") {
                $notifyArr->dial_code = $user->dial_code;
                $notifyArr->mobile = $user->mobile;
            } else {
                $notifyArr->send_email = 1;
                $notifyArr->email = $user->email;
                $notifyArr->locale = $dataArr->locale;
            }
            $notifyArr->device_id = $dataArr->device_id;
            $notifyArr->user_id = $user->id;
            $notifyArr->title = __('sms.otp_title');
            $notifyArr->message = __('sms.otp', [
                'attribute' => $user->otp,
            ]);
            \Event::dispatch(new \App\Events\TriggerNotification($notifyArr));

            $output = new \stdClass;
            $output->id = $user->id;
            $output->token = $user->remember_token;

            return successMessage('otp_resent', 200, $output);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function verifyOtp(Request $request)
    {
        $dataArr = arrayFromPost(['id', 'hash_token', 'otp', 'fcm_id']);
        $this->validate($request, [
            'id' => 'required|exists:users',
            'hash_token' => 'required|exists:users,remember_token',
            'otp' => 'required|numeric|digits:4',
        ]);
        try {
            \DB::beginTransaction();

            $user = \App\Models\User::where([
                'id' => $dataArr->id,
                'remember_token' => $dataArr->hash_token,
                'is_deleted' => 0,
            ])->first();
            if (!$user) {
                \DB::rollBack();
                errorMessage('unauthorized_access', false, [], 401);
            }

            if (($user->otp == null) or ($user->otp && ($dataArr->otp != config('app.defaultOTP') && $user->otp != $dataArr->otp))) {
                \DB::rollBack();
                errorMessage('invalid_otp');
            }
            $user->remember_token = null;
            $user->otp = null;
            $user->save();
            \DB::commit();
            $output = generateToken($request, $dataArr, $user);
            return successMessage('otp_verified', 200, $output);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function refreshToken()
    {
        try {
            $output = new \stdClass;
            $output->token_type = 'bearer';
            $output->expires_in = \JWTAuth::factory()->getTTL() * 60; // In Seconds
            $output->expires_unit = 'Seconds';
            $output->access_token = auth('api')->parseToken()->refresh();
            $tokenUser = auth('api')->setToken($output->access_token)->user();
            if (!$tokenUser) {
                throw new \Tymon\JWTAuth\Exceptions\TokenBlacklistedException(__('validation.jwt_no_longer_refresh'));
            }
            $tokenUser->last_token = $output->access_token;
            $tokenUser->save();
            return successMessage('token_refreshed', 200, $output);
        } catch (\Exception $e) {

            throw new \Tymon\JWTAuth\Exceptions\TokenBlacklistedException(__('validation.jwt_no_longer_refresh'));
        }
    }

    public function updateFCMToken(Request $request)
    {
        $dataArr = arrayFromPost(['fcm_id']);
        $this->validate($request, [
            'fcm_id' => 'required',
        ]);
        try {
            if ($this->tokenUser) {
                \DB::beginTransaction();
                storeFCMData($dataArr, $this->tokenUser->id);
                \DB::commit();
                return successMessage('success', 200);
            } else {
                \DB::rollBack();
                errorMessage('unauthorized_access', false, [], 401);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }

    public function logout()
    {
        $dataArr = arrayFromPost();
        try {
            \DB::beginTransaction();
            $token = \JWTAuth::getToken();
            $tokenUser = auth('api')->setToken($token)->user();
            auth('api')->invalidate($token);
            if ($dataArr->device_id) {
                deleteFCMToken($dataArr->device_id);
            }
            if ($tokenUser) {
                $userLoginLogs = \App\Models\UserLoginLogs::where([
                    'user_id' => $tokenUser->id,
                    'device_id' => $dataArr->device_id,
                ])->whereNull('logout_at')->get();
                if ($userLoginLogs->isNotEmpty()) {
                    foreach ($userLoginLogs as $value) {
                        $value->logout_at = \Carbon::now()->toDateTimeString();
                        $value->duration = diffInMinutes($value->login_at, $value->logout_at);
                        $value->save();
                    }
                }
            }
            \DB::commit();
            return successMessage('logged_out_successfully', 200);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}
