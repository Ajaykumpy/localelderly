@extends('admin.layouts.default')
@section('title')
Admin - Symptoms
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
                <h3 class="page-title">Symptoms</h3>
            </div>
        </div>
    </div>
   <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Symptoms</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{url(route('admin.symptoms.update',$symptoms->id))}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="row">

                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                                <label>Symptoms Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" @error('name') is-invalid @enderror" id="name" name="name" value="{{$symptoms->name}}" required>
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert" >
                                                        <strong>{{$message}}</strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                                  <label>Status <span class="text-danger">*</span></label>
                                                  <div class="input-group">
                                                        <select class="form-control" name="status" required>
                                                            <option value="0" {{$symptoms->status == 0 ? 'Selected':''}}>Disable</option>
                                                            <option value="1" {{$symptoms->status == 1 ? 'Selected':''}}>Enable</option>
                                                        </select>
                                                  </div>
                                              </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{route('admin.symptoms.index')}}" class="btn btn-danger">Cancel</a>
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
            required: "Please enter a packages",
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
