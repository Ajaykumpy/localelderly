@extends('admin.layouts.default')
@section('title')
Admin - Banner Create
@endsection
@section('content')
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Banners</h3>
            </div>
        </div>
    </div>
    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Banner</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.banner.store')}}" method="Post" enctype="multipart/form-data">
                                @csrf
                            
                                    <div class="row">                                     
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="name">image <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="file" name="image" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                                 <label>Status <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                             <select class="form-control" name="status" required>
                                                <option value="1" >Enable</option>
                                                <option value="0" >Disable</option>
                                            </select>
                                           </div>
                                           </div>
                                          
                                    </div>
                                    <div class="text-end">
                                        <a href="" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
</div>
@stop