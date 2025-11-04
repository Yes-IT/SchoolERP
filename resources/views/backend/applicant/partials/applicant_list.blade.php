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
            <tr>
                <td>{{ $applicants->firstItem() + $index }}</td>
                <td>{{ $applicant->last_name }}</td>
                <td>{{ $applicant->first_name }}</td>
                 <td>
                    <a href="{{ route('applicant.view_applicant_info', ['id' => $applicant->id]) }}" class="view-attachment-btn">
                        <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                    </a>
                </td>
                
                <td><span class="cmn-tbl-btn yellow-bg">{{ optional($applicant->interview)->interview_status ?? '-' }}</span></td>
                <td>{{optional($applicant->interview)->interview_mode ?? '-' }}</td>
                <td>{{ optional($applicant->interview)->interview_date ? optional($applicant->interview)->interview_date->format('d/m/Y') : '-' }}</td>
                <td>{{ optional($applicant->interview)->interview_time ?? '-' }}</td>
                <td>{{ optional($applicant->interview)->interview_location ?? '-' }}</td>
                <td>{{ optional($applicant->interview)->interview_link ?? '-' }}</td>
                <td>
                   <a href="{{ route('applicant.schedule_interview', $applicant->id) }}" class="cmn-btn btn-sm"><img src="{{global_asset('backend/assets/images/calender-icon.svg')}}" alt="Image"> Schedule Interview</a>
                </td>
                <td><span class="cmn-tbl-btn yellow-bg">{{ $applicant->applicant_status ?? '-' }}</span></td>

                <td>
                    <div class="actions-wrp">
                        <button type="button" class="cmn-tbl-btn green-bg"><i class="fa-solid fa-check"></i> Approve</button>
                        <button type="button" class="cmn-tbl-btn red-bg"><i class="fa-solid fa-xmark"></i> Reject</button>
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