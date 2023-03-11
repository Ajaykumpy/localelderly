@extends('admin.layouts.default')
@section('title')
    Admin - Dashboard
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
                        <h4 class="card-title">Allot Internal Doctor</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-valide" action="{{ route('admin.appointments.update', $patientrequest->id) }}" method="Post"
                            enctype="multipart/form-data" >
                            {{-- class="form-valide" action="{{ route('admin.appoinments.update', $patientrequest->id) }}" method="Post"
                            enctype="multipart/form-data" --}}
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                    <label>Doctors <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" id="doctor_name" name="doctor_name">
                                            <option value="">--Select Doctor--</option>
                                                @if ($doctor->count() > 0)
                                                    @foreach ($doctor as $data)
                                                        <option value="{{ $data->id??''}}" {{ $patientrequest->doctor_type->id??'' == $data->id ? 'Selected' : '' }}>
                                                            {{$data->name}} - {{$data->specialist->name}}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    No Record Found
                                                @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('admin.appointments.index') }}" class="btn btn-danger">Cancel</a>
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
@push('scripts')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script>
    $(function(){


$('#doctor_nakme').on('change', function () {
    var idCountry = this.value;
    $("#doctor_name").html('');
    $.ajax({
        url: "{{ url()->current()}}",
        type: "POST",
        data: {
            doctor_name: idCountry,

            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function (result) {
            $('#doctor_name').html('<option value="">-- Select State --</option>');
            $.each(result.states, function (key, value) {
                $("#doctor_name").append('<option value="' + value.doctor.id + '">' + value.doctor.name + '</option>');
            });
            $('#city-dropdown').html('<option value="">-- Select City --</option>');
        }
    });
 });
});
</script>
@endpush
