@extends('admin.layouts.default')
@section('title')
Admin - Package Activation
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
                    <h4 class="card-title">Edit Package Activation</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{url(route('admin.package-activation.update',$activation->id))}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="col-md-6 form-group">
                                <label>Package Name<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="specialist_id" class="form-control">
                                        <option value="">--SELECT--</option>
                                        @forelse(\App\Models\Package::whereStatus(1)->get() as $items)
                                        <option value="{{$items->id}}" {{ ($activation->package && $activation->package->id==$items->id)?'selected':'' }}>{{$items->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Company Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{$activation->company_name}}" placeholder="Enter Company name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Patient Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="user_name" name="user_name" value="{{$activation->user_name}}" placeholder="Enter Patient name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Patient No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="user_mobile" name="user_mobile" value="{{$activation->user_mobile}}" placeholder="Enter Mobile No" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Patient Email<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="user_email" name="user_email" value="{{$activation->user_email}}" placeholder="Enter Patient Email" required>
                            </div>


                            <div class="col-md-3 form-group">
                                <label>Activation Code<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><button type="button" class="Generate" id="generate-promo-code"><i class="fa fa-refresh"></i></button></span>
                                    <input type="text" class="form-control" id="activation_code" name="activation_code" value="{{$activation->activation_code}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{route('admin.package-activation.index')}}" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
$(document).ready(function(){
  $("#generate-promo-code").click(function(){
    var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    var promoCode = "";
    for(var i=0; i < 8; i++) {
        promoCode += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    $("#activation_code").val(promoCode);


  });
});
</script>
@endpush
