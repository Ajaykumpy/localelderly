@extends('admin.layouts.default')
@section('title')
    Admin - Settings
@endsection
@section('head')
    <!-- link here -->
@endsection
@section('content')
    <div class="main-wrapper">
        <div class="settings-menu-links">
            <ul class="nav nav-tabs menu-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.general_setting.index') }}">General Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.general_setting.localization') }}">Localization</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.general_setting.email') }}">Email Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.general_setting.appointment') }}">Appointment Setting</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('admin.general_setting.app_update') }}">App Update</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('admin.general_setting.zego_setting') }}">Zego Settings</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('admin.general_setting.razor_key') }}">RAZOR KEY Setting</a>
                </li>
            </ul>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Patient App Update</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3  form-group">
                            <label>App Version<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="patient_app_version" name="patient_app_version"
                                    value="{{ $options['patient_app_version'] ?? '' }}">
                            </div>
                        </div>
                        <div class=" col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                            <label>URL<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="patient_url" name="patient_url"
                                    value="{{ $options['patient_url'] ?? '' }}">
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.general_setting.app_update') }}" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>


        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Doctor App Update</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3  form-group">
                            <label>App Version<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="doctor_app_version" name="doctor_app_version"
                                    value="{{ $options['doctor_app_version'] ?? '' }}">
                            </div>
                        </div>
                        <div class=" col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                            <label>URL<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="doctor_url" name="doctor_url"
                                    value="{{ $options['doctor_url'] ?? '' }}">
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.general_setting.app_update') }}" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>


        </div>


    </div>
    </div>
@stop
