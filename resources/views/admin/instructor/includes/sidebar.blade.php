<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

         {{--   <ul>
                <li class="menu-title"><span>Main</span></li>
                <li class="{{ request()->is('doctor/dashboard')?'active':'' }}">
                    <a href="{{ route('doctor.dashboard') }}"><i class="feather-grid"></i> <span>Dashboard</span></a>
                </li>
                <li class="{{ (request()->is('doctor/appoinment') || (request()->is('doctor/appoinment/*')))?'active':'' }}">
                    <a href="{{ route('doctor.appoinment.index') }}"><i class="feather-calendar"></i>
                        <span>Appointments</span></a>
                </li>
                <li>
                    <a href="{{route('doctor.prescription.index')}}"><i class="feather-clipboard me-1"></i>
                        <span>Prescription</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('doctor.call_log.index')}}"><i class="feather-clipboard me-1"></i>
                        <span>Call Log</span>
                    </a>
                </li>

            </ul>--}}
            <ul>
                <li class="menu-title"><span>Main</span></li>
                <li>
                    <a href="{{ route('admin.dashboard') }}"><i class="feather-grid"></i> <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="#"><i class="feather-calendar"></i>
                        <span>Appointments</span></a>
                </li>
                <li>
                    <a href=""><i class="feather-clipboard me-1"></i>
                        <span>Prescription</span>
                    </a>
                </li>
                <li>
                    <a href=""><i class="feather-clipboard me-1"></i>
                        <span>Call Log</span>
                    </a>
                </li>

            </ul>


        </div>
    </div>
</div>
