<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="header">

    <div class="header-left">
        <a href="" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
        </a>
        <a href="" class="logo logo-small">
            <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
        </a>
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="feather-chevrons-left"></i>
        </a>
    </div>


    <div class="top-nav-search">
        <div class="main mt-3">        
            {{--<form class="search" method="post"
                action="">
                <div class="s-icon"><i class="fas fa-search"></i></div>
                <input type="text" class="form-control" placeholder="Start typing your Search..." />
                
            </form>--}}
        </div>
    </div>



    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <!-- script is in other file    -->
    

    <ul class="nav nav-tabs user-menu">
        
        {{--<li class="nav-item">
            <a href="#" id="dark-mode-toggle" class="dark-mode-toggle">
                <i class="feather-sun light-mode"></i><i class="feather-moon dark-mode"></i>
            </a>
        </li>


        <li class="nav-item dropdown noti-nav">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="feather-bell"></i> <span class="badge"></span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"><i class="feather-more-vertical"></i></a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                    </ul>
                </div>
            </div>
        </li>--}}


        <li class="nav-item dropdown main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img src="{{asset(auth()->user()->image??'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y')}}" alt="">
                    <span class="status online"></span>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{asset(auth()->user()->image??'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y')}}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                    <h6>{{ ucwords(auth()->user()->name)}}</h6>
                        <p class="text-muted mb-0">Doctor</p>
                    </div>
                </div>
                <a class="dropdown-item" href="{{url('doctor/profile')}}"><i class="feather-user me-1"></i> My Profile</a>
                {{--<a class="dropdown-item" href="profile.html"><i class="feather-edit me-1"></i> Edit Profile</a>
                <a class="dropdown-item" href="account-settings.html"><i class="feather-sliders me-1"></i>
                    Account Settings</a>--}}
                <hr class="my-0 ms-2 me-2">
                <a class="dropdown-item" href="{{url('doctor/logout')}}"><i class="feather-log-out me-1"></i> Logout</a>
            </div>
        </li>

    </ul>

</div>