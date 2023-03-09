@extends('doctor.layouts.default')
@section('title','Appointment Details')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="page-title">Appointment Details</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">#{{$patientrequest->id}} <a onclick="window.history.back();" href="#" class="btn btn-sm text-primary float-end"><i class="fas fa-reply"></i></a></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mem-info">
                                <h6>Call Id</h6>
                                <p>#{{$patientrequest->meeting_id??'N/A'}}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mem-info">
                                <h6>Symptoms</h6>
                                <p>{!!$patientrequest->symptoms->map(function($items){ return '<span class="badge badge-info">'.$items->name.'</span>'; })->join(' ')??'N/A'!!}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mem-info">
                                <h6>Status</h6>
                                @php
                                $status=['0'=>'UPCOMMING','1'=>'ONGOING','2'=>'COMPLETED','3'=>'CANCELLED','4'=>"Didn't Connect"];
                                if($patientrequest->status){
                                    $statusname = $status[$patientrequest->status];
                                }else{
                                    $statusname = $status[$patientrequest->status];
                                }
                                @endphp                                
                                <p><span class="badge badge-{{emergency_status($patientrequest->status)}}">{{$statusname}}</span></p>
                            </div>
                        </div>

                    </div>
                </div>    
            </div>
        </div>
        <div class="col-md-6">
            @if($patientrequest->patient)
            <div class="card profile">
                <div class="card-header">
                    <h4 class="card-title">Patient Details</h4>
                </div>
                <div class="card-body">
                    <div class="media d-flex align-items-center justify-content-between">
                        <div class="flex-shrink-0 d-flex align-items-center">
                            <img src="{{$patientrequest->patient->image ? $patientrequest->patient->image : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" alt="patient" class="doctor">
                            <div>
                                <div class="docs-id"> #{{$patientrequest->patient->id}}</div>
                                <h3>{{$patientrequest->patient->name}}</h3>
                                <p>{{$patientrequest->patient->gender}}, {{$patientrequest->patient->age}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="member-wrapper">
                        <h5>Personal Details</h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Phone Number</h6>
                                    <p>{{$patientrequest->patient->mobile??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Email ID</h6>
                                    <p>{{$patientrequest->patient->email??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mem-info">
                                    <h6>Location</h6>
                                    <p>{{($patientrequest->patient && $patientrequest->patient->location)?$patientrequest->patient->location:'NA'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Date of Birth</h6>
                                    <p>{{$patientrequest->patient->age??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-1">
                                <div class="mem-info">
                                    <h6>Existing Disease</h6>
                                    <p>{{$patientrequest->patient->existing_disease??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-1">
                                <div class="mem-info">
                                    <h6>Blood Group</h6>
                                    <p>{{$patientrequest->patient->blood_group??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-1">
                                <div class="mem-info">
                                    <h6>Age</h6>
                                    <p>{{ getAge($patientrequest->patient->dob??NULL) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Alert!</strong> No Patient Found!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="col-md-6">
            @if($patientrequest->doctor)
            <div class="card profile">
                <div class="card-header">
                    <h4 class="card-title">Doctor Details</h4>
                </div>
                <div class="card-body">
                    <div class="media d-flex align-items-center justify-content-between">
                        <div class="flex-shrink-0 d-flex align-items-center">
                            <img src="{{$patientrequest->doctor->profile->image ? $patientrequest->doctor->profile->image : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" alt="patient" class="doctor">
                            <div>
                                <div class="docs-id"> {{$patientrequest->doctor->id}}</div>
                                <h3>{{$patientrequest->doctor->name}}</h3>
                                <p>{{$patientrequest->doctor->profile->gender??"NA"}}, {{$patientrequest->doctor->age??"NA"}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="member-wrapper">
                        <h5>Personal Details</h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Phone Number</h6>
                                    <p>{{$patientrequest->doctor->mobile??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Email ID</h6>
                                    <p>{{$patientrequest->doctor->email??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mem-info">
                                    <h6>Location</h6>
                                    <p>{{$patientrequest->doctor->profile->address??'NA'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Date of Birth</h6>
                                    <p>{{$patientrequest->doctor->dob??"NA"}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Specialist</h6>
                                    <p>{{$patientrequest->doctor->specialist->name??"NA"}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Alert!</strong> No Doctor Found!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>



    </div>    
</div>    
@stop