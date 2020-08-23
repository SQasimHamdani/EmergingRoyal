<?php

namespace App\Http\Controllers;

use App\ChargeCommision;
use App\Deposit;
use App\Gateway;
use App\Lib\GoogleAuthenticator;
use App\Menu;
use App\Newsletter;
use App\Package;
use App\Service;
use App\Silder;
use App\Team;
use App\Testimonal;
use App\General;
use App\User;
use App\WithdrawTrasection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;

use Illuminate\Foundation\Auth\RegistersUsers;

class FrontEndController extends Controller

{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function FrontEndIndex()
    {
        $service = User::all()->count();
        // $service = Service::all();
        // $slider = Silder::findOrFail(20);
        // $commision = ChargeCommision::first();
        // $team = Team::all();
        // $testimonial = Testimonal::all();
        // $pack = Package::where('status', 1)->get();
        // $gateway = Gateway::where('status', 1)->get();
        // $deposit = Deposit::orderBy('id', 'desc')->where('status', 1)->take(5)->get();
        // $withdraw = WithdrawTrasection::orderBy('id', 'desc')->where('status', 1)->take(5)->get();
        // return view('fonts.index',compact('service',
        //     'slider', 'commision', 'team', 'testimonial',
        //     'gateway', 'deposit', 'withdraw', 'pack'));
        return view('FrontEnd.index', compact($service));
    }
    public function FrontEndAdvertiserIndex()
    {
        
        $pack = Package::whereStatus(1)->get();
        return view('FrontEnd.advertiser', compact('pack'));
        
    }

    public function FrontEndMemberIndex()
    {
        return view('FrontEnd.member');
    }


    public function showFrontEndLoginForm()
    {
        
        if (Auth::check()){
            
            return redirect()->route('home');
        }
        else{

            return view('FrontEnd.login');
        }
    }

