@extends('doctor.layouts.default')
@section('title')
    Doctor -
@endsection
@section('head')
    <!-- link here -->
@endsection
@section('content')
    <!-- content -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Appoinments</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Appoinments</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-valide" action="{{ route('doctor.appoinment.update', $patientrequest->id) }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                    <label>Doctor<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="doctor_id" name="doctor_id"
                                            value="{{ $patientrequest->doctor_id }}">
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="status">
                                            <option value="0" {{ $doctors->status == 0 ? 'Selected' : '' }}>Disable
                                            </option>
                                            <option value="1" {{ $doctors->status == 1 ? 'Selected' : '' }}>Enable
                                            </option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="text-end">
                                <a href="{{ route('doctor.appoinment.index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Patient Booking Details</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-valide" action="{{ route('admin.appointments.update', $patientrequest->id) }}" method="Post"
                            enctype="multipart/form-data" >
                            {{-- class="form-valide" action="{{ route('admin.appoinments.update', $patientrequest->id) }}" method="Post"
                            enctype="multipart/form-data" --}}
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                    <label>Patient Booked Slot<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="registration_council" name="registration_council" value="{{$patientrequest->date??""}}/{{$patientrequest->start_time??""}} - {{$patientrequest->start_end??""}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3 col-xxl-6 mb-3 form-group">
                                    <label>Comment<span class="text-danger">*</span></label>
                                    <textarea readonly rows="10" cols="100" >
                                        {{$patientrequest->comment??""}}
                                      </textarea>
                                    {{-- <p>{{$patientrequest->comment??""}}</p> --}}
                                    {{-- <div class="input-group">
                                        <input type="text-box" class="form-control" id="registration_council" name="registration_council" value="{{$patientrequest->comment??""}}" readonly>
                                    </div> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <!-- script -->
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script>
        jQuery(".form-valide").validate({
            rules: {
                "name": {
                    : !0,
                    minlength: 3
                },
            },
            messages: {
                "name": {
                    : "Please enter a speciality",
                    minlength: "Your benefit must consist of at least 3 characters"
                },
            },
            ignore: [],
            errorClass: "invalid-feedback animated fadeInUp",
            errorElement: "div",
            errorPlacement: function(e, a) {
                jQuery(a).parents(".form-group > div").append(e)
            },
            highlight: function(e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
            },
            success: function(e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
            },
        });
    </script>
@stop
