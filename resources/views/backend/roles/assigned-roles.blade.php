@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

<style>
    .error-input {
        border: 1px solid red !important;
    }
    .error-message {
        color: red;
        font-size: 13px;
        margin-top: 4px;
    }
</style>

<div class="ds-breadcrumb">
    <h1>Assigned Roles</h1>
    <ul>
        <li><a href="{{ route('dashboard') }}">Dashboard</a> /</li>
        <li>Assigned Roles</li>
    </ul>
</div>

<div class="ds-pr-body">

    <div class="atndnc-filter-wrp w-100">
        <div class="sec-head">
            <h2>Filters</h2>
        </div>
        <div class="atndnc-filter student-filter">
            <form method="GET" action="">
                <div class="atndnc-filter-form">
                    <div class="atndnc-filter-options multi-input-grp grp-3">

                        {{-- SEARCH --}}
                        <div class="input-grp">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search Users">
                        </div>

                        {{-- ROLE FILTER --}}
                        <div class="input-grp">
                            <select name="role_id" id="roleId" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($data['roles'] as $role)
                                    <option value="{{ $role->id }}"
                                        {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- PANEL FILTER --}}
                        <div class="input-grp">
                            <select name="panel_id" id="panelId" class="form-control">
                                <option value="">Select Panel</option>
                                @foreach ($data['panels'] as $panel)
                                    <option value="{{ $panel->id }}"
                                        {{ request('panel_id') == $panel->id ? 'selected' : '' }}>
                                        {{ $panel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="d-flex gap-3 align-items-center">
                        <button type="submit" class="btn-search">Search</button>
                        @if(request('search') || request('role_id') || request('panel_id'))
                            <a href="{{ url()->current() }}" class="cmn-btn">Clear</a>
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="ds-cmn-table-wrp">

        <div class="ds-content-head has-drpdn">
            <div class="sec-head">
                <h2>View Assigned Roles</h2>
            </div>
            <div class="ds-cmn-filter-wrp">
                <button href="#url" class="cmn-btn btn-sm" data-bs-target="#addUserModal" data-bs-toggle="modal">
                    <i class="fa-solid fa-plus"></i> Add New User
                </button>
            </div>
        </div>

        <div class="ds-cmn-tble w1200">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Assigned Panels</th>
                        <th>Assigned Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data['users'] as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->name ?? '-' }}</td>
                            <td>
                                <p class="toggle-text-wrapper">
                                    {{ $user->role->panels->pluck('name')->implode(', ') ?: '-' }}
                                </p>
                            </td>
                            <td>
                                <button class="view-attachment-btn view-permissions" data-user="{{ $user->id }}">
                                    <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                </button>
                            </td>
                            <td>
                                <div class="actions-wrp">
                                    <button type="button" class="edit-btn" data-user="{{ $user->id }}">
                                        <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Icon">
                                    </button>
                                    <button type="button" class="delete-btn" data-user="{{ $user->id }}">
                                        <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Icon">
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- Add User Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="addUserModal"  tabindex="-1" role="dialog" aria-labelledby="createNewExamTypeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Add New User</h2>
                    <div class="request-leave-form-wrp">

                    <form id="addUserForm" action="" method="post" autocomplete="off">
                        @csrf

                        <div class="request-leave-form">

                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label>Full Name</label>
                                    <input type="text" name="name" placeholder="Full Name" autocomplete="off" required>
                                </div>
                                <div class="input-grp">
                                    <label>Email Id</label>
                                    <input type="email" name="email" id="email" placeholder="Email Id" autocomplete="off" required>
                                    <div class="error-message" data-error="email"></div>
                                </div>
                            </div>

                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label>Designation</label>
                                    <select name="designation_id" id="designation" class="form-control" autocomplete="off" required>
                                        <option value="" selected disabled hidden>Select Designation</option>
                                        @forelse ($data['designations'] as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @empty
                                            <option value="" disabled>No designation found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" placeholder="Password" autocomplete="new-password" required>
                                    <div class="error-message" data-error="password"></div>
                                </div>
                            </div>

                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password" required>
                                    <div class="error-message" data-error="password_confirmation"></div>
                                </div>
                            </div>

                            <div class="input-grp">
                                <label for="role_id">Role Selection</label>
                                <select name="role_id" id="role_id" class="form-control" autocomplete="off" required>
                                    <option value="" selected disabled hidden>Select Role</option>
                                    @forelse ($data['roles'] as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @empty
                                        <option value="" disabled>No roles found</option>
                                    @endforelse
                                </select>
                            </div>

                            <button type="submit" class="btn-sm">Save</button>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Add User Modal -->

<!-- Edit User Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="editUserModal"  tabindex="-1" role="dialog" aria-labelledby="createNewExamTypeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Edit User</h2>
                    <div class="request-leave-form-wrp">

                    <form id="editUserForm" action="" method="post" autocomplete="off">
                        @csrf
                        <input id="edit-user-id" type="hidden" name="user_id" />
                        <div class="request-leave-form">

                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label>Full Name</label>
                                    <input type="text" name="name" placeholder="Full Name" autocomplete="off" required>
                                    <div class="error-message" data-error="name"></div>
                                </div>
                                <div class="input-grp">
                                    <label>Email Id</label>
                                    <input type="email" name="email" id="edit-email" placeholder="Email Id" autocomplete="off" readonly>
                                    <div class="error-message" data-error="email"></div>
                                </div>
                            </div>

                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label>Designation</label>
                                    <select name="designation_id" id="edit-designation" class="form-control" autocomplete="off" required>
                                        <option value="" selected disabled hidden>Select Designation</option>
                                        @forelse ($data['designations'] as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @empty
                                            <option value="" disabled>No designation found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="input-grp">
                                <label for="role_id">Role Selection</label>
                                <select name="role_id" id="role_id" class="form-control" autocomplete="off" required>
                                    <option value="" selected disabled hidden>Select Role</option>
                                    @forelse ($data['roles'] as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @empty
                                        <option value="" disabled>No roles found</option>
                                    @endforelse
                                </select>
                            </div>

                            <button type="submit" class="btn-sm">Save</button>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Edit User Modal -->

<!-- Assigned Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="assignedPermissons" tabindex="-1" role="dialog" aria-labelledby="assignedPermissons" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Assigned Permissions</h2>
                    <div id="dynamicPermissionContainer" class="multi-tbl-wrp">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Assigned Modal -->

<!-- Delete Role Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Close">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp text-center">
                    <div class="modal-icon mb-3">
                        <img src="{{ global_asset('backend/assets/images/bin-primary.svg') }}" alt="Bin Icon">
                    </div>
                    <h2 class="mb-2">Delete!</h2>
                    <p class="mb-2">Are you sure you want to delete this user?</p>
                    <p class="mb-4">Note - this action cannot be undone and all the assignees access will get deleted.</p>

                    <form id="deleteUserForm">
                        @csrf
                        <input id="delete-user-id" type="hidden" name="user_id" />
                        <div class="btn-wrp d-flex justify-content-center gap-2">
                            <button type="button" class="cmn-btn delete-confirm-btn">Delete</button>
                            <button type="button" class="cmn-btn" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Delete Role Modal -->

@endsection

@push('script')

<script>
$(document).ready(function () {

    $('#addUserForm').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const btn  = form.find('button[type="submit"]');
        const originalBtnText = btn.text();

        // Reset previous errors
        form.find('.error-message').text('');
        form.find('input, select').removeClass('error-input');

        const email            = form.find('[name="email"]').val().trim();
        const password         = form.find('[name="password"]').val();
        const confirmPassword  = form.find('[name="password_confirmation"]').val();
        const emailPattern     = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;

        let valid = true;

        // Email validation
        if (!emailPattern.test(email)) {
            const emailField = form.find('[name="email"]');
            emailField.addClass('error-input');
            form.find('[data-error="email"]').text('Please enter a valid email address.');
            valid = false;
        }

        // Confirm password validation
        if (password !== confirmPassword) {
            const confirmField = form.find('[name="password_confirmation"]');
            confirmField.addClass('error-input');
            form.find('[data-error="password_confirmation"]').text('Passwords do not match.');
            valid = false;
        }

        if (!valid) return;

        btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('roles.user.create') }}",
            method: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    form[0].reset();
                    $('#addUserModal').modal('hide');
                    location.reload();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        const field = form.find('[name="' + key + '"]');
                        field.addClass('error-input');
                        form.find('[data-error="' + key + '"]').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
            complete: function () {
                btn.prop('disabled', false).text(originalBtnText);
            }
        });
    });

    // Real-time error clearing
    $('#addUserForm').on('input change', 'input, select', function () {
        $(this).removeClass('error-input');
        const key = $(this).attr('name');
        $(this).closest('form').find('[data-error="' + key + '"]').text('');
    });

});
</script>

