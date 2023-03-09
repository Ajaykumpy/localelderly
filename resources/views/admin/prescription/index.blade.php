@extends('admin.layouts.default')
@section('title','Admin - Prescription')
@section('content')
<div class="content container-fluid">
    <div class="page-header d-none">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="doc-badge me-3">Total Prescription <span class="ms-1">48</span></div>
                <div class="SortBy">
                    <div class="selectBoxes order-by">
                        <p class="mb-0"><img src="{{ asset('assets/img/icon/sort.png') }}" class="me-2" alt="icon"> Order by </p>
                        <span class="down-icon"><i class="feather-chevron-down"></i></span>
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
            <h5 class="card-title">Prescription</h5>
            </div>
            <div class="col-auto custom-list d-flex">
            <div class="form-custom me-2">
            <div id="tableSearch" class="dataTables_wrapper"></div>
            </div>
            </div>
            </div>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
            <table class="datatables table table-borderless hover-table" id="table">
            <thead class="thead-light">
            <tr>
            <th>ID</th>
            <th>Patient</th>
            <!-- <th>Diagnosis</th> -->
            <th>Symptom</th>
            <th>Date</th>
            <th>Doctor</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
            </div>
            </div>
            </div>
            <div id="tablepagination" class="dataTables_wrapper"></div>
        </div>
    </div>
</div>
@push('styles')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function(){
    $('#table').DataTable({
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
            },
        },
        "columns": [
            { "data": 'prescription_id',"name":'prescription_id','orderable': false, 'searchable': false,'width':'5%'},
            { "data": "patient.name","name":"patient.name",defaultContent:''},
            // { "data": "diagnosis","name":"diagnosis"},
            { "data": "symptom","name":"symptom"},
            { "data": "date","name":"date"},
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
                    if(data){
						let image=(row.patient && row.patient.image)?row.patient.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.patient && row.patient.gender)?row.patient.gender:'';
					//	let age=(row.patient && row.patient.age)?row.patient.age:'';
                        let profile='<span class="text-muted">';
                        if(gender){
                            profile+=gender;
                        }
                        // if(age){
                        //     profile+=', '+age;
                        // }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<a href="{{route("admin.patient.index")}}/'+row.patient.id+'"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
                        +'<a href="{{route("admin.patient.index")}}/'+row.patient.id+'"><span class="user-name">'+data+'</span> '+profile+'</a>'
                        +'</h2>';
                    }
                    return data;
                },
                "targets":1,
            },
            {render: function (data, type, row, meta) {
                    if(data.length>0){
                        return data.map(function(v,i){
                            return '<span class="badge bg-info text-light">'+v.symptom+'</span>';
                        }).join(' ');
                    }
                    return data;
                },
                "targets":2,
                "className"
            },
			{render: function (data, type, row, meta) {
                    if(data){
						let image=(row.doctor && row.doctor.profile && row.doctor.profile.image)?row.doctor.profile.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.doctor && row.doctor.profile && row.doctor.profile.gender)?row.doctor.profile.gender:'';
					//	let age=(row.doctor && row.doctor.profile && row.doctor.profile.age)?row.doctor.profile.age+' ':'';
                        let profile='<span class="text-muted">';
                        if(gender){
                            profile+=gender;
                        }
                        // if(age){
                        //     profile+=', '+age;
                        // }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<a href="{{route("admin.doctor.index")}}/'+row.doctor.id+'"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
                        +'<a href="{{route("admin.doctor.index")}}/'+row.doctor.id+'"><span class="user-name">'+data+'</span> '+profile+'</a>'
                        +'</h2>';
                    }
                    return data;
                },
                "targets":-2,
            },
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
@stop
