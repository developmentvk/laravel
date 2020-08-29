<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
class LoginController extends AdminController
{
   
    //Trait
    public function username() {
        return 'username';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login',[
            'username' => \Cookie::get('__ud') ? base64_decode(\Cookie::get('__ud')) : "",
            'password' => \Cookie::get('__up') ? base64_decode(\Cookie::get('__up')) : ""
        ]);
    }
    /**
     * Validate the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateLogin(Request $request)
    {
        $dataArr = arrayFromPost(["username", "password", "remember"]);
        $this->validate($request, [
            "username" => "required|max:191",
            "password" => "required|max:191",
        ]);
        try {
            if(!auth()->attempt(['username' => $dataArr->username, 'password' => $dataArr->password], ($dataArr->remember? TRUE : FALSE))) {
                errorMessage('invalid_username_login_credentials');
            } else {
                $admin = auth()->user();
                if($admin->status != 'Active')
                {
                    auth()->logout();
                    if($admin->status == 'Inactive') {
                        errorMessage('account_inactive');
                    } else {
                        errorMessage('account_blocked');
                    }
                }
                $adminLoginLogs = new \App\Models\AdminLoginLogs();
                $adminLoginLogs->device_type = "web";
                $adminLoginLogs->admin_id = $admin->id;
                $adminLoginLogs->login_at = \Carbon::now()->toDateTimeString();
                $adminLoginLogs->ip_address = detectUserIpAddress();
                $adminLoginLogs->browser = $request->server('HTTP_USER_AGENT');
                $adminLoginLogs->save();
                $admin->login_log_id = $adminLoginLogs->id;
                $admin->save();
                if (\Session::exists('adminLoginLogs')) {
                    \Session::remove('adminLoginLogs');
                }
                \Session::put('adminLoginLogs', $adminLoginLogs);
                \Session::save();
                if($dataArr->remember) {
                    \Cookie::queue(\Cookie::make('__ud', base64_encode($dataArr->username)));
                    \Cookie::queue(\Cookie::make('__up', base64_encode($dataArr->password)));
                } else {
                    \Cookie::queue(\Cookie::make('__ud', null));
                    \Cookie::queue(\Cookie::make('__up', null));
                }
                return successMessage('loggedin_successfully');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2],true);
        }
    }
    /**
     * Logout the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        if (\Session::exists('adminLoginLogs')) {
            $adminLoginLogsData = \Session::get('adminLoginLogs');
            if($adminLoginLogsData != NULL)
            {
                $adminLoginLogs = \App\Models\AdminLoginLogs::find($adminLoginLogsData->id);
                if($adminLoginLogs != NULL)
                {
                    $adminLoginLogs->logout_at = \Carbon::now()->toDateTimeString();
                    $adminLoginLogs->duration = diffInMinutes($adminLoginLogs->login_at, $adminLoginLogs->logout_at);
                }
                $admin = auth()->user();
                $admin->login_log_id = (NULL);
                $admin->save();
            }
        }
        auth()->logout();
        if (\Session::exists('navigationPermissions')) {
            \Session::remove('navigationPermissions');
        }
        if (\Session::exists('navigations')) {
            \Session::remove('navigations');
        }
        if (\Session::exists('adminLoginLogs')) {
            \Session::remove('adminLoginLogs');
        }
        return redirect()->route('admin.login')->with(['success' =>  __('validation.logged_out_successfully')]);
    }
    public function getForgotPassword()
    {
        return view('admin.forgot-password');
    }
    public function generateForgotPasswordLink(Request $request)
    {
        $dataArr = arrayFromPost(["email"]);
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        try {
            $admin = \App\Models\Admins::where([
                'email' => $dataArr->email
            ])->first();
            if($admin == NULL) {
                errorMessage('email_not_exist');
            }
            if($admin->status != 'Active')
            {
                if($admin->status == 'Inactive')
                {
                    errorMessage('account_inactive');
                } else {
                    errorMessage('account_blocked');
                }
            }
            $admin->remember_token = hashToken();
            $admin->save();
            if($admin->email)
            {
                // Send Email to User
                $notifyArr = new \stdClass;
                $notifyArr->is_email = 1;
                $notifyArr->email = $admin->email;
                $notifyArr->name = $admin->name;
                $notifyArr->username = $admin->username;
                $notifyArr->buildUrl = route('admin.forgot.password.link', [
                    'remember_token' => $admin->remember_token,
                    'id' => $admin->id,
                ]);
                $notifyArr->subject = __('admin.password_recovery_subject');
                $notifyArr->template = 'en.forgot-password';
                \Event::dispatch(new \App\Events\TriggerNotification($notifyArr));
                return successMessage('password_recovery_instruction');
            } else {
                errorMessage('recovery_email_not_exist');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            errorMessage($e->errorInfo[2],true);
        }
    }
    public function createForgotPassword(Request $request)
    {
        $admin = \App\Models\Admins::where([
            'remember_token' => $request->remember_token,
            'id' => $request->id,
        ])->first();
        if($admin == NULL) {
            return redirect()->route('admin.forgot.password')->with('fail', __('admin.password_recovery_link_expired'));
        }
        return view('admin.update-password', [
            'remember_token' => $request->remember_token,
            'id' => $request->id,
        ]);
    }
    public function updateNewPassword(Request $request)
    {
        $dataArr = arrayFromPost(["remember_token", "password", "password_confirmation"]);
        $this->validate($request, [
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
        ]);
        try {
            \DB::beginTransaction();
            $admin = \App\Models\Admins::where([
                'remember_token' => $request->remember_token,
                'id' => $request->id,
            ])->first();
            if($admin == NULL) {
                \DB::rollBack();
                errorMessage('password_recovery_link_expired');
            }
            $admin->password = \Hash::make($dataArr->password);
            $admin->remember_token = NULL;
            $admin->save();
            // Send Email to User
            $notifyArr = new \stdClass;
            $notifyArr->is_email = 1;
            $notifyArr->email = $admin->email;
            $notifyArr->name = $admin->name;
            $notifyArr->subject = __('admin.password_changed_subject');
            $notifyArr->template = 'en.create-password';
            \Event::dispatch(new \App\Events\TriggerNotification($notifyArr));
            
            \DB::commit();
            return successMessage('password_changed');
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2],true);
        }
    }
}
