@extends('admin.layouts.default')
@section('title')
    Admin - Settings
@stop
@section('head')
    <!-- link here -->
@stop
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
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.general_setting.email') }}">Email Settings</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" href="{{route('admin.general_setting.appointment')}}">Appointment Setting</a>
                </li>
                <li class="nav-item">
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

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">PHP Mail</h5>
                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                <input type="checkbox" id="status_1" class="check">
                                <label for="status_1" class="checktoggle">checkbox</label>
                            </div>
                        </div>
                        <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="settings-form">
                                <div class="form-group form-placeholder">
                                    <label>Email From Address <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ $options['email'] ?? '' }}">
                                </div>
                                <div class="form-group form-placeholder">
                                    <label>Email Password <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="email_password" name="email_password"
                                        value="{{ $options['email_password'] ?? '' }}">
                                </div>
                                <div class="form-group form-placeholder">
                                    <label>Emails From Name <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="email_form_name" name="email_form_name"
                                        value="{{ $options['email_form_name'] ?? '' }}">
                                </div>
                                <div class="form-group mb-0">
                                    <div class="settings-btns">
                                        <button type="submit" class="btn btn-orange">Submit</button>
                                        <button herf="{{ route('admin.general_setting.email') }}"
                                            class="btn btn-grey">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">SMTP</h5>
                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                <input type="checkbox" id="status_2" class="check" checked="">
                                <label for="status_2" class="checktoggle">checkbox</label>
                            </div>
                        </div>
                        <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="settings-form">
                                <div class="form-group form-placeholder">
                                    <label>Email From Address <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="email_smpt_address"
                                        name="email_smpt_address" value="{{ $options['email_smpt_address'] ?? '' }}">
                                </div>
                                <div class="form-group form-placeholder">
                                    <label>Email Password <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="email_smpt_password"
                                        name="email_smpt_password" value="{{ $options['email_smpt_password'] ?? '' }}">
                                </div>
                                <div class="form-group form-placeholder">
                                    <label>Email Host <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="email_smpt_host" name="email_smpt_host"
                                        value="{{ $options['email_smpt_host'] ?? '' }}">
                                </div>
                                <div class="form-group form-placeholder">
                                    <label>Email Port <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="email_port" name="email_port"
                                        value="{{ $options['email_port'] ?? '' }}">
                                </div>
                                <div class="form-group mb-0">
                                    <div class="settings-btns">
                                        <button type="submit" class="btn btn-orange">Submit</button>
                                        <button herf="{{ route('admin.general_setting.email') }}"
                                            class="btn btn-grey">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
