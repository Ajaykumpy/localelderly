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
                    <h4 class="card-title">ZEGO KEY</h4>
                </div>
                <div class="card-body">
                    <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-xl-6 col-xxl-6 mb-3  form-group">
                            <label>ZEGO SERVER KEY<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="ZEGO_SERVER_KEY" name="ZEGO_SERVER_KEY"
                                    value="{{ $options['ZEGO_SERVER_KEY'] ?? '' }}">
                            </div>
                        </div>
                        <div class=" col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                            <label>ZEGO APP ID<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="ZEGO_APP_ID" name="ZEGO_APP_ID"
                                    value="{{ $options['ZEGO_APP_ID'] ?? '' }}">
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
    </div>
@stop
