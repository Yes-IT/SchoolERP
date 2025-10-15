@extends('student.Layout.app')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>Apply Leaves</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>Apply Leaves</li>
    </ul>
</div>
<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Leaves</h2>
            </div>
            <div class="ds-cmn-filter-wrp">
                <div class="dsbdy-filter-wrp p-0">
                    <button class="cmn-btn h-40" data-bs-target="#requestLeave" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> Request Leave
                    </button>

                    <form method="GET" action="{{ route('student.apply_leave') }}">
                        <div class="input-grp">
                            <select name="year" id="yearSelect" onchange="this.form.submit()">
                                <option value="">Select Year</option>
                                @foreach($yearOptions as $key => $label)
                                <option value="{{ $key }}" {{ request('year') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <form method="GET" action="{{ route('student.apply_leave') }}">
                        <input type="hidden" name="year" value="{{ request('year') }}">
                        <div class="input-grp">
                            <select name="semester" id="semesterSelect" onchange="this.form.submit()">
                                <option value="">Select Semester</option>
                                @foreach($semesteroptions as $key => $label)
                                <option value="{{ $key }}" {{ request('semester') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="ds-cmn-tble  w1200">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Apply Date</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Reason</th>
                        <th>
                            <div class="status-wrp">
                                Status
                                <div class="ibtn">
                                    <button type="button" class="ibtn-icon">
                                        <img src="{{asset('student/images/i-icon.svg')}}" alt="Icon">
                                    </button>
                                    <div class="ibtn-info lg rt p15">
                                        <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                            <img src="{{asset('student/images/fa-times.svg')}}" alt="icon">
                                        </button>
                                        <h3 class="txt-primary mb-2">Note:</h3>
                                        <p>Your leave will be reviewed by your Mechaneches.</p>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $key => $leave)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $leave->created_at->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d/m/Y') }}</td>
                        <td>
                            <div class="linecamped line-count-1" title="{{ $leave->reason }}">
                                {{ $leave->reason ?? 'N/A' }}
                            </div>
                        </td>

                        <td>
                            @if($leave->is_approved == 0)
                            <p class="yellow-bg cmn-tbl-btn">Pending</p>
                            @elseif($leave->is_approved == 1)
                            <p class="green-bg cmn-tbl-btn">Approved ({{ $leave->updated_at->format('d/m/Y') }})</p>
                            @else
                            <p class="cmn-tbl-btn red-bg  ">Rejected</p>
                            @endif
                        </td>
                        <td>
                            @if($leave->is_approved == 1)
                            -- {{-- Approved => no action --}}
                            @else
                            <div class="actions-wrp">
                                <button type="button" class="edit-leave-btn" data-id="{{ $leave->id }}" data-bs-toggle="modal" data-bs-target="#editLeaveRequest">
                                    <img src="{{asset('student/images/edit-icon-primary.svg')}}" alt="Icon">
                                </button>
                                <button type="button" class="delete-leave-btn" data-id="{{ $leave->id }}" data-bs-toggle="modal" data-bs-target="#deleteLeaveRequest">
                                    <img src="{{asset('student/images/bin-icon.svg')}}" alt="Icon">
                                </button>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No leave requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="tablepagination">
            <div class="tbl-pagination-inr">
                {{ $leaves->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>

            <div class="pages-select">
                <form method="GET" id="perPageForm">
                    <div class="formfield">
                        <label>Per page</label>
                        <select name="perPage" onchange="document.getElementById('perPageForm').submit()">
                            @foreach([1,2,3,4,5,10,15,20,25,50] as $size)
                            <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <p>
                    Showing {{ $leaves->firstItem() }} - {{ $leaves->lastItem() }}
                    of {{ $leaves->total() }} results
                </p>
            </div>
        </div>
    </div>
</div>
<!-- End Of Dashboard -->

<!-- Request Leave Modal Begin -->

<div class="modal fade cmn-popwrp pop800" id="requestLeave" tabindex="-1" role="dialog" aria-labelledby="requestLeave" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>
            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Request Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form action="{{route('student.apply_leave.store')}}" method="POST">
                            @csrf
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" name="from_date" required>
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" name="to_date" required>
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea name="reason" placeholder="Reason"></textarea>
                                </div>
                                <input type="submit" value="Submit" class="btn-sm">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

<!-- Edit Request Leave Modal Begin -->

<div class="modal fade cmn-popwrp pop800" id="editLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="editLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Edit Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form id="editLeaveForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" name="from_date" id="edit_from_date" required>
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" name="to_date" id="edit_to_date" required>
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea name="reason" id="edit_reason"></textarea>
                                </div>
                                <input type="submit" value="Update" class="btn-sm">
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- End Of Edit Request Leave Modal -->

<!-- Request of delete Leave Modal Begin -->

<div class="modal fade cmn-popwrp popwrp w400" id="deleteLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="deleteLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{asset('student/images/bin-primary.svg')}}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this Leave Request?</p>
                        <div class="btn-wrp">

                            <form id="deleteLeaveForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cmn-btn">Delete</button>
                            </form>
                            <button type="button" class="cmn-btn" data-bs-dismiss="modal">Cancel</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Of delete  Request Leave Modal -->

@endsection

@push('page_script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-leave-btn');
        const editForm = document.getElementById('editLeaveForm');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const leaveId = this.getAttribute('data-id');

                // Fetch leave data via AJAX
                fetch(`/student_apply_leave/${leaveId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_from_date').value = data.from_date;
                        document.getElementById('edit_to_date').value = data.to_date;
                        document.getElementById('edit_reason').value = data.reason;

                        // Update form action
                        editForm.action = `/student_apply_leave/${leaveId}`;
                    });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-leave-btn');
        const deleteForm = document.getElementById('deleteLeaveForm');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const leaveId = this.getAttribute('data-id');
                // Set form action dynamically
                deleteForm.action = `/student_apply_leave/${leaveId}`;
            });
        });
    });
</script>

<script>
    document.getElementById('yearSelect').addEventListener('change', function() {
        if (this.value === '') {
            window.location.href = "{{ route('student.apply_leave') }}";
        }
    });
</script>
<script>
    document.getElementById('semesterSelect').addEventListener('change', function() {
        if (this.value === '') {
            window.location.href = "{{ route('student.apply_leave') }}";
        }
    });
</script>

@endpush