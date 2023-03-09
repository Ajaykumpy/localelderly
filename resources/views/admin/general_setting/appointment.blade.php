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

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Patient</h4>
                </div>
                <div class="card-body">
                <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post"
                    enctype="multipart/form-data">
                    @csrf

				<div class="row">
						<div class="col-md-6 col-xl-6 col-xxl-6 mb-3  form-group">
							<label>No Of Doctors<span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" id="no_of_doctor" name="no_of_doctor"
									value="{{ $options['no_of_doctor']??'' }}">
							</div>
						</div>
						<div class=" col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
							<label>Call Per Hour<span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" id="call_per_hour" name="call_per_hour"
									value="{{ $options['call_per_hour']??'' }}">
							</div>
						</div>
						<div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
							<label>Start Time<span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" id="start_time" name="start_time"
									value="{{ $options['start_time']??'' }}">
							</div>
						</div>
						<div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
							<label>End Time<span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" id="end_time" name="end_time"
									value="{{ $options['end_time']??'' }}">
							</div>
						</div>
						<div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
							<label>Minimum Call Hour<span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" id="minimum_call_hour" name="minimum_call_hour"
									value="{{ $options['minimum_call_hour']??'' }}">
							</div>
						</div>
						<div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
							<label>No Of Days<span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" id="current_days" name="current_days"
									value="{{ $options['current_days']??'' }}">
							</div>
						</div>
				</div>
        </div>

    </div>
    <div class="text-end">
        <a href="{{ route('admin.general_setting.appointment') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>
    </div>


    </div>
    </div>
@stop
