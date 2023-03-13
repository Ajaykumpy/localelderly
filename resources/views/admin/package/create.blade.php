@extends('admin.layouts.default')
@section('title')
Admin - Package
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
                        <div class="form-row row">
                            <div class="col-md-6 form-group">
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter package name" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Period<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="invoice_period" name="invoice_period" placeholder="Enter Day" required>
                                    <span class="input-group-text">Day</span>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Price<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-rupee-sign"></i></span>
                                    <input type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="price" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1">
                                    <label class="form-check-label" for="status">Enable</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                <label>Category <span class="text-danger">*</span></label>
                           <div class="input-group">
                            <select class="form-control" name="category_id" required >
                                @foreach ($category as $data)
                               <option value="{{$data->id}}" >{{$data->category_name}}</option>
                              @endforeach
                           </select>
                          </div>
                          </div>

                            <div class="col-md-3 form-group">
                                <label for="name">Image</label>
                                <div class="change-photo-btn h-50">
                                    <div>
                                        <i class="feather-upload"></i>
                                        <p>Upload File</p>
                                    </div>
                                    <input type="file" name="image" class="upload" id="image">
                                    <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                        alt="preview image" style="max-height: 250px;">
                                </div>
                                <div class="col-md-12 mb-2">
                                </div>
                                {{-- @if($packages->image)
                                <p class="file-name text-success">Successfully {{$packages->image}} uploaded <a href="#" class="text-danger"><i class="feather-x"></i></a></p>
                                @endif --}}
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Description<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" placeholder="Enter Description"></textarea>
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
