@extends('admin.layouts.default')
@section('title')
Admin - Category Create
@endsection
@section('content')

<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Category</h3>
            </div>
        </div>
    </div>
   <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Customer</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{route('admin.customer.store')}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row row">
                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                <label for="name">Image <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                <label>Member Name<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="member_name" name="member_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label>Joining Date<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="joining_date" name="joining_date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                        <label>Expiry Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                    <label>Member Type <span class="text-danger">*</span></label>
                               <div class="input-group">
                                <select class="form-control" name="member_type" required>
                                   <option value="0" >Diet</option>
                                   <option value="1" >Yoga</option>
                                   <option value="2" >Diet + Yoga</option>
                               </select>
                              </div>
                              </div>




                                <div class="col-md-12 mb-2">
                                </div>
                            </div>


                        </div>
                        <div class="text-end">
                            <a href="{{route('admin.package.index')}}" class="btn btn-danger my-2 ">Cancel</a>
                            <button type="submit" class="btn btn-success mx-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
 @push('scripts')
<!-- script -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script>
$(function(){
    $('textarea[name="description"]').summernote({
        placeholder: 'Enter Description...',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
    $(".form-valide").validate({
        ignore: [],
        errorClass: "invalid-feedback animated fadeInUp",
        errorElement: "div",
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
    });
});
</script>
@endpush
