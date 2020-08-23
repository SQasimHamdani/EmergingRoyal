<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Advertise;
use App\Deposit;
use App\Package;
use App\PackageDetail;
use App\Transaction;
use App\User;
use App\General;
use App\Withdraw;
use App\WithdrawTrasection;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function saveResetPassword(Request $request){

        
        $this->validate($request,[
            'passwordold' =>'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $c_password = Admin::find($request->id)->password;
            $c_id = Admin::find($request->id)->id;
            $user = Admin::findOrFail($c_id);
            if(Hash::check($request->passwordold, $c_password)){
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                return redirect()->back()->withMsg('Password Changes Successfully.');
            }else{
                session()->flash('message', 'Password Not Matched');
                Session::flash('type', 'warning');
                return redirect('admin/home');
            }
        } catch (\PDOException $e) {
            session()->flash('message', 'Some Problem Occurs, Please Try Again!');
            Session::flash('type', 'warning');
            return redirect('admin/home');
        }

    }

    public function usersIndex(){
        $user = User::orderBy('id', 'desc')->paginate(15);
        return view('AdminPanel.Users.index', compact('user'));
    }


    public function indexUserDetail($id)
    {
        $user = User::find($id);
        return view('AdminPanel.Users.view',compact('user'));
    }

    public function userUpdate(Request $request ,$id)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'birth_day' => 'required',
            'city' => 'required',
            'country' => 'required',
        ]);

        if ($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        if ($request->emailv == 'on'){
            $emailv = 0;
        }else{
            $emailv = 1;
        }

        if ($request->smsv == 'on'){
            $smsv = 0;
        }else{
            $smsv = 1;
        }

        User::whereId($id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'birth_day' => $request->birth_day,
            'city' => $request->city,
            'country' => $request->country,
            'status' => $status,
            'emailv' => $emailv,
            'smsv' => $smsv,
        ]);
        return redirect()->back()->withMsg('Successfully Updated');
    }
    public function userDelete(Request $request ,$id)
    {
        
        User::where('id', $id)->delete();
        return redirect()->back()->withMsg('User Successfully Deleted');
    }

    public function indexUserBalance($id)
    {
        $user = User::find($id);
        return view('AdminPanel.Users.balance',compact('user'));
    }

    public function indexBalanceUpdate(Request $request ,$id)
    {
        $this->validate($request,[
            'amount' => 'required|numeric|min:1',
            'message' => 'required',
        ]);

            if ($request->operation == 'on'){
                $user = User::find($id);
                $new_balance = $user['balance'] =  $user['balance'] + $request->amount;
                $user->save();
                $message = $request->message;

                Transaction::create([
                    'user_id' => $id,
                    'trans_id' => rand(),
                    'time' => Carbon::now(),
                    'description' => 'ADMIN'. '#ID'.'-'.'ADD'.rand(),
                    'amount' => $request->amount,
                    'new_balance' => $new_balance,
                    'type' => 5,
                ]);

                send_email($user['email'], 'Admin Balance Add' ,$user['first_name'], $message);


                $sms = $request->message;
                send_sms($user['mobile'], $sms);
                return redirect()->back()->withMsg('Balance Add Successful');
            }else{
                $user = User::find($id);
                if ($user->balance > $request->amount){
                    $new_balance = $user['balance'] =  $user['balance'] - $request->amount;
                    $user->save();
                    $message = $request->message;

                    Transaction::create([
                        'user_id' => $id,
                        'trans_id' => rand(),
                        'time' => Carbon::now(),
                        'description' => 'ADMIN'. '#ID'.'-'.'SUBTRACT'.rand(),
                        'amount' => '-'.$request->amount,
                        'new_balance' => $new_balance,
                        'type' => 6,
                    ]);

                    send_email($user['email'], 'Admin Balance Subtract' ,$user['first_name'], $message);
                    $sms = $request->message;
                    send_sms($user['mobile'], $sms);
                    return redirect()->back()->withMsg('Balance Subtract Successful');
                    }
                return redirect()->back()->withdelmsg('Insufficient Balance');
            }

    }

    public function userSendMail($id)
    {
        $user = User::find($id);
        return view('AdminPanel.Users.user_mail',compact('user'));
    }

    public function userSendMailUser(Request $request, $id)
    {
        $user = User::find($id);
        $subject =$request->subject;
        $message = $request->message;
        send_email($user['email'], $subject ,$user['first_name'], $message);
        return redirect()->back()->withMsg('Mail Send');

    }


    public function userSearch(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user == ''){
            $user_notfound = 0;
            return redirect()->back()->with( 'not_found', 'Oops, User Not Found!');
        }else{
            return view('AdminPanel.Users.view', compact('user'));
        }
    }

    public function userSearchEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == ''){
            $user_notfound = 0;
            return redirect()->back()->with( 'not_found', 'Oops, User Not Found!');
        }else{
            return view('AdminPanel.Users.view', compact('user'));
        }
    }

    public function paidUser()
    {
        $user = User::orderBy('id', 'desc')->where('paid_status', 1)->paginate(15);
        return view('AdminPanel.Users.paid', compact('user'));
    }

    public function freeUser()
    {
        $user = User::orderBy('id', 'desc')->where('paid_status', 0)->paginate(15);
        return view('AdminPanel.Users.free', compact('user'));
    }

    public function userdepositLog()
    {
        $add_fund = Deposit::where('status', 1)->orderBy('id', 'desc')->get();
        return view('AdminPanel.Users.deposit_log', compact('add_fund'));
    }

    public function transView($id)
    {
        $trans_object = Transaction::where('user_id', $id)->first();
        $trans = Transaction::where('user_id', $id)->orderBy('id', 'desc')->get();
        return view('AdminPanel.Users.trans_view', compact('trans', 'trans_object'));
    }

    public function depositView($id)
    {
        $trans_object = Deposit::where('user_id', $id)->first();
        $trans = Deposit::where('user_id', $id)->where('status', 1)->orderBy('id', 'desc')->get();
        return view('AdminPanel.Users.deposit_view', compact('trans', 'trans_object'));
    }

    public function sendMoneyView($id)
    {
        $trans_object = Transaction::where('user_id', $id)->first();
        $trans = Transaction::where('user_id', $id)->where('type', 3)->orderBy('id', 'desc')->get();
        return view('AdminPanel.Users.send_money_view', compact('trans', 'trans_object'));
    }

    public function withDrawView($id)
    {
        $trans_object = WithdrawTrasection::where('user_id', $id)->first();
        $trans = WithdrawTrasection::where('user_id', $id)->where('status', 1)->orderBy('id', 'desc')->get();
        return view('AdminPanel.Users.withdraw_view', compact('trans', 'trans_object'));
    }

    public function newAddvertise()
    {
        $add = Advertise::orderBy('id', 'desc')->where('package_status', 1)->paginate(15);
        return view('AdminPanel.PTC.add', compact('add'));
    }

    public function newAddvertiseStore(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'link' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1',
        ]);

        Advertise::create([
            'title' => $request->title,
            'link' => $request->link,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'package_status' => 1,
            'token' => $request->token,
            'remain' => 0,
        ]);
        return redirect()->back()->withMsg('Successfully Create');
    }

    public function newAddvertiseEdit($id)
    {
        $add = Advertise::findOrFail($id);
        return view('AdminPanel.PTC.edit', compact('add'));
    }

    public function limitIndex()
    {
        return view('AdminPanel.PTC.settings');
    }

    public function newAddvertiseUpdate(Request $request,$id)
    {
        $this->validate($request,[
            'title' => 'required',
            'link' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1',
        ]);
        $add = Input::except(['_method', '_token']);
        Advertise::whereId($id)->update($add);
        return redirect('admin/add/new')->withMsg('Successfully Update');
    }

    public function newAddvertiseDelete($id)
    {
        Advertise::whereId($id)->delete();
        return redirect()->back()->withMsg('Successfully Deleted');
    }

    public function packageIndex()
    {
        $pack = Package::all();
        return view('AdminPanel.PTC.package.index', compact('pack'));
    }

    public function packageStore(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required|numeric|min:0',
            'click' => 'required|numeric|min:1',
        ]);
       $pack =  Package::create([
            'status' => 1,
            'title' => $request->title,
            'price' => $request->price,
            'click' => $request->click,
        ]);
        foreach ($request->detail as $data)
        {
            PackageDetail::create([
                'package_id' => $pack->id,
                'detail' => $data
            ]);
        }
        return redirect()->back()->withMsg('Successfully Create');
    }

    public function packageDelete($id)
    {
        PackageDetail::where('package_id', $id)->delete();
        Package::whereId($id)->delete();
        return redirect()->back()->withMsg('Successfully Delete');
    }

    public function packageEdit($id)
    {
        $pack = Package::findOrFail($id);
        return view('AdminPanel.PTC.package.edit',compact('pack'));
    }

    public function packageUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required|numeric|min:0',
            'click' => 'required|numeric|min:1',
        ]);
        if ($request->status == 'on')
        {
            $status = 1;
        }else{
            $status = 0;
        }

        Package::where('id', $id)
            ->update([
                'status' => $status,
                'title' => $request->title,
                'price' => $request->price,
                'click' => $request->click,
            ]);

        for ($i = 0; $i < count($request->detail); $i++) {
            PackageDetail::updateOrCreate(['id' => $request->deg_id[$i],], [
                'detail' => $request->detail[$i],
                'package_id' => $id
            ]);
        }

        return redirect('admin/ptc/packages')->withMsg('Updated');
    }

    public function packageDetailDelete(Request $request)
    {
        $packa = $request->id;
        PackageDetail::destroy($packa);
        return $packa;
    }

    public function reqAddIndex()
    {
        $add = Advertise::where('package_status', 3)->paginate(15);
        return view('AdminPanel.PTC.req_advertise.index', compact('add'));
    }

    public function approveAdd(Request $request)
    {
        $this->validate($request,[
            'advertise_id' => 'required',
            'user_id' => 'required',
            'price' => 'required',
        ]);

        Advertise::whereId($request->advertise_id)
            ->update([
                'package_status' => 1,
                'price' => $request->price,
            ]);
        $user = User::findOrFail($request->user_id);
        $message ='Congratulations,Your Advertise Approved. Your Advertise on live.';
        send_email($user['email'], 'Advertise Create Complete' ,$user['first_name'], $message);

        $sms =  'Congratulations,Your Advertise Approved. Your Advertise on live';
        send_sms($user->mobile, $sms);
        return redirect()->back()->withMsg('Approved');
    }

    public function rejectAdd(Request $request)
    {
        $this->validate($request,[
            'advertise_id' => 'required',
            'user_id' => 'required',
            'package_id' => 'required',
        ]);

        Advertise::whereId($request->advertise_id)
            ->update(['package_status' => 0]);
        $pack = Package::findOrFail($request->package_id);
        $user = User::findOrFail($request->user_id);
        $new_balance = $user['balance'] =  $user['balance'] + $pack['price'];
        $user->save();

        Transaction::create([
            'user_id' => $user['id'],
            'trans_id' => rand(),
            'time' => Carbon::now(),
            'description' => 'BACKMONEY'. '#ID'.'-'.'BM'.rand(),
            'amount' => $pack['price'] ,
            'new_balance' => $new_balance,
            'type' => 1,
        ]);

        $message ='Your Advertise Rejected. Please try another advertise. Your buying package payment back';
        send_email($user['email'], 'Advertise Reject' ,$user['first_name'], $message);

        $sms =  'Your Advertise Rejected. Please try another advertise';
        send_sms($user->mobile, $sms);
        return redirect()->back()->withMsg('Successfully Rejected');
    }

    public function rejectAddIndex()
    {
        $add = Advertise::where('package_status', 0)->paginate(15);
        return view('AdminPanel.PTC.req_advertise.reject_ad', compact('add'));
    }

    public function allAddIndex()
    {
        $add = Advertise::where('user_id' ,'!=' , null)->where('package_status', 1)->paginate(15);
        return view('AdminPanel.PTC.req_advertise.all_ad', compact('add'));
    }

    

    public function buyPackageHistory()
    {
        $pack = Transaction::where('type', 9)->get();
        return view('AdminPanel.PTC.buy_package_log', compact('pack'));
    }

}