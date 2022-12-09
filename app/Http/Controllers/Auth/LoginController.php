<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
       $pageTitle = 'Login Page';

       return view('frontend.auth.login',compact('pageTitle'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user){
            $notify[] = ['error','No user found associated with this email'];
             return redirect()->route('user.login')->withNotify($notify);
        }

        if($user->ev == 0){
            
            $code = random_int(100000, 999999);

            session()->put('user' , $user->id);

            sendMail('VERIFY_EMAIL',['code' => $code],$user);

            $user->verification_code = $code;

            $user->save();

            $notify[] = ['error','Please active your account, Verification code send to your email'];

            return redirect()->route('user.email.verify')->withNotify($notify);
        }
   
        if (Auth::attempt($data)) {

            $notify[] = ['success','Successfully logged in'];

            return redirect()->intended('user/dashboard')
                        ->withNotify($notify);
        }
        
        $notify[] = ['error','Invalid Credentials'];
        return redirect()->route('user.login')->withNotify($notify);
    }

    
    public function emailVerify()
    {
       $pageTitle = "Email Verify";

       return view('frontend.auth.email',compact('pageTitle'));
    }

    public function emailVerifyConfirm(Request $request)
    {
        $request->validate(['code' => 'required']);
        
        $user = User::findOrFail(session('user'));

        if($request->code == $user->verification_code){
            $user->verification_code = null;
            $user->ev = 1;
            $user->save();

            Auth::login($user);

            $notify[] = ['success','Successfully verify your account'];

            return redirect()->route('user.dashboard')->withNotify($notify);
        }

        $notify[] = ['error','Invalid Code'];

        return back()->withNotify($notify);
    }
}
