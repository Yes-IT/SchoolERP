@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

<div class="ds-breadcrumb">
    <h1>Assign Access</h1>
    <ul>
        <li><a href="{{ route('dashboard') }}">Dashboard</a> /</li>
        <li>Assign Access</li>
    </ul>
</div>

<div class="ds-pr-body">
    
    <div class="ds-cmn-table-wrp">

        <div class="ds-content-head has-drpdn">
            <div class="sec-head">
                <h2>Assign Access</h2>
            </div>
            <div class="ds-cmn-filter-wrp">
                <a href="{{ route('roles.assigned-roles') }}" class="cmn-btn btn-sm">View Assigned Role</a>
            </div>
        </div>

        <div class="create-role-form-wrp">
            <form id="assignAccessForm">
                <div class="create-role-form">
                    <div class="multi-input-grp">
                        <div class="input-grp">
                            <label>Step 1: Select Role</label>
                            <select name="roleId" id="roleId" class="form-control" required>
                                <option value="" selected disabled hidden>Select Role</option>
                                @forelse ($data['roles'] as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @empty
                                    <option value="" disabled>No roles found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="input-grp">
                            <label>Step 2: Select Panel</label>

                            <div class="dropdown subject-dropdown">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-subject">
                                    <span class="label">Select Panel</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-subject">
                                    <label><input type="checkbox" name="panel_id[]" value="" disabled> Select Panel</label>
                                    @foreach($data['panels'] as $panel)
                                        <label><input type="checkbox" name="panel_id[]" value="{{ $panel->id }}">&nbsp;{{ $panel->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="ds-cmn-table-wrp">
        
        <div class="ds-content-head has-drpdn">
            <div class="sec-head">
                <h2>Configure Permissions</h2>
            </div>
            <div class="ds-cmn-filter-wrp">
                <div class="dsbdy-filter-wrp p-0">
                    <button id="btnClearSelection" class="cmn-btn btn-sm">Clear Selection</button>
                    <button id="btnSavePermissions" class="cmn-btn btn-sm">Save Permissions</button>
                </div>
            </div>
        </div>

        <div class="ds-cmn-tble w1200">
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Menu Name</th>
                        <th>Read</th>
                        <th>Add</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody id="assignModulePermission">
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No panels selected
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>
        
</div>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1800,
        timerProgressBar: true,
    });

    // Load modules when panel selection changes
    $('input[name="panel_id[]"]').on('change', function() {
        const selectedPanels = $('input[name="panel_id[]"]:checked')
            .map(function() { return $(this).val(); })
            .get();

        $.ajax({
            url: "{{ route('roles.modules-by-panels') }}",
            type: "POST",
            data: {
                panel_ids: selectedPanels,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#assignModulePermission').html(response.html);
            }
        });
    });

    // Clear all module selections
    $(document).on('click', '#btnClearSelection', function (e) {
        e.preventDefault();
        $('#assignModulePermission input[type="checkbox"]').prop('checked', false);
        $('.module-select').trigger('change');
    });

    // Toggle permission checkboxes when a module checkbox is clicked
    $(document).on("change", ".module-select[data-type='module']", function () {
        let row = $(this).closest("tr");
        let isChecked = $(this).is(":checked");
        let permCheckboxes = row.find(".module-select[data-type!='module']");

        permCheckboxes.prop("disabled", !isChecked);

        if (!isChecked) {
            permCheckboxes.prop("checked", false);
        }
    });

    // Permission auto-dependency logic
    $(document).on('change', '.module-select[data-type]', function () {
        const $this = $(this);
        const type = $this.data("type");
        const row = $this.closest("tr");

        const read   = row.find('.module-select[data-type="read"]');
        const create = row.find('.module-select[data-type="create"]');
        const update = row.find('.module-select[data-type="update"]');
        const del    = row.find('.module-select[data-type="delete"]');

        if (type === "update") {
            if ($this.is(':checked')) {
                read.prop('checked', true);
            }
        }

        if (type === "delete") {
            if ($this.is(':checked')) {
                read.prop('checked', true);
                create.prop('checked', true);
                update.prop('checked', true);
            } else {
                // create.prop('checked', false);
                // update.prop('checked', false);
            }
        }
        
        if (type === "read" && !$this.is(':checked')) {
            update.prop('checked', false);
            del.prop('checked', false);
        }
    });

    // Save Permissions
    $(document).on('click', '#btnSavePermissions', function (e) {
        e.preventDefault();

        const roleId = $('#roleId').val();
        const panelIds = $('input[name="panel_id[]"]:checked')
            .map(function () { return $(this).val(); })
            .get();

        if (!roleId) {
            Toast.fire({
                icon: 'warning',
                title: 'Select a role first'
            });
            return;
        }

        if (panelIds.length === 0) {
            Toast.fire({
                icon: 'warning',
                title: 'Select at least one panel'
            });
            return;
        }

        let permissions = {};
        let moduleIds = [];
        let validationFailed = false;

        $('#assignModulePermission .module-select[data-type="module"]:checked').each(function () {
            const $row = $(this).closest('tr');
            const moduleId = $(this).val();

            let read   = $row.find('.module-select[data-type="read"]:enabled').is(':checked');
            let create = $row.find('.module-select[data-type="create"]:enabled').is(':checked');
            let update = $row.find('.module-select[data-type="update"]:enabled').is(':checked');
            let del    = $row.find('.module-select[data-type="delete"]:enabled').is(':checked');

            if (!read && !create && !update && !del) {
                validationFailed = true;
                $row.css('background', '#ffe1e1');

                setTimeout(() => {
                    $row.css('transition', 'background 0.5s ease-in-out');
                    $row.css('background', '');
                }, 1200);
            }

            moduleIds.push(moduleId);
            permissions[moduleId] = {
                read:   read   ? $row.find('.module-select[data-type="read"]').val()   : null,
                create: create ? $row.find('.module-select[data-type="create"]').val() : null,
                update: update ? $row.find('.module-select[data-type="update"]').val() : null,
                delete: del    ? $row.find('.module-select[data-type="delete"]').val() : null,
            };
        });

        if (moduleIds.length === 0) {
            Toast.fire({
                icon: 'warning',
                title: 'Select at least one module'
            });
            return;
        }

        if (validationFailed) {
            Toast.fire({
                icon: 'error',
                title: 'Each module needs at least one permission'
            });
            return;
        }

        $.ajax({
            url: '/roles/save-permissions',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                role_id: roleId,
                panel_ids: panelIds,
                module_ids: moduleIds,
                permissions: permissions,
            },
            success: function () {
                Toast.fire({
                    icon: 'success',
                    title: 'Permissions saved successfully'
                });
                setTimeout(() => location.reload(), 800);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong'
                });
            }
        });
    });

});
</script>

@endpush
