<div class="ds-cmn-tble count-row tbl-5_4k">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>View Details</th>
                <th>Last Name</th>
                <th>Father Title</th>
                <th>Father Name</th>
                <th>Mother Title</th>
                <th>Mother Name</th>
                <th>Maiden Name</th>
                <th>Student's Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
                <th>Country</th>
                <th>Home Phone</th>
                <th>Father Call</th>
                <th>Mother Call</th>
                <th>Father Email</th>
                <th>Mother Email</th>
                <th>Father Hebrew Name</th>
                <th>Mother Hebrew Name</th>
                <th>Father Birth Date</th>
                <th>Mother Birth Date</th>
                <th>Father Occupation</th>
                <th>Mother Occupation</th>
                <th>Father Information</th>
                <th>Mother Information</th>
                <th>Marital Status</th>
                <th>Marital Comment</th>
                <th>Relative Name</th>
                <th>Relative Address</th>
                <th>Relative Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parents as $index => $parent)
                @php
                    // The $parent is an array containing both users and parent_guardians columns
                    $user = $parent;

                    // Fallback for student's name (if student relation not loaded)
                    $studentName = $user['student_name'] ?? 'N/A';

                    // Last Name - assuming it's part of the parent's name or from student
                    $lastName = $user['last_name'] ?? explode(' ', $user['name'] ?? '')[1] ?? 'N/A';
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                       
                         <a href="{{ route('parent_flow.parent_info', $user['id']) }}" class="view-attachment-btn">
                                    <img src="{{ asset('backend/assets/images/new_images/eye-white.svg') }}" alt="Eye Icon">
                        </a>
                    </td>
                    <td>{{ $lastName }}</td>
                    <td>{{ $user['father_title'] ?? 'N/A' }}</td>
                    <td>{{ $user['father_name'] ?? 'N/A' }}</td>
                    <td>{{ $user['mother_title'] ?? 'N/A' }}</td>
                    <td>{{ $user['mother_name'] ?? 'N/A' }}</td>
                    <td>{{ $user['maiden_name'] ?? 'N/A' }}</td>
                    <td>{{ $studentName }}</td>
                    <td>{{ $user['guardian_address'] ?? $user['address'] ?? 'N/A' }}</td>
                    <td>{{ $user['city'] ?? 'N/A' }}</td>
                    <td>{{ $user['state'] ?? 'N/A' }}</td>
                    <td>{{ $user['zip_code'] ?? 'N/A' }}</td>
                    <td>{{ $user['country'] ?? 'N/A' }}</td>
                    <td>{{ $user['guardian_home_phone'] ?? 'N/A' }}</td>
                    <td>{{ $user['father_mobile'] ?? 'N/A' }}</td>
                    <td>{{ $user['mother_mobile'] ?? 'N/A' }}</td>
                    <td>{{ $user['father_email'] ?? 'N/A' }}</td>
                    <td>{{ $user['mother_email'] ?? 'N/A' }}</td>
                    <td>{{ $user['father_hebrew_name'] ?? 'N/A' }}</td>
                    <td>{{ $user['mother_hebrew_name'] ?? 'N/A' }}</td>
                    <td>{{ $user['father_dob'] ?? 'N/A' }}</td>
                    <td>{{ $user['mother_dob'] ?? 'N/A' }}</td>
                    <td>{{ $user['father_profession'] ?? 'N/A' }}</td>
                    <td>{{ $user['mother_profession'] ?? 'N/A' }}</td>
                    <td>{{ $user['father_image'] ? 'Has Image' : 'No Image' ?? 'N/A' }}</td>
                    <td>{{ $user['mother_image'] ? 'Has Image' : 'No Image' ?? 'N/A' }}</td>
                    <td>{{ $user['marital_status'] ?? 'N/A' }}</td>
                    <td>{{ $user['marital_comment'] ?? 'N/A' }}</td>
                    <td>{{ $user['guardian_name'] ?? 'N/A' }}</td>
                    <td>{{ $user['guardian_address'] ?? 'N/A' }}</td>
                    <td>{{ $user['guardian_mobile'] ?? $user['guardian_home_phone'] ?? 'N/A' }}</td>
                    <td>
                        <div class="actions-wrp">
                            <button type="button">
                                <a href="{{ route('parent_flow.parent.edit', $user->id) }}"><img src="{{ asset('backend/assets/images/new_images/edit-icon-primary.svg') }}" alt="Edit"></a> 
                            </button>
                            <!-- Add delete or other actions if needed -->
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="33" class="text-center">No parents/guardians found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($parents->hasPages())
<div class="tablepagination">
    @include('backend.partials.pagination', ['paginator' => $parents, 'routeName' => 'parent_flow.index'])
</div>
@endif