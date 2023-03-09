@extends('doctor.layouts.default')
@section('title','Doctor - Call Log')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="page-title">Call Log Details</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{$call_log->id}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="mem-info">
                                <h6>Meeting Id</h6>
                                <p>{{$call_log->meeting_id??'N/A'}}</p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="mem-info">
                                <h6>Status</h6>
                                @php
                                $status=['Pending'=>'Pending','1'=>'Connected','2'=>'Completed'];
                                if($call_log->status == "Connected"){
                                    $statusname = 'primary';
                                }elseif($call_log->status == "Pending"){
                                    $statusname = 'info';
                                }
                                elseif($call_log->status == "Completed"){
                                    $statusname = 'success';
                                }
                                @endphp
                                <p><span class="badge badge-{{$statusname}}">{{$call_log->status}}</span></p>
                            </div>
                        </div>
                        @if($call_log->call_type == '2')
                            <div class="col-sm-2">
                                <div class="mem-info media-info">
                                    <h6>Links</h6>
                                    @if($call_log->video_url->count()>0)
    									@forelse($call_log->video_url as $items)
    									<a target="_blank" class="d-block text-primary mt-2" href="{{$items->replay_url}}"><span class="d-flex align-items-center"><i class="feather-video me-2"></i> {{$items->type}}</span></a>
    									@empty

    									@endforelse
    								@endif
                                </div>
                            </div>
                        @endif
                        @if($call_log->call_type == '1')
                            <div class="col-sm-2">
                                <div class="mem-info media-info">
                                    <h6>Call Start at</h6>
                                    {{$call_log->appointment->call_start_at}}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mem-info media-info">
                                    <h6>Call End at</h6>
                                    {{$call_log->appointment->call_end_at}}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mem-info media-info">
                                    <h6>Duration</h6>
                                    {{ call_duration($call_log->appointment->call_start_at??NULL, $call_log->appointment->call_end_at??NULL)}} hrs
                                   
                                </div>
                            </div>
                        @endif                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if($call_log->patient)
            <div class="card profile">
                <div class="card-header">
                    <h4 class="card-title">Patient Details</h4>
                </div>
                <div class="card-body">
                    <div class="media d-flex align-items-center justify-content-between">
                        <div class="flex-shrink-0 d-flex align-items-center">
                            <img src="{{$call_log->patient->image ? $call_log->patient->image : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" alt="patient" class="doctor">
                            <div>
                                <div class="docs-id"> {{$call_log->patient->id}}</div>
                                <h3>{{$call_log->patient->name}}</h3>
                                <p>{{$call_log->patient->gender}}, {{$call_log->patient->age}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="member-wrapper">
                        <h5>Personal Details</h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Phone Number</h6>
                                    <p>{{$call_log->patient->mobile}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Email ID</h6>
                                    <p>{{$call_log->patient->email}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Blood Group</h6>
                                    <p>{{$call_log->patient->blood_group}}</p>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mem-info">
                                    <h6>Address</h6>
                                    <p>{{$call_log->patient->room_no}},{{$call_log->patient->street_name}},{{$call_log->patient->location}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Date of Birth</h6>
                                    <p>{{$call_log->patient->age}}</p>
                                </div>
                            </div>                            
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>BMI</h6>
                                    <p>{{ getBmi($call_log->patient->height??NULL,  $call_log->patient->weight??NULL) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h5>Existing Disease</h5>
                                <p>{{($user->existing_disease)?$user->existing_disease:"NA"}}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h5>Height</h5>
                                <p>{{($user->height)?$user->height:"NA"}}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h5>Weight</h5>
                                <p>{{($user->weight)?$user->weight:"NA"}}</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h5>Address</h5>
                                <p>{{($user->room_no)?$user->room_no:"NA"}},{{$user->street_name}},{{$user->location}}</p>
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
            @if($call_log->doctor)
            <div class="card profile">
                <div class="card-header">
                    <h4 class="card-title">Doctor Details</h4>
                </div>
                <div class="card-body">
                    <div class="media d-flex align-items-center justify-content-between">
                        <div class="flex-shrink-0 d-flex align-items-center">
                            <img src="{{$call_log->doctor->profile->image}}" alt="patient" class="doctor">
                            <div>
                                <div class="docs-id"> #{{$call_log->doctor->id}}</div>
                                <h3>{{$call_log->doctor->name}}</h3>
                                <p>{{$call_log->doctor->profile->gender}}, {{$call_log->doctor->profile->age}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="member-wrapper">
                        <h5>Personal Details</h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Phone Number</h6>
                                    <p>{{$call_log->doctor->mobile}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Email ID</h6>
                                    <p>{{$call_log->doctor->email}}</p>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mem-info">
                                    <h6>Location</h6>
                                    <p>{{$call_log->doctor->profile->address??''}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Date of Birth</h6>
                                    <p>{{$call_log->doctor->profile->age}}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h5>City</h5>
                                <p>{{$call_log->doctor->profile->city}}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h5>Post Code</h5>
                                <p>{{$call_log->doctor->profile->postcode}}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h5>State</h5>
                                <p>{{$call_log->doctor->profile->state}}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h5>Country</h5>
                                <p>{{$call_log->doctor->profile->country}}</p>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info">
                                    <h6>Specialist</h6>
                                    <p>{{$call_log->doctor->specialist->name??"NA"}}</p>
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
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function(){
	$.fn.size = function() {
        return this.length;
    }
	$(".media-info a").fancybox();
});
</script>
@endpush
