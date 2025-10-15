@extends('backend.master')
@section('title')
{{ ___('common.School Management System | Teacher') }}
@endsection

@section('content')
    
    <div class="ds-breadcrumb">
        <h1>Room Management</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="./dashboard.html">Room Management</a> /</li>
            <li>Existing Rooms</li>
        </ul>
    </div>

    <div class="ds-pr-body dspr-body-outer">
        <div class="ds-cmn-table-wrp">

            <div class="ds-content-head">
                <div class="sec-head">
                    <h2>Existing Rooms</h2>
                </div>
                <div class="btn-wrp"> 
                    <a href="{{ route('room_management.room_availability') }}" class="cmn-btn btn-sm">Room Availability</a>
                    <button class="cmn-btn btn-sm" data-bs-target="#addRoomModal" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus"></i> Add New Room
                    </button>
                </div>
            </div>

            <div class="ds-cmn-info-cards-wrp ds-class-info-cards-wrp">
                <div class="row" id="room-list">
                    @foreach($rooms as $room)
                    <div class="col-lg-3" data-room-id="{{ $room->id }}">
                        <div class="ds-cmn-info-card" role="group" aria-label="Room {{ $room->room_no }} card">
                            <div class="ds-cmn-ic-head mb10">
                                <div class="ds-cmn-ic-head-left">
                                    <h3>{{ $room->room_no }}</h3>
                                    <span class="gray-txt">{{ $room->location }}</span>
                                </div>
                                <div class="actions-wrp">
                                    <span class="cmn-tbl-btn {{ $room->status ? 'green-bg' : 'red-bg' }}" role="status" aria-label="Status: {{ $room->status ? 'Active' : 'Inactive' }}">{{ $room->status ? 'Active' : 'Inactive' }}</span>
                                </div>
                            </div>
                            
                            <div class="ds-cmn-ic-body">
                                <div class="class">
                                    <div class="info-row">
                                        <span class="label">Type:</span>
                                        <span class="value clr-primary">Classroom</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="label">Capacity:</span>
                                        <span class="value clr-primary">{{ $room->capacity }}</span>
                                    </div>
                                    <div class="btn-wrp justify-content-start">
                                        <button type="button" class="cmn-btn btn-sm edit-btn" 
                                                data-bs-target="#editRoomModal" 
                                                data-bs-toggle="modal" 
                                                data-room-id="{{ $room->id }}" 
                                                data-room-no="{{ $room->room_no }}" 
                                                data-capacity="{{ $room->capacity }}" 
                                                data-location="{{ $room->location }}" 
                                                data-status="{{ $room->status ? 1 : 0 }}" 
                                                aria-label="Edit room">Edit</button>
                                        <button type="button" class="icon-btn delete-btn" 
                                                data-room-id="{{ $room->id }}" 
                                                data-bs-target="#deleteRoomModal" 
                                                data-bs-toggle="modal" 
                                                aria-label="Delete room">
                                            <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Icon">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

<!-- Add Room Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Add New Room</h2>
                    <div class="request-leave-form-wrp">
                        <form id="addRoomForm" method="post">
                            @csrf
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label for="room_no">Room No</label>
                                        <input type="text" id="room_no" name="room_no" value="{{ $nextRoomNo }}" readonly>
                                    </div>
                                    <div class="input-grp">
                                        <label for="capacity">Capacity</label>
                                        <input type="number" id="capacity" name="capacity" placeholder="20">
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label for="location">Floor/Location</label>
                                    <input type="text" id="location" name="location" placeholder="1st Floor">
                                </div>
                                <label for="">Status</label>
                                <input type="checkbox" id="status" name="status" value="1">
                                <br>
                                <input type="submit" value="Submit" class="btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Add Room Modal -->

<!-- Edit Room Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="editRoomModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Edit Room</h2>
                    <div class="request-leave-form-wrp">
                        <form id="editRoomForm" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="edit_room_id">
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label for="edit_room_no">Room No</label>
                                        <input type="text" id="edit_room_no" name="room_no" readonly>
                                    </div>
                                    <div class="input-grp">
                                        <label for="edit_capacity">Capacity</label>
                                        <input type="number" id="edit_capacity" name="capacity" placeholder="20">
                                    </div>
                                </div>
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label for="edit_location">Floor/Location</label>
                                        <input type="text" id="edit_location" name="location" placeholder="1st Floor">
                                    </div>
                                    <label for="">Status</label>
                                    <input type="checkbox" id="edit_status" name="status" value="1">
                                    <br>
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
<!-- End Of Edit Room Modal -->

