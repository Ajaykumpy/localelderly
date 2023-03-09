@extends('doctor.layouts.default')
@section('title')
Admin - Dashboard
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
                <h3 class="page-title">Package</h3>
            </div>
        </div>
    </div>
   <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Package</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.package.store')}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                    <div class="row">
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Package Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="package_name" name="package_name" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Month<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="month" name="month" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Price<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="price" name="price" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>No of Devices<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="no_of_devices" name="no_of_devices" required>
                                                </div>
                                            </div>
                                             <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label for="name">image <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="file" name="image" class="form-control" required>
                                                </div>
                                            </div>
                                             <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                  <label>Status <span class="text-danger">*</span></label>
                                                  <div class="input-group">
                                                        <select class="form-control" name="status" required>
                                                            <option value="0" >Disable</option>
                                                            <option value="1" >Enable</option>
                                                        </select>
                                                  </div>
                                              </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{route('admin.package.index')}}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
</div>
@stop
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
