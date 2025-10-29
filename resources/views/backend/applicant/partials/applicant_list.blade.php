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
                <td><span class="cmn-tbl-btn yellow-bg">Pending</span></td>
                <td>Online</td>
                <td>12/12/2022</td>
                <td>10:00 AM</td>
                <td>Zoom</td>
                <td>https://zoom.us/</td>
                <td>
                   <a href="#url" class="cmn-btn btn-sm"><img src="{{global_asset('backend/assets/images/calender-icon.svg')}}" alt="Image"> Reschedule Interview</a>
                </td>
                <td><span class="cmn-tbl-btn yellow-bg">Pending</span></td>
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