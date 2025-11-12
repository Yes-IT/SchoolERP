 <table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>View</th>
            <th>Interview Status</th>
            <th>Interview Mode</th>
            <th>Interview Date</th>
            <th>Interview Time</th>
            <th>Interview Location</th>
            <th>Meeting Link</th>
            <th>Interview Action</th>
            <th>Applicant Status</th>
            <th>Applicant Action</th>
        </tr>
    </thead>
    <tbody>
       @forelse ($applicants as $index => $applicant) 
         @php
                        $interviewStatus = optional($applicant->processing)->interview_status;
                        $statusClass = 'yellow-bg'; // Default for pending/0
                        $statusText = '-';
                        $interviewButtonText = 'Schedule Interview';
                        
                        if ($interviewStatus == 1) {
                            $statusClass = 'green-bg'; // Scheduled
                            $statusText = 'Scheduled';
                            $interviewButtonText = 'Reschedule Interview';
                        } elseif ($interviewStatus == 2) {
                            $statusClass = 'red-bg'; // rescheduled or other status
                            $statusText = 'Rescheduled';
                            $interviewButtonText = 'View Details';
                        } elseif ($interviewStatus == 3) {
                            $statusClass = 'blue-bg';  
                            $statusText = 'Cancelled';
                            $interviewButtonText = 'Schedule Interview';
                        } elseif ($interviewStatus == 0) {
                            $statusText = 'Pending';
                            $interviewButtonText = 'Schedule Interview';
                        }else {
                            // If no processing record exists, show as pending
                            $statusClass = 'yellow-bg';
                            $statusText = 'Pending';
                            $interviewButtonText = 'Schedule Interview';
                        }
                        
                       
                    @endphp
            <tr>
                <td>{{ $applicants->firstItem() + $index }}</td>
                <td>{{ $applicant->last_name }}</td>
                <td>{{ $applicant->first_name }}</td>
                 <td>
                    <a href="{{ route('applicant.view_applicant_info', ['id' => $applicant->id]) }}" class="view-attachment-btn">
                        <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                    </a>
                </td>
                
                {{-- <td><span class="cmn-tbl-btn yellow-bg">{{ optional($applicant->interview)->interview_status ?? '-' }}</span></td> --}}
                <td>
                    <span class="cmn-tbl-btn {{ $statusClass }}">{{ $statusText }}</span>
                </td>

                <td>{{optional($applicant->processing)->interview_mode ?? '-' }}</td>
                <td>{{ optional($applicant->processing)->interview_date ? optional($applicant->processing)->interview_date->format('d/m/Y') : '-' }}</td>
                <td>{{ optional($applicant->processing)->interview_time ?? '-' }}</td>
                <td>{{ optional($applicant->processing)->interview_location ?? '-' }}</td>
                <td>{{ optional($applicant->processing)->interview_link ?? '-' }}</td>
                {{-- <td>
                   <a href="{{ route('applicant.schedule_interview', $applicant->id) }}" class="cmn-btn btn-sm"><img src="{{global_asset('backend/assets/images/calender-icon.svg')}}" alt="Image"> Schedule Interview</a>
                </td> --}}

                 <!-- Interview Action -->
                {{-- <td>
                   <a href="{{ route('applicant.schedule_interview', $applicant->id) }}"  class="cmn-btn btn-sm" >
                       <img src="{{ global_asset('backend/assets/images/calender-icon.svg') }}" alt="Image"> 
                       {{ $interviewButtonText }}
                   </a>
                </td> --}}
                <!-- Interview Action -->
                <td>
                    @if(in_array($interviewStatus, [0, 1, 2])) {{-- Pending, Scheduled, or Rescheduled --}}
                        @if($interviewStatus == 0) {{-- Pending --}}
                            <a href="{{ route('applicant.schedule_interview', $applicant->id) }}" class="cmn-btn btn-sm single-centered-btn">
                                <img src="{{ global_asset('backend/assets/images/calender-icon.svg') }}" alt="Image"> 
                                Schedule Interview
                            </a>
                        @else {{-- Scheduled (1) or Rescheduled (2) --}}
                            <a href="{{ route('applicant.reschedule_interview', $applicant->id) }}" class="cmn-btn btn-sm single-centered-btn">
                                <img src="{{ global_asset('backend/assets/images/calender-icon.svg') }}" alt="Image"> 
                                Reschedule Interview
                            </a>
                        @endif
                    @elseif($interviewStatus == 3) {{-- Completed --}}
                        <button class="cmn-btn btn-sm gray-bg" disabled>
                            <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="View Icon"> 
                            Completed
                        </button>
                    @else
                        <a href="{{ route('applicant.schedule_interview', $applicant->id) }}" class="cmn-btn btn-sm">
                            <img src="{{ global_asset('backend/assets/images/calender-icon.svg') }}" alt="Image"> 
                            Schedule Interview
                        </a>
                    @endif
                </td>

                {{-- <td><span class="cmn-tbl-btn yellow-bg">{{ $applicant->applicant_status ?? '-' }}</span></td> --}}
                <td>
                    @php
                        $applicantStatus = $applicant->applicant_status?->value ?? '-';
                        $applicantStatusClass = 'yellow-bg';
                        $displayText = ucfirst($applicantStatus);

                        if ($applicantStatus === 'accept') {
                            $applicantStatusClass = 'green-bg';
                            $displayText = 'Approved';
                        } elseif ($applicantStatus === 'not_accepted') {
                            $applicantStatusClass = 'red-bg';
                            $displayText = 'Rejected';
                        } elseif ($applicantStatus === 'pending') {
                            $applicantStatusClass = 'yellow-bg';
                            $displayText = 'Pending';
                        }
                    @endphp

                    <span class="cmn-tbl-btn {{ $applicantStatusClass }}">
                        {{ $displayText }}
                    </span>

                </td>

                <td>
                    <div class="actions-wrp">
                        @if ($applicantStatus === 'accept' || $applicantStatus === 'not_accepted')
                            {{-- If status is already approved or rejected, show greyed-out buttons --}}
                            <button type="button"
                                class="cmn-tbl-btn gray-bg"
                                disabled>
                                <i class="fa-solid fa-check"></i> Approve
                            </button>

                            <button type="button"
                                class="cmn-tbl-btn gray-bg"
                                disabled>
                                <i class="fa-solid fa-xmark"></i> Reject
                            </button>
                        @else
                            {{-- Active buttons when pending --}}
                            <button type="button"
                                class="cmn-tbl-btn green-bg applicant-action-btn"
                                data-id="{{ $applicant->id }}"
                                data-action="approved">
                                <i class="fa-solid fa-check"></i> Approve
                            </button>

                            <button type="button"
                                class="cmn-tbl-btn red-bg applicant-action-btn"
                                data-id="{{ $applicant->id }}"
                                data-action="rejected">
                                <i class="fa-solid fa-xmark"></i> Reject
                            </button>
                        @endif
                    </div>
                </td>

            </tr>
            @empty
            <tr><td colspan="9">No Applicants Found</td></tr>
        @endforelse
        
    </tbody>
</table>

<div class="tablepagination">
    @include('backend.partials.pagination', ['paginator' => $applicants, 'routeName' => 'applicant.student_application_form'])
</div>