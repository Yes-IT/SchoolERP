@extends('parent-panel.partials.master')

@section('content')

<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>Request Transcript</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>Request Transcript</li>
    </ul>
</div>
<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Transcripts</h2>
            </div>
            <div class="btn-wrp align-items-start">
                <div class="ibtn">
                    <button type="button" class="ibtn-icon">
                        <img src="{{asset('student/images/i-icon.svg')}}" alt="Icon">
                    </button>
                    <div class="ibtn-info lg rt p15">
                        <button type="button" class="ibtn-close" style="filter: brightness(0);">
                            <img src="{{asset('student/images/fa-times.svg')}}" alt="icon">
                        </button>
                        <h3 class="txt-primary mb-2">Important Notice:</h3>
                        <p>You cannot request a transcript if your tuition fees are not paid. Please clear all dues before applying.</p>
                    </div>
                </div>

                @if ($hasTranscripts)
                    <button class="cmn-btn" data-bs-target="#newRequest" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> New Request</button>
                @else
                    <button class="cmn-btn" data-bs-target="#newRequestFree" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> New Request</button>
                @endif
            </div>
        </div>

        <div class="ds-cmn-tble count-row">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Date</th>
                        <th>Destination</th>
                        <th>Payment Requirement</th>
                        <th>Payment Status</th>
                        <th>Payment Receipt</th>
                        <th>Application Status</th>
                    </tr>
                </thead>
                <!-- <tbody>
                    @forelse($transcripts as $index => $transcript)
                    <tr>
                        <td>{{ $transcripts->firstItem() + $index }}</td>
                        <td>{{ \Carbon\Carbon::parse($transcript->created_at)->format('m/d/Y') }}</td>
                        <td>{{ $transcript->destination }}</td>
                        <td>{{ ucfirst($transcript->payment_requirement) }}</td>
                        <td>
                            @if($transcript->payment_status == 1)
                            <div class="upcoming cmn-tbl-btn yellow-bg">Pending</div>
                            @elseif($transcript->payment_status == 2)
                            <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                            @else
                            <div class="upcoming cmn-tbl-btn red-bg">Unpaid</div>
                            @endif
                        </td>
                        <td>
                            @if($transcript->payment_receipt_link)
                            <a href="{{ $transcript->payment_receipt_link }}" class="cmn-tbl-btn gap-10" target="_blank">
                                <img src="{{ asset('student/images/download-icon.svg') }}" alt="Icon"> Download
                            </a>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($transcript->status == 0)
                            <p class="yellow-txt">Pending</p>
                            @elseif($transcript->status == 1)
                            <p class="green-txt">Approved</p>
                            @else
                            <p class="red-txt">Rejected</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No transcripts found.</td>
                    </tr>
                    @endforelse


                </tbody> -->

                <tbody>
                    @forelse($transcripts as $index => $transcript)
                    <tr>
                        <td>{{ $transcripts->firstItem() + $index }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($transcript->created_at)->format('m/d/Y') }}
                        </td>
                        <td>{{ $transcript->destination }}</td>
                        <td>{{ ucfirst($transcript->payment_requirement) }}</td>
                        <td>
                            @php
                            $status = strtolower($transcript->payment_status);
                            @endphp
                            @if($status == 'approved')
                            <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                            @elseif($status == 'pending')
                            <div class="upcoming cmn-tbl-btn yellow-bg">Pending</div>
                            @else
                            <div class="upcoming cmn-tbl-btn red-bg">Unpaid</div>
                            @endif
                        </td>
                        <!-- <td>
                            @if(!empty($transcript->payment_receipt_link))
                            <a href="{{ $transcript->payment_receipt_link }}" class="cmn-tbl-btn gap-10" target="_blank">
                                <img src="{{ asset('student/images/download-icon.svg') }}" alt="Icon"> Download
                            </a>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td> -->
                        <td>
                            @if($transcript->transaction_id)
                            <a href="{{ route('student.transcript.payment.download', $transcript->id) }}" class="cmn-tbl-btn gap-10" target="_blank">
                                <img src="{{ asset('student/images/download-icon.svg') }}" alt="Icon"> Download Payment
                            </a>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        <td>
                            @if($transcript->status == 0)
                            <p class="yellow-txt">Pending</p>
                            @elseif($transcript->status == 1)
                            <p class="green-txt">Approved</p>
                            @else
                            <p class="red-txt">Rejected</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No transcripts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="tablepagination">
            <div class="tbl-pagination-inr">
                {{ $transcripts->appends(request()->query())->links('vendor.pagination.custom') }}
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
                    Showing {{ $transcripts->firstItem() }} - {{ $transcripts->lastItem() }}
                    of {{ $transcripts->total() }} results
                </p>
            </div>
        </div>


    </div>
</div>
<!-- End Of Dashboard -->



