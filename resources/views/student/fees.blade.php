@extends('student.Layout.app')

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
                        {{-- First option to reset filter --}}
                        <div class="dropdown-option" data-value="">Select Year</div>
                        @foreach ($yearOptions as $key => $label)
                            <div class="dropdown-option" data-value="{{ $key }}">{{ $label }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

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
                    </tbody>
                </table>
            </div>

            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        <li><a href="#url"><img src="{{ asset('student/images/arrow-left.svg') }}" alt="Icon"></a>
                        </li>
                        <li class="active"><a href="#url">1</a></li>
                        <li><a href="#url">2</a></li>
                        <li><a href="#url">3</a></li>
                        <li><a href="#url"><img src="{{ asset('student/images/arrow-right.svg') }}" alt="Icon"></a>
                        </li>
                    </ul>
                </div>

                <div class="pages-select">
                    <form>
                        <div class="formfield">
                            <label>Per page</label>
                            <select>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </form>
                    <p>of 2 results</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Dashboard -->
@endsection

@push('page_script')
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
                    const text = option.textContent;

                    label.textContent = text;
                    dropdown.setAttribute('data-selected', value);
                    dropdown.classList.remove('open');
                    console.log('Selected year id:', value);
                });
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });
    </script>
@endpush
