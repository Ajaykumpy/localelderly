@extends('doctor.layouts.default')
@section('title')
Doctor-Profile
@endsection
@section('head')
<!-- link here -->
@endsection
@section('content')
<!-- content -->
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Doctor</h3>
            </div>
        </div>
    </div>
   <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Doctor</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{url('doctor/profile')}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="row">
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="name" name="name" value="{{$doctor->name}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="email" name="email" value="{{$doctor->email}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                <label class="text-label">Password <span class="text-danger">*</span></span></label>
                                                <div class="input-group transparent-append">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> <i class="fa fa-lock" style=" width:20px; height:26px"></i> </span>
                                                    </div>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" onkeyup="validatePassword()" id="password" minlength="6" name="password" placeholder="Choose a safe one..">
                                                    <div class="input-group-append show-pass">
                                                        <span class="input-group-text"> <i class="fa fa-eye-slash " style=" width:20px; height:26px" id="pass-status" aria-hidden="true" onClick="viewPassword()"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                <label class="text-label">Confirm Password <span class="text-danger">*</span></span></label>
                                                <div class="input-group transparent-append">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> <i class="fa fa-lock" style=" width:20px; height:26px"></i> </span>
                                                    </div>
                                                    <input type="password" class="form-control" id="password_confirmation" onkeyup="validatePassword()" minlength="6" name="password_confirmation" minlength="6" placeholder="Choose a safe one..">
                                                    <div class="input-group-append show-pass">
                                                        <span class="input-group-text"> <i id="cnfpass-status" class="fa fa-eye-slash" style=" width:20px; height:26px" aria-hidden="true" onClick="viewCnfPassword()"></i>
                                                        </span>
                                                    </div>
                                                    <span class="invalid-feedback FDcnfpassword d-none" role="alert">
                                                        <strong>Password don't match</strong>
                                                    </span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="col-md-12">
            <div class="card profile">
                <div class="card-header">
                    <h4 class="card-title">Doctor Details</h4>
                </div>
                <div class="card-body">
                    <div class="media d-flex align-items-center justify-content-between">
                        <div class="flex-shrink-0 d-flex align-items-center">
                            <img src="{{$doctor->profile->image??''}}" alt="patient" class="doctor">
                            <div>
                                <div class="docs-id"> #{{$doctor->id??''}}</div>
                                <h3>{{$doctor->name??''}}</h3>
                                <p>{{$doctor->profile->gender??''}}, {{$doctor->profile->age??''}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="member-wrapper">
                        <h5>Personal Details</h5>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <h5>Mobile</h5>
                                    <p>{{$doctor->mobile}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Email</h5>
                                    <p>{{$doctor->email}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Gender</h5>
                                    <p>{{$doctor->profile->gender??''}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Age</h5>
                                    <p>{{$doctor->profile->age??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>City</h5>
                                    <p>{{$doctor->profile->city??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Post Code</h5>
                                    <p>{{$doctor->profile->postcode??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>State</h5>
                                    <p>{{$doctor->profile->state??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Country</h5>
                                    <p>{{$doctor->profile->country??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Year Of Experience</h5>
                                    <p>{{$doctor->profile->yrs_of_exp??""}},{{$doctor->profile->experience_class??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Registration Number</h5>
                                    <p>{{$doctor->profile->registration_number??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Registration Council</h5>
                                    <p>{{$doctor->profile->registration_council??""}}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h5>Registration Year</h5>
                                    <p>{{$doctor->profile->registration_year??""}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@stop
@push('name')

@push('scripts')
<!-- script -->
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script>
function viewPassword(){
  var passwordInput = document.getElementById('password');
  var passStatus = document.getElementById('pass-status');
  if (passwordInput.type == 'password'){
    passwordInput.type='text';
    passStatus.className='fa fa-eye';
  }
  else{
    passwordInput.type='password';
    passStatus.className='fa fa-eye-slash';
  }
}

function viewCnfPassword(){
  var passwordInput = document.getElementById('password_confirmation');
  var passStatus = document.getElementById('cnfpass-status');
  if (passwordInput.type == 'password'){
    passwordInput.type='text';
    passStatus.className='fa fa-eye';
  }
  else{
    passwordInput.type='password';
    passStatus.className='fa fa-eye-slash';
  }
}

function validatePassword(){
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("password_confirmation").value;
    if(confirm_password){
        if(password != confirm_password) {
          $(".Submitform").attr("disabled", true);
          $(".FDcnfpassword").removeClass('d-none');
          $("#password_confirmation").addClass('is-invalid');

      } else {
            $(".Submitform").attr("disabled", false);
            $(".FDcnfpassword").addClass('d-none');
            $("#password_confirmation").removeClass('is-invalid');
      }
    }
}

</script>
@endpush
