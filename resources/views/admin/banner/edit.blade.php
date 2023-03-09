@extends('admin.layouts.default')
@section('title')
Admin - Banner edit
@endsection
@section('content')
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Banner </h3>
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Banner</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.banner.update',$banner->id)}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                    <div class="row">
                                 {{--   <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                <label>status<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="status" name="status" required value="{{$banner->status}}">
                                                </div>
                                            </div>--}}
                                            
                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                                <label for="name">image <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="file" name="image" class="form-control" required value="{{$banner->image}}">
                                                </div>
                                            </div>
                                       
                                           <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                                 <label>Status <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                             <select class="form-control" name="status"  id="status" required>
                                             <option value="1" {{$banner->status==1 ? "selected" : ''}} >Enable</option>
                                                <option value="0" {{$banner->status==0 ? "selected" : ''}} >Disable</option>
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
</div>
 {{--<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Program</h3>
            </div>
        </div>
    </div>
   <div class="row">

        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Program</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{route('program.update',$program->id)}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row row">
                            <div class="col-md-4 form-group">
                                <label>Package Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="program_name" name="program_name" placeholder="Enter package name" required>
                            </div>
                         
             
                            <div class="col-md-6 col-xl-4 col-xxl-4  mb-3 form-group">
                            <label>Price<span class="text-danger">*</span></label>
                            <div class="input-group">
                            <input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="price" name="price" required value="{{$program->price}}">
                            </div>
                       
                            <div class="col-md-6 col-xl-4 col-xxl-6 mb-3">
                                      <label>Status <span class="text-danger">*</span></label>
                                      <div class="input-group">
                                            <select class="form-control" name="status" required>
                                                <option value="1" >Enable</option>
                                                <option value="0" >Disable</option>
                                            </select>
                                      </div>
                                  </div>
                          
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Description<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
                            </div>
                            

                        </div>
                        <div class="text-end">
                            <a href="{{route('program.index')}}" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@stop