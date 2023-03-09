@extends('admin.layouts.default')
@section('title','Patient')
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul role="tablist" class="nav nav-tabs card-header-tabs float-right">
                        <li class="nav-item">
                            <a href="#patient-profile" data-bs-toggle="tab" class="nav-link active"><i class="fa fa-user"></i> Patient Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#prescription" data-bs-toggle="tab" class="nav-link"><i class="fa fa-calendar"></i> Prescription</a>
                        </li>
                        <li class="nav-item">
                            <a href="#emergency-request" data-bs-toggle="tab" class="nav-link"><i class="fa fa-phone"></i> Emergency Request</a>
                        </li>
                        <li class="nav-item">
                            <a href="#emergency-call-log" data-bs-toggle="tab" class="nav-link"><i class="fa-solid fa-phone-volume"></i> Emergency Call Log</a>
                        </li>
						<li class="nav-item">
                            <a href="#location-log" data-bs-toggle="tab" class="nav-link"><i class="fa-solid fa-map"></i> Location Log</a>
                        </li>
                        <li class="nav-item">
                            <a href="#book-appointment" data-bs-toggle="tab" class="nav-link"><i class="fa fa-calendar"></i> Booked Appointment</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content pt-0">
                        <div role="tabpanel" id="patient-profile" class="tab-pane fade show active">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 border-r">
                                    <div class="card">
                                        <div class="card-header"><h5 class="card-title">{{$user->name}} <a href="#" onclick="window.history.back();" class="float-end btn-sm"><i class="fa fa-reply"></i></a></h5></div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img class="profile-user-img img-responsive rounded" src="{{($user->image)?$user->image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" width="115" height="115">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Mobile</h5>
                                                            <p>{{$user->mobile}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Email</h5>
                                                            <p>{{$user->email}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Gender</h5>
                                                            <p>{{($user->gender)?$user->gender:"NA"}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Blood Group</h5>
                                                            <p>{{($user->blood_group)?$user->blood_group:"NA"}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Date Of Birth</h5>
                                                            <p>{{($user->dob)?$user->dob:"NA"}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Age</h5>
                                                            <p>{{ getAge($user->dob??NULL)}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>BMI</h5>
                                                            <p>{{ getBmi($user->height??NULL, $user->weight??NULL)}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4 mb-3">
                                                    <h5>Existing Disease</h5>
                                                    <p>{{($user->existing_disease)?$user->existing_disease:"NA"}}</p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <h5>Height</h5>
                                                    <p>{{($user->height)?$user->height:"NA"}} Ft/CM</p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <h5>Weight</h5>
                                                    <p>{{($user->weight)?$user->weight:"NA"}} KG</p>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <h5>Address</h5>
                                                    <p>{{($user->room_no)?$user->room_no:"NA"}},{{$user->street_name}},{{$user->location}}</p>
                                                </div>
                                                @if($user->latest_prescription && $user->latest_prescription->symptom->count()>0)
                                                    <div class="col-md-12">
                                                        <h6 class="pro-title mb-0 pb-0 mt-2">Symptoms</h6>
                                                        <p>
                                                        @foreach($user->latest_prescription->symptom as $items)
                                                        <span class="badge badge-info">{{ucwords($items->symptom)}}</span>
                                                        @endforeach
                                                        </p>
                                                    </div>
                                                @endif
                                                <div class="col-md-12">
                                                    <h6 class="pro-title pb-0 mb-0">Diagnosis</h6>
                                                    <div>{{ $user->latest_prescription->diagnosis??'' }}</div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h6 class="pro-title pb-0 mb-0">Description</h6>
                                                    <div>{{ $user->latest_prescription->description??'' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
									<div class="row">
									<div class="col-md-12"><h4>Packages</h4></div>
									@php
									$subscriptions=$user->activePackageSubscriptions();
                                    // $subscriptions=\App\Models\Package::get();
									if($subscriptions->count()>0){
										$subscriptions=$subscriptions->filter(function($items){
											return $items->ends_at!=null;
										});
									}
									@endphp
									@forelse($subscriptions as $items)
									@php
									$package=\App\Models\Package::find($items->package_id);
									@endphp
									<div class="col-md-6 card flex-fills">
										<img alt="Card Image" src="{{(!empty($package->image))?url($package->image):''}}" class="card-img-top img-fluid">
										<div class="card-header">
										<h5 class="card-title mb-0">{{$package->name??''}}</h5>
										</div>
										<ul class="list-group list-group-flush">
											<li class="list-group-item"><strong>Status :</strong> {!! $user->subscribedTo($items->package_id)?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Inactive</span>' !!}</li>
											<li class="list-group-item"><strong>Expiry :</strong> {!! \Carbon\Carbon::parse($items->ends_at)->format('d-m-Y h:i A') !!}</li>
										</ul>
									</div>
									@empty
									<div class="col-md-12"><div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Alert!</strong> No Active Subscription found!
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div></div>
									@endforelse
									</div>
                                    @if($user->latest_prescription && $user->latest_prescription->vital_sign->count()>0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6 class="pro-title mb-0 pb-0 mt-2">Vital Sign</h6>
                                        </div>
                                        @foreach($user->latest_prescription->vital_sign as $items)
                                        <div class="col-md-4 mb-3">
                                            <h5 class="text-muted">{{$items->name}}</h5>
                                            <p>{{$items->value}} / {{$items->value_class}}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if($user->latest_prescription && $user->latest_prescription->medicine->count()>0)
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
                                                @foreach($user->latest_prescription->medicine as $items)
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
                        </div>
                        <div role="tabpanel" id="prescription" class="tab-pane fade text-center">
                            <div class="table-responsive">
                                <table id="prescription-table" class="datatable table table-borderless hover-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient</th>
                                        <th>Diagnosis</th>
                                        <th>Symptom</th>
                                        <th>Date</th>
                                        <th>Doctor</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" id="emergency-request" class="tab-pane fade text-center">
                            <div class="table-responsive">
                                <table id="emergency-request-table" class="datatable table table-borderless hover-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Meeting Id</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Doctor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" id="emergency-call-log" class="tab-pane fade text-center">
                            <div class="table-responsive">
                                <table id="emergency-call-log-table" class="datatable table table-borderless hover-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Meeting Id</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Link</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
						<div role="tabpanel" id="location-log" class="tab-pane fade text-center">
                            <div class="table-responsive">
                                <table id="location-log-table" class="datatable table table-borderless hover-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr.No</th>
											<th>Date</th>
											<th>Event</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" id="book-appointment" class="tab-pane fade text-center">
                            <div class="table-responsive">
                                <table id="book-appointment-table" class="datatable table table-borderless hover-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr.No</th>
											<th>Patient</th>
											<th>Doctor</th>
                                            <th>Symptoms</th>
                                            <th>Comment</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@stop
@push('styles')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function(){
    $('#prescription-table').DataTable({
        "language": {
            search: ' ',
            searchPlaceholder: "Search...",
            paginate: {
                next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
                previous: '<i class="fas fa-chevron-left me-2"></i> Previous'
            }
        },
        "bFilter": true,
        "bInfo": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "ajax": {
            "url": "{{ url()->current() }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
                data.type='prescription';
                data.patient_id={{$user->id}}||0;
            },
        },
        "columns": [
            { "data": 'prescription_id',"name":'prescription_id','orderable': false, 'searchable': false,'width':'5%'},
            { "data": "patient.name","name":"patient.name"},
            { "data": "diagnosis","name":"diagnosis"},
            { "data": "symptom","name":"symptom"},
            { "data": "date","name":"date"},
            { "data": "doctor.name","name":"doctor.name"},
            { "data": "action",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {

                    return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {
                    if(data.length>0){
                        return data.map(function(v,i){
                            return '<span class="badge bg-info text-light">'+v.symptom+'</span>';
                        }).join(' ');
                    }
                    return data;
                },
                "targets":3,
            },
        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
        },
    });
    //call request
    $('#emergency-request-table').DataTable({
        "language": {
            search: ' ',
            searchPlaceholder: "Search...",
            paginate: {
                next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
                previous: '<i class="fas fa-chevron-left me-2"></i> Previous'
            }
        },
        "bFilter": true,
        "bInfo": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "ajax": {
            "url": "{{ url()->current() }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
                data.type='call_requests';
                data.patient_id={{$user->id}}||0;
            },
        },
        "columns": [
            { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
            { "data": "meeting_id","name":"meeting_id"},
            { "data": "status","name":"status"},
            { "data": "created_at","name":"created_at"},
            { "data": "created_at","name":"created_at"},
            { "data": "doctor.name","name":"doctor.name",defaultContent:"NA"},
            { "data": "action",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {
                    return meta.row+1;
                },
                "targets":0,
            },
			{render: function (data, type, row, meta) {
					let label=[];
                    label['completed']='badge-primary';
					label['connected']='badge-success';
					label['pending']='badge-danger';
                    return '<span class="badge '+label[data.toLowerCase()]+'">'+data+'</span>';
                },
                "targets":2,
            },
            {render: function (data, type, row, meta) {
                   return moment(data).format('DD-MM-YYYY');
               },
               "targets":-4,
            },
            {render: function (data, type, row, meta) {
                   return moment(data).format('hh:mm:ss A');
               },
               "targets":-3,
            },
        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
        },
    });
    //emergency-call-log-table
    $('#emergency-call-log-table').DataTable({
        "language": {
            search: ' ',
            searchPlaceholder: "Search...",
            paginate: {
                next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
                previous: '<i class="fas fa-chevron-left me-2"></i> Previous'
            }
        },
        "bFilter": true,
        "bInfo": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "ajax": {
            "url": "{{ url()->current() }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
                data.type='emergency_call_log';
                data.patient_id={{$user->id}}||0;
            },
        },
        "columns": [
            { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
            { "data": "meeting_id","name":"meeting_id"},
            { "data": "status","name":"status",defaultContent:"NA"},
            { "data": "date","name":"date"},
            { "data": "time","name":"time"},
            { "data": "video_url","name":"video_url"},
            //{ "data": "doctor.name","name":"doctor.name",defaultContent:""},
            //{ "data": "action",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {

                    return meta.row+1;
                },
                "targets":0,
            },
			{render: function (data, type, row, meta) {
					if(data == 'Connected'){
                        return '<span class="badge badge-info">'+data+'</span>';
                    }else if(data == 'Pending'){
                        return '<span class="badge badge-danger">'+data+'</span>';
                    }else if(data == 'Completed'){
                        return '<span class="badge badge-success">'+data+'</span>';
                    }
                },
                "targets":2,
            },
			{render: function (data, type, row, meta) {
					let link='';
                   if(data.length){
					   $.each(data,function(i,v){
						   //link+='<a target="_blank" class="d-block text-primary mt-2" href="'+v.replay_url+'"><span class="d-flex align-items-center"><i class="feather-video me-2"></i> '+v.type+' '+((v.type=='Patient')?' <i class="fa fa-user"></i>':' <i class="fa-solid fa-user-doctor"></i>')+'</span></a> ';
						   link+='<a target="_blank" class="d-block text-primary mt-2" href="'+v.replay_url+'"><span class="d-flex align-items-center"><i class="feather-video me-2"></i> '+v.type+'</span></a> ';
					   });
				   }
				   return link;
                    return data;
                },
                "targets":-1,
            },

        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
        },
    });
	//location log
    $('#location-log-table').DataTable({
        "language": {
            search: ' ',
            searchPlaceholder: "Search...",
            paginate: {
                next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
                previous: '<i class="fas fa-chevron-left me-2"></i> Previous'
            }
        },
        "bFilter": true,
        "bInfo": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "ajax": {
            "url": "{{ url()->current() }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
                data.type='location_log';
                data.patient_id={{$user->id}}||0;
            },
        },
        "columns": [
            { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
			{ "data": "created_at","name":"created_at"},
            //{ "data": "properties.latitude","name":"properties.latitude"},
            //{ "data": "properties.longitude","name":"properties.longitude"},
			{ "data": "event","name":"event"},
            { "data": "address","name":"address"},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {

                    return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {

                   return moment(data).format('LLLL');
               },
               "targets":1,
           },
		   {render: function (data, type, row, meta) {
					if(row.properties.latitude && row.properties.longitude){
						return '<a href="http://www.google.com/maps/place/'+row.properties.latitude+','+row.properties.longitude+'" target="_blank"><i class="fas fa-map"></i></a>';
					}
                   return 'N/A'
               },
               "targets":-1,
           },
        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
        },
    });
    //Booked Appointment
    //book-appointment-table
    $('#book-appointment-table').DataTable({
        "language": {
            search: ' ',
            searchPlaceholder: "Search...",
            paginate: {
                next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
                previous: '<i class="fas fa-chevron-left me-2"></i> Previous'
            }
        },
        "bFilter": true,
        "bInfo": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "ajax": {
            "url": "{{ url()->current() }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
                data.type='booked_appointment';
                data.patient_id={{$user->id}}||0;
            },
        },
        "columns": [
            { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
            { "data": "patient.name","name":"patient.name",defaultContent:''},
            { "data": "doctor.name","name":"doctor.name",defaultContent:'NA'},
            { "data": "symptom_id","name":"symptom_id",'orderable': false,defaultContent:''},
            { "data": "comment","name":"comment",'orderable': false,},
            { "data": "date","name":"date"},
            { "data": "status","name":"status"},

        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {

                    return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {
                    return data+'/ '+row.start_time+' -  '+row.start_end;
                },
                "targets":-2,
            },
            {render: function (data, type, row, meta) {
                    if(row.symptoms && row.symptoms.length>0){
                        let symptoms=row.symptoms.map(function(v,i){
                            return '<span class="badge badge-info desc-info mb-1">'+v.name+'</span>';
                        }).join(' ');
                        return symptoms;
                    }
                    return 'N/A';
                },
                "targets":3,
                "className":"desc-info"
            },
            {render: function (data, type, row, meta) {
                //refer 0 = UPCOMMING,1=ONGOING, 2=COMPLETED, 3=CANCELLED
                var status = "Pending";var color = "badge-info";
                    if(data == 0){
                        var color = "badge-info";
                        var status = "UPCOMMING";
                    }else if(data == 1){
                        var color = "badge-primary";
                        var status = "ONGOING";
                    }else if(data == 2){
                        var color = "badge-success";
                        var status = "COMPLETED";
                    }else if(data == 3){
                        var color = "badge-danger";
                        var status = "CANCELLED";
                    }
                    return '<span class="badge '+color+' text-capitalize"><i class="fas fa-circle me-1"></i> '+status+'</span>';
                },
                "targets":-1,
            },
			// {render: function (data, type, row, meta) {
			// 		let label=[];
			// 		label['connected']='badge-success';
			// 		label['pending']='badge-danger';
            //         return '<span class="badge '+label[data.toLowerCase()]+'">'+data+'</span>';
            //     },
            //     "targets":2,
            // },
			// {render: function (data, type, row, meta) {
			// 		let link='';
            //        if(data.length){
			// 		   $.each(data,function(i,v){
			// 			   //link+='<a target="_blank" class="d-block text-primary mt-2" href="'+v.replay_url+'"><span class="d-flex align-items-center"><i class="feather-video me-2"></i> '+v.type+' '+((v.type=='Patient')?' <i class="fa fa-user"></i>':' <i class="fa-solid fa-user-doctor"></i>')+'</span></a> ';
			// 			   link+='<a target="_blank" class="d-block text-primary mt-2" href="'+v.replay_url+'"><span class="d-flex align-items-center"><i class="feather-video me-2"></i> '+v.type+'</span></a> ';
			// 		   });
			// 	   }
			// 	   return link;
            //         return data;
            //     },
            //     "targets":-1,
            // },

        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
        },
    });

});
</script>
@endpush