<!-- Delete Room Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="deleteRoomModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoomModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{ global_asset('backend/assets/images/bin-primary.svg') }}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this room?</p>
                        <div class="btn-wrp">
                            <button type="button" class="cmn-btn delete-confirm-btn" data-room-id="">Delete</button>
                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Delete Room Modal -->

@endsection

@push('script')

<script>
    $(document).ready(function() {
        // Display session messages if present
        @if(Session::has('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('success') }}'
            });
        @endif

        @if(Session::has('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('error') }}'
            });
        @endif

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // Populate Edit Modal
        $(document).on('click', '.edit-btn', function() {
            let roomId = $(this).data('room-id');
            let roomNo = $(this).data('room-no');
            let capacity = $(this).data('capacity');
            let location = $(this).data('location');
            let status = $(this).data('status');

            $('#edit_room_id').val(roomId);
            $('#edit_room_no').val(roomNo);
            $('#edit_capacity').val(capacity);
            $('#edit_location').val(location);
            $('#edit_status').prop('checked', status == 1);
        });

        // Add Room
        $('#addRoomForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("room_management.store") }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        $('#addRoomModal').modal('hide');
                        $('#addRoomForm')[0].reset();
                        location.reload(); // Reload page to show new room
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors || { general: [xhr.responseJSON.message || 'An error occurred.'] };
                    for (let field in errors) {
                        Toast.fire({
                            icon: 'error',
                            title: errors[field][0]
                        });
                    }
                }
            });
        });

        // Update Room
        $('#editRoomForm').on('submit', function(e) {
            e.preventDefault();
            let roomId = $('#edit_room_id').val();
            $.ajax({
                url: '{{ route("room_management.update", ":id") }}'.replace(':id', roomId),
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        $('#editRoomModal').modal('hide');
                        updateRoom(response.room);
                        location.reload(); // Reload page to reflect changes
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors || { general: [xhr.responseJSON.message || 'An error occurred.'] };
                    for (let field in errors) {
                        Toast.fire({
                            icon: 'error',
                            title: errors[field][0]
                        });
                    }
                }
            });
        });

        // Delete Room - Set room ID
        $(document).on('click', '.delete-btn', function() {
            let roomId = $(this).data('room-id');
            $('.delete-confirm-btn').data('room-id', roomId);
            $('#deleteRoomModal').modal('show');
        });

        // Confirm Delete
        $('.delete-confirm-btn').on('click', function() {
            let roomId = $(this).data('room-id');
            $.ajax({
                url: '{{ route("room_management.destroy", ":id") }}'.replace(':id', roomId),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        $('#deleteRoomModal').modal('hide');
                        $(`div[data-room-id="${roomId}"]`).remove();
                        location.reload(); // Reload page to reflect deletion
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function(xhr) {
                    let message = xhr.responseJSON.message || 'An error occurred while deleting the room.';
                    Toast.fire({
                        icon: 'error',
                        title: message
                    });
                }
            });
        });

        function updateRoom(room) {
            let statusClass = room.status ? 'green-bg' : 'red-bg';
            let statusText = room.status ? 'Active' : 'Inactive';
            let roomCard = $(`div[data-room-id="${room.id}"]`);
            roomCard.find('h3').text(room.room_no);
            roomCard.find('.gray-txt').text(room.location);
            roomCard.find('.value.clr-primary').text(room.capacity);
            roomCard.find('.cmn-tbl-btn').removeClass('green-bg red-bg').addClass(statusClass).text(statusText);
            roomCard.find('.cmn-tbl-btn').attr('aria-label', `Status: ${statusText}`);
            roomCard.find('.edit-btn').data('room-no', room.room_no);
            roomCard.find('.edit-btn').data('capacity', room.capacity);
            roomCard.find('.edit-btn').data('location', room.location);
            roomCard.find('.edit-btn').data('status', room.status ? 1 : 0);
        }
    });
</script>

@endpush