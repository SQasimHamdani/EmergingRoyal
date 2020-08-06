@extends('UserPanel.header')
@section('site')
    DashBoard
@endsection
@section('style')
    <style>
        .visual{
            color: #f7f6ff;
        }
        .pranto{
            margin-bottom: 10px;
        }

        .dashboard-stat .details .desc {
            text-align: right;
            font-size: 16px !important;
            letter-spacing: 0;
            font-weight: 300;
        }

        rect:nth-child(even){
            fill: #2980b9;

        }
        rect:nth-child(odd){
            fill: #8e44ad;
        }

        @media only screen and (max-width: 480px) {
            .input-lg {
                width: 100%!important;
            }
        }

    </style>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection
@section('main-content')
    <div class="page-content-wrapper">
        <div class="page-content">

            @if (count($errors) > 0)
                <div class="row">
                    <div class="col-md-06">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alert!</h3>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box " style="background: #1289a7">
                        <div class="portlet-title">
                            <div class="caption uppercase bold"><i class="fas fa-sort-amount-down"></i> Dashboard</div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">

                                

                                <div class="pranto pranto col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <a href="{{route('my.advertise')}}">
                                        <div class="dashboard-stat green-jungle">
                                            <div class="visual">
                                                <div class="service-icon"  style="color: white">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                </div>
                                                <div class="desc"> Create Ad </div>
                                            </div>
                                            <a class="more" href="{{route('my.advertise')}}"> View more
                                                <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </a>
                                </div>

                                <div class="pranto pranto col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <a href="{{route('ptc.add.index')}}">
                                        <div class="dashboard-stat blue-ebonyclay">
                                            <div class="visual">
                                                <div class="service-icon"  style="color: white">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </div>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                </div>
                                                <div class="desc"> View Ad </div>
                                            </div>
                                            <a class="more" href="{{route('ptc.add.index')}}"> View more
                                                <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </a>
                                </div>

                                <div class="pranto pranto col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <a href="{{route('profile.index')}}">
                                    <div class="dashboard-stat red-intense">
                                        <div class="visual">
                                            <div class="service-icon"  style="color: white">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                            </div>
                                            <div class="desc"> My Profile </div>
                                        </div>
                                        <a class="more" href="{{route('profile.index')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                    </a>
                                </div>
                                
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    
@endsection

