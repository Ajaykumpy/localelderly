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
                                <h4 class="card-title">Edit Page</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.page.update',$page->ID)}}" method="Post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="post_type" value="page">
                                    <div class="form-row row">
                                        <div class="col-md-12 form-group">
                                            <label>Title<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="post_title" name="post_title" value="{!!$page->post_title!!}" placeholder="Enter Title Name" required>
                                        </div>


                                    </div>
                                    <div class="form-row row">
                                        <div class="col-md-12 form-group">
                                            <label>Description<span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="post_content" placeholder="Enter Description">{!!$page->post_content!!}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-row row">
                                        <div class="col-md-12 form-group">
                                            <label>Status<span class="text-danger">*</span></label>
                                            <select class="form-control" id="post_status" name="post_status" required>
                                                <option value="unpublish" {{$page->post_status == 'unPublish' ? 'Selected':''}}>UnPublish</option>
                                                <option value="publish" {{$page->post_status == 'publish' ? 'Selected':''}}>Publish</option>
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
<!-- script -->
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script>
$(function(){
    $(".form-valide").validate({
        rules: {
            "post_title": {
                required: !0,
                minlength: 3
            },
        },
        messages: {
            "post_title": {
                required: "Please enter page name",
                minlength: "Your page must consist of at least 3 characters"
            },
        },
        ignore: [],
        errorClass: "invalid-feedback animated fadeInUp",
        errorElement: "div",
        errorPlacement: function(e, a) {
            $(a).parents(".form-group > div").append(e)
        },
        highlight: function(e) {
            $(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
        },
        success: function(e) {
            $(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
        },
    });
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

});
</script>
@endpush
