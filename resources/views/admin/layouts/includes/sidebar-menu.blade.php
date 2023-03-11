@php
    $url_1= $url_2=0;
    $url = request()->route()->uri;
    $url = explode('/', $url);
    if(count($url) > 1){
        $url_1 = $url[0];
        $url_2 = $url[1];
    }elseif(count($url) == 1){

    }
@endphp

<ul>
    <!-- <li class="menu-title"><span>Main</span></li> -->
    <li class="{{ $url_1 == '0' && $url_2 == '0'  ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}"><i class="feather-grid"></i> <span>Dashboard</span></a>
    </li>

    {{-- <li class= "{{ $url_2 == 'package' ? 'active' : '' }} {{ $url_2 == 'packages' ? 'active' : '' }}"><a href="#">
        <i class="feather-package"></i> <span >Package</span></a> --}}
        {{-- <ul style="{{ $url_2 == 'package' ? 'display: block;' : '' }} {{ $url_2 == 'packages' ? 'display: block;' : '' }}"> --}}
            {{-- <li class="{{ $url_2 == 'package' ? 'active' : '' }}">
                <a href="{{ route('admin.package.index') }}"><span >Package</span></a>
            </li> --}}
          {{--  <li  class="{{ $url_2 == 'packages' ? 'active' : '' }}">
                <a href="{{ route('admin.package-activation.index') }}"><span >Package Activation</span></a>
            </li>--}}
        {{-- </ul> --}}
    {{-- </li> --}}

    <li class= "{{ $url_2 == 'package' ? 'active' : '' }} {{ $url_2 == 'packages' ? 'active' : '' }}"><a href="{{route('admin.package.index')}}">
        <i class="feather-package"></i> <span >Package</span> </span></a>

    </li>

  <li class= "{{ $url_2 == 'Member Management' ? 'active' : '' }} {{ $url_2 == 'Member Management' ? 'active' : '' }}"><a href="#">
        <i class="feather-users"></i> <span >Member Management</span> <span class="menu-arrow"></span></a>
        <ul style="{{ $url_2 == 'Member Management' ? 'display: block;' : '' }} {{ $url_2 == 'packages' ? 'display: block;' : '' }}">
            <li class="{{ $url_2 == 'customer' ? 'active' : '' }}">
                <a href="{{ route('admin.customer.index') }}"><i class="feather-circle"></i> <span >Users</span></a>
            </li>
            <li  class="{{ $url_2 == 'instructors' ? 'active' : '' }}">
                <a href="{{ route('admin.instructor.index') }}"><i class="feather-circle"></i> <span >Instructors</span></a>
            </li>
            <li  class="{{ $url_2 == 'instructors' ? 'active' : '' }}">
                <a href="{{ route('admin.customer.index') }}"><i class="feather-circle"></i> <span >Dietian</span></a>
            </li>
        </ul>
    </li>
{{--
     <li class= "{{ $url_2 == 'instructor' ? 'active' : '' }}">
        <a href="#"><i class="feather-user-plus"></i> <span >Instructors</span><span class="menu-arrow"></span></a>
        <ul style="{{ $url_2 == 'instructor' ? 'display: block;' : '' }}">
        <li class="{{ $url_2 == 'instructor' ? 'active' : '' }}">
        <a href="{{ route('admin.instructor.index') }}"><i class="feather-user-plus"></i> <span >Instructor</span></a>
        </li>


        </ul>
    </li> --}}
    <li class="{{ $url_2 == 'patient' ? 'active' : '' }}">
        <a href="{{ route('admin.customer.index') }}"><i class="feather-users"></i> <span >Customers</span></a>
    </li>
    <li class="{{ $url_2 == 'banner' ? 'active' : '' }}">
        <a href="{{ route('admin.banner.index') }}"><i class="feather-users"></i> <span >Banner</span></a>
    </li>





   {{-- <li>
        <a href=#><i class="feather-settings"></i> <span>Settings</span><span class="menu-arrow"></span></i>
        </a>
        <ul>
            <li>
                <a href="{{ route('admin.general_setting.index') }}"><span>General</span></a>
            </li>
			<li>
                <a href="{{ route('admin.page.index') }}"><span>Pages</span></a>
            </li>
             <li>


                <a href="{{ route('admin.specialist.index') }}">
                    <span>Specialities</span></a>
            </li>
             <li>
                <a href="{{ route('admin.terms-and-conditions.index') }}"> <span>Terms &
                        Conditions</span></a>
            </li>
            <li>
                <a href="{{ route('admin.privacy-policy.index') }}"> <span>Privacy Policy</span></a>
            </li>
        </ul>
    </li>--}}



    <li class="{{ $url_2 == 'program' ? 'active' : '' }}">
        <a href="{{route('admin.program.index')}}"><i class="feather-settings"></i> <span >program</span></span></i>
        </a>
    </li>
    <li class="{{ $url_2 == 'category' ? 'active' : '' }}">
        <a href="{{url('admin/category')}}"><i class="feather-settings"></i> <span >Category</span></span></i>
        </a>
    </li>

    <li class= "{{ $url_2 == 'subcategory' ? 'active' : '' }} {{ $url_2 == 'packages' ? 'active' : '' }}"><a href="{{route('admin.subcategory.index')}}">
        <i class="feather-package"></i> <span >Sub Category</span> </span></a>

    </li>

    <li class="{{ $url_2 == 'settings' ? 'active' : '' }} {{ $url_2 == 'specialist' ? 'active' : '' }}{{ $url_2 == 'page' ? 'active' : '' }}">
        <a href=#><i class="feather-settings" ></i> <span>Settings</span><span class="menu-arrow"></span></i>
        </a>
        <ul style="{{ $url_2 == 'settings' ? 'display: block;' : '' }} {{ $url_2 == 'specialist' ? 'display: block;' : '' }}{{ $url_2 == 'page' ? 'display: block;' : '' }}">
             <li class="{{ $url_2 == 'settings' ? 'active' : '' }}">
                <a href="{{ route('admin.general_setting.index') }}"><span>General</span></a>
            </li>
			<li class="{{ $url_2 == 'page' ? 'active' : '' }}">
                <a href="{{ route('admin.page.index') }}"><span>Pages</span></a>
            </li>

            {{-- <li  class="{{ $url_2 == 'specialist' ? 'active' : '' }}">
                <a href="{{ route('admin.specialist.index') }}">
                    <span>Specialities</span></a>
            </li> --}}
        </ul>
    </li>

</ul>
