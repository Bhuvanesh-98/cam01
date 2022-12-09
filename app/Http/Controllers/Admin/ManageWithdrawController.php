<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\Withdraw;
use App\Models\WithdrawLog;
use Illuminate\Http\Request;

class ManageWithdrawController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Withdraw Methods';

        $search = $request->search;

        $withdraws = Withdraw::when($search, function($q) use($search){$q->where('name','LIKE','%'.$search.'%');})->latest()->paginate(10);

        return view('admin.withdraw.index', compact('pageTitle', 'withdraws'));
    }

    public function withdrawMethodCreate (Request $request)
    {
        $request->validate([
            'name' => 'required|unique:withdraw_gateways,name',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'charge_type' => 'required|in:fixed,percent',
            'charge' => 'required|numeric',
            'status' => 'required|in:0,1',
            'withdraw_instruction' => 'sometimes'
        ]);

        Withdraw::create([
            'name' => $request->name,
            'min_withdraw' => $request->min_amount,
            'max_withdraw' => $request->max_amount,
            'charge_type' => $request->charge_type,
            'charge' => $request->charge,
            'status' => $request->status,
            'withdraw_instruction' => $request->withdraw_instruction
        ]);

        $notify[] = ['success', 'Withdraw Method Created'];
        return redirect()->back()->withNotify($notify);
    }

    public function withdrawMethodUpdate (Request $request, Withdraw $method)
    {
        $request->validate([
            'name' => 'required|unique:withdraw_gateways,name,'.$method->id,
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'charge_type' => 'required|in:fixed,percent',
            'charge' => 'required|numeric',
            'status' => 'required|in:0,1',
            'withdraw_instruction' => 'sometimes'
        ]);

       $method->update([
            'name' => $request->name,
            'min_withdraw' => $request->min_amount,
            'max_withdraw' => $request->max_amount,
            'charge_type' => $request->charge_type,
            'charge' => $request->charge,
            'status' => $request->status,
            'withdraw_instruction' => $request->withdraw_instruction
        ]);

        $notify[] = ['success', 'Withdraw Method Updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function withdrawMethodDelete(Withdraw $method)
    {
        $ifPending = $method->withdrawLogs()->where('status',0)->count();

        if($ifPending > 0){
            $notify[] = ['error', 'Withdraw request is pending under this method.'];
            return redirect()->back()->withNotify($notify);
        }

        $method->delete();

        $notify[] = ['success', 'Withdraw Method Deleted Successfully'];
        return redirect()->back()->withNotify($notify);

    }

    public function accepted()
    {
        $pageTitle = 'Accepted Withdraws';

        $withdrawlogs = WithdrawLog::where('status', 1)->latest()->with('withdraw','user')->paginate(10);

        return view('admin.withdraw.withdraw_all',compact('pageTitle','withdrawlogs'));
    }
    public function pending()
    {
        $pageTitle = 'Pending Withdraws';

        $withdrawlogs = WithdrawLog::where('status', 0)->latest()->with('withdraw','user')->paginate(10);

        return view('admin.withdraw.withdraw_all',compact('pageTitle','withdrawlogs'));
    }
    public function rejected()
    {
        $pageTitle = 'Rejected Withdraws';

        $withdrawlogs = WithdrawLog::where('status', 2)->latest()->with('withdraw','user')->paginate(10);

        return view('admin.withdraw.withdraw_all',compact('pageTitle','withdrawlogs'));
    }

    public function withdrawAccept(WithdrawLog $withdraw)
    {
        $general = GeneralSetting::first();
        $withdraw->status = 1;
        $withdraw->save();

        Transaction::create([
            'trx' => $withdraw->trx,
            'user_id' => $withdraw->user->id,
            'amount' => $withdraw->amount,
            'currency' => $general->site_currency,
            'charge' => $withdraw->charge,
            'details' => 'Withdraw via '.$withdraw->withdraw->name,
            'type' => '-'
        ]);


        sendMail('WITHDRAW_ACCEPTED',['amount'=>$withdraw->amount, 'method' => $withdraw->withdraw->name,'trx'=> $withdraw->trx,'currency' => $general->site_currency], $withdraw->user);
        
        $notify[] = ['success', 'Withdraw Accepted Successfully'];
        return redirect()->back()->withNotify($notify);
    }


    public function withdrawReject(Request $request, WithdrawLog $withdraw)
    {
       $request->validate(['reason_of_reject' => 'required']);
    
        $general = GeneralSetting::first();
        $withdraw->status = 2;
        $withdraw->reason_of_reject = $request->reason_of_reject;
        $withdraw->save();

        $withdraw->user->balance = $withdraw->user->balance + $withdraw->amount;
        $withdraw->user->save();

        Transaction::create([
            'trx' => $withdraw->trx,
            'user_id' => $withdraw->user->id,
            'amount' => $withdraw->amount,
            'currency' => $general->site_currency,
            'charge' => $withdraw->charge,
            'details' => 'Rejected Withdraw via '.$withdraw->withdraw->name,
            'type' => '+',

        ]);

        sendMail('WITHDRAW_REJECTED',['amount'=>$withdraw->amount, 'method' => $withdraw->withdraw->name,'trx'=> $withdraw->trx,'currency' => $general->site_currency,'reason' => $withdraw->reason_of_reject], $withdraw->user);
        
        $notify[] = ['success', 'Withdraw Rejected Successfully'];
        return redirect()->back()->withNotify($notify);

    }
}
