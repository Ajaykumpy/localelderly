@extends('admin.layouts.default')
@section('title')
    Admin - Prescription
@endsection
@section('head')
    <!-- link here -->
@endsection
@section('content')
    <div class="main-wrapper">


        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Prescription</h4>
                </div>
                <div class="card-body">
                <form class="form-valide" action="{{ route('admin.prescription.store') }}" method="Post"
                    enctype="multipart/form-data">
                    @csrf
  <div class="row">
                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3  form-group">
                        <label>Diagnosis<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="diagnosis" name="diagnosis" required>
                        </div>
                    </div>
                    <div class=" col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                        <label>Weight<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="weight" name="weight" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                        <label>Patient Id<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="patient_id" name="patient_id" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                        <label>Symptom<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="symptom" name="symptom" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                        <label>Date<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="date" name="date" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6 col-xxl-6 mb-3 form-group">
                        <label>Description<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                    </div>
            </div>
        </div>

    </div>
    <div class="text-end">
        <a href="{{ route('admin.general_setting.appointment') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>
    </div>


    </div>
    </div>
@stop
