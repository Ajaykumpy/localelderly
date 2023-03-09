@extends('admin.layouts.default')
@section('title')
Admin - Patient
@endsection
@section('head')
<!-- link here -->
@endsection
@section('content')
<style>
.avatar {
  vertical-align: middle;
  width: 70px;
  height: 112px;
  border-radius: 50%;
}
</style>
<!-- content -->
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Patient</h3>
            </div>
        </div>
    </div>
   <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Patient</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{url(route('admin.patient.update',$users->id))}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="row">
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Image</label>
                                                <div class="input-group">
                                                    <img class="avatar"
                                                       src="{{($users->image)?$users->image:''}}"
                                                        alt="preview image" style="max-width: 100px;">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="name" name="name" value="{{$users->name}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="email" name="email" value="{{$users->email}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Mobile No<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{$users->mobile}}" readonly required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Room No<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="room_no" name="room_no" value="{{$users->room_no}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Street Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="street_name" name="street_name" value="{{$users->street_name}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>location<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="location" name="location" value="{{$users->location}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Gender<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="gender" name="gender" value="{{$users->gender}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Date Of  Birth<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="dob" name="dob" value="{{$users->dob}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Height<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="height" name="height" value="{{$users->height}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Weight<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="weight" name="weight" value="{{$users->weight}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Any Existing illness<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="existing_disease" name="existing_disease" value="{{$users->existing_disease}}" required>
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
                                                    <img id="preview-image-before-upload"
                                                       src=""
                                                        alt="preview image" style="max-width: 100px;">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Blood Group<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control" id="blood_group" name="blood_group"  required>
                                                        <option value="A+" {{$users->blood_group == "A+" ? 'Selected':''}}>A+</option>
                                                        <option value="B+" {{$users->blood_group == "B+" ? 'Selected':''}}>B+</option>
                                                        <option value="O+" {{$users->Olood_group == "O+" ? 'Selected':''}}>O+</option>
                                                        <option value="AB+" {{$users->blood_group == "AB+" ? 'Selected':''}}>AB+</option>
                                                        <option value="A-" {{$users->blood_group == "A-" ? 'Selected':''}}>A-</option>
                                                        <option value="B-" {{$users->blood_group == "B-" ? 'Selected':''}}>B-</option>
                                                        <option value="O-" {{$users->blood_group == "O-" ? 'Selected':''}}>O-</option>
                                                        <option value="AB-" {{$users->blood_group == "AB-" ? 'Selected':''}}>AB-</option>
                                                    </select>
                                                </div>
                                            </div>
                                             {{-- <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                  <label>Status <span class="text-danger">*</span></label>
                                                  <div class="input-group">
                                                        <select class="form-control" name="status" required>
                                                            <option value="0" {{$users->status == 0 ? 'Selected':''}}>Disable</option>
                                                            <option value="1" {{$users->status == 1 ? 'Selected':''}}>Enable</option>
                                                        </select>
                                                  </div>
                                              </div> --}}
                                    </div>
                                    <div class="text-end">
                                        <a href="{{route('admin.patient.index')}}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
            required: !0,
            minlength: 3
        },
    },
    messages: {
        "name": {
            required: "Please enter a speciality",
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
