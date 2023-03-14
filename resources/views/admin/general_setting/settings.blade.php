@extends('admin.layouts.default')
@section('title', ' Admin - Settings')
@section('head')
    <!-- link here -->
@stop
@section('content')

    <div class="main-wrapper">

        <div class="settings-menu-links">
            <ul class="nav nav-tabs menu-tabs">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.general_setting.index') }}">General Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.general_setting.localization') }}">Localization</a>
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
                            <h5 class="card-title">Website Basic Details</h5>
                        </div>
                        <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="settings-form">
                                    <div class="form-group">
                                        <label>Name <span class="star-red">*</span></label>
                                        <input type="text" class="form-control" id="name"
                                            value="{{ $options['name']??'' }}" name="name" placeholder="Enter Name" >
                                    </div>
                                    <div class="form-group">
                                        <p class="settings-label">Logo <span class="star-red">*</span></p>
                                        <div class="settings-btn">
                                            <input type="file" accept="image/*" name="logo"
                                                value="{{ $options['image']??'' }}" id="logo" onchange="loadFile(event)"
                                                class="hide-input">
                                            <label for="logo" class="upload">
                                                <i class="feather-upload"></i>
                                            </label>
                                        </div>
                                        <h6 class="settings-size">Recommended image size is <span>150px x 150px</span></h6>
                                        <div class="upload-image">
                                            <img src="assets/img/logo.png" alt="image">
                                            <a href="javascript:void(0);" class="btn-icon logo-hide-btn">
                                                <i class="feather-x-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <p class="settings-label">Favicon <span class="star-red">*</span></p>
                                        <div class="settings-btn">
                                            <input type="file" accept="image/*" value="{{ $options['favicon']??'' }}"
                                                name="favicon" id="favicon" onchange="loadFile(event)" class="hide-input">
                                            <label for="favicon" class="upload">
                                                <i class="feather-upload"></i>
                                            </label>
                                        </div>
                                        <h6 class="settings-size">
                                            Recommended image size is <span>16px x 16px or 32px x 32px</span>
                                        </h6>
                                        <h6 class="settings-size mt-1">Accepted formats: only png and ico</h6>
                                        <div class="upload-images upload-size">
                                            <img src="assets/img/favicon.png" alt="Image">
                                            <a href="javascript:void(0);" class="btn-icon logo-hide-btn">
                                                <i class="feather-x-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="settings-btns">
                                            <button type="submit" class="btn btn-orange">Update</button>
                                            <button type="submit" herf="{{ route('admin.general_setting.index') }}"
                                                class="btn btn-grey">Cancel</button>
                                        </div>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
           {{-- <div class="col-md-6">
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="card-header">
                            <h5 class="card-title">Address Details</h5>
                        </div>
                        <form class="form-valide" action="{{ route('admin.general_setting.store') }}" method="Post" enctype="multipart/form-data">
                          @csrf
                            <div class="settings-form">
                                <div class="form-group">
                                    <label>Address Line 1 <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $options['address']??'' }}"
                                        placeholder="Enter Address Line 1">
                                </div>
                                <div class="form-group">
                                    <label>Address Line 2 <span class="star-red">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $options['address']??'' }}"
                                        placeholder="Enter Address Line 2">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City <span class="star-red">*</span></label>
                                            <input type="text" id="city" value="{{ $options['city']??'' }}" name="city" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State/Province <span class="star-red">*</span></label>
                                            <select class="select form-control" name="state">
                                                <option >Select</option>
                                                <option value="California" {{ $options['state'] == 'California' ? 'Selected' :"" }}>California</option>
                                                <option value="Tasmania" {{ $options['state'] == 'Tasmania' ? 'Selected' :"" }}>Tasmania</option>
                                                <option value="Auckland" {{ $options['state'] == 'Auckland' ? 'Selected' :"" }}>Auckland</option>
                                                <option value="Marlborough" {{ $options['state'] == 'Marlborough' ? 'Selected' :"" }}>Marlborough</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Zip/Postal Code <span class="star-red">*</span></label>
                                            <input type="text" id="zip" value="{{ $options['zip']??'' }}" name="zip" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country <span class="star-red">*</span></label>
                                            <select class="select form-control" name="country">
                                                <option >Select</option>
                                                <option value="India" {{ $options['country'] == 'India' ? 'Selected' :"" }}>India</option>
                                                <option value="London" {{ $options['country'] == 'London' ? 'Selected' :"" }}>London</option>
                                                <option value="France" {{ $options['country'] == 'France' ? 'Selected' :"" }}>France</option>
                                                <option value="USA" {{ $options['country'] == 'USA' ? 'Selected' :"" }}>USA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="settings-btns">
                                        <button type="submit" class="btn btn-orange">Update</button>
                                        <button type="submit" herf="{{ route('admin.general_setting.index') }}"
                                            class="btn btn-grey">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
@stop
@push('scripts')
<script>
 $(function(){
    $('input[name="logo"]').on('change',function(){

        $.ajax({
            type: 'POST',
            url: "{{route('media')}}",
            data:'',
            dataType: "json",
            success: function(resultData) {
                console.log("Save Complete");
            }
        });
    });
 });
 loadFile();
</script>
@endpush
