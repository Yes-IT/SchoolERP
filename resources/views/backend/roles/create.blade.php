@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')

<div class="ds-breadcrumb">
    <h1>Roles</h1>
    <ul>
        <li><a href="{{ route('dashboard') }}">Dashboard</a> /</li>
        <li>Roles</li>
    </ul>
</div>

<div class="ds-pr-body">
    <div class="ds-cmn-table-wrp">
        <div class="ds-content-head has-drpdn">
            <div class="sec-head">
                <h2>View Assigned Roles</h2>
            </div>
            <div class="ds-cmn-filter-wrp">
                <a href="{{ route('roles.assign-access') }}" class="cmn-btn btn-sm">Assign Role</a>
            </div>
        </div>

        <div class="create-role-form-wrp">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="create-role-form">
                    <div class="multi-input-grp">
                        <div class="input-grp">
                            <label>Role Name</label>
                            <input type="text" name="name" placeholder="Role Name" required>
                        </div>
                        <div class="input-grp">
                            <label>Description</label>
                            <input type="text" name="description" placeholder="Description" required>
                        </div>
                    </div>
                    <input type="submit" class="cmn-btn btn-sm" value="Create Role">
                </div>
            </form>
        </div>
    </div>

    @if(!empty($data['roles']) && count($data['roles']) > 0)

    <div class="ds-cmn-table-wrp existing-roles">
        <div class="ds-content-head sec-head">
            <h2>Existing Roles</h2>
        </div>

        <div class="existing-roles-wrp">

            @foreach ($data['roles'] as $role)
                <div class="existing-role gr-bg">
                    <div class="existing-role-left">
                        <div class="erl-content">
                            <h3>{{ $role->name ?? ''}}</h3>
                            <p>{{ $role->description ?? ''}}</p>
                        </div>
                        <div class="erl-timestamp cmn-tbl-btn primary-bg">{{ $role->created_at ? \Carbon\Carbon::parse($role->created_at)->format('Y-m-d') : '' }}</div>
                    </div>
                    <div class="existing-role-right">
                        <button type="button" class="cmn-btn btn-sm delete-btn" data-role-id="{{ $role->id }}">Delete</button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    @endif

</div>

<!-- Delete Role Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="deleteRoleModal" tabindex="-1" aria-hidden="true">
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
                    <p class="mb-2">Are you sure you want to delete this role?</p>
                    <p class="mb-4">Note - this action cannot be undone and all the assignees access will get blocked.</p>

                    <form id="deleteRoleForm">
                        @csrf
                        @method('DELETE')
                        <input id="delete-role-id" type="hidden" name="role_id" />
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
$(function () {
    // Open Delete Modal
    $(document).on('click', '.delete-btn', function () {
        $('#delete-role-id').val($(this).data('role-id'));
        $('#deleteRoleModal').modal('show');
    });

    // Submit Delete Form
    $(document).on('click', '#deleteRoleForm .delete-confirm-btn', function (e) {
        e.preventDefault();

        const roleId = $('#delete-role-id').val();
        const $btn = $(this);
        $btn.prop('disabled', true).text('Deleting...');

        const formData = $('#deleteRoleForm').serialize();

        $.ajax({
            url: `/roles/delete/${roleId}`,
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response[1] === 'success') {
                    $('#deleteRoleModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(response[0] || 'Something went wrong.');
                }
            },
            error: function (err) {
                alert(err.responseJSON?.message || 'Error deleting role.');
            },
            complete: function () {
                $btn.prop('disabled', false).text('Delete');
            }
        });
    });
});
</script>

@endpush
