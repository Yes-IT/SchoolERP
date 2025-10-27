 <table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>High School</th>
            <th>High School (Application)</th>
            <th>City</th>
            <th>Birth Date</th>
            <th>Age</th>
            <th>USA Cell</th>
            <th>Email</th>
            <th>Father Title</th>
            <th>Father Name</th>
            <th>Mother Title</th>
            <th>Mother Name</th>
            <th>Maiden Name</th>
            <th>Address</th>
            <th>Current State</th>
            <th>Current Zipcode</th>
            <th>Current Country</th>
            <th>Marital Status</th>
            <th>Marital Comment</th>
            <th>Home Phone</th>
            <th>Father Cell</th>
            <th>Mother Cell</th>
            <th>Father Email</th>
            <th>Mother Email</th>
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
                <td>{{ $applicant->high_school }}</td>
                <td>{{ $applicant->highschool_application }}</td>
                <td>kolkata</td>
                <td>{{ $applicant->date_of_birth }}</td>
                <td>
                    @if($applicant->date_of_birth)
                        {{ \Carbon\Carbon::parse($applicant->date_of_birth)->age }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $applicant->usa_cell }}</td>
                <td>{{ $applicant->email }}</td>
                <td>
                    <a href="{{ route('applicant.edit_applicant', $applicant->id) }}" class="cmn-btn btn-sm">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="9">No Applicants Found</td></tr>
        @endforelse
        
    </tbody>
</table>

<div class="tablepagination">
    @include('backend.partials.pagination', ['paginator' => $applicants, 'routeName' => 'applicant.index'])
</div>