@extends('staff.master')

@section('content')
<div class="ds-breadcrumb">
    <h1>Assignments</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard </a> /</li>
        <li><a href="{{route('staff.assignment.index')}}">Assignments </a> /</li>
        <li>Assignment Evaluation</li>
    </ul>
</div>
<div class="ds-pr-body">
    <div class="atndnc-filter-wrp w-100">
        <div class="sec-head">
            <h2>Summary</h2>
        </div>
        <div class="atndnc-filter">
            <form>
                <div class="atndnc-filter-form">
                    <div class="atndnc-filter-options headers-assignemnt">
                        <div class="header-divs">
                            <p class="summary-p"><img src="{{asset('staff/assets/images/notice.svg')}}" class="noticeCalender" /><span>Notice Date:</span>{{ $assignment->assigned_date->format('m/d/Y') }}</p>
                            <p class="summary-p"><Span>Subject:</Span> {{ $assignment->subject->name ?? 'N/A' }} </p>
                            <p class="summary-p"><span>Total Marks:</span>{{ $assignment->grade }}</p>
                        </div>
                        <div  class="header-div-second">
                            <p class="summary-p"><span>Assignment Title:</span> {{ $assignment->title }}</p>
                            <p class="summary-p"><span>Description:</span> {{ $assignment->description ?? 'No description' }}</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="ds-cmn-table-wrp tab-wrapper">
        <div class="ds-content-head">
            <div class="cmn-tab-head">
                <h2 class="assign-h2">Assignment Evaluation</h2>
            </div>

        </div>
        <div class="tab-content current-tab active">
            <div class="ds-cmn-tble pending count-table">
                    <form action="{{ route('staff.assignment.evaluateAssignmentSave', $assignment->id) }}" method="POST">
                     @csrf
                        <table class="evaluation-table">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Student Name</th>
                                    <th>Submitted on</th>
                                    <th>Submitted Document</th>
                                    <th>Weightage (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                {{-- <tr>
                                    <td>1</td>
                                    <td>Lorem ipsum dolor sit amet</td>
                                    <td>04/02/2025</td>
                                    <td><button class="view-btn">View</button></td>
                                    <td>20</td>
                                </tr>
                                <tr class="note-row">
                                    <td colspan="5"><textarea placeholder="Note"></textarea></td>
                                </tr> --}}
                                    
                                @foreach ($submissions as $index => $submission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $submission->student->first_name }} {{ $submission->student->last_name }}</td>

                                        <td>{{ $submission->submitted_at ? $submission->submitted_at->format('m/d/Y') : '-' }}</td>

                                        <td>
                                            @if ($submission->file_path)
                                                <a href="{{ asset('uploads/assignments/' . $submission->file_path) }}" target="_blank" class="view-btn">View</a>
                                            @else
                                                No File
                                            @endif
                                        </td>

                                        <td>
                                            <input type="number" name="grades[{{ $submission->id }}]" class="weight-input" min="0" max="100" placeholder="Marks" value="{{ $submission->grade }}">
                                        </td>
                                    </tr>

                                    <tr class="note-row">
                                        <td colspan="5">
                                            <textarea name="notes[{{ $submission->id }}]" placeholder="Note">{{ $submission->note }}</textarea>
                                        </td>
                                    </tr>
                                @endforeach


                
                            </tbody>
                        </table>

                                {{-- <div class="evaluation-footer">
                                    <label for="due-date">Evaluation Due Date*</label>
                                    <input type="date" id="due-date">
                                    <button class="save-btn">Save</button>
                                </div> --}}
                            <div class="form-submission btn-sm align-right">
                                <button type="submit" class="save-btn">Save </button>
                            </div>
                    </form>

            </div>
        </div>
    </div>

</div>
@endsection