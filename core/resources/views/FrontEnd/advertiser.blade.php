@extends('FrontEnd.template')

@section('content')
@section('title','Advertiser')
@section('style')
    <style>
        @media only screen and (max-width: 480px) {
            .input-lg {
                width: 100%!important;
            }
        }
    </style>
@endsection

    

<div class="highlight-blue" style=" background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),  url(&quot;assets/img/Einsatz-Video-Marketing.jpg&quot;);background-repeat: no-repeat;background-size: cover;background-position: center;height: 400px;">
        <div class="container" >
            <div class="intro">
                <h2 class="text-center">Advertisers</h2>
                <p class="text-center">Are you Creative Content Creator (3C's)  but woried about the low traffic you got ? </p>
            </div>
            <div class="buttons"><a class="btn btn-primary" role="button" href="#">You got here Right</a></div>
        </div>
    </div>
    <div class="page-content-wrapper" style="background-color:#2f2f2f; color:#fff;">
        <div class="page-content" style="padding:100px; ">
            <div class="row">
                   

                    @foreach($pack as $data)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Buy {{$data->title}}</h4>
                                </div>
                                <div class="panel-body"> <h4 class="bold text-center">{{$general->symbol}} {{$data->price}} for {{$data->click}} Clicks</h4></div>
                                <div class="panel-body text-center">
                                    @foreach($data->detail as $value)
                                        <p style="color:#fff; font-size: 15px; border-bottom:1px solid blue">{{$value->detail}}</p>
                                    @endforeach
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-success btn-block" data-toggle="modal" data-target="#buyModal{{$data->id}}"> Buy </button>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
            </div>
        </div>
    </div>
@endsection