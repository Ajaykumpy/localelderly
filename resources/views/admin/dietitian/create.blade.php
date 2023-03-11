@extends('admin.layouts.default')
@section('title')
Admin - Dietitian Create
@endsection
@section('content')
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Dietitian</h3>
            </div>
        </div>
    </div>
    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Dietitian</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.dietitian.store')}}" method="Post" enctype="multipart/form-data">
                                @csrf

                                    <div class="row">
                                      <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="name">image <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="file" name="image" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="name">First Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="name">Middle Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="middle_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="name">Last Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="last_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="name">DOB <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="date" name="dob" class="form-control" required>
                                            </div>
                                         </div>

                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                        <label for="name">Mobile No <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="mobile" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                        <label for="name">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="email" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                        <label for="name">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                                 <label>Gender <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                            <select class="form-control" name="gender" required>
                                                <option value="1" >Male</option>
                                                <option value="2" >Female</option>
                                                <option value="3" >Others</option>
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