<script>
$(document).on("click", ".view-permissions", function () {

    let userId = $(this).data("user");
    $('#assignedPermissons').modal('show');
    let container = $("#dynamicPermissionContainer");

    container.html(`<p style="text-align:center;width:100%;padding:20px;">Loading...</p>`);

    $.ajax({
        url: `/roles/user-permissions/${userId}`,
        method: "GET",
        success: function (res) {
            container.html(res.html);
        },
        error: function () {
            container.html("<p>Error fetching permissions</p>");
        }
    });
});
</script>

<script>
$(document).ready(function () {
    // Open Delete Modal
    $(document).on('click', '.delete-btn', function () {
        $('#delete-user-id').val($(this).data('user'));
        $('#deleteUserModal').modal('show');
    });

    // Submit Delete Form
    $(document).on('click', '#deleteUserForm .delete-confirm-btn', function (e) {
        e.preventDefault();

        const userId = $('#delete-user-id').val();

        if(!userId) {
            return;
        }
        
        const $btn = $(this);
        $btn.prop('disabled', true).text('Deleting...');

        const formData = $('#deleteUserForm').serialize();

        $.ajax({
            url: "{{ route('roles.user.delete') }}",
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.status) {
                    $('#deleteUserModal').modal('hide');
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert('Something went wrong.');
                }
            },
            error: function (err) {
                alert(err.responseJSON?.message || 'Error deleting user.');
            },
            complete: function () {
                $btn.prop('disabled', false).text('Delete');
            }
        });
    });
});
</script>

