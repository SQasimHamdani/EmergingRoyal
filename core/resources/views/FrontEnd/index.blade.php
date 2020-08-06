@extends('FrontEnd.template')
@section('title','Welcome to Emerging Royal')
@section('content')
    <div data-bs-parallax-bg="true" class="highlight-blue" style="background-color: rgb(67,105,175);background: url(assets/img/mountain_bg.jpg);filter: blur(0px);background-image: url(&quot;assets/img/contactus-banner.png&quot;);background-repeat: no-repeat;background-size: cover;background-position: center;height: 550px;">
        <div class="container">
            <div class="intro">
                <h1 class="text-center shadow-lg" style="font-size: 40px;padding: 60px;filter: blur(0px) brightness(200%);background-color: rgba(28,28,28,0.71);font-weight: 400;">Welcome to Pakistan's <br>Very First MEDIA AGENCY<br><strong>EMERGING ROYAL</strong></h1>
                <p class="text-center" style="margin-top: 20px;background-color: #233641;padding: 10px;font-size: 18px;">Reach Us and Get the Task Done</p>
            </div>
            <div class="buttons"></div>
        </div>
    </div>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xl-6 offset-xl-0 bg-earn-user" style="background-color: #f4d86c;">
                    <h2 class="text-center bg-dark border rounded border-info shadow d-flex float-none d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-start flex-wrap mx-auto mx-sm-auto justify-content-xl-center align-items-xl-center"
                        src="assets/img/Publisher.png" style="color: rgb(255,255,255);margin: 30px 0;padding: 10px;/*width: 550px;*/font-size: 26px;">Do you want to Earn Money by simply Watching the Ads ?</h2><img class="img-fluid d-flex d-xl-flex flex-column justify-content-center align-content-center align-self-center flex-nowrap mx-auto justify-content-xl-start align-items-xl-end"
                        data-bs-hover-animate="bounce" src="assets/img/Publisher.png" style="width: 200px;margin: 30px 0px;height: 167px;">
                    <h2 class="text-center d-flex d-xl-flex justify-content-center mx-auto justify-content-xl-center align-items-xl-center" src="assets/img/Publisher.png"
                        style="color: rgb(53,83,137);">Watch Ads</h2>
                    <h1 class="text-center d-xl-flex mx-auto justify-content-xl-center align-items-xl-center" src="assets/img/Publisher.png">Get Paid</h1><button class="btn btn-success text-center d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center mx-auto justify-content-xl-center align-items-xl-center" type="button" style="margin: 40px 0px;font-size: 22px;">Register as <strong>&nbsp;Member</strong></button></div>
                <div
                    class="col-md-6 offset-xl-0 m-sm-auto bg-earn-user" style="background-color: #56c6c6;">
                    <h2 class="text-center bg-dark border rounded border-warning shadow d-flex d-xl-flex justify-content-center mx-auto justify-content-xl-center align-items-xl-center" src="assets/img/Publisher.png" style="color: rgb(255,255,255);margin: 30px 0;padding: 10px;/*width: 550px;*/font-size: 26px;">Are you a Content Creator and want to reach a Wider Audience ?</h2><img class="d-flex d-sm-flex d-xl-flex mx-auto justify-content-sm-center align-items-xl-center" data-bs-hover-animate="bounce" src="assets/img/Advertiserr.png" style="width: 200px;margin: 30px 0px;">
                    <h2
                        class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center mx-auto justify-content-sm-center align-items-sm-center mx-sm-auto mx-md-auto mx-lg-auto justify-content-xl-center align-items-xl-center mx-xl-auto" style="color: rgb(250,70,58);">Share Content</h2>
                        <h1 class="d-flex d-sm-flex d-xl-flex justify-content-center mx-auto justify-content-sm-center justify-content-xl-center align-items-xl-center">Get Promoted</h1><button class="btn btn-success text-center d-flex d-sm-flex d-xl-flex justify-content-center mx-auto justify-content-sm-center justify-content-xl-center align-items-xl-center" type="button" style="margin: 40px 0px;font-size: 22px;">Register as&nbsp;<strong>Advertiser</strong></button></div>
        </div>
    </div>
    </div>
    <div class="projects-horizontal">
        <div class="container-fluid" style="background-color: #e1dede;padding: 100px;">
            <div class="intro">
                <h2 class="text-center">Why Choose US?</h2>
                <p class="text-center" style="font-size: 20px;color: rgb(232,32,19);">We are a group of professionals and accounting engineers!</p>
            </div>
            <div class="row projects">
                <div class="col-sm-6 item">
                    <div class="row">
                        <div class="col-md-12 col-lg-5"><a href="#"><img class="img-fluid" src="assets/img/members.jpg"></a></div>
                        <div class="col">
                            <h3 class="text-center name" style="font-size: 25px;">Total Active Members</h3>
                            <p class="text-center description" 
                            style="background-color: #f4d86c;color: rgb(255,255,255);padding: 10px 0px;font-size: 30px;">
                            {{\App\User::where('status', 1)->count('id')}}
                        </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 item">
                    <div class="row">
                        <div class="col-md-12 col-lg-5"><a href="#"><img class="img-fluid" src="assets/img/Pay-Money-1561409.jpg"></a></div>
                        <div class="col">
                            <h3 class="text-center name" style="font-size: 25px;">Total Balance</h3>
                            <p class="text-center description" style="background-color: #56c6c6;color: rgb(255,255,255);padding: 10px 0px;font-size: 30px;">{{round(\App\User::sum('balance'),0)}}/{{$general->symbol}}</p>
                            <!-- <p class="text-center description" style="background-color: #56c6c6;color: rgb(255,255,255);padding: 10px 0px;font-size: 30px;">{{round(\App\WithdrawTrasection::where('status', 1)->sum('amount'),0)}}/{{$general->symbol}}</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection