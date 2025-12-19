@extends('parent-panel.partials.master')

@section('content')
    <!-- Dashboard Begin -->
    <div class="ds-breadcrumb">
        <h1>My Tuition Fees</h1>
        <ul>
            <li><a href="{{ route('parent-panel-dashboard.index') }}">Dashboard</a> /</li>
            <li>My Tuition Fees</li>
        </ul>
    </div>
    <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp fees-pg">
                    <div class="ds-content-head">
                        <div class="sec-head">
                            <!-- Replace heading with tabs -->
                            <ul class="nav nav-tabs" id="feesTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab">Tuition Fees</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="uniform-tab" data-bs-toggle="tab" data-bs-target="#uniform" type="button" role="tab">Student Fees</button>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="select-yr">
                            <select>
                                <option value="2024-25" selected>2024-25</option>
                                <option value="2025-26">2025-26</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="feesTabContent">
                        <!-- Assignments Table -->
                        <div class="tab-pane fade show active" id="assignments" role="tabpanel">
                            <div class="ds-cmn-tble count-row">
                                <table>
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Type</th>
                                                <th>Due Date</th>
                                                <th>Transaction Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Payment ID</th>
                                                <th>Payment Method</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        {{-- <tbody>
                                            @forelse ($feesData as $index => $fee)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $fee->fees_type_name }}</td>

                                                <td>{{ \Carbon\Carbon::parse($fee->installment_due_date)->format('d/m/Y') }}</td>

                                                <td>
                                                    {{ $fee->payment_date
                                                        ? \Carbon\Carbon::parse($fee->payment_date)->format('d/m/Y')
                                                        : '--' }}
                                                </td>

                                                <td>
                                                    {{ $fee->payment_date
                                                        ? \Carbon\Carbon::parse($fee->payment_date)->format('h:i A')
                                                        : '--' }}
                                                </td>

                                                <td>
                                                    <div class="upcoming cmn-tbl-btn {{ $fee->status_class }}">
                                                        {{ $fee->status_text }}
                                                    </div>
                                                </td>

                                                <td>
                                                    {{ number_format($fee->final_amount, 2) }}

                                                    @if ($fee->fine_calculated > 0)
                                                        <br>
                                                        <small style="color:red;">
                                                            Fine: {{ number_format($fee->fine_calculated, 2) }}
                                                        </small>
                                                    @endif
                                                </td>

                                                <td>{{ $fee->transaction_id ?? '--' }}</td>

                                                <td>{{ ucfirst($fee->payment_method ?? '--') }}</td>

                                                <td>
                                                    @if ($fee->status_text !== 'Paid')
                                                       
                                                        <button class="edit-file-btn cmn-tbl-btn pay-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#payModal"
                                                                data-amount="{{ $fee->final_amount + $fee->fine_calculated }}"
                                                                data-installment-id="{{ $fee->installment_id }}"
                                                                data-base-amount="{{ $fee->installment_amount }}"
                                                                data-fine="{{ $fee->fine_calculated }}"
                                                                data-due-date="{{ $fee->installment_due_date }}"
                                                                data-type="{{ $fee->fees_type_name }}">
                                                            Pay
                                                        </button>
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    No fee records found
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody> --}}

                                        <tbody>
                                            @if($feesData->isEmpty())
                                                <tr>
                                                    <td colspan="10" class="text-center">
                                                        No fee records found
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($feesData as $index => $fee)
                                                <tr>
                                                    <td>{{ ($feesData->currentPage() - 1) * $feesData->perPage() + $loop->iteration }}</td>

                                                    <td>{{ $fee->fees_type_name }}</td>

                                                    <td>{{ \Carbon\Carbon::parse($fee->installment_due_date)->format('d/m/Y') }}</td>

                                                    <td>
                                                        {{ $fee->payment_date
                                                            ? \Carbon\Carbon::parse($fee->payment_date)->format('d/m/Y')
                                                            : '--' }}
                                                    </td>

                                                    <td>
                                                        {{ $fee->payment_date
                                                            ? \Carbon\Carbon::parse($fee->payment_date)->format('h:i A')
                                                            : '--' }}
                                                    </td>

                                                    <td>
                                                        <div class="upcoming cmn-tbl-btn {{ $fee->status_class }}">
                                                            {{ $fee->status_text }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        {{ number_format($fee->final_amount, 2) }}

                                                        @if ($fee->fine_calculated > 0)
                                                            <br>
                                                            <small style="color:red;">
                                                                Fine: {{ number_format($fee->fine_calculated, 2) }}
                                                            </small>
                                                        @endif
                                                    </td>

                                                    <td>{{ $fee->transaction_id ?? '--' }}</td>

                                                    <td>{{ ucfirst($fee->payment_method ?? '--') }}</td>

                                                    <td>
                                                        @if ($fee->status_text !== 'Paid')
                                                            <button class="edit-file-btn cmn-tbl-btn pay-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#payModal"
                                                                    data-amount="{{ $fee->final_amount + $fee->fine_calculated }}"
                                                                    data-installment-id="{{ $fee->installment_id }}"
                                                                    data-base-amount="{{ $fee->installment_amount }}"
                                                                    data-fine="{{ $fee->fine_calculated }}"
                                                                    data-due-date="{{ $fee->installment_due_date }}"
                                                                    data-type="{{ $fee->fees_type_name }}">
                                                                Pay
                                                            </button>
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>

                                    </table>

                                     <!-- Pagination Section -->
                                        @if($feesData->hasPages())
                                            <div class="pagination-container" style="margin-top: 20px;">
                                                @include('backend.partials.pagination', [
                                                    'paginator' => $feesData,
                                                    'routeName' => 'parent-panel-fees.index'
                                                ])
                                            </div>
                                        @endif
                            </div>
                        </div>

                        <!-- Uniform Fees Table -->
                        <div class="tab-pane fade" id="uniform" role="tabpanel">
                            <div class="ds-cmn-tble count-row">
                                <table>
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Type</th>
                                                <th>Due Date</th>
                                                <th>Transaction Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Payment ID</th>
                                                <th>Payment Method</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Uniform</td>
                                                <td>21/12/2024</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td><div class="upcoming cmn-tbl-btn red-bg">Upcoming</div></td>
                                                <td>4500.00</td>
                                                <td>1056/1</td>
                                                <td>--</td>
                                                <td><button class="edit-file-btn cmn-tbl-btn">Pay</button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>Cash</td>
                                                <td>--</td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>

                        <!-- Exam Fees Table -->
                        
                    </div>
            </div>   
    </div>
    <!-- End Of Dashboard -->

   
    <div class="modal fade cmn-popwrp pop650" id="payModal" tabindex="-1" role="dialog" aria-labelledby="newRequest" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <h2>Pay Fee</h2>
                        <div class="new-request-form-wrp">
                            <form id="parentPaymentForm" method="POST" action="{{ route('parent.my-fees.store') }}">
                                @csrf
                                
                                <div class="new-request-form">
                                    <div class="autocomplete input-grp h48">

                                        <div class="row">

                                            {{-- <input type="hidden" name="fee_amount" id="modalFeeAmount">
                                            <input type="hidden" name="fee_id" id="modalFeeId"> --}}

                                             <!-- Hidden fields -->
                                            <input type="hidden" name="installment_id" id="modalInstallmentId">
                                            <input type="hidden" name="amount" id="modalAmountHidden">
                        

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="modalAmountDisplay" readonly required>
                                            </div>
                                            
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

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Billing Email (Optional)</label>
                                                <input type="email" class="form-control"
                                                    value="{{ Auth::user()->email }}" disabled>
                                            </div>

                                        </div>

                                    </div>

                                    <button type="submit" id="submit-form" class="cmn-btn w-100 py-2 btn-sm">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@push('script')
<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const payModal = document.getElementById('payModal');
        
    //     payModal.addEventListener('show.bs.modal', function (event) {
    //         // Button that triggered the modal
    //         const button = event.relatedTarget;
            
    //         // Extract info from data-* attributes
    //         const amount = button.getAttribute('data-amount');
    //         const feeType = button.getAttribute('data-type');
            
    //         // Update modal content
    //         document.getElementById('modalAmount').value = amount;
    //         document.getElementById('modalFeeAmount').value = amount;
    //         document.getElementById('modalFeeType').textContent = 'Fee Type: ' + feeType;
    //     });

      
    // });


    document.addEventListener('DOMContentLoaded', function () {
        const payModal = document.getElementById('payModal');
    
        payModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // Extract all data attributes
            const totalAmount = button.getAttribute('data-amount');
            const installmentId = button.getAttribute('data-installment-id');
            const baseAmount = button.getAttribute('data-base-amount');
            const fineAmount = button.getAttribute('data-fine');
            const feeType = button.getAttribute('data-type');
            const dueDate = button.getAttribute('data-due-date');
            
            // Update modal fields
            document.getElementById('modalAmountDisplay').value = '$' + parseFloat(totalAmount).toFixed(2);
            document.getElementById('modalAmountHidden').value = totalAmount;
            document.getElementById('modalInstallmentId').value = installmentId;
            
            // Optional: Show fee breakdown
            const amountField = document.querySelector('#modalAmountDisplay').parentNode;
            
            // Remove any existing breakdown
            const existingBreakdown = amountField.querySelector('.fee-breakdown');
            if (existingBreakdown) {
                existingBreakdown.remove();
            }
            
            const feeBreakdown = document.createElement('div');
            feeBreakdown.className = 'fee-breakdown mt-1';
            feeBreakdown.innerHTML = `
                <small class="text-muted d-block">Fee Type: ${feeType}</small>
                <small class="text-muted d-block">Due Date: ${new Date(dueDate).toLocaleDateString()}</small>
                <small class="text-muted d-block">
                    Breakdown: Base: $${parseFloat(baseAmount).toFixed(2)} | 
                    Fine: $${parseFloat(fineAmount).toFixed(2)}
                </small>
            `;
            
            amountField.appendChild(feeBreakdown);
        });
    });
</script>
@endpush