<!-- <div class="modal fade cmn-popwrp pop650" id="newRequest" tabindex="-1" role="dialog" aria-labelledby="newRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>New Request</h2>
                    <div class="new-request-form-wrp">
                        <form>
                            
                            <div class="new-request-form">
                                <div class="autocomplete input-grp h48">
                                    <label for="dest">Destination</label>

                                    <select class="js-example-basic-single" name="state">
                                        <option value="AL">Alabama</option>
                                        <option value="WY">Wyoming</option>
                                    </select>

                                    <input class="dest" name="destination" type="text" placeholder="Lorem ipsum dolor sit amet" autocomplete="off">
                                    <div class="dist-list-wrp">
                                        <div class="dest-list" class="autocomplete-list"></div>
                                    </div>
                                    <span id="destination_error" style="color: red;"></span>
                                </div>
                                <div class="input-grp h48 paylink">
                                    <label>Payment Link</label>
                                    <div class="has-submit">
                                        <input type="url" name="payment_receipt_link" placeholder="https://pay.example.com/share/invoice123xyz">
                                        <input type="submit" value="Pay Now">
                                    </div>
                                    <span id="payment_error" style="color: red;"></span>
                                </div>
                                <button type="button" value="Submit" id="submit-form" class="cmn-btn btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> -->



<div class="modal fade" id="newRequest" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>

            <h4 class="mb-3">New Request</h4>

            <form id="paymentForm" method="POST" action="{{ route('student.transcripts.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Destination</label>
                    <select class="js-example-basic-single form-select" name="destination" required>
                        @foreach ($destinations as $destination)
                        <option value="{{ $destination }}">{{ $destination }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Card Holder Name</label>
                        <input type="text" class="form-control" name="card_holder_name" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" name="billing_card"
                            placeholder="4111 1111 1111 1111" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="text" class="form-control" name="exp_date"
                            placeholder="MM/YYYY" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">CVV</label>
                        <input type="password" class="form-control" name="security_code" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Billing Email (Optional)</label>
                        <input type="email" class="form-control"
                            value="{{ Auth::user()->email }}" disabled>
                    </div>

                </div>

                <button type="submit" class="btn w-100 py-2" style="background-color:#660000;color:white">
                    Submit Payment
                </button>

            </form>

        </div>
    </div>
</div>


<div class="modal fade" id="newRequestFree" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>

            <h4 class="mb-3">New Request</h4>

            <form id="paymentForm" method="POST" action="{{ route('student.transcripts.store_fee_pay') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Destination</label>
                    <select class="js-example-basic-single form-select" name="destination" required>
                        @foreach ($destinations as $destination)
                        <option value="{{ $destination }}">{{ $destination }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn w-100 py-2" style="background-color:#660000;color:white">
                    Submit
                </button>

            </form>

        </div>
    </div>
</div>




<!-- End Of Attachments Modal -->

<!-- Success Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="success" tabindex="-1" role="dialog" aria-labelledby="success" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{asset('student/images/check-circle-primary.svg')}}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Successful</h2>
                        <p>Your transcript request has been submitted successfully.</p>
                        <div class="btn-wrp">
                            <button type="submit" id="page-refresh" data-bs-dismiss="modal" aria-label="Close" class="cmn-btn btn-sm">Okay</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Of Success Modal -->
@endsection

@push('script')
<!-- Make sure you have Bootstrap JS included -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $("#submit-form").click(function(e) {
        e.preventDefault();
        // alert("AAAAAAAAA");

        // Get form values
        const destination = $('input[name="destination"]').val();
        const paymentReceiptLink = $('input[name="payment_receipt_link"]').val();

        // Basic validation
        if (!destination) {
            $("#destination_error").html("Please enter destination")
            // alert('Please enter destination');
            return;
        } else {
            $("#destination_error").html("")

        }

        if (!paymentReceiptLink) {
            $("#payment_error").html("Please enter payment link");
            return;
        }

        // Get CSRF token
        const token = $('meta[name="csrf-token"]').attr('content');
        const submitBtn = $(this);
        submitBtn.prop('disabled', true).text('Submitting...');

        // Send AJAX request
        $.ajax({
            url: "{{ route('student.transcripts.store') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {
                destination: destination,
                payment_receipt_link: paymentReceiptLink
            },
            success: function(response) {
                if (response.success) {
                    // alert('Transcript request submitted successfully!');

                    // Close the modal
                    $('#newRequest').modal('hide');
                    $('#success').modal('show');
                    // setTimeout(function() {
                    //     $('#success').modal('show');
                    // }, 300);

                    // Optional: reload page after a delay
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 1000);
                } else {
                    alert('Error: ' + (response.message || 'Please try again.'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);

                // Handle validation errors
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Please fix the following errors:\n';
                    for (let field in errors) {
                        errorMessage += `- ${errors[field][0]}\n`;
                    }
                    alert(errorMessage);
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).text('Submit');
            }
        });
    });
</script>

<script>
    $(document).on('click', '#page-refresh', function() {
        location.reload();
    });
</script>


<script>
    $(document).on('shown.bs.modal', '#newRequest', function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#newRequest')
        });
    });
</script>
@endpush