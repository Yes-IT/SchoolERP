 <table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>High School</th>
            <th>Interview City</th>
            <th>Status</th>
            <th>Date of Deposit/Entry Date</th>
            <th>View</th>
            <th>Interview Details State</th>
            <th>Interview Status</th>
            <th>Interview Mode</th>
            <th>Interview Date</th>
            <th>Interview Time</th>
            <th>Interview Location</th>
            {{-- <th>Meeting Link</th> --}}
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
                <td>{{ $applicant->highSchool->hs_name ?? (!empty($applicant->high_school) ? 'Other (' . $applicant->high_school . ')' : 'N/A') }}</td>
                <td>{{ $applicant->interview_city ?? '-' }}</td>
                @php
                    $statusLabels = [
                        0 => 'Pending',
                        1 => 'Approved',
                        2 => 'Rejected',
                        3 => 'Accepted',
                        4 => 'Not Accepted',
                        5 => 'Priority Pending',
                    ];
                @endphp
                <td>
                    {{ $statusLabels[$applicant->processing->status ?? null] ?? '-' }}
                </td>
                <td>{{ optional($applicant->confirmation)->created_at ? optional($applicant->confirmation)->created_at->format('d/m/Y') : '-' }}</td>
                 <td>
                    <a href="{{ route('applicant.view_applicant_info', ['id' => $applicant->id]) }}" class="view-attachment-btn">
                        <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                    </a>
                </td>
                <td>
                    <div class="availability-toggle">
                        <div class="status-text">
                            <span class="unavailable {{ $applicant->processing->interview_state == 0 ? '' : 'inactive' }}">Suspend</span>

                            <label class="toggle-label">
                                <input 
                                    type="checkbox" 
                                    class="availability-switch toggle-interview-state"
                                    data-id="{{ $applicant->id }}"
                                    {{ $applicant->processing->interview_state == 1 ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>

                            <span class="available {{ $applicant->processing->interview_state == 1 ? '' : 'inactive' }}">Active</span>
                        </div>
                    </div>
                </td>


                <td>
                    <span class="cmn-tbl-btn {{ $statusClass }}">{{ $statusText }}</span>
                </td>
                <td>{{optional($applicant->processing)->interview_mode ?? '-' }}</td>
                <td>{{ optional($applicant->processing)->interview_date ? optional($applicant->processing)->interview_date->format('d/m/Y') : '-' }}</td>
                <td>{{ optional($applicant->processing)->interview_time ?? '-' }}</td>
                <td>{{ optional($applicant->processing)->interview_location ?? '-' }}</td>
                {{-- <td>{{ optional($applicant->processing)->interview_link ?? '-' }}</td> --}}
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