@extends('admin.layouts.default')
@section('title')
Admin - Staff Create
@endsection
@section('content')
<div class="content container-fluid">
     <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Staff</h3>
            </div>
        </div>
    </div>
    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Staff</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="{{route('admin.staff.store')}}" method="Post" enctype="multipart/form-data">
                                @csrf

                                    <div class="row">
                                      <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="image">Image <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="file" id="image" name="image" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="name">First Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="name" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="middle_name">Middle Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="middle_name" name="middle_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                            <label for="dob">Dob <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="date"  id="dob" name="dob" class="form-control" required>
                                            </div>
                                         </div>

                                         <div class="col-md-6 col-xl-6 col-xxl-6 mb-3">
                                            <label>Assign Role <span class="text-danger">*</span></label>
                                       <div class="input-group">
                                       <select class="form-control" name="role" required>
                                           <option value="0" >Instructor</option>
                                           <option value="1" >Dietitian</option>

                                       </select>
                                      </div>
                                   </div>
                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                        <label for="mobile">Mobile No <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="mobile" name="mobile" class="form-control" onkeypress="this.value = this.value.replace(/[^0-9\-\.]/g, '')" required />

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="email" name="email" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" class="form-control" required>
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
