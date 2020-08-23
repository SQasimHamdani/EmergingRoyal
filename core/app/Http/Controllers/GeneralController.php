<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Social;
use App\User;
use App\ChargeCommision;
use App\General;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        $general = General::find(1);
        return view('AdminPanel.WebGeneral.general', compact('general'));
    }

    public function limitUpdate(Request $request, $id)
    {
        $this->validate($request,array(
            'add_show' => 'required|numeric|min:1',
            'add_show_limit' => 'required|numeric|min:1',
        ));

        General::whereId($id)
            ->update([
               'add_show' => $request->add_show,
               'add_show_limit' => $request->add_show_limit,
            ]);
        return redirect()->back()->withMsg('Successfully Updated');
    }

    public function update(Request $request, General $general, $id)
    {
        
        $this->validate($request,array(
            'web_title' => 'required',
            'currency' => 'required',
            'symbol' => 'required',
            'theme' => 'required',
            'start_date' => 'required',
            'sec_color' => 'required',
        ));

        if ($request->emailver == 'on') {
            $emailv = 0;
        }else{
           $emailv = 1;
        }

        if ($request->smsver == 'on') {
          $smsv = 0;
        }else{
            $smsv = 1;
        }

        if ($request->email_nfy == 'on') {
            $email_nfy = 1;
        }else{
            $email_nfy = 0;
        }

        if ($request->sms_nfy == 'on') {
            $sms_nfy = 1;
        }else{
            $sms_nfy = 0;
        }

        $user = User::all();
        foreach ($user as $key => $data) {
            User::whereId($data->id)
                ->update([
                    'emailv' => $emailv,
                    'smsv' => $smsv,
                ]);
        }
        General::whereId($id)->update([
            'web_title' => $request->web_title,
            'currency' => $request->currency,
            'symbol' => $request->symbol,
            'theme' => $request->theme,
            'sec_color' => $request->sec_color,
            'email_nfy' => $email_nfy,
            'sms_nfy' => $sms_nfy,
            'emailver' => $emailv,
            'smsver' => $smsv,
            'start_date' =>  date('Y-m-d', strtotime($request->start_date))
        ]);

        return redirect()->back()->withMsg('Successfully Updated');
    }


    public function indexCommision(Request $request)
    {
        $charge = ChargeCommision::findOrFail(1);
        return view('AdminPanel.PTC.commision', compact('charge'));
    }

    public function indexFooter(Request $request)
    {
        $general = General::first();
        return view('AdminPanel.WebGeneral.footer', compact('general'));
    }

    public function updateFooter(Request $request)
    {
        $this->validate($request,array(
            'footer' => 'required',
            'footer_text' => 'required',
        ));
        $general = General::first();
        $input = Input::except(array('_method', '_token'));
        General::whereId($general->id)->update($input);
        return redirect()->back()->withMsg('Successfully Updated');
    }


    public function indexAbout(Request $request)
    {
        $general = General::first();
        return view('AdminPanel.WebGeneral.about', compact('general'));
    }

    public function updateAbout(Request $request, $id)
    {
        $general = General::find($id);
        $this->validate($request,array(

            'image' => 'mimes:jpeg,jpg,png',
            'about_text' => 'required',
        ));

        $general->about_text = $request->input('about_text');

        if ($request->hasFile('image')) {
            unlink('assets/images/about_image/'.$general->image);
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $location = 'assets/images/about_image/'. $filename;
            Image::make($image)->save($location);
            $general->image =  $filename;
        }
        $general->save();

        return redirect()->back()->withMsg('Successfully Updated');
    }

    public function UpdateCommision( Request $request, $id)
    {
        $this->validate($request,array(
            'transfer_charge' => 'required',
            'withdraw_charge' => 'required',
            'update_charge' => 'required',
            'update_commision_tree' => 'required',
            'update_commision_sponsor' => 'required',
            'match_bonus' => 'required',
            'update_text' => 'required',
        ));
         ChargeCommision::whereId($id)->update([
            'transfer_charge' => $request->transfer_charge,
            'withdraw_charge' => $request->withdraw_charge,
            'update_charge' => $request->update_charge,
            'update_commision_tree' => $request->update_commision_tree,
            'update_commision_sponsor' => $request->update_commision_sponsor,
            'update_text' => $request->update_text,
            'match_bonus' => $request->match_bonus,
        ]);
        return redirect()->back()->withMsg('Successfully Updated');
    }

}
