@extends('parent-panel.partials.master')

@section('content')
    <!-- Dashboard Begin -->
    <div class="ds-breadcrumb">
        <h1>My Fees</h1>
        <ul>
            <li><a href="{{ route('student.dashboard') }}">Dashboard</a> /</li>
            <li>My Fees</li>
        </ul>
    </div>
    <div class="ds-pr-body">

        <div class="ds-cmn-table-wrp fees-pg">
            <div class="ds-content-head">
                <div class="sec-head">
                    <h2>My Fees</h2>
                </div>

                <div class="dropdown-year" data-selected="">
                    <div class="dropdown-trigger">
                        <span class="dropdown-label">Select Year</span>
                        <i class="dropdown-arrow"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option" data-value="">Select Year</div>
                        @foreach ($yearOptions as $key => $label)
                            <div class="dropdown-option" data-value="{{ $key }}">{{ $label }}</div>
                        @endforeach
                    </div>
                </div>
                <!-- Hidden form for year filter -->
                <form method="GET" action="{{ route('student.fees') }}" id="yearFilterForm" style="display:none;">
                    <input type="hidden" name="year" id="yearInput" value="{{ $selectedYear ?? '' }}">
                </form>

            </div>

            <div class="ds-cmn-tble">
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
                    <!-- <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Uniform</td>
                                                <td>21/12/2024</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn red-bg">Upcoming</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>1056/1</td>
                                                <td>--</td>
                                                <td><button class="edit-file-btn cmn-tbl-btn">Pay</button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn red-bg">Upcoming</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>1058/1</td>
                                                <td>--</td>
                                                <td><button class="edit-file-btn cmn-tbl-btn">Pay</button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>Cash</td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>Cash</td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="{{ asset('student/images/printer-icon.svg') }}"
                                                            alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="{{ asset('student/images/printer-icon.svg') }}"
                                                            alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="{{ asset('student/images/printer-icon.svg') }}"
                                                            alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td>
                                                    <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                                                </td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="{{ asset('student/images/printer-icon.svg') }}"
                                                            alt="Icon"></button></td>
                                            </tr>
                                        </tbody> -->
                    <tbody>
                        @forelse ($fees as $index => $fee)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $fee->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($fee->due_date)->format('d/m/Y') }}</td>
                                <td>--</td>
                                <td>--</td>
                                <td>
                                    <div class="upcoming cmn-tbl-btn red-bg">Upcoming</div>
                                </td>
                                <td>{{ number_format($fee->amount, 2) }}</td>
                                <td>--</td>
                                <td>--</td>
                                <td>

                                    <button data-bs-target="#newRequest" data-bs-toggle="modal"
                                        onclick="fillData('{{ $fee->id }}','{{ $fee->amount }}')"
                                        class="cmn-tbl-btn">
                                        Pay
                                    </button>

                                    <!-- <button data-bs-target="#newRequest" data-bs-toggle="modal" onclick="fillData('{{ $fee->id }},{{ $fee->amount }}')" class="cmn-tbl-btn">Pay</button></td> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No fees assigned.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    {{ $fees->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>

                <div class="pages-select">
                    <form method="GET" id="perPageForm">
                        <div class="formfield">
                            <label>Per page</label>
                            <select name="perPage" onchange="document.getElementById('perPageForm').submit()">
                                @foreach ([1, 2, 3, 4, 5, 10, 15, 20, 25, 50] as $size)
                                    <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <p>
                        Showing {{ $fees->firstItem() }} - {{ $fees->lastItem() }}
                        of {{ $fees->total() }} results
                    </p>
                </div>
            </div>








            <div class="modal fade" id="newRequest" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content p-4">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>

                        <h4 class="mb-3">Pay</h4>

                        <form id="paymentForm" method="POST" action="{{ route('student.my-fees.store') }}">
                            @csrf

                            {{-- <div class="mb-3">
                            <label class="form-label">Destination</label>
                            <select class="js-example-basic-single form-select" name="destination" required>
                                @foreach ($destinations as $destination)
                                <option value="{{ $destination }}">{{ $destination }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Card Holder Name</label>
                                    <input type="text" class="form-control" name="card_holder_name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" class="form-control card-input" name="billing_card" maxlength="19"
                                        placeholder="4111 1111 1111 1111" required>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control expiry-input" name="exp_date"
                                        placeholder="MM/YYYY" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Id</label>
                                    <input type="text" id="fee_id" class="form-control" name="id"
                                        placeholder="" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="text" id="amount" class="form-control" name="amount"
                                        placeholder="" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CVV</label>
                                    <input type="password" class="form-control cvv-input" name="security_code" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Billing Email (Optional)</label>
                                    <input type="email" class="form-control" value="{{ Auth::user()->email }}"
                                        disabled>
                                </div>

                            </div>

                            <button type="submit" class="btn w-100 py-2" style="background-color:#660000;color:white">
                                Submit Payment
                            </button>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Of Dashboard -->
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.querySelector('.dropdown-year');
            const trigger = dropdown.querySelector('.dropdown-trigger');
            const options = dropdown.querySelectorAll('.dropdown-option');
            const label = dropdown.querySelector('.dropdown-label');

            trigger.addEventListener('click', () => {
                dropdown.classList.toggle('open');
            });

            options.forEach(option => {
                option.addEventListener('click', () => {
                    const value = option.getAttribute('data-value');
                    const text = option.textContent.trim();

                    label.textContent = text;
                    dropdown.setAttribute('data-selected', value);
                    dropdown.classList.remove('open');

                    document.getElementById('yearInput').value = value;
                    document.getElementById('yearFilterForm').submit();
                });
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });

            // document.addEventListener('click', function(e) {
            //     if (e.target.classList.contains('edit-file-btn')) {
            //         const button = e.target;
            //         const row = button.closest('tr');

            //         button.textContent = 'Processing...';
            //         button.disabled = true;

            //         setTimeout(() => {
            //             // Generate dummy data
            //             const now = new Date();
            //             const transactionDate = now.toLocaleDateString('en-GB'); // dd/mm/yyyy
            //             const transactionTime = now.toLocaleTimeString([], {
            //                 hour: '2-digit',
            //                 minute: '2-digit'
            //             });
            //             const paymentId = Math.floor(100000 + Math.random() * 900000);
            //             const paymentMethod = 'UPI';
            //             const status = 'Paid';

            //             // Fill table cells with dummy data
            //             row.cells[3].textContent = transactionDate;
            //             row.cells[4].textContent = transactionTime;
            //             row.cells[5].innerHTML = `<div class="upcoming cmn-tbl-btn green-bg">${status}</div>`;
            //             row.cells[7].textContent = paymentId;
            //             row.cells[8].textContent = paymentMethod;

            //             // Replace "Pay" button with Print icon

            //             row.cells[9].innerHTML = `
        //             <button class="print-btn">
        //                 <img src="{{ asset('student/images/printer-icon.svg') }}" alt="Icon">
        //             </button>
        //         `;
            //         }, 1000);
            //     }

            //     if (e.target.closest('.print-btn')) {
            //         const btn = e.target.closest('.print-btn');

            //         // Collect data attributes
            //         const studentName = btn.dataset.student || 'Student Name';
            //         const amount = btn.dataset.amount || '0';
            //         const paymentId = btn.dataset.id;
            //         const paymentMethod = btn.dataset.method;
            //         const transactionDate = btn.dataset.date;
            //         const transactionTime = btn.dataset.time;

            //         // Generate a small HTML receipt

            //         const receiptHTML = `
        //     <html>
        //     <head>
        //         <title>Payment Receipt</title>
        //         <style>
        //             body {
        //                 font-family: Arial, sans-serif;
        //                 margin: 40px;
        //                 color: #333;
        //             }
        //             .receipt-container {
        //                 border: 2px solid #333;
        //                 padding: 20px;
        //                 border-radius: 10px;
        //                 width: 400px;
        //                 margin: 0 auto;
        //                 text-align: center;
        //             }
        //             h2 {
        //                 color: #007bff;
        //                 margin-bottom: 10px;
        //             }
        //             table {
        //                 width: 100%;
        //                 border-collapse: collapse;
        //                 margin-top: 15px;
        //             }
        //             td {
        //                 padding: 6px;
        //                 text-align: left;
        //             }
        //             .footer {
        //                 margin-top: 20px;
        //                 font-size: 13px;
        //                 color: #777;
        //             }
        //         </style>
        //     </head>
        //     <body>
        //         <div class="receipt-container">
        //             <h2>Payment Receipt</h2>
        //             <table>
        //                 <tr><td><strong>Student:</strong></td><td>${studentName}</td></tr>
        //                 <tr><td><strong>Amount:</strong></td><td>${amount}</td></tr>
        //                 <tr><td><strong>Payment ID:</strong></td><td>${paymentId}</td></tr>
        //                 <tr><td><strong>Method:</strong></td><td>${paymentMethod}</td></tr>
        //                 <tr><td><strong>Date:</strong></td><td>${transactionDate}</td></tr>
        //                 <tr><td><strong>Time:</strong></td><td>${transactionTime}</td></tr>
        //                 <tr><td><strong>Status:</strong></td><td>Paid ✅</td></tr>
        //             </table>
        //             <div class="footer">
        //                 <p>Thank you for your payment!</p>
        //                 <p>— School Management System</p>
        //             </div>
        //         </div>
        //         <script>
        //             window.print();
        //             setTimeout(() => window.close(), 1000);
        //         <\/script>
        //     </body>
        //     </html>
        // `;

            //         // Open print popup
            //         const printWindow = window.open('', '_blank');
            //         printWindow.document.write(receiptHTML);
            //         printWindow.document.close();
            //     }
            // });


        });
    </script>


    <script>
        $(document).on('shown.bs.modal', '#newRequest', function() {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#newRequest')
            });
        });
    </script>


    <script>
        function fillData(id, amount) {
            $("#fee_id").val(id);
            $("#amount").val(amount);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cardInput = document.querySelector('.card-input');

            cardInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ""); // remove non-numbers

                // Limit to 16 digits
                value = value.substring(0, 16);

                // Format: 4111 1111 1111 1111
                let formatted = value.replace(/(.{4})/g, "$1 ").trim();

                e.target.value = formatted;

                // Store clean numeric value for submitting
                const hiddenField = document.querySelector('input[name="billing_card_clean"]');
                hiddenField.value = value;
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const expiryInput = document.querySelector('.expiry-input');

            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ""); // remove all non-numbers

                // Limit to MMYYYY (6 digits)
                value = value.substring(0, 6);

                let month = value.substring(0, 2);
                let year = value.substring(2, 6);

                // Validate month (01–12)
                if (month.length === 2) {
                    if (parseInt(month) < 1) month = "01";
                    if (parseInt(month) > 12) month = "12";
                }

                // Build formatted value
                if (year.length > 0) {
                    e.target.value = month + "/" + year;
                } else {
                    e.target.value = month;
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cvvInput = document.querySelector('.cvv-input');

            cvvInput.addEventListener('input', function(e) {
                // Allow only numbers
                let value = e.target.value.replace(/\D/g, '');

                // Limit to 3 digits
                value = value.substring(0, 3);

                e.target.value = value;
            });
        });
    </script>
@endpush
