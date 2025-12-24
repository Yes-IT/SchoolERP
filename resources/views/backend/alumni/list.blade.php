<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Name</th>
            <th>School Year</th>
            <th>Year Status</th>
            <th>Marital Status</th>
            <th>Date Married</th>
            <th>Current Address</th>
            <th>Current City</th>
            <th>Current State</th>
            <th>Current Zipcode</th>
            <th>Current Country</th>
            <th>Current Home Phone</th>
            <th>Cell Phone</th>
            <th>Email</th>
            <th>Student Last Name</th>
            <th>First Name</th>
            <th>Parents</th>
            <th>Parents Address</th>
            <th>Parents City</th>
            <th>Parents State</th>
            <th>Parents Zipcode</th>
            <th>Parents Country</th>
            <th>Parents Home Phone</th>
            <th>Updated Last Name</th>
            <th>Updated Title Name</th>
            <th>Husband Name</th>
            <th>Husband Title</th>
            <th>Updated Address</th>
            <th>Updated City</th>
            <th>Updated State</th>
            <th>Updated Zip Code</th>
            <th>Updated Country</th>
            <th>Updated Home Phone</th>
            <th>High School</th>
            <th>Birth Date</th>
            <th>Hold Transcript</th>
        </tr>
    </thead>
    <tbody>

        {{-- @dd($alumni) --}}

        @forelse ($alumni as $index => $student)
            <tr>
                <td>{{ $alumni->firstItem() + $index }}</td>
                <td>
                    <a href="{{ route('alumni_flow.alumni_list_info', $student->id) }}">
                        {{ $student->first_name . ' ' . $student->last_name }}
                    </a>
                </td>
                <td>{{ $student->school_year ?? '--' }}</td>
                <td>{{ $student->year_status_name ?? '--' }}</td>
                <td>{{ $student->marital_status ?? '--' }}</td>
                <td>{{ $student->date_married ?? '--' }}</td>
                <td>{{ $student->residance_address ?? '--' }}</td>
                <td>{{ $student->city ?? '--' }}</td>
                <td>{{ $student->state ?? '--' }}</td>
                <td>{{ $student->zip_code ?? '--' }}</td>
                <td>{{ $student->country ?? '--' }}</td>
                <td>{{ $student->mobile ?? '--' }}</td>
                <td>{{ $student->mobile ?? '--' }}</td>
                <td>{{ $student->email ?? '--' }}</td>
                <td>{{ $student->last_name ?? '--' }}</td>
                <td>{{ $student->first_name ?? '--' }}</td>

                <td>{{ $student->parent->father_name ?? '--' }}</td>
                <td>{{ $student->guardian_address ?? '--' }}</td>
                <td>{{ $student->parent->parents_city ?? '--' }}</td>
                <td>{{ $student->parent->parents_state ?? '--' }}</td>
                <td>{{ $student->parent->parents_zipcode ?? '--' }}</td>
                <td>{{ $student->parent->parents_country ?? '--' }}</td>
                <td>{{ $student->parent->guardian_home_phone ?? '--' }}</td>

                <td>{{ $student->updated_last_name ?? '--' }}</td>
                <td>{{ $student->updated_title_name ?? '--' }}</td>
                <td>{{ $student->husband_name ?? '--' }}</td>
                <td>{{ $student->husband_title ?? '--' }}</td>
                <td>{{ $student->updated_address ?? '--' }}</td>
                <td>{{ $student->updated_city ?? '--' }}</td>
                <td>{{ $student->updated_state ?? '--' }}</td>
                <td>{{ $student->updated_zip_code ?? '--' }}</td>
                <td>{{ $student->updated_country ?? '--' }}</td>
                <td>{{ $student->updated_home_phone ?? '--' }}</td>
                <td>{{ $student->high_school ?? '--' }}</td>
                <td>{{ $student->birth_date ?? '--' }}</td>
                <td>{{ $student->hold_transcript ?? '--' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="36">No alumni data available.</td>
            </tr>
        @endforelse
    </tbody>
</table>


<div class="tablepagination">
    @include('backend.partials.pagination', ['paginator' => $alumni, 'routeName' => 'alumni_flow.index'])
</div>