<script>
$(document).ready(function () {
    // Open Edit Modal
    $(document).on('click', '.edit-btn', function () {
        const userId = $(this).data('user');
        $('#edit-user-id').val(userId);

        // Reset old errors & fields
        $('#editUserForm')[0].reset();
        $('#editUserForm .error-message').text('');
        $('#editUserForm input, #editUserForm select').removeClass('error-input');

        // Fetch user data
        $.ajax({
            url: `/roles/show-user/${userId}`,
            method: "GET",
            success: function (response) {
                if (response.status === false) {
                    alert(response.message);
                    return;
                }

                const user = response.data ?? response;
                $('[name="name"]').val(user.name);
                $('[name="email"]').val(user.email);
                $('[name="designation_id"]').val(user.designation_id);
                $('[name="role_id"]').val(user.role_id);

                $('#editUserModal').modal('show');
            },
            error: function () {
                alert('Failed to fetch user details.');
            }
        });
    });

    // Submit Delete Form
    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const btn  = form.find('button[type="submit"]');
        const originalText = btn.text();

        // Clear previous errors
        form.find('.error-message').text('');
        form.find('input, select').removeClass('error-input');

        btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('roles.user.update') }}",
            method: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('#editUserModal').modal('hide');
                    location.reload();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {
                        const input = form.find('[name="' + key + '"]');
                        input.addClass('error-input');
                        form.find('[data-error="' + key + '"]').text(value[0]);
                    });

                } else {
                    alert('Update failed. Please try again.');
                }
            },
            complete: function () {
                btn.prop('disabled', false).text(originalText);
            }
        });
    });

    $('#editUserForm').on('input change', 'input, select', function () {
        const key = $(this).attr('name');
        $(this).removeClass('error-input');
        $(this).closest('form').find('[data-error="' + key + '"]').text('');
    });

    $('#addUserModal').on('hidden.bs.modal', function () {
        const form = $('#addUserForm');
        form[0].reset();

        form.find('.error-message').text('');
        form.find('input, select').removeClass('error-input');

        const btn = form.find('button[type="submit"]');
        btn.prop('disabled', false).text('Save');
    });

    $('#editUserModal').on('hidden.bs.modal', function () {
        const form = $('#editUserForm');

        form[0].reset();
        form.find('.error-message').text('');
        form.find('input, select').removeClass('error-input');

        const btn = form.find('button[type="submit"]');
        btn.prop('disabled', false).text('Save');
    });

});
</script>

@endpush