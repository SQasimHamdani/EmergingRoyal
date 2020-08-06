<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler"> </div>
            </li>
            <li class="sidebar-search-wrapper">
            </li>


            <li class="nav-item  @php echo "active",(request()->path() != 'home')?:"";@endphp">
                <a href="{{ url('/home') }}" class="nav-link nav-toggle">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="title">Dashboard </span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  @php echo "active",(request()->path() != '')?:"";@endphp
            @php echo "active",(request()->path() != 'advertises')?:"";@endphp">
                <a href="{{route('ptc.add.index')}}" class="nav-link nav-toggle">
                    <i class="fas fa-mouse-pointer"></i>
                    <span class="title">Click Advertise </span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item @php echo "active",(request()->path() != 'create/advertise')?:"";@endphp
            @php echo "active",(request()->path() != 'my/advertises')?:"";@endphp">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fab fa-adversal"></i>
                    <span class="title">Make Your Ad</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  @if( request()->path() == 'create/advertise' ) active open @endif">
                        <a href="{{route('my.advertise')}}" class="nav-link ">
                            <i class="fas fa-mouse-pointer"></i>
                            <span class="title">Create Ad</span>
                        </a>
                    </li>

                    <li class="nav-item  @if( request()->path() == 'my/advertises' ) active open @endif">
                        <a href="{{route('manage.advertise')}}" class="nav-link ">
                            <i class="fas fa-key"></i>
                            <span class="title">Manage Ad</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>