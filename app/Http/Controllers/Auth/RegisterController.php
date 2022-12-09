<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function index()
    {
        $pageTitle = 'Register User';

        return view('frontend.auth.register', compact('pageTitle'));
    }

    public function register(Request $request)
    {
        
       $request->validate([
            'user_type' => 'required|in:1,2',
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ],[
            'fname.required'=> 'First name is required',
            'lname.required' => 'Last name is required'
        ]);

        $slug = Str::slug($request->username);
       

        $user = $this->create($request, $slug);

        $code = random_int(100000, 999999);

        sendMail('VERIFY_EMAIL',['code' => $code],$user);

        session()->put('user', $user->id);

        $user->verification_code = $code;
        $user->save();

        $notify[] = ['success','A code Send to your email'];

        return redirect()->route('user.email.verify')->withNotify($notify);
    }

    public function dashboard()
    {
        if (auth()->check()) {
            return view('frontend.user.dashboard');
        }

        return redirect()->route('user.login')->withSuccess('You are not allowed to access');
    }

    public function create($request,$slug)
    {
       
        return User::create([
            'user_type' => $request->user_type,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'slug' => $slug
        ]);
    }

    public function signOut()
    {
        Auth::logout();

        return Redirect()->route('user.login');
    }
}
