@extends('admin.layouts.default')
@section('title')
Admin - General Settings
@endsection
@section('content')
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">General Settings </h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Settings</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{route('admin.general_setting.store')}}" method="Post" enctype="multipart/form-data">
                    @csrf

                        <div class="row">
                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                <label for="name">Company Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="name" name="name" class="form-control" required >
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                <label for="image">Company Logo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                <label for="image_fav">Company Favicon <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" id="image_fav" name="image_fav" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                <label for="email">Contact Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                <label for="mobile">Contact Mobile <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="mobile" name="mobile" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>
                            </div>

                       {{-- <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                            <label for="name">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="password" class="form-control" required value={{$instructor->}}>
                            </div>
                        </div>--}}


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
@endsection
