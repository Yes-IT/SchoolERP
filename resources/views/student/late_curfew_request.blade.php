@extends('student.Layout.app')

@section('content')

<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>Late Curfew Request</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>Late Curfew Request</li>
    </ul>
</div>
<div class="ds-pr-body late-curfew-request-pg">

    <div class="atndnc-filter-wrp w-100">
        <div class="sec-head">
            <h2>Filters</h2>
        </div>
        <div class="atndnc-filter">
            <form>
                <div class="atndnc-filter-form">
                    <div class="multi-input-grp">
                            <div class="input-grp">
                            <select name="year" id="yearSelect">
                                <option value="">Select Year</option>
                                @foreach($yearOptions as $key => $label)
                                <option value="{{ $key }}" {{ request('year')==$key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-grp">
                            <input type="text" name="dates" value="" />
                        </div>
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="btn-search">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="ds-cmn-table-wrp tab-wrapper">
        <div class="ds-content-head">
            <div class="cmn-tab-head">
                <ul>
                    <li class="tab-bg"></li>
                    <li>Requested Late Curfew </li>
                    <li>Final Late Curfew</li>
                </ul>
            </div>
            <div class="ds-cmn-filter-wrp">
                <div class="dsbdy-filter-wrp p-0">
                    <button class="cmn-btn h-40" data-bs-target="#addRequest" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> Add Request
                    </button>
                </div>
            </div>
        </div>

        <div class="ds-cmn-tble count-row w1200">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requested as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        <td>{{ Auth::user()->name ?? 'N/A' }}</td> {{-- If student is logged in --}}
                        <td>{{ $item->room }}</td>
                        <td>
                            <div class="linecamped line-count-1" title="{{ $item->reason }}">{{ $item->reason ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <p class="yellow-bg cmn-tbl-btn">Pending</p>
                        </td>
                        <td>
                            <div class="actions-wrp">

                                <button type="button" class="edit-btn"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editRequest">
                                    <img src="{{ asset('student/images/edit-icon-primary.svg') }}" alt="Icon">
                                </button>

                                <button type="button" class="delete-btn" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#deleteRequest">
                                    <img src="{{ asset('student/images/bin-icon.svg') }}" alt="Icon">
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No pending requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    {{ $requested->links('vendor.pagination.custom') }}
                </div>
                <p>
                    Showing {{ $requested->firstItem() }} - {{ $requested->lastItem() }}
                    of {{ $requested->total() }} results
                </p>
            </div>
        </div>
        <div class="ds-cmn-tble count-row w1200">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($final as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        <td>{{ Auth::user()->name ?? 'N/A' }}</td>
                        <td>{{ $item->room }}</td>
                        <td>
                            <div class="linecamped line-count-1" title="{{ $item->reason }}">{{ $item->reason ?? 'N/A' }}</div>
                        </td>
                        <td>
                            @if($item->status === 'approved')
                            <p class="green-bg cmn-tbl-btn">Approved ({{ $item->updated_at->format('d/m/Y') }})</p>
                            @elseif($item->status === 'rejected')
                            <p class="red-bg cmn-tbl-btn">Rejected</p>
                            @endif
                        </td>
                        <td>
                            @if($item->status === 'approved')
                            <div class="actions-wrp">
                                <button type="button" class="edit-btn"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editRequest">
                                    <img src="{{ asset('student/images/edit-icon-primary.svg') }}" alt="Icon">
                                </button>



                                <button type="button" class="delete-btn" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#deleteRequest">
                                    <img src="{{ asset('student/images/bin-icon.svg') }}" alt="Icon">
                                </button>
                            </div>
                            @else
                            --
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No approved/rejected requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    {{ $final->links('vendor.pagination.custom') }}
                </div>
                <p>
                    Showing {{ $final->firstItem() }} - {{ $final->lastItem() }}
                    of {{ $final->total() }} results
                </p>
            </div>

        </div>

    </div>
</div>
<!-- Add Request  Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="addRequest" tabindex="-1" role="dialog" aria-labelledby="addRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Add Request</h2>
                    <div class="request-leave-form-wrp">
                        <form method="POST" action="{{ route('student.late_curfew.store') }}">
                            @csrf
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>Select Date *</label>
                                        <input type="date" name="date" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div class="input-grp">
                                        <label>Select Time *</label>
                                        <input type="time" name="time" placeholder="00:00 AM">
                                    </div>
                                </div>
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>Room *</label>
                                        <input type="number" name="room" placeholder="Select Room">
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

<!-- Edit Request Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="editRequest" tabindex="-1" role="dialog" aria-labelledby="editRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{ asset('student/images/cross-icon.svg') }}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Edit Request</h2>
                    <div class="request-leave-form-wrp">
                        <!-- Default action points to ID=0, will be replaced by JS -->
                        <!-- <form method="POST" action="{{ route('student.late_curfew.update', 0) }}" id="editRequestForm"> -->
                        <form method="POST" action="" id="editRequestForm" data-base-route="{{ route('student.late_curfew.update', 'ID_PLACEHOLDER') }}">

                            @csrf
                            @method('PUT')
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>Select Date *</label>
                                        <input type="date" name="date" id="edit_date" required>
                                    </div>
                                    <div class="input-grp">
                                        <label>Select Time *</label>
                                        <input type="time" name="time" id="edit_time" required>
                                    </div>
                                </div>
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>Room *</label>
                                        <input type="number" name="room" id="edit_room" required>
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea name="reason" id="edit_reason"></textarea>
                                </div>
                                <div class="btn-wrp justify-content-start">
                                    <button type="submit" class="cmn-btn btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Delete Request Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="deleteRequest" tabindex="-1" role="dialog" aria-labelledby="deleteRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{ asset('student/images/cross-icon.svg') }}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{ asset('student/images/bin-primary.svg') }}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this Late Entry Request?</p>
                        <form method="POST" action="" id="deleteRequestForm">

                            @csrf
                            @method('DELETE')
                            <div class="btn-wrp">
                                <button type="submit" class="cmn-btn">Delete</button>
                                <button type="button" class="cmn-btn" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>




@endsection

@push('page_script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const id = this.dataset.id;
                const form = document.getElementById('editRequestForm');

                try {
                    const res = await fetch(`/student_late_curfew_request/${id}/edit`);
                    const data = await res.json();

                    document.getElementById('edit_date').value = data.date;
                    document.getElementById('edit_time').value = data.time;
                    document.getElementById('edit_room').value = data.room;
                    document.getElementById('edit_reason').value = data.reason;

                    const baseRoute = form.dataset.baseRoute;
                    form.action = baseRoute.replace('ID_PLACEHOLDER', id);


                } catch (err) {
                    console.error("Error loading request data:", err);
                }
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('deleteRequestForm');
                form.action = `/student_late_curfew_request/${id}`;
            });
        });

    });
</script>
@endpush