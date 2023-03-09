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
                            <li class="nav-item active">
                                <a class="nav-link"
                                    href="{{ route('admin.general_setting.localization') }}">Localization</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.general_setting.email')}}">Email Settings</a>
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
                                    <div class="card-header">
                                        <h5 class="card-title">Localization Details</h5>
                                    </div>
                                    <form class="form-valide" action="{{ route('admin.general_setting.store') }}"
                                        method="Post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="settings-form">
                                            <div class="form-group">
                                                <label>Time Zone</label>
                                                <select class="select form-control" id="time_zone" name="time_zone">
                                                    <option value="(UTC +5:30) Antarctica/Palmer" {{ $options['time_zone'] == '(UTC +5:30) Antarctica/Palmer' ? 'Selected' :"" }}>(UTC +5:30) Antarctica/Palmer</option>
                                                    <option value="(UTC+05:30) India" {{ $options['time_zone'] == '(UTC+05:30) India' ? 'Selected' :"" }}>(UTC+05:30) India</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Date Format</label>
                                                <select class="select form-control" id="data" name="data">
                                                    <option value="15 May 2016" {{ $options['data'] == '15 May 2016' ? 'Selected' :"" }}>15 May 2016</option>
                                                    <option value="15/05/2016" {{ $options['data'] == '15/05/2016' ? 'Selected' :"" }}>15/05/2016</option>
                                                    <option value="15.05.2016" {{ $options['data'] == '15.05.2016' ? 'Selected' :"" }}>15.05.2016</option>
                                                    <option value="15-05-2016" {{ $options['data'] == '15-05-2016' ? 'Selected' :"" }}>15-05-2016</option>
                                                    <option value="05/15/2016" {{ $options['data'] == '05/15/2016' ? 'Selected' :"" }}>05/15/2016</option>
                                                    <option value="2016/05/15" {{ $options['data'] == '2016/05/15' ? 'Selected' :"" }}>2016/05/15</option>
                                                    <option value="2016-05-15" {{ $options['data'] == '2016-05-15' ? 'Selected' :"" }}>2016-05-15</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Time Format</label>
                                                <select class="select form-control" id="time" name="time">
                                                    <option value="12 Hours" {{ $options['time'] == '12 Hours' ? 'Selected' :"" }}>12 Hours</option>
                                                    <option value="24 Hours" {{ $options['time'] == '24 Hours' ? 'Selected' :"" }}>24 Hours</option>
                                                    <option value="36 Hours" {{ $options['time'] == '36 Hours' ? 'Selected' :"" }}>36 Hours</option>
                                                    <option value="48 Hours" {{ $options['time'] == '48 Hours' ? 'Selected' :"" }}>48 Hours</option>
                                                    <option value="60 Hours" {{ $options['time'] == '60 Hours' ? 'Selected' :"" }}>60 Hours</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Currency Symbol</label>
                                                <select class="select form-control" id="currency" name="currency">
                                                    <option value="$" {{ $options['currency'] == '$' ? 'Selected' :"" }}>$</option>
                                                    <option value="₹" {{ $options['currency'] == '₹' ? 'Selected' :"" }}>₹</option>
                                                    <option value="£" {{ $options['currency'] == '£' ? 'Selected' :"" }}>£</option>
                                                    <option value="€" {{ $options['currency'] == '€' ? 'Selected' :"" }}>€</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="settings-btns">
                                                    <button type="submit" class="btn btn-orange">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

    </div>
    </div>
@stop
