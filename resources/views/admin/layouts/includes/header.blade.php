<div class="header headerbg">

    <div class="header-left headercenter">
        <a href="{{url('/')}}" class="logo">
            <img src="{{ asset('assets/img/swasthin_logo.png')}}" alt="Logo" style="width:150px;height:65px;">
        </a>
        <a href="{{url('/')}}" class="logo headerright logo-small">
            <img src="{{ asset('assets/img/swasthinlogo1.png')}}" alt="Logo" width="30" height="30">
        </a>
        <a  href="javascript:void(0);" id="toggle_btn">
            <i class="feather-chevrons-left"></i>
        </a>
    </div>
    {{-- <div class="top-nav-search">
        <div class="main">
            <form class="search" method="GET"
                action="/admin">
                @method('GET')
                <div class="s-icon"><i class="fas fa-search"></i></div>
                <input type="text" class="form-control" id="searchBar" placeholder="Start typing your Search..." />
                <ul class="results"></ul>
            </form>
        </div>
    </div> --}}
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav nav-tabs headerright user-menu">
       {{--<li class="nav-item">
            <a href="#" id="dark-mode-toggle" class="dark-mode-toggle">
                <i class="feather-sun light-mode"></i><i class="feather-moon dark-mode"></i>
            </a>
        </li> --}}
        <li class="nav-item dropdown main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                   <img src="{{asset(auth()->user()->avatar)}}" alt="">
                    <span class="status online"></span>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                 <img src="{{asset(auth()->user()->avatar)}}" alt="{{auth()->user()->name}}"  
                            class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                    {{--    <h6>{{ ucwords(auth()->user()->name)}}</h6>--}}
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>
              <a class="dropdown-item" href="{{route('admin.account.edit',auth()->user()->id)}}"><i class="feather-edit me-1"></i> My Profile</a>
                <a class="dropdown-item" href="{{ route('admin.general_setting.index') }}"><i class="feather-sliders me-1"></i>
                    Account Settings</a>
                <hr class="my-0 ms-2 me-2">
                <a class="dropdown-item" href="{{url('logout')}}"><i class="feather-log-out me-1"></i> Logout</a>
            </div>
        </li>
    </ul>
</div>

{{-- @push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
  // Listen for changes to the search bar input
  $('#searchBar').on('input', function() {
    var searchTerm = $(this).val().toLowerCase();

    // Loop through each item to check if it matches the search term
    $('.item').each(function() {
      var text = $(this).text().toLowerCase();
      var match = text.indexOf(searchTerm) > -1;

      // Show or hide the item depending on whether it matches the search term
      $(this).toggle(match);
    });
  });
});
</script>
@endpush --}}
