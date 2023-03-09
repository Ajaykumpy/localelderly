{{-- Extends layout --}}
@extends('admin.layouts.default')
@section('title', 'Admin - Privacy Policy')
@php
$editing = isset($privacypolicy);
@endphp
@section('content')
<div class="container-fluid">
    
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12" >
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Privacy Policy</h4>
                </div>
                <div class="card-body">
                    <form class="" action="{{route('admin.privacy-policy.store')}}" method="post">
                  @csrf
                  @method('POST')
                    <textarea class="summernote" id="privacy_policy" name="privacy_policy" rows="4" cols="50">
                    {{ $editing ? $privacypolicy->post_content : '' }}</textarea><br>
                    <button type="submit" class="btn btn-primary mb-2 mr-2 " style="float:right;">Submit</button>
                    </form>
                    </div>
            </div>
        </div>
       
    </div> <!-- row end -->
</div>
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@push('scripts')
<!-- script -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script>
$(function(){
    $('textarea[name="privacy_policy"]').summernote({
        placeholder: 'Enter Terms And Condition...',
        tabsize: 2,
        height: 250,
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
    
});
</script>
@endpush
@stop
