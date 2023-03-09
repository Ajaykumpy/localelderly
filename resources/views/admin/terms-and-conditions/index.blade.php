{{-- Extends layout --}}
@extends('admin.layouts.default')
@section('title', 'Admin - Terms & Condition')
@php
$editing = isset($termsandcondition);
@endphp
@section('content')
<div class="container-fluid">
    
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12" >
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Terms & Conditions</h4>
                </div>
                <div class="card-body">
                    <form class="" action="{{route('admin.terms-and-conditions.store')}}" method="post">
                  @csrf
                  @method('POST')
                    <textarea class="summernote" id="terms_and_conditions" name="terms_and_conditions" rows="4" cols="50">
                    {{ $editing ? $termsandcondition->post_content : '' }}</textarea><br>
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
    $('textarea[name="terms_and_conditions"]').summernote({
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