    public function actionLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $request['username'], 'password' => $request['password']])) {
            return redirect()->route('home');
        }
        return redirect() -> back() ->with(['errors', 'Something is wrong with this field!']);
    }


    public function showFrontEndRegisterForm()
    {
        if (Auth::check()){
            return redirect()->route('home');
        }
        else{
            return view('FrontEnd.register2');
        }
    }



    public function actionRegister(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => ['required', 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/'],
            'last_name' => ['required', 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/'],
            'birth_day' => 'required',
            'mobile' => 'required',
            'street_address' => 'required',
            'city' => ['required', 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/'],
            'post_code' => 'required|numeric|min:0',
            'country' => 'required',
            'username' => 'required',
        ]);
        $data = $request->all();
        // $email = $request['email'];
        // $name = $request['name'];
        // $username = $request['username'];
        // $password = bcrypt($request['password']);

        // $user = new User();
        // $user->email = $email;
        // $user->name = $name;
        // $user->username = $username;
        // $user->password = $password;

        // $user->save();
        

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'referrer_id' => 1,
            'position' => 'L',
            'mobile' => $data['mobile'],
            'street_address' => $data['street_address'],
            'city' => $data['city'],
            'post_code' => $data['post_code'],
            'country' => $data['country'],
            'username' => $data['username'],
            'birth_day' =>  date('Y-m-d',strtotime($data['birth_day'])),
            'join_date' => Carbon::today(),
            'balance' => 0,
            'status' => 1,
            'paid_status' => 0,
            'ver_status' => 0,
            'ver_code' => 0,
            'forget_code' => 0,
            'tauth' => 0,
            'tfver' => 1,
            'emailv' => 1,
            'smsv' => 1,
        ]);
        // // $user = User::find(Auth::id());
        // $user = User::where('email', $data['email'])->first();
        // Auth::login($user);
        
        // return redirect() -> back();
        // $user = $this->create($request->all());
        // event(new Registered($user = $this->create($request->all())));
        // $this->guard()->login($user);

        // return $this->registered($request, $user)?: redirect($this->redirectPath());
        // return redirect($this->redirectPath());
        return view('FrontEnd.login');
        return redirect() -> back() ->with(['success', 'Account Created Successfully. Please Procceed to Login']);
    }

    

    public function logout()
    {
        //
        Auth::logout();
        return view('FrontEnd.login');
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $general = General::first();
        send_email($general->email,'Contact Us Message', 'I am '.' '.$request->name, $request->message);

        return redirect()->back()->with('message', 'Message Send Complete');
    }

    

    public function authorization()
    {
        if(Auth::user()->tfver == '1' && Auth::user()->status == '1' && Auth::user()->emailv == 1 && Auth::user()->smsv == 1)
        {
            return redirect('home');
        }
        else
        {
            return view('auth.notauthor');
        }
    }

    public function sendemailver()
    {
        $user = User::find(Auth::id());
        $chktm = $user->vsent+1000;
        if ($chktm >time())
        {
            $delay = $chktm-time();
            return back()->with('alert', 'Please Try after '.$delay.' Seconds');
        }
        else
        {
            $code = substr(rand(),0,6);
            $message = 'Your Verification code is: '.$code;
            $user['vercode'] = $code ;
            $user['vsent'] = time();
            $user->save();
           send_email($user->email,'Verification Code', $user['first_name'], $message);

            $sms = $message;
            send_sms($user['mobile'], $sms);
            return back()->with('success', 'Email verification code sent succesfully');
        }

    }
    


    

    public function emailverify(Request $request)
    {

        $this->validate($request, [
            'code' => 'required'
        ]);
        $user = User::find(Auth::id());

        $code = $request->code;
        if ($user->vercode == $code)
        {
            $user['emailv'] = 1;
            $user['vercode'] = str_random(10);
            $user['vsent'] = 0;
            $user->save();

            return redirect('home')->with('success', 'Email Verified');
        }
        else
        {
            return back()->with('alert', 'Wrong Verification Code');
        }

    }


    public function verify2fa( Request $request)
    {
        $user = User::find(Auth::id());

        $this->validate($request,
            [
                'code' => 'required',
            ]);
        $ga = new GoogleAuthenticator();

        $secret = $user->secretcode;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['tfver'] = 1;
            $user->save();
            return redirect('home');
        } else {

            return back()->with('alert', 'Wrong Verification Code');
        }

    }


    public function forgotPass(Request $request)
    {
        $this->validate($request,[
                'email' => 'required',
            ]);
        $user = User::where('email', $request->email)->first();
        if ($user == null)
        {
            return back()->with('alert', 'Email Not Available');
        }
        else
        {
            $to =$user->email;
            $name = $user->first_name;
            $subject = 'Password Reset';
            $code = str_random(30);
            $message = 'Use This Link to Reset Password: '.url('/').'/reset/'.$code;

            DB::table('password_resets')->insert(
                ['email' => $to, 'token' => $code, 'status' => 0, 'created_at' => date("Y-m-d h:i:s")]
            );

            send_email($to, $subject, $name, $message);

            return back()->with('message', 'Password Reset Email Sent Succesfully');
        }

    }

    public function resetLink($code)
    {
        $reset = DB::table('password_resets')->where('token', $code)->orderBy('created_at', 'desc')->first();
        if ( $reset->status == 1)
        {
            return redirect()->route('login')->with('alert', 'Invalid Reset Link');
        }else{
            return view('auth.passwords.reset', compact('reset'));
        }

    }

    public function passwordReset(Request $request)
    {
        $this->validate($request,[
                'email' => 'required',
                'token' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required',
            ]);

        $reset = DB::table('password_resets')->where('token', $request->token)->orderBy('created_at', 'desc')->first();
        $user = User::where('email', $reset->email)->first();
        if ( $reset->status == 1)
        {
            return redirect()->route('login')->with('alert', 'Invalid Reset Link');
        }
        else
        {
            if($request->password == $request->password_confirmation)
            {
                $user->password = bcrypt($request->password);
                $user->save();

                DB::table('password_resets')->where('email', $user->email)->update(['status' => 1]);

                $msg =  'Password Changed Successfully';
                send_email($user->email,'Password Changed', $user->username, $msg);
                $sms =  'Password Changed Successfully';
                send_sms($user->mobile, $sms);

                return redirect()->route('login')->with('success', 'Password Changed');
            }
            else
            {
                return back()->with('alert', 'Password Not Matched');
            }
        }
    }
     public function pageNotFound()
    {
        return view('error.404');
    }

    public function storeSubscriber(Request $request)
    {

        if ($request->email == '' || $request->email == null){
            return "<div class=\"alert alert-danger\">Please Input Valid Email And Name</div>";
        }
        $already = Newsletter::where('email', $request->email)->count();

        if ($already == 0){
            Newsletter::create([
                'email' => $request->email,
            ]);

            $message = 'Welcome, You will get our every news. Stay with me. And we will tell you
        about our every New Feature.';
            send_email($request->email, 'Subscribe Complete', 'Subscriber' , $message);

            return "<div class=\"alert alert-success\">Successfully Subscribe</div>";
        }else{
            return "<div class=\"alert alert-danger\">Email Already Exist</div>";
        }
    }

}
