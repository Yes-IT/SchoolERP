@extends('staff.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@push('styles')
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
@endpush

@section('content')
    
<div class="ds-breadcrumb">
    <h1>Apply Leaves</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
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
                    <button class="cmn-btn h-40" data-bs-target="#requestLeave" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus"></i> Request Leave
                    </button>
                </div>
            </div>
        </div>

        <div id="leaveListContainer">
            {{-- Load leave list here --}}
        </div>

    </div>
        
</div>

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="requestLeave" tabindex="-1" role="dialog" aria-labelledby="requestLeave" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ asset('staff/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Request Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form id="requestLeaveForm">
                            @csrf
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" name="from_date" placeholder="DD-MM-YYYY" required>
                                        <div class="error-message" data-error="from_date"></div>
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" name="to_date" placeholder="DD-MM-YYYY" required>
                                        <div class="error-message" data-error="to_date"></div>
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea name="reason" placeholder="Reason" required></textarea>
                                    <div class="error-message" data-error="reason"></div>
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

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="editLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="editLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ asset('staff/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Edit Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form id="editLeaveForm">
                            @csrf
                            <input type="hidden" id="edit-leave-id" name="leave_id">
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" name="from_date" placeholder="DD-MM-YYYY" required>
                                        <div class="error-message" data-error="from_date"></div>
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" name="to_date" placeholder="DD-MM-YYYY" required>
                                        <div class="error-message" data-error="to_date"></div>
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea name="reason" placeholder="Reason" required></textarea>
                                    <div class="error-message" data-error="reason"></div>
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

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="deleteLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="deleteLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ asset('staff/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{ asset('staff/assets/images/bin-primary.svg') }}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this Leave Request?</p>
                        <form id="deleteLeaveForm">
                            @csrf
                            <input type="hidden" id="delete-leave-id" name="leave_id">
                            <div class="btn-wrp">
                                <button type="submit" class="cmn-btn">Delete</button>
                                <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

@endsection

@push('script')
<script>
$(document).ready(function () {
    const $leaveListContainer = $('#leaveListContainer');
    const $perPageSelect = $('#perPageSelect');

    let currentPageUrl = null;
    let currentPerPage = $perPageSelect.val() || 10;

    function refreshLeaveList(pageUrl = null, perPage = null) {
        if (perPage) currentPerPage = perPage;
        if (pageUrl) currentPageUrl = pageUrl;

        const url = new URL(pageUrl || currentPageUrl || "{{ route('staff.apply-leave.index') }}", window.location.origin);
        url.searchParams.set('per_page', currentPerPage);

        $.get(url.toString())
            .done(function (response) {
                $leaveListContainer.html(response.html);
            })
            .fail(function () {
                showError('Failed to load leave requests. Please try again.');
            });
    }

    // Pagination & Per Page Change
    $(document).on('change', '#perPageSelect', function () {
        refreshLeaveList(null, $(this).val());
    });

    $(document).on('click', '.tablepagination a', function (e) {
        e.preventDefault();
        refreshLeaveList($(this).attr('href'));
    });

    function resetForm($form, resetValues = true) {
        if (resetValues) {
            $form[0].reset();
        }
        $form.find('.error-message').text('');
        $form.find('.error-input').removeClass('error-input');
    }

    function showValidationErrors($form, errors) {
        $.each(errors, function (field, messages) {
            const $input = $form.find(`[name="${field}"]`);
            $input.addClass('error-input');
            $form.find(`[data-error="${field}"]`).text(messages[0]);
        });
    }

    // Submit Leave Request
    $('#requestLeaveForm').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $btn = $form.find('input[type="submit"]');
        const originalText = $btn.val();

        resetForm($form, false);
        $btn.prop('disabled', true).val('Submitting...');

        $.ajax({
            url: "{{ route('staff.apply-leave.apply') }}",
            method: "POST",
            data: $form.serialize(),
            success: function ( response ) {
                if (response.status) {
                    $('#requestLeave').modal('hide');
                    resetForm($form);
                    showSuccess('Leave request submitted successfully.');
                    refreshLeaveList();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showValidationErrors($form, xhr.responseJSON.errors);
                } else {
                    showError(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                }
            },
            complete: function () {
                $btn.prop('disabled', false).val(originalText);
            }
        });
    });

    // Edit Leave Request
    $(document).on('click', '.edit-btn', function () {
        const leaveId = $(this).data('leave');
        const $form = $('#editLeaveForm');
        const $modal = $('#editLeaveRequest');

        $('#edit-leave-id').val(leaveId);
        resetForm($form, true);

        $.get("{{ url('staff/apply-leave/get-leave') }}/" + leaveId)
            .done(function (response) {
                if (!response.status && response.message) {
                    showError(response.message);
                    return;
                }

                const leave = response.data || response;
                $form.find('[name="from_date"]').val(leave.from_date);
                $form.find('[name="to_date"]').val(leave.to_date);
                $form.find('[name="reason"]').val(leave.reason);

                $modal.modal('show');
            })
            .fail(function () {
                showError('Failed to fetch leave details.');
            });
    });

    $('#editLeaveForm').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const leaveId = $('#edit-leave-id').val();
        if (!leaveId) return showError('Invalid leave request.');

        const $btn = $form.find('input[type="submit"]');
        const originalText = $btn.val();

        resetForm($form, false);
        $btn.prop('disabled', true).val('Saving...');

        $.ajax({
            url: "{{ url('staff/apply-leave/update') }}/" + leaveId,
            method: "PUT",
            data: $form.serialize() + "&_token={{ csrf_token() }}",
            success: function (response) {
                if (response.status) {
                    $('#editLeaveRequest').modal('hide');
                    resetForm($form, true);
                    showSuccess('Leave request updated successfully.');
                    refreshLeaveList();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showValidationErrors($form, xhr.responseJSON.errors);
                } else {
                    showError(xhr.responseJSON?.message || 'Update failed.');
                }
            },
            complete: function () {
                $btn.prop('disabled', false).val(originalText);
            }
        });
    });

    // Delete Leave Request
    $(document).on('click', '.delete-btn', function () {
        $('#delete-leave-id').val($(this).data('leave'));
        $('#deleteLeaveRequest').modal('show');
    });

    $('#deleteLeaveForm').on('submit', function (e) {
        e.preventDefault();
        const leaveId = $('#delete-leave-id').val();
        if (!leaveId) return showError('Invalid leave ID.');

        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: "{{ url('staff/apply-leave/delete') }}/" + leaveId,
            method: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.status) {
                    $('#deleteLeaveRequest').modal('hide');
                    showSuccess('Leave request deleted successfully.');
                    refreshLeaveList();
                } else {
                    showError(response.message || 'Delete failed.');
                }
            },
            error: function () {
                showError('Error deleting leave request.');
            },
            complete: function () {
                $btn.prop('disabled', false).text('Delete');
            }
        });
    });

    // Reset forms on modal close
    $('#requestLeave, #editLeaveRequest').on('hidden.bs.modal', function () {
        resetForm($(this).find('form'));
    });

    refreshLeaveList();
});
</script>
@endpush