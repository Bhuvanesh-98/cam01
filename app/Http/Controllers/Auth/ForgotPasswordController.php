<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        $pageTitle = 'Forgot Password';

        return view('frontend.auth.forgot_password', compact('pageTitle'));
    }

    public function sendVerification(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();


        if (!$user) {
            $notify[] = ['error', 'Please Provide a valid Email'];
            return back()->withNotify($notify);
        }

        $code = random_int(100000, 999999);

        $user->verification_code = $code;

        $user->save();

        sendMail('PASSWORD_RESET', ['code' => $code],  $user);

        session()->put('email',$user->email);


        $notify[] = ['success', 'Send verification code to your email'];
        return redirect()->route('user.auth.verify')->withNotify($notify);
    }

    public function verify()
    {
        $email = session('email');

        $pageTitle = 'Verify Code';

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('user.forgot.password');
        }

        return view('frontend.auth.verify', compact('pageTitle', 'email'));
    }

    public function verifyCode(Request $request)
    {
        
        $request->validate([
            'code' => 'required',
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();


        $token = $user->verification_code;

        if ($user->verification_code != $request->code) {

            $user->verification_code = null;

            $user->save();

            $notify[] = ['error','Invalid Code'];

            return back()->withNotify($notify);
        }

        $user->verification_code = null;

        $user->save();

        session()->put('identification', [
            "token" => $token,
            "email" => $user->email
        ]);

        return redirect()->route('user.reset.password');
    }

    public function reset()
    {
        $session = session('identification');

        if (!$session) {

            return redirect()->route('user.login');
        }

        $pageTitle = 'Reset Password';

        return view('frontend.auth.reset', compact('pageTitle', 'session'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email', 'password' => 'required|confirmed']);

        $user = User::where('email', $request->email)->first();

        $user->password = bcrypt($request->password);

        $user->save();

        $notify[] = ['success', 'Successfully Reset Your Password'];

        return redirect()->route('user.login')->withNotify($notify);
    }

}
