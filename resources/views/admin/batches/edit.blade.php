@extends('admin.layouts.default')
@section('title')
Admin - Instructor Edit
@endsection
@section('content')
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Batches </h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">@extends('admin.layouts.default')
                @section('title')
                Admin - Batches Edit
                @endsection
                @section('content')
                <div class="content container-fluid">
                     <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Batches</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Edit Batches</h4>
                                            </div>
                                            <div class="card-body">
                                                <form class="form-valide" action="{{route('admin.batches.update',$batches->id)}}" method="Post" enctype="multipart/form-data">
                                                @csrf

                                                    <div class="row">
                                                      <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                            <label for="image">Image <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" name="image" id="image "class="form-control" required >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                            <label for="name"> Name <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" name="name" id="name" class="form-control" required value={{$batches->name}}>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                            <label for="start_time">Start Time <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="time" id="start_time" name="start_time" class="form-control" required value={{$batches->start_time}}>
                                                            </div>
                                                         </div>

                                                         <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                            <label for="end_time">End Time <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="time" id="end_time" name="end_time" class="form-control" required value={{$batches->end_time}}>
                                                            </div>
                                                         </div>



                                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                                                 <label>Status <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                            <select class="form-control" name="status"  required value={{$batches->status}}>
                                                                <option value="1" >Enable</option>
                                                                <option value="0" >Disable</option>

                                                            </select>
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

@endsection
