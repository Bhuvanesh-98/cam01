<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest');   
    }

    public function index()
    {
        $pageTitle = 'Forgot Password';

        $admin = Admin::first();

        $admin->verification_code = null;

        $admin->save();

        return view('admin.auth.forgot_password',compact('pageTitle'));
    }

    public function sendVerification(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        $admin = Admin::where('email',$request->email)->first();


        if(!$admin){
            $notify[] = ['error','Please Provide a valid Email'];
            return back()->withNotify($notify);

        }

        $code = random_int(100000, 999999);

        $admin->verification_code = $code ;

        $admin->save();

        sendMail('PASSWORD_RESET',['code'=> $code],  $admin);

        $notify[] = ['success','Send verification code to your email'];
        return redirect()->route('admin.auth.verify')->withNotify($notify);
    }

    public function verify()
    {
        $pageTitle = 'Verify Code';

        $admin = Admin::first();

        if($admin->verification_code == null){

            return redirect()->route('admin.forgot.password');
        }

        return view('admin.auth.verify',compact('pageTitle'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $admin = Admin::first();

        $token = $admin->verification_code;

        if($admin->verification_code !== $request->code){

            $admin->verification_code = null ;

            $admin->save();

            $notify[] = ['error','Invalid Code'];

            return redirect()->route('admin.forgot.password')->withNotify($notify);
        }

        $admin->verification_code = null ;

        $admin->save();

        session()->put('token',$token);

        return redirect()->route('admin.reset.password');

    }

    public function reset ()
    {
        $token = session('token');

        if($token == null){

            return redirect()->route('admin.login');

        }

        $pageTitle = 'Reset Password';

        return view('admin.auth.reset',compact('pageTitle'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate(['password'=>'required|confirmed']);

        $admin = Admin::first();

        $admin->password = bcrypt($request->password);

        $admin->save();

        $notify[] = ['success','Successfully Reset Your Password'];

        return redirect()->route('admin.login')->withNotify($notify);
    }
}
