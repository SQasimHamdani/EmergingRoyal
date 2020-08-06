<?php

namespace App\Http\Controllers;

use App\Advertise;
use App\Package;
use App\User;
use App\UserAdvertise;
use App\General;
use App\Transaction;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class UserPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','ckstatus']);
    }

    public function index()
    {
        return view('UserPanel.homepage');
    }

    public function profileIndex()
    {
       return view('UserPanel.profile');
    }

    public function updateProfile(Request $request)
    {

        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'month' => 'required',
            'day' => 'required',
            'year' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'post_code' => 'required',
            'country' => 'required',
            'image' => 'mimes:png,jpg,jpeg,svg,gif'
        ]);

        User::whereId(Auth::user()->id)
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile' => $request->mobile,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'post_code' => $request->post_code,
                'country' => $request->country,
                'email' => $request->email,
                'birth_day' => $request->year.'-'.$request->month.'-'.$request->day,
            ]);

        $user = User::find(Auth::user()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = 'assets/images/user_profile_pic/'. $filename;
            Image::make($image)->save($location);
            $user->image =  $filename;
            $user->save();
        }
        return redirect('home')->with('message', 'Profile Successfully Updated ');
    }

    public function securityIndex()
    {
        return view('UserPanel.changepassword');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request,[
            'passwordold' =>'required',
            'password' => 'required|min:5|confirmed'
        ]);

        try {
            $c_password = User::find($request->id)->password;
            $c_id = User::find($request->id)->id;
            $user = User::findOrFail($c_id);

            if(Hash::check($request->passwordold, $c_password)){

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();

                return redirect()->back()->with('message','Password Change Successfully.');
            }else{
                session()->flash('alert', 'Password Not Match');
                Session::flash('type', 'warning');
                return redirect()->back();
            }
        }catch (\PDOException $e) {
            session()->flash('message', 'Some Problem Occurs, Please Try Again!');
            Session::flash('type', 'warning');
            return redirect()->back();
        }

    }

    public function AvailableAdsIndex()
    {
        $general = General::first();
        $add_history = UserAdvertise::where('user_id', Auth::id())
            ->where('date',date('Y-m-d'))->count();

        if ($add_history == 0)
        {
            $advertise =  Advertise::where('quantity','>=',DB::raw('remain'))
                ->inRandomOrder()
                ->take($general->add_show_limit)
                ->where('package_status', 1)->get();
            foreach ($advertise as $data)
            {
                UserAdvertise::create([
                   'user_id' => Auth::id(),
                   'date' => date('Y-m-d'),
                   'add_id' => $data->id,
                   'status' => 1,
                ]);
            }
        }

        $add = UserAdvertise::where('user_id', Auth::user()->id)->where('date',date('Y-m-d'))->get();
        return view('UserPanel.Ads.WatchAvailableAds',compact('add'));

    }

    public function getIframe($token)
    {
        $add = Advertise::whereToken($token)->first();
        $user_add = UserAdvertise::where('user_id', Auth::user()->id)
        ->where('add_id', $add->id)
        ->where('date', date('Y-m-d'))->first();
        return view('UserPanel.Ads.AdWatchiframe', compact('add', 'user_add'));
    }

    public function submitAdVerification(Request $request)
    {
    	$id = $request->user_add;
        $advertise = $request->advertise;

	      $user_Advertise = UserAdvertise::find($id);
        if ($user_Advertise->status == 1) {
        	UserAdvertise::where('add_id', $advertise)->update(['status' => 0 ]);
            $add = Advertise::whereId($advertise)->first();
            Advertise::whereId($advertise)
                ->update([
                    'remain' => $add->remain + 1,
                ]);
            $user = User::findOrFail(Auth::user()->id);
            $new_balance = $user['balance'] = $user['balance'] + $add->price;
            $user->save();

            Transaction::create([
                'user_id' => Auth::user()->id,
                'trans_id' => rand(),
                'time' => Carbon::now(),
                'description' => 'CLICKADD'. '#ID'.'-'.'CA'.rand(),
                'amount' => $add->price ,
                'new_balance' => $new_balance,
                'type' => 1,
            ]);
        }
        else{
        	return Session::flash('wrong', 'Fruad Detected: Multiple Click Not Support!!');
        }

        

    }

    public function CreateMyAds()
    {
        $pack = Package::whereStatus(1)->get();
        return view('UserPanel.Ads.CreateMyAds', compact('pack'));
    }

    public function buyPack(Request $request)
    {
        $pack_id = $request->package_id;
        return view('fonts.marketing.create_ad', compact('pack_id'));
    }

    public function createAdvertise(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'link' => 'required',
        ]);
        $package = Package::findOrFail($request->package_id);
        $user = User::find(Auth::id());
        $new_balance = $user['balance'] =  $user['balance'] - $package['price'];
        $user->save();

        Transaction::create([
            'user_id' => Auth::user()->id,
            'trans_id' => rand(),
            'time' => Carbon::now(),
            'description' => 'BUYPACKAGE'. '#ID'.'-'.'BP'.$package->title,
            'amount' => '-'.$package['price'] ,
            'new_balance' => $new_balance,
            'type' => 9,
        ]);

        Advertise::create([
           'title' => $request->title,
           'token' => str_random(),
           'link' => $request->link,
           'quantity' => $pack->click,
           'remain' => 0,
           'user_id' => Auth::user()->id,
           'package_id' => $pack->id,
           'package_status' => 3,
        ]);

        $message ='Congratulations,Your Advertise Create Complete. Please wait for admin Confirmation.
         If your advertise reject, you will get your payment back.';
        send_email($user['email'], 'Advertise Create Complete' ,$user['first_name'], $message);

        return redirect('UserPanel.homepage')->with('message', 'Advertise Submit Complete, wait for admin confirmation');

    }

    public function myAdvertise()
    {
        $add = Advertise::where('user_id', Auth::id())->get();
        return view('UserPanel.Ads.ManageMyAds', compact('add'));
    }
}
