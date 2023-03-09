@extends('admin.layouts.default')
@section('title')
Admin - Doctor
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
                <h3 class="page-title">Doctors</h3>
            </div>
        </div>
    </div>
   <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Doctors</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.doctor.update',$doctors->id)}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="row">
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="name" name="name" value="{{$doctors->name}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="email" name="email" value="{{$doctors->email}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Mobile Number<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{$doctors->mobile}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Age<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="age" name="age" value="{{$doctors->profile->age??''}}">
                                                </div>
                                            </div>
											<div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Specialist<span class="text-danger">*</span></label>
                                                <div class="input-group">
													<select name="specialist_id" class="form-control">
														<option value="">--SELECT--</option>
														@forelse(\App\Models\Speciality::whereStatus(1)->get() as $items)
														<option value="{{$items->id}}" {{ ($doctors->specialist && $doctors->specialist->id==$items->id)?'selected':'' }}>{{$items->name}}</option>
														@empty
														@endforelse
													</select>
                                                </div>
                                            </div>
											<div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Address<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="address" name="address" value="{{$doctors->profile->address??''}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>City<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="city" name="city" value="{{$doctors->profile->city??''}}" >
                                                </div>
                                            </div>
											<div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Pincode<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="state" name="postcode" value="{{$doctors->profile->postcode??''}}" >
                                                </div>
                                            </div>
											<div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>State<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="state" name="state" value="{{$doctors->profile->state??''}}" >
                                                </div>
                                            </div>
                                                <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                  <label>Gender <span class="text-danger">*</span></label>
                                                  <div class="input-group">
                                                        <select class="form-control" name="gender" >
															<option value="">--Select--</option>
                                                            <option value="1" {{($doctors->profile && $doctors->profile->gender == 'Male') ? 'Selected':''}}>Male</option>
                                                            <option value="0" {{($doctors->profile && $doctors->profile->gender == 'Female') ? 'Selected':''}}>Female</option>
                                                            <option value="2" {{($doctors->profile && $doctors->profile->gender =='others') ? 'Selected':''}}>Others</option>
                                                        </select>
                                                  </div>
                                                </div>
											<div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Year of experience<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="yrs_of_exp" name="yrs_of_exp" value="{{$doctors->profile->yrs_of_exp??""}}" >
                                                </div>
                                            </div>
											<div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Registration Number<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="registration_number" name="registration_number" value="{{$doctors->profile->registration_number??""}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Registration Council<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="registration_council" name="registration_council" value="{{$doctors->profile->registration_council??""}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Registration Year<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="registration_year" name="registration_year" value="{{$doctors->profile->registration_year??""}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label for="name">Image</label>
                                                <div class="change-photo-btn h-50">
                                                    <div>
                                                        <i class="feather-upload"></i>
                                                        <p>Upload File</p>
                                                    </div>
                                                    <input type="file" name="image" class="upload" id="image">
                                                    <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                                        alt="preview image" style="max-height: 250px;">
                                                </div>
                                                {{-- @if($doctors->profile->image)
                                                <p class="file-name text-success">Successfully {{$doctors->profile->image??""}} uploaded <a href="#" class="text-danger"><i class="feather-x"></i></a></p>
                                                @endif --}}
                                            </div>
                                            {{-- <div class="col-md-4 col-xl-3 col-xxl-4 mb-3 form-group">
                                                <label for="name">Image<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="file" name="image" class="form-control">
                                                    &nbsp;&nbsp;
                                                    @if($doctors->profile->image)
                                                        <img src="{{ asset('storage/doctor'.$doctors->profile->image??"") }}" class="img-fluid" alt="image" style="width: 41px;height: 40px;">
                                                    @endif
                                                </div>
                                            </div>  --}}
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Doctor Type <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="type" required>
                                                            <option value="">--Select--</option>
                                                            <option value="normal" {{$doctors->type == 'normal' ? 'Selected':''}}>Normal</option>
                                                            <option value="emergency" {{$doctors->type == 'emergency' ? 'Selected':''}}>Emergency</option>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                @if($doctors->ban == 1 && $doctors->status != 0 && $doctors->document_verified != 0)
                                                    <a href="{{url('admin/approve/doctor/'.$doctors->id)}}" class="btn btn-success btn-add">Approve Doctor</a>
                                                @elseif($doctors->ban == 0 && $doctors->status != 0 && $doctors->document_verified != 0)
                                                    <a href="{{url('admin/disable/doctor/'.$doctors->id)}}" class="btn btn-danger btn-add">Disable Doctor</a>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{route('admin.doctor.index')}}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- doctor education -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Doctors Education</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.doctor.update',$doctors->id)}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="row">

                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Degree<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="institute" name="name" value="{{$doctors->education->name??""}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>College/ Institute<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="yrs_of_exp" name="institute" value="{{$doctors->education->institute??""}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Years Of Completion<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="yrs_of_completion" name="year" value="{{$doctors->education->year??""}}" >
                                                </div>
                                            </div>
                                            {{--<div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Specialist<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="specialist" name="specialist" value="{{$doctors->Specialist->name??""}}" >
                                                </div>
                                            </div>--}}

                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                <div class="input-group">
                                                    @if($doctors->document_verified == 0)
                                                        {{-- <a href="{{url('admin/approve/doctor/document/'.$doctors->id)}}" class="btn btn-success btn-add">Approve Document</a> --}}
                                                    @endif
                                                </div>

                                                @if($doctors->status == 0)
                                                    <a href="{{url('admin/approve/doctor/profile/'.$doctors->id)}}" class="btn btn-success btn-add">Approve Doctor Profile</a>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="text-end">
                                       {{-- <a href="{{route('admin.doctor.index')}}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- doctor education end -->
                </div>
</div>
@stop
@push('scripts')
    <script>
        $(document).ready(function (e) {


 $('#image').change(function(){

  let reader = new FileReader();

  reader.onload = (e) => {

    $('#preview-image-before-upload').attr('src', e.target.result);
  }

  reader.readAsDataURL(this.files[0]);

 });

});
    </script>
@endpush
@section('scripts')
<!-- script -->
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script>
jQuery(".form-valide").validate({
    rules: {
        "name": {
            : !0,
            minlength: 3
        },
    },
    messages: {
        "name": {
            : "Please enter a speciality",
            minlength: "Your benefit must consist of at least 3 characters"
        },
    },
    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
    },
});
</script>
@stop
