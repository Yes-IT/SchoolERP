@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')


 <div class="ds-breadcrumb">
                <h1>Exam Schedule</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li>Exam Schedule</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-cmn-info-cards-wrp">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Create Exam Types</h3>
                                        <p>Define and manage different types of exams for students.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="{{route('exam-schedule.createExamType')}}" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Exam Schedule</h3>
                                        <p>Maintain and update the complete exam timetable in the system.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="{{route('exam-schedule.createExamScheduleType')}}" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Room Availability</h3>
                                        <p>Track and manage available rooms to efficiently allocate spaces for scheduled exams.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="{{route('exam-schedule.roomAvailability')}}" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                  
            </div>

@endsection