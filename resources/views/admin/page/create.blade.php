@extends('admin.layouts.default')
@section('title')
Admin - Pages
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
                <h3 class="page-title">Page</h3>
            </div>
        </div>
    </div>
   <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Page</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{route('admin.page.store')}}" method="Post" enctype="multipart/form-data">  
                        @csrf     
                        <input type="hidden" name="post_type" value="page">                             
                        <div class="form-row row">
                            <div class="col-md-12 form-group">
                                <label>Title<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="post_title" name="post_title" placeholder="Enter Title Name" required>
                            </div>
                            
                           
                        </div>
                        <div class="form-row row">
                            <div class="col-md-12 form-group">
                                <label>Description<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="post_content" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="col-md-12 form-group">
                                <label>Status<span class="text-danger">*</span></label>
                                <select class="form-control" id="post_status" name="post_status" required>
                                    <option value="unpublish">UnPublish</option>           
                                    <option value="publish">Publish</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="col-md-12 form-group">
                                <div class="text-end">
                                    <a href="{{route('admin.page.index')}}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
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
    $.summernote.dom.emptyPara = "";
    $('textarea[name="post_content"]').summernote({
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
        ],
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