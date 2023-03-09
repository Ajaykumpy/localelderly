@extends('admin.layouts.default')
@section('title')
Admin - Category Edit
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
                    <h4 class="card-title">Edit Category</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{route('category.update',$category->id)}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row row">
                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                <label>Program Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                         
                                                <input type="text" class="form-control" id="category_name" name="category_name" required value="{{$category->category_name}}">
                                                
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                <label for="name">Image <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="file" name="image" class="form-control" required>
                                                </div>
                                        </div>
                                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                                 <label>Status <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                             <select class="form-control" name="status" required >
                                                <option value="1" {{$category->status==1 ? "selected" : ''}} >Enable</option>
                                                <option value="0" {{$category->status==0 ? "selected" : ''}} >Disable</option>
                                            </select>
                                           </div>
                                           </div>
                                          
                                       
                                          
                                <div class="col-md-12 mb-2">
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Description<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" placeholder="Enter Description">{{$category->description}}</textarea>
                            </div>

                        </div>
                        <div class="text-end">
                            <a href="{{route('admin.package.index')}}" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit</button>
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
