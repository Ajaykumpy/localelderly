@extends('admin.layouts.default')
@section('title')
Admin - Allergy Edit
@endsection
@section('content')
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Allergy</h3>
            </div>
        </div>
    </div>
    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Allergy</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.allergy.update',$allergy->id)}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                    <div class="row">                                     
                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                <label>Allergy Name<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="allergy_name" name="allergy_name" required value="{{$allergy->name}}">
                                            </div> 
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                                 <label>Status <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                             <select class="form-control" name="status" required >
                                                <option value="1" {{$allergy->status==1 ? "selected" : ''}} >Enable</option>
                                                <option value="0" {{$allergy->status==0 ? "selected" : ''}} >Disable</option>
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