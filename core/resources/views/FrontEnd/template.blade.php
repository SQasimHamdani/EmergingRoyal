<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title') | Emerging Royal</title>
    <link rel="icon" type="image/png" sizes="2127x2149" href="assets/img/favicon.png">
    <link rel="icon" type="image/png" sizes="2127x2149" href="assets/img/favicon.png">
    <link rel="icon" type="image/png" sizes="2127x2149" href="assets/img/favicon.png">
    <link rel="icon" type="image/png" sizes="2127x2149" href="assets/img/favicon.png">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/Highlight-Blue.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    
    @yield('css')
</head>

<body>
    
    <nav class="navbar navbar-light navbar-expand-lg sticky-top navigation-clean-button ">
        <div class="container"><a class="navbar-brand" href="{{url('/')}}"><img src="assets/img/Logo.png"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse text-center text-primary bounce animated" id="navcol-1">
                <ul class="nav navbar-nav mr-auto" data-aos="fade">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('member')}}">Members</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('advertiser')}}">Advertisers</a></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">About us</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Contact Us</a></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>


                @if(Auth::guard('admin')->check())
                        <span class="navbar-text actions">
                            <a class="btn btn-warning  mr-1" role="button" href="{{url('admin')}}">
                                Admin - {{Auth::guard('admin')->user()->name}}
                            </a>
                        </span>
                @endif

                @if(Auth::guard('web')->check())
                    <span class="navbar-text actions">
                        <a class="btn btn-light action-button" role="button" href="{{url('home')}}">
                        {{Auth::guard('web')->user()->first_name}} {{Auth::guard('web')->user()->last_name}}'s Dashboard
                        </a>
                    </span>
                    <span class="navbar-text actions"> 
                        <a class="btn btn-outline-info ml-1" 
                            style="border-radius: 20px; border-color: #66d7d7; padding: .5rem 1rem; color:#66d7d7;" 
                            role="button" 
                            href="{{ route('logout') }}" 
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            >
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}    
                                Logout
                            </form>
                        </a>
                    </span>
                @else
                    
                    <span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="{{url('login')}}">Login</a></span>
                    <span class="navbar-text actions"> <a class="btn btn-outline-info ml-1" style="border-radius: 20px; border-color: #66d7d7; padding: .5rem 1rem; color:#66d7d7;" role="button" href="{{url('register')}}">Register</a></span>
                
                    
                @endif
                
            </div>
        </div>
    </nav>

    @yield('content')
    
    <div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Home</h3>
                        <ul>
                            <li><a href="#">Members</a></li>
                            <li><a href="#">Advertisers</a></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Know Us</h3>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 item text">
                        <h3>Emerging Royal</h3>
                        <p>We mainly focuses on YOU, To help you achieve something.</p>
                    </div>
                    <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
                </div>
                <p class="copyright">{{$general->footer}} - {{$general->footer_text}}</p>
            </div>
        </footer>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    @yield('js')
</body>

</html>