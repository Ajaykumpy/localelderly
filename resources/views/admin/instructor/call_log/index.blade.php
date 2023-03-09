@extends('doctor.layouts.default')
@section('title','Admin - Call log')
@section('content')
<div class="content container-fluid">
    <div class="page-header mb-2">
		<div class="row align-items-center">
			<div class="col">
				<ul class="list-links">
				<li class="active"><a class="py-1" href="#">Completed</a></li>
				<li><a class="py-1" href="#">Pending</a></li>
				</ul>
			</div>
			<div class="col-auto">
				<div class="doc-badge me-3">Total Call Log <span class="ms-1 recordsTotal">0</span></div>
				<div class="bookingrange btn btn-white btn-sm d-none">
					<div class="cal-ico">
						<i class="feather-calendar mr-1"></i>
						<span>Select Date</span>
					</div>
					<div class="ico">
						<i class="fas fa-chevron-left"></i>
						<i class="fas fa-chevron-right"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Call Logs</h5>
                        </div>
                        <div class="col-auto d-flex">
                            <div class="form-custom me-2">
                                <div id="tableSearch" class="dataTables_wrapper"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                <div class="card-body card-filter flex-container farmer-filter px-0">
                    <form class="row gx-3 gy-2 align-items-center form-filter">
                            <div class="col-sm-4">
                                <div class="input-daterange input-group" data-date-format="dd M, yyyy"  data-date-autoclose="true"  data-provide="datepickers">
                                    <input type="text" class="form-control start_date" name="start" placeholder="To"/>
                                    <input type="text" class="form-control end_date" name="end" placeholder="From"/>
                                </div>
                            </div>
                            {{-- <div class="col-sm-2">
                                <select id="doctors" name="doctors" class="form-control select2">
                                        <option  value="">Select Doctor</option>
                                        @if($doctors)
                                        @foreach($doctors as $doctor)
                                            <option value="{!! $doctor->id !!}">{!! $doctor->name !!}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>--}}
                            <div class="col-sm-2">
                                <select id="users" name="users" class="form-control select2">
                                        <option  value="">Select Patient</option>
                                        @if($users)
                                        @foreach($users as $user)
                                            <option value="{!! $user->id !!}">{!! $user->name !!}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select id="status" name="status" class="form-control select2">
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Connected">Connected</option>
                                        <option value="Completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-rounded btn-danger filter-remove"><span class="btn-icon-start text-dangers"><i class="fa fa-filter color-danger"></i> </span>Clear</button>
                            </div>
                    </form>
                </div>
                    <div class="table-responsive">
                        <table class="datatables table table-borderless hover-table" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Call Id</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Type</th>                                    
                                    <th>Call By</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tablepagination" class="dataTables_wrapper"></div>
        </div>
    </div>


</div>
@stop
@push('styles')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script>
$(function(){
    $('input[name="start"],input[name="end"]').each(function() {
        $(this).datepicker({format:' yyyy-mm-dd',autoclose:true});
    });
	let status='Completed';
    let table=$('#table').DataTable({
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
		//"processing": true,
        //"serverSide": true,
        "ajax": {
            "url": "{{ url()->current() }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
				        $('.start_date').each(function(){
                            data['start_date'] =$(this).val();
                        });
                        $('.end_date').each(function(){
                            data['end_date'] =$(this).val();
                        });
                        $('.card-filter select').each(function(){
                            if($(this).val()){
                                 data[$(this).attr('name')]=$(this).val();
                            }
                        });
            },
        },
        "columns": [
            { "data": 'id',"name":'id','orderable': true, 'searchable': false,'width':'5%'},
            { "data": "meeting_id","name":"meeting_id",defaultContent:''},
            { "data": "status","name":"status",defaultContent:'NA'},
            { "data": "date","name":"date",defaultContent:''},
            { "data": "time","name":"time"},
            { "data": "call_type","name":"call_type"},            
            { "data": "type","name":"type"},
            { "data": "patient.name","name":"patient.name",defaultContent:''},
            { "data": "doctor.name","name":"doctor.name",defaultContent:'NA'},
            { "data": "action",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {
					return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {
                    return data;
                },
                "targets":1,
            },
            {render: function (data, type, row, meta) {      
                    if(data == '1'){//for appointment
                        return '<span class="badge badge-info">Appointment</span>';
                    }else if(data == '2'){// for sos
                        return '<span class="badge badge-info">SOS</span>';
                    }else{
                        return 'NA';
                    }    
                },
                "targets":-5,
            },
            {render: function (data, type, row, meta) {
					let status=[];status['pending']='danger',status['connected']='success',status['completed']='info';
                    if(data){
                        return '<span class="badge badge-'+status[data.toLowerCase()]+'">'+data+'</span>';
                    }
                    return data;
                },
                "targets":2,
            },
            {render: function (data, type, row, meta) {
                    if(data){
						let image=(row.patient && row.patient.image)?row.patient.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.patient && row.patient.gender)?row.patient.gender:'';
						let age=(row.patient && row.patient.age)?row.patient.age:'';
                        let profile='<span class="text-muted">';
                        if(gender){
                            profile+=gender;
                        }
                        if(age){
                            profile+=', '+age;
                        }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<a href="#"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
                        +'<a href="#"><span class="user-name">'+data+'</span> '+profile+'</a>'
                        +'</h2>';
                    }
                    return data;
                },
                "targets":-3,
            },
            {render: function (data, type, row, meta) {
                    if(data){
						let image=(row.doctor && row.doctor.profile && row.doctor.profile.image)?row.doctor.profile.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.doctor && row.doctor.profile && row.doctor.profile.gender)?row.doctor.profile.gender:'';
						let age=(row.doctor && row.doctor.profile && row.doctor.profile.age)?row.doctor.profile.age+' Year':'';
                        let profile='<span class="text-muted">';
                        if(gender){
                            profile+=gender;
                        }
                        if(age){
                            profile+=', '+age;
                        }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<a href="#"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
                        +'<a href="#"><span class="user-name">'+data+'</span> '+profile+'</a>'
                        +'</h2>';
                    }
                    return data;
                },
                "targets":-2,
            },
        ],
        //"aaSorting": [],
        "order": [[0, 'desc']],
        "initComplete": (settings, json) => {
			//console.log(json);
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
			$('.recordsTotal').empty().text(json.recordsTotal);
        },
		"drawCallback": function( settings ) {
			if(settings && settings.json && settings.json.recordsTotal){
				$('.recordsTotal').empty().text(settings.json.recordsTotal);
			}
		}
    });
	$('.list-links a').on('click',function(e){
		e.preventDefault();
		$('.list-links li').removeClass('active');
		$(this).parent().addClass('active');
		status=$(this).text();
		table.ajax.reload();

	});

    $('.filter-remove').on('click',function(e){
		e.preventDefault();
		$(".form-filter select").val("").trigger('change');
		$(".start_date").val('').trigger('change');
		$(".end_date").val('').trigger('change');
    });

    $('.card-filter select').on('change',function(){
        $(".datatables").DataTable().ajax.reload();
    });

      $('.start_date').on('change',function(){
        $(".datatables").DataTable().ajax.reload();
      });
      $('.end_date').on('change',function(){
        $(".datatables").DataTable().ajax.reload();
      });




    $('#doctors').select2({
        selectOnClose: true
    });
    $('#users').select2({
        selectOnClose: true
    });
    $('#status').select2({
        selectOnClose: true
    });

});
</script>
@endpush
