<ul>
    <li class="menu-title"><span>Main</span></li>
    <li class="active">
        <a href="{{ route('admin.dashboard') }}"><i class="feather-grid"></i> <span>Dashboard</span></a>
    </li>
<li>
        <a href="{{ route('admin.prescription.create') }}"><i class="feather-calendar me-1"></i>
            <span>Prescription Form</span></a>
    </li>
    <li>
        <a href="{{ route('admin.appoinments.index') }}"><i class="feather-calendar me-1"></i>
            <span>Appointments</span></a>
    </li>
	<li>
        <a href="{{ route('admin.call_request.index') }}"><i class="feather-phone-call me-1"></i>
            <span>Emergency Call</span></a>
    </li>
	<li>
        <a href="{{route('admin.prescription.index')}}"><i class="feather-clipboard me-1"></i>
            <span>Prescription</span>
        </a>
    </li>

    <li><a href="#"><i class="feather-package"></i> <span>Package</span> <span class="menu-arrow"></span></a>
        <ul>
            <li>
                <a href="{{ route('admin.package.index') }}"><span>Package</span></a>
            </li>
            <li>
                <a href="{{ route('admin.package-activation.index') }}"><span>Package Activation</span></a>
            </li>
        </ul>
    </li>

     <li>
        <a href="#"><i class="feather-user-plus"></i> <span>Doctors</span><span class="menu-arrow"></span></a>
        <ul>
        <li>
        <a href="{{ route('admin.doctor.index') }}"><i class="feather-user-plus"></i> <span>Doctors</span></a>
        </li>
        <li>
        <a href="{{ route('admin.emergency_doctor.index') }}"><i class="feather-user-plus"></i> <span>Emergency Doctors</span></a>
         </li>
         <li>
            <a href="{{ route('admin.doctor-bankdetails.index') }}"><i class="feather-user-plus"></i> <span>Doctors Bank Details</span></a>
             </li>

        </ul>
    </li>
    <li>
        <a href="{{ route('admin.patient.index') }}"><i class="feather-users"></i> <span>Patients</span></a>
    </li>

    <li>
        <a href="{{ route('admin.doctor_feedback.index') }}"><i class="feather-users"></i> <span>Feedback</span></a>
    </li>
    <li>
        <a href="{{ route('admin.transaction.index') }}"><i class="feather-credit-card"></i> <span>Transactions</span></a>
    </li>

    <li>
        <a href=#><i class="feather-bar-chart"></i>
            <span>Reports</span><span class="menu-arrow"></span></i>
        </a>
        <ul>
            <li>
                <a href="{{ route('admin.prescription.index') }}">
                    <span>Prescription</span></a>
            </li>
            <li>
                <a href="{{ route('admin.symptoms.index') }}">
                    <span>Symptoms</span></a>
            </li>
            <li>
                <a href="{{ route('admin.question.index') }}">
                    <span>Question</span></a>
            </li>
        </ul>
    </li>

    <li>
        <a href="{{ route('admin.call_log.index') }}"><i class="feather-book-open"></i> <span>Call Log</span></a>
    </li>

    <li>
        <a href=#><i class="feather-settings"></i> <span>Settings</span><span class="menu-arrow"></span></i>
        </a>
        <ul>
            <li>
                <a href="{{ route('admin.general_setting.index') }}"><span>General</span></a>
            </li>
			<li>
                <a href="{{ route('admin.page.index') }}"><span>Pages</span></a>
            </li>
            <li>
                <a href="#"><span>Appointments</span></a>
            </li>
            <li>
                <a href="{{ route('admin.healthrecord.index') }}">
                    <span>Health Record</span></a>
            </li>
            <li>
                <a href="{{ route('admin.call_request.index') }}">
                    <span>Call Request</span></a>
            </li>
            <li>
                <a href="{{ route('admin.specialist.index') }}">
                    <span>Specialities</span></a>
            </li>
            <li>
                <a href="{{ route('admin.terms-and-conditions.index') }}"> <span>Terms &
                        Conditions</span></a>
            </li>
            <li>
                <a href="{{ route('admin.privacy-policy.index') }}"> <span>Privacy Policy</span></a>
            </li>
        </ul>
    </li>
</ul>
