@extends('doctor.layouts.default')
@section('title','Doctor - Prescription')
@section('content')
<div class="content container-fluid">

    <div class="row">
        <div class="col-md-8">
            <div class="prescription-info">
                <h4>Prescription Detail  <a class="btn btn-sm text-danger" href="{{route('doctor.prescription.pdf',$prescription->prescription_id)}}" target="_blank"><i class="fa fa-file-pdf"></i> Download</a> <a href="#" onclick="window.history.go(-1);" class="btn btn-sm float-end">Back</a></h4>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="pro-title mb-0">Weight : {{$prescription->weight}} {{$prescription->weight_class}} </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="mb-0 pb-0">Diagnosis</h6>
                        <span class="text-black">{!! $prescription->diagnosis !!}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="mb-0 pb-0 mt-2">Details</h6>
                        <span>{!! $prescription->description !!}</span>
                    </div>
                </div>
                @if($prescription->vital_sign->count()>0)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="pro-title mb-0 pb-0 mt-2">Vital Sign</h6>
                    </div>
                    @foreach($prescription->vital_sign as $items)
                    <div class="col-md-4 mb-3">
                        <h5 class="text-muted">{{$items->name}}</h5>
                        <p>{{$items->value}} / {{$items->value_class}}</p>
                    </div>
                    @endforeach
                </div>
                @endif
                @if($prescription->symptom->count()>0)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="pro-title mb-0 pb-0 mt-2">Symptoms</h6>
                        <p>
                        @foreach($prescription->symptom as $items)
                        <span class="badge badge-info">{{ucwords($items->symptom)}}</span>
                        @endforeach
                        </p>
                    </div>
                </div>
                @endif
                @if($prescription->medicine->count()>0)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="pro-title pb-0 mt-2">Medicine Detail</h6>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Strength</th>
                                    <th>Dosage</th>
                                    <th>Duration</th>
                                    <th>Preparation</th>
                                    <th>Direction</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($prescription->medicine as $items)
                            <tr>
                            <td>{{$items->medicine_name}}</td>
                            <td>{{$items->quantity}}</td>
                            <td>{{$items->strength}} {{$items->strength_unit}}</td>
                            <td>{{$items->dosage}} {{$items->dosage_unit}}</td>
                            <td>{{$items->duration}} {{$items->duration_unit}}</td>
                            <td>{{$items->preparation}}</td>
                            <td>{{$items->direction}}</td>
                            <td>{{$items->note}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        <div class="col-md-4">
            <div class="profile-info">
                <h4>Patient Detail</h4>
                <div class="profile-list">
                    <div class="profile-detail">
                        <label class="avatar profile-cover-avatar">
                        <img class="avatar-img" src="{{ ($prescription->patient->image??"")?asset($prescription->patient->image??""):'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y' }}" alt="{{ $prescription->patient->name ??""}}">
                        </label>
                        <div class="pro-name">
                            <p>@ {{$prescription->patient->mobile??""}}</p>
                            <h4>{{ $prescription->patient->name??"" }}</h4>
                        </div>
                    </div>
                <div class="row">
                    {{--<div class="col-md-12">
                        <h6 class="pro-title">Personal Information</h6>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Date of Birth</h5>
                        <p>15/12/2022</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Gender</h5>
                        <p>Male</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Age</h5>
                        <p>46</p>
                    </div>--}}
                    <div class="col-md-12">
                        <h6 class="pro-title">Address & Location</h6>
                    </div>
                    <div class="col-md-12">
                        <h5>Address</h5>
                        <p>{{$prescription->patient->address??$prescription->patient->location??""}}</p>
                    </div>

                </div>
                </div>
                <div class="profile-list">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pro-title d-flex justify-content-between">
                                <h6>Account Information</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Email Address</h5>
                            <p><a class="text-break" href="mailto:{{$prescription->patient->email??""}}">{{$prescription->patient->email??""}}</a></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Phone Number</h5>
                            <p>{{$prescription->patient->mobile??""}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
