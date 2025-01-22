<div class="header" id="header">
    <div class="container">
        <a href="#" class="logo">Elzero</a>
        <ul class="main-nav">
            <li><a href="#articles">Articles</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#features">Features</a></li>
            <li>
                <a href="#">Other Links</a>
                <!-- Start Megamenu -->
                <div class="mega-menu">
                    <div class="image">
                        <img src="{{asset('web_assets/imgs/megamenu.png')}}" alt="" />
                    </div>
                    <ul class="links">
                        @if(\Illuminate\Support\Facades\Auth::guard('student')->check())
                            <li>
                                <a href="{{route('student.course.myCourses')}}"><i class="far fa-comments fa-fw"></i>My Courses</a>
                            </li>
                        @endif
                        <li>
                            <a href="#team"><i class="far fa-user fa-fw"></i> Team Members</a>
                        </li>
                        <li>
                            <a href="#services"><i class="far fa-building fa-fw"></i> Services</a>
                        </li>
                        <li>
                            <a href="#our-skills"><i class="far fa-check-circle fa-fw"></i> Our Skills</a>
                        </li>
                        <li>
                            <a href="#work-steps"><i class="far fa-clipboard fa-fw"></i> How It Works</a>
                        </li>
                    </ul>
                    <ul class="links">
                        <li>
                            <a href="#events"><i class="far fa-calendar-alt fa-fw"></i> Events</a>
                        </li>
                        <li>
                            <a href="#pricing"><i class="fas fa-server fa-fw"></i> Pricing Plans</a>
                        </li>
                        <li>
                            <a href="#video"><i class="far fa-play-circle fa-fw"></i> Top Videos</a>
                        </li>
                        <li>
                            <a href="#stats"><i class="far fa-chart-bar fa-fw"></i> Stats</a>
                        </li>
                        <li>
                            <a href="#discount"><i class="fas fa-percent fa-fw"></i> Request A Discount</a>
                        </li>
                    </ul>
                </div>
                <!-- End Megamenu -->
            </li>
        </ul>

        <!-- Start User Profile Section -->
        <div class="user-profile">
            @if(\Illuminate\Support\Facades\Auth::guard('student')->check())
                <div class="profile-dropdown">
                    <div class="profile-trigger">
                        <img src="{{asset('Image/' . \Illuminate\Support\Facades\Auth::guard('student')->user()->img)}}" alt="User Profile" class="profile-img">
                        <div class="dropdown-content">
                            <div class="user-info">
                                <h4 class="user-name">{{\Illuminate\Support\Facades\Auth::guard('student')->user()->name}}</h4>
                                <span class="user-email">{{\Illuminate\Support\Facades\Auth::guard('student')->user()->email}}</span>
                            </div>
                            <ul class="dropdown-menu">
                                <li><a href="#profile">My Profile</a></li>
                                <li><a href="#settings">Settings</a></li>
                                <li><a href="{{route('student.logout')}}">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{route('student.login.page')}}" class="login-btn">Login</a>
            @endif
        </div>
        <!-- End User Profile Section -->

    </div>
</div>
