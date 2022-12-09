<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Chat;
use App\Models\FaqCategory;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use App\Models\Review;
use App\Models\Schedule;
use App\Models\SectionData;
use App\Models\Service;
use App\Models\Subscribe;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\WithdrawLog;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function home()
    {
        $pageTitle = 'Admin Dashboard';

        $totalUser = User::where('user_type', 1)->count();
        $totalProvider = User::where('user_type', 2)->count();
        $totalService = Service::count();
        $totalCategory = Category::count();
        $providers = User::where('user_type', 2)->paginate(10);
        $users = User::where('user_type', 1)->paginate(10);


        // Monthly Deposit & Withdraw Report Graph
        $payment['months'] = collect([]);
        $payment['deposit_month_amount'] = collect([]);
        $payment['withdraw_month_amount'] = collect([]);

        $depositsMonth = Booking::whereYear('created_at', '>=', now()->subYear())
        ->selectRaw("SUM( CASE WHEN payment_confirmed = 1 THEN amount END) as payments")
            ->selectRaw("DATE_FORMAT(created_at,'%M') as months")
            ->orderBy('created_at')
            ->groupBy(DB::Raw("MONTH(created_at)"))->get();

            
        
        $depositsMonth->map(function ($q) use ($payment) {
           
            $payment['months']->push($q->months);
            $payment['deposit_month_amount']->push(number_format($q->payments,2));
        });


       
        

        $withdrawalMonth = WithdrawLog::whereYear('created_at', '>=', now()->subYear())->where('status', 1)
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as withdrawAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M') as months")
            ->orderBy('created_at')
            ->groupBy(DB::Raw("MONTH(created_at)"))->get();
        $withdrawalMonth->map(function ($q) use ($payment) {
            $payment['withdraw_month_amount']->push(number_format($q->withdrawAmount,2));
        });

       


        // Withdraw Graph
        $withdrawal = WithdrawLog::where('created_at', '>=', now()->subDays(30))->where('status', 1)
            ->select(array(DB::Raw('sum(amount)   as totalAmount'), DB::Raw('DATE(created_at) day')))
            ->groupBy('day')->get();
        $withdrawals['per_day'] = collect([]);
        $withdrawals['per_day_amount'] = collect([]);
        $withdrawal->map(function ($a) use ($withdrawals) {
            $withdrawals['per_day']->push(date('d M', strtotime($a->day)));
            $withdrawals['per_day_amount']->push($a->totalAmount + 0);
        });



        return view('admin.dashboard', compact('pageTitle', 'totalUser', 'totalProvider', 'totalService', 'totalCategory', 'providers', 'users','payment','depositsMonth','withdrawals','withdrawalMonth'));
    }

    public function changeLang(Request $request, $code = '')
    {
       
        $language = Language::where('shortcode', $code)->first();
        
        if (!$language){
            $code = 'en';  
        } 
        $request->session()->put('lang', $code);
       
        return redirect()->route('admin.dashboard');
    }

    public function clearDatabase ()
    {
        Category::truncate();
        Service::truncate();
        Booking::truncate();
        Schedule::truncate();
        Chat::truncate();
        User::truncate();
        Transaction::truncate();
        Subscribe::truncate();
        WithdrawLog::truncate();
        Withdraw::truncate();
        BlogComment::truncate();
        BlogCategory::truncate();
        FaqCategory::truncate();
        Review::truncate();
        SectionData::truncate();
        Page::truncate();
        File::deleteDirectory(filePath('category'));
        File::deleteDirectory(filePath('service'));
        File::deleteDirectory(filePath('user'));

        $jsonUrl = resource_path('views/').'sections.json';

        $sections = json_decode(file_get_contents($jsonUrl),true);

        foreach($sections as $key => $value){
            File::deleteDirectory(filePath($key));
        }
        

        $notify[] = ['success', 'Database Cleared Successfully'];

        return redirect()->route('admin.dashboard')->withNotify($notify);
    }

    public function profile()
    {
        $pageTitle = 'Profile';

        return view('admin.profile', compact('pageTitle'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png'
        ]);

        $admin = auth()->guard('admin')->user();

        if ($request->has('image')) {

            $filename = uploadImage($request->image, filePath('profile'),$admin->image);

            $admin->image = $filename;
        }


        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->save();


        $notify[] = ['success', 'Admin Profile Update Success'];

        return redirect()->back()->withNotify($notify);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $admin = auth()->guard('admin')->user();

    

        $admin->password = bcrypt($request->password);
        $admin->save();


        $notify[] = ['success', 'Password changed Successfully'];

        return back()->withNotify($notify);
    }

    public function loginPage()
    {
        $pageTitle = 'Login Setting ';

        return view('admin.setting.login_setting', compact('pageTitle'));
    }

    public function loginPageUpdate(Request $request)
    {
        $general = GeneralSetting::first();

        $request->validate([
            'login_image' => [Rule::requiredIf($general->login_page->login_image == null), 'image', 'mimes:jpg,png,jpeg'],
            'overlay' => 'required'
        ]);

        if ($request->hasFile('login_image')) {

            $filename = uploadImage($request->login_image, filePath('login'), $general->login_page->login_image ?? '');
        }

        $general->update([
            'login_page' => [
                'login_image' => $filename ?? $general->login_page->login_image,
                'overlay' => $request->overlay
            ]
        ]);

        $notify[] = ['success', 'Login Setting Updated Successfully'];

        return back()->withNotify($notify);
    }

    public function transaction(Request $request)
    {
        $pageTitle = "Transactions";

        $transactions = Transaction::when($request->search,function($q) use($request){
            $q->where('trx','like', $request->search);
        })->latest()->with('user')->paginate();

        return view('admin.transaction', compact('pageTitle', 'transactions'));
    }

    public function blogComment()
    {
        $pageTitle = 'Blog Comments';

        $comments = BlogComment::whereHas('blog')->latest()->paginate();


        return view('admin.blog_comment',compact('pageTitle','comments'));
    }

    public function blogCommentUpdate(Request $request, BlogComment $comment)
    {
        $request->validate(['status' => 'required|in:0,1']);

        $comment->disabled = $request->status;

        $comment->save();

        $notify[] = ['success', 'Update Blog Comment Successfully'];

        return back()->withNotify($notify);
    }
}
