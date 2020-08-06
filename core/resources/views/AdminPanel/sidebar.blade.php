<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler"> </div>
            </li>
            <li class="sidebar-search-wrapper">
            </li>

            <li class="nav-item  @php echo "active",(request()->path() != 'admin/home')?:"";@endphp">
                <a href="{{url('admin/home')}}" class="nav-link nav-toggle">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            @php
                $url = Find_fist_int(request()->path());
            @endphp

            <li class="nav-item  @php echo "active",(request()->path() != 'admin/general')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/logo/icon')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/about')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/social/index')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/contact')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/footer')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/footer'  )?:"";@endphp
            @php echo "active",(request()->path() != 'admin/background/images'  )?:"";@endphp
            @php echo "active",(request()->path() != 'admin/slider')?:"";@endphp">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fas fa-desktop"></i>
                    <span class="title">Website Settings</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  @if( request()->path() == 'admin/general' ) active open @endif">
                        <a href="{{route('general.index')}}" class="nav-link ">
                            <i class="fas fa-cog"></i>
                            <span class="title">General Settings</span>
                        </a>
                    </li>
                    <li class="nav-item  @if( request()->path() == 'admin/logo/icon' ) active open @endif">
                        <a href="{{route('logo.icon')}}" class="nav-link ">
                            <i class="fas fa-file-image"></i>
                            <span class="title">Logo</span>
                        </a>
                    </li>

                    <li class="nav-item  @if( request()->path() == 'admin/about' || request()->path() == "admin/about" ) active open @endif">
                        <a href="{{route('about.admin.index')}}" class="nav-link ">
                            <i class="fab fa-buysellads"></i>
                            <span class="title">About</span>
                        </a>
                    </li>

                    <li class="nav-item  @if( request()->path() == 'admin/footer' || request()->path() == "admin/footer" ) active open @endif">
                        <a href="{{route('footer.index.admin')}}" class="nav-link ">
                            <i class="fab fa-foursquare"></i>
                            <span class="title">Footer</span>
                        </a>
                    </li>





                </ul>
            </li>

            


            @php $req = \App\WithdrawTrasection::where('status', 0)->count() @endphp

            <li class="nav-item  @php echo "active",(request()->path() != 'admin/users')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/paid/user')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/deactive/user')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/free/user')?:"";@endphp">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fas fa-users"></i>
                    <span class="title">Users Management</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  @if( request()->path() == 'admin/users' ) active open @endif">
                        <a href="{{route('user.manage')}}" class="nav-link ">
                            <i class="far fa-user-circle"></i>
                            <span class="title">All Users</span>
                        </a>
                    </li>

                    <li class="nav-item  @if( request()->path() == 'admin/paid/user' ) active open @endif">
                        <a href="{{route('paid.user.index')}}" class="nav-link ">
                            <i class="far fa-user"></i>
                            <span class="title">Paid Users</span>
                        </a>
                    </li>

                    <li class="nav-item  @if( request()->path() == 'admin/free/user' ) active open @endif">
                        <a href="{{route('free.user.index')}}" class="nav-link ">
                            <i class="fas fa-user-times"></i>
                            <span class="title">Free Users</span>
                        </a>
                    </li>



                </ul>
            </li>
            @php $ad_req = \App\Advertise::where('package_status', 3)->count()@endphp
            <li class="nav-item  @php echo "active",(request()->path() != 'admin/ptc/limitation')?:"";@endphp
            @php echo "active",(request()->path() != '')?:"";@endphp">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fas fa-users"></i>
                    <span class="title">PTC @if($ad_req == 0)  @else<span class="badge badge-danger">{{$ad_req}} @endif</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">

                    <li class="nav-item  @if( request()->path() == 'admin/ptc/limitation' ) active open @endif">
                        <a href="{{route('ptc.limit')}}" class="nav-link nav-toggle">
                        <i class="fas fa-sliders-h"></i>
                        <span class="title">PTC Manage Limitation</span>
                        <span class="selected"></span>
                    </li>
                    <li class="nav-item  @if( request()->path() == 'admin/charge/commission' ) active open @endif">
                        <a href="{{route('charge.commission')}}" class="nav-link ">
                            <i class="fas fa-money-bill-alt"></i>
                            <span class="title">Charges/Commision</span>
                        </a>
                    </li>

                    <li class="nav-item  @php echo "active",(request()->path() != 'admin/add/new')?:"";@endphp
                    @php echo "active",(request()->path() != '')?:"";@endphp">
                        <a href="{{route('add.addvertise')}}" class="nav-link nav-toggle">
                            <i class="fab fa-adversal"></i>
                            <span class="title">PTC Management</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="nav-item  @php echo "active",(request()->path() != 'admin/ptc/packages')?:"";@endphp
                    @php echo "active",(request()->path() != '')?:"";@endphp">
                        <a href="{{route('package.index')}}" class="nav-link nav-toggle">
                            <i class="fas fa-archive"></i>
                            <span class="title">PTC Packages</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item  @php echo "active",(request()->path() != 'admin/buy/package/history')?:"";@endphp
                    @php echo "active",(request()->path() != '')?:"";@endphp">
                        <a href="{{route('buy.package.user')}}" class="nav-link nav-toggle">
                            <i class="fas fa-paste"></i>
                            <span class="title">Buy Package History</span>
                            <span class="selected"></span>
                        </a>
                    </li>
            @php $ad_req = \App\Advertise::where('package_status', 3)->count()@endphp
            <li class="nav-item  @php echo "active",(request()->path() != 'admin/request/advertise')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/advertises')?:"";@endphp
            @php echo "active",(request()->path() != 'admin/reject/advertise')?:"";@endphp">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fas fa-spinner"></i>
                    <span class="title">Advert Requests   @if($ad_req == 0)  @else<span class="badge badge-danger">{{$ad_req}} @endif</span> </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  @if( request()->path() == 'admin/request/advertise' ) active open @endif">
                        <a href="{{route('req.add.index')}}" class="nav-link ">
                            <i class="fas fa-ellipsis-h"></i>
                            <span class="title">Requests   @if($ad_req == 0)  @else<span class="badge badge-danger">{{$ad_req}} @endif</span></span>
                        </a>
                    </li>
                    <li class="nav-item  @if( request()->path() == 'admin/advertises' ) active open @endif">
                        <a href="{{route('all.add.index')}}" class="nav-link ">
                            <i class="fas fa-info-circle"></i>
                            <span class="title">Advertise Log</span>
                        </a>
                    </li>
                    <li class="nav-item  @if( request()->path() == 'admin/reject/advertise' ) active open @endif">
                        <a href="{{route('reject.add.index')}}" class="nav-link ">
                            <i class="fas fa-ban"></i>
                            <span class="title">Rejected Advertise</span>
                        </a>
                    </li>

                </ul>
            </li>

                </a>
                </ul>
            </li>


            



        </ul>
    </div>
</div>