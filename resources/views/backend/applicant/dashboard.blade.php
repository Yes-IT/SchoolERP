@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')


 <div class="ds-breadcrumb">
                <h1>Student Application Forms</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li>Student Application Forms</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-cmn-info-cards-wrp">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Student Application Forms</h3>
                                        <p>Easily manage student registrations and track application details online.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="{{route('applicant.student_application_form')}}" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Calendar</h3>
                                        <p>Plan and update school schedules, exams, and events in one place.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="{{route('applicant.schedule_interview')}}" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Application Form</h3>
                                        <p>Assign classrooms and organize resources for upcoming exams efficiently.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="{{route('applicant.application_form')}}" class="cmn-btn w-100 btn-sm">Create Form</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Parent Contract</h3>
                                        <p>Digitally manage parent agreements and keep communication transparent.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="{{route('applicant.parent_contract')}}" class="cmn-btn w-100 btn-sm">Create Contract</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                  
            </div>

@endsection