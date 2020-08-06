@extends('fonts.layouts.master')
@section('content')
    <!--Start Banner Image Area-->
    <section id="banner-image-area" style="background: url({{asset('assets/images/fontend_slide/'. $slider->image)}}); background-size: cover ; background-position:center">
        <div class="overlay"></div>
        <div class="banner-content dp-table">
            <div class="tbl-cell text-center">

                <h1>{{$slider->heading}}</h1>
                <p>
                    {{$slider->description}}
                </p>
                <a class="pranto" href="{{url('login')}}">Sign In</a>
                <a class="pranto" href="{{url('register')}}">Sign Up</a>
            </div>
        </div>
    </section>
    <!--End  Banner Image Area-->

    <!--Start About Area-->
    <section id="about-area">
        <!--Start Container-->
        <div class="container">
            <!--Start Row-->
            <div class="row">
                <!--Start About Content-->
                <div class="col-md-6">
                    <div class="about-content">
                        <h2>About Us</h2>
                        <p>{!! $general->about_text !!}</p>
                    </div>
                </div>
                <!--End About Content-->

                <!--Start About Image-->
                <div class="col-md-6">
                    <div class="about-img">
                        <img src="{{asset('assets/images/about_image/'.$general->image)}}" class="img-responsive" alt="Image">
                    </div>
                </div>
                <!--End About Image-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End About Area-->

    <!--Start Pricing Area-->
    <section id="pricing-area">
        <!--Start Container-->
        <div class="container">
            <!--Start Heading Row-->
            <div class="row">
                <!--Start Section Heading-->
                <div class="col-md-6 col-md-offset-3">
                    <div class="section-heading text-center">
                        <h5>Choose Your Plan</h5>
                        <h2>Our Pricing Plan</h2>
                    </div>
                </div>
                <!--End Section Heading-->
            </div>
            <!--End Heading Row-->

            <!--Start Pricing Row-->
            <div class="row">
            @foreach($pack as $key => $data)
                <!--Start Pricing Table Single-->
                <div class="col-md-4">
                    <div class="pricing-tbl-single @if($key+1 == 2) popular @endif text-center">
                        <h3>{{$data->title}}</h3>
                        <div class="price-amount ">
                            <h1>{{$general->symbol}} {{$data->price}}</h1>
                            <p>{{$data->click}} Click</p>
                        </div>
                        <div class="pricing-content">
                            <ul>
                                @foreach($data->detail as $value)
                                    <li>{{$value->detail}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a href="{{route('my.advertise')}}">Get Started</a>
                        </div>
                    </div>
                </div>
                <!--End Pricing Table Single-->
            @endforeach
            </div>
            <!--End Pricing Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Pricing Area-->

    <!--Start Counter Area-->
    <section id="counter-area" class="section-padding bg-cover">
        <div class="overlay"></div>
        <!--Start Container-->
        <div class="container">
            <!--Start Heading Row-->
            <div class="row">
                <!--Start Section Heading-->
                <div class="col-md-6 col-md-offset-3">
                    <div class="section-heading text-center">
                        <h5 class="white-color">We Proud Of</h5>
                        <h2 class="white-color">Our Achievement</h2>
                    </div>
                </div>
                <!--End Section Heading-->
            </div>
            <!--End Heading Row-->

            <!--Start Counter Row-->
            <div class="row">
                <!--Start Counter Single-->
                <div class="col-md-3">
                    <div class="counter-single text-center">
                        <div class="counter-icon">
                            <i class="icofont icofont-files white-color"></i>
                        </div>
                        <h1 class="white-color">{{\App\Deposit::where('status', 1)->count('id')}}</h1>
                        <h4 class="white-color">Total Deposit</h4>
                    </div>
                </div>
                <!--End Counter Single-->

                <!--Start Counter Single-->
                <div class="col-md-3">
                    <div class="counter-single text-center">
                        <div class="counter-icon">
                            <i class="icofont icofont-emo-slightly-smile white-color"></i>
                        </div>
                        <h1 class="white-color">{{\App\User::where('status', 1)->count()}}</h1>
                        <h4 class="white-color">Happy Clients</h4>
                    </div>
                </div>
                <!--End Counter Single-->

                <!--Start Counter Single-->
                <div class="col-md-3">
                    <div class="counter-single text-center">
                        <div class="counter-icon">
                            <i class="icofont icofont-clock-time white-color"></i>
                        </div>
                        <h1 class="white-color"> {{\Carbon\Carbon::parse($general->start_date)->diffInDays() * 24}}</h1>
                        <h4 class="white-color">Won Award</h4>
                    </div>
                </div>
                <!--End Counter Single-->

                <!--Start Counter Single-->
                <div class="col-md-3">
                    <div class="counter-single text-center">
                        <div class="counter-icon">
                            <i class="icofont icofont-money-bag white-color"></i>
                        </div>
                        <h1 class="white-color">{{\App\Withdraw::where('status', 1)->count('id')}}</h1>
                        <h4 class="white-color">Total Withdraw</h4>
                    </div>
                </div>
                <!--End Counter Single-->
            </div>
            <!--End Counter Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Counter Area-->

    <!--Start Contact Area-->
    <section id="contact-area" class="section-padding bg-cover">
        <!--Start Container-->
        <div class="container">
            <!--Start Heading Row-->
            <div class="row">
                <!--Start Section Heading-->
                <div class="col-md-6 col-md-offset-3">
                    <div class="section-heading text-center">
                        <h5>Have Any Question?</h5>
                        <h2>Contact With Us</h2>
                    </div>
                </div>
                <!--End Section Heading-->
            </div>
            <!--End Heading Row-->

            <!--Start Row-->
            <div class="row">
                <!--Start Contact Info-->
                <div class="contact-info fix">
                    <!--Start Contact Info Single-->
                    <div class="col-md-4">
                        <div class="contact-info-single text-center">
                            <i class="icofont icofont-social-google-map"></i>
                            <p>{{$general->address}}</p>
                        </div>
                    </div>
                    <!--End Contact Info Single-->

                    <!--Start Contact Info Single-->
                    <div class="col-md-4">
                        <div class="contact-info-single text-center">
                            <i class="icofont icofont-envelope"></i>
                            <p>{{$general->email}}</p>

                        </div>
                    </div>
                    <!--End Contact Info Single-->

                    <!--Start Contact Info Single-->
                    <div class="col-md-4">
                        <div class="contact-info-single text-center">
                            <i class="icofont icofont-phone"></i>
                            <p>{{$general->mobile}}</p>
                        </div>
                    </div>
                    <!--End Contact Info Single-->
                </div>
                <!--End Contact Info-->
            </div>
            <!--End Row-->

            <!--Start Row-->
            <div class="row">
                @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
                <!--Start Contact Form-->
                <div class="col-md-8">
                    <div class="contact-form">
                        <form action="{{route('contact.us.message')}}" method="POST">
                            {{csrf_field()}}
                            <div class="input-box">
                                <div class="contact-icon"><i class="icofont icofont-user-alt-2"></i></div>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="Name">
                                @if ($errors->has('name'))
                                    <span class="help-block" style="color: red">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="input-box">
                                <div class="contact-icon"><i class="icofont icofont-email"></i></div>
                                <input type="email" value="{{ old('email') }}" class="form-control"  name="email" placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block" style="color: red">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="textarea-box">
                                <div class="contact-icon"><i class="icofont icofont-comment"></i></div>
                                <textarea class="form-control" name="message" rows="10" placeholder="Message"></textarea>
                                @if ($errors->has('message'))
                                    <span class="help-block" style="color: red">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
                <!--End Contact Form-->

                <!--Start Google Map-->
                <div class="col-md-4">
                    <div class="map">
                        {!! $general->google_map_address !!}
                    </div>
                </div>
                <!--End Google Map-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Contact Area-->

@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(document).on('click','#post',function(){
                var email = $("#email").val();

                $.ajax({
                    type:"POST",
                    url:"{{route('store.new.letter')}}",
                    data:{

                        'email' : email,
                        '_token' : $('input[name=_token]').val()
                    },
                    success:function(data){
                        $('#messsge').html(data);
                        $("#email").val(' ');
                    }
                });
            });
        });
    </script>
@endsection