@extends('admin.layouts.default')
@section('title','Doctor')
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="tab-content pt-0">
                        <div role="tabpanel" id="doctors-profile" class="tab-pane fade show active">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 border-r">
                                    <div class="card">
                                        <div class="card-header app-head">
                                            <h5 class="card-title">{{$doctors->name}} </h5>
                                            <span class="con-time bg-primary" >{{($doctors->current_status->status)??'NA'}}</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img class="profile-doctors-img img-responsive rounded" src="{{($doctors->profile->image??'')?$doctors->profile->image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" width="115" height="115">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Mobile</h5>
                                                            <p>{{$doctors->mobile}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Email</h5>
                                                            <p>{{$doctors->email}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Gender</h5>
                                                            <p>{{$doctors->profile->gender??''}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Age</h5>
                                                            <p>{{$doctors->profile->age??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>City</h5>
                                                            <p>{{$doctors->profile->city??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Post Code</h5>
                                                            <p>{{$doctors->profile->postcode??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>State</h5>
                                                            <p>{{$doctors->profile->state??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Country</h5>
                                                            <p>{{$doctors->profile->country??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Year Of Experience</h5>
                                                            <p>{{$doctors->profile->yrs_of_exp??""}},{{$doctors->profile->experience_class??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Registration Number</h5>
                                                            <p>{{$doctors->profile->registration_number??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Registration Council</h5>
                                                            <p>{{$doctors->profile->registration_council??""}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Registration Year</h5>
                                                            <p>{{$doctors->profile->registration_year??""}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-lg-6 ">
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="card-header">
                                                <h5 class="card-title">Doctor Education Details</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Degree</h5>
                                                            <p>{{$doctors->education->name??''}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>College/ Institute</h5>
                                                            <p>{{$doctors->education->institute??''}}</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <h5>Years Of Completion</h5>
                                                            <p>{{$doctors->education->year??''}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="container-fluid d-flex">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Settings</h5>
                    </div>
                    <div class="card-body">
                    @if($doctors->ban == 0 && $doctors->status == 0)
                    <!-- this will be used when first time registered -->
                        <a href="{{url('admin/approve/doctor/document/'.$doctors->id)}}" class="btn btn-success btn-add">Approve Doctor</a>
                    @endif
                    @if($doctors->ban != 0 && $doctors->status != 0)
                    <!-- this will be use to make doctor active after being disable -->
                        <a href="{{url('admin/approve/doctor/'.$doctors->id)}}" class="btn btn-success btn-add mx-1" title="Approve doctor from here">Approve</a>
                    @elseif($doctors->ban == 0 && $doctors->status != 0)

                        @if($doctors->ban != 1)
                        <!-- this will be use to disable doctor  -->
                            <a href="{{url('admin/disable/doctor/'.$doctors->id)}}" class="btn btn-danger btn-add" title="Ban doctor from here">Disable</a>
                        @endif

                    @endif
                    @if($doctors->document_verified != 0)
                        @if($doctors->ban != 1)
                            @if($doctors->type == 'normal')
                            <!-- switch purpose -->
                                <a href="{{url('admin/switch/doctor/'.$doctors->id)}}" class="btn btn-info text-white" title="Switch to l2">Switch to L2</a>
                            @endif
                        @endif
                    @endif
                    </div>
                </div>
            </div>
            <!-- end of settings -->
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

    </script>
    @endpush
