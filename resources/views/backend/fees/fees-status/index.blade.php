@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .multi-input-grp {
        display: flex;
        gap: 20px;
        /* space between inputs */
    }

    .multi-input-grp .input-grp {
        flex: 1;
        /* make them equal width */
        display: flex;
        flex-direction: column;
    }

    .first-row {
        display: flex;
        flex-direction: row;
    }

    .second-row {
        display: flex;
        flex-direction: row;
        margin-top: 6px;
        margin-left: 182px;
    }

    .third-row {
        display: flex;
        flex-direction: row;
        margin-top: 6px;
        margin-left: 182px;
    }

    .student-details-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f8f8;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 15px;

    }

    .student-info-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .student-name {
        font-size: 23px;
        font-weight: 800;
        color: var(--primary-clr);

    }

    .student-contact,
    .student-id {
        font-size: 15px;
        color: var(--secondary-clr);
        font-weight: 800;


    }

    .reminder-btn {
        /* background-color: var(--primary-clr); */
        color: var(--primary-clr);
        border: none;
        padding: 6px 14px;
        /* border-radius: 6px; */
        cursor: pointer;
        font-size: 14px;
        transition: 0.3s ease;
        border: 1px solid var(--primary-clr);
        width: 122px;
        height: 40px;
        font-weight: 500;

    }
    .student-total-section {
    display: flex
;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f8f9fa;
    /* border: 1px solid #ddd; */
    border-radius: 8px;
    margin-bottom: 15px;
    margin-top: 16px;
}

.student-total-title h3 {
  margin: 0;
  font-size: 1.2rem;
  font-weight: 600;
  color: var(--primary-clr)
}

.student-total-values {
    display: flex
;
    gap: 70px;
    font-size: 17px;
    font-weight: 700;
}

.student-total-values span strong {
  color: #333;
}
</style>

@section('content')


    <div class="dashboard-main light-bg">

        <!-- Sidebar Begin -->

        @include('backend.partials.sidebar')
        <!-- End Of Sidebar -->

        <!-- Dashboard Body Begin -->

        <div class="dashboard-body dspr-body-outer">
            <div class="dashboard-body-head">
                <div class="dsbdy-head-left">
                    <div class="dsbdy-search-form">
                        <div class="input-grp search-field">
                            <input type="text" placeholder="Search Page">
                            <input type="submit" value="Search">
                        </div>
                    </div>
                </div>
                <div class="dsbdy-head-right">
                    <button class="tgl-flscrn" aria-label="Toggle fullscreen">
                        <img src="{{ asset('images/fees/fullscreen-toggler-icon.svg') }}" alt="Icon">
                    </button>
                    <div class="profile-ctrl">
                        <button class="profile-ctrl-toggler">
                            <div class="pr-pic">
                                <img src="{{ asset('images/fees/profile-picture.png') }}" alt="Profile Picture">
                            </div>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="pr-ctrl-menu">
                            <ul>
                                <li><a href="profile.html">My Profile</a></li>
                                <li><a href="../../set-password.html">Change Password</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ds-breadcrumb">
                <h1>Students Fees Status</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">Additional Fees</a> /</li>
                    <li>Student Fees Status</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">

                    <div class="dsbdy-cmn-card w55" style="width:1500px;">
                       <div class="sec-head" style="display:flex; justify-content:space-between; align-items:flex-start;">

                            <!-- Heading -->
                            <h2 style="    font-size: 21px;
                font-weight: 500;">Select Criteria</h2>

                            <!-- Dropdown Container -->
                            <div class="criteria-grid">
                                <!-- Row 1 -->
                                <div class="first-row">
                                    <div class="atndnc-filter student-filter">

                                        <div class="atndnc-filter-form">
                                            <div class="atndnc-filter-options multi-input-grp" style="gap:12px;">
                                                <div class="input-grp"
                                                    style="        width: 110px;     margin-left: 126px;">
                                                    <select id="ParentyearFilter" style="border-radius: 0px;
                                    height: 40px;">
                                                        <option value="">Select Year</option>
                                                        @foreach(range(date('Y'), 2000) as $year)
                                                            <option value="option 1">option 1</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-grp" style="    width: 367px;">
                                                    <select id="ParentyearFilter" style="border-radius: 0px;
                                    height: 40px;">
                                                        <option value="">Select Year Status </option>
                                                        @foreach(range(date('Y'), 2000) as $year)
                                                            <option value="option 1">option 1</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="input-grp" style="    width: 367px;">
                                                    <select id="ParentyearFilter" style="border-radius: 0px;
                                    height: 40px;">
                                                        <option value="">Select Semester</option>
                                                        @foreach(range(date('Y'), 2000) as $year)
                                                            <option value="option 1">option 1</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>


                                            <!-- Search Button -->

                                        </div>
                                        </form>
                                    </div>
                                </div>


                                <!-- Row 2 -->
                                <div class="second-row">
                                    <div class="atndnc-filter student-filter">

                                        <div class="atndnc-filter-form">
                                            <div class="atndnc-filter-options multi-input-grp">
                                                <div class="input-grp" style="    width: 367px; margin-left: 70px;">
                                                    <select id="ParentyearFilter" style="border-radius: 0px;
                                    height: 40px;">
                                                        <option value="">Select Class</option>
                                                        @foreach(range(date('Y'), 2000) as $year)
                                                            <option value="option 1">option 1</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-grp" style="    width: 367px;">
                                                    <select id="ParentyearFilter" style="border-radius: 0px;
                                    height: 40px;">
                                                        <option value="">Select Subject</option>
                                                        @foreach(range(date('Y'), 2000) as $year)
                                                            <option value="option 1">option 1</option>
                                                        @endforeach
                                                    </select>
                                                </div>



                                            </div>


                                            <!-- Search Button -->

                                        </div>
                                        </form>
                                    </div>
                                </div>


                                <!-- Row 3 -->
                                <div class="third-row">
                                    <div class="atndnc-filter student-filter">

                                        <div class="atndnc-filter-form">
                                            <div class="atndnc-filter-options multi-input-grp">
                                                <div class="input-grp" style="    width: 367px; margin-left: 70px;">
                                                    <select id="ParentyearFilter" style="border-radius: 0px;
                                    height: 40px;">
                                                        <option value="">Select Group </option>
                                                        @foreach(range(date('Y'), 2000) as $year)
                                                            <option value="option 1">option 1</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-grp" style="    width: 367px;">
                                                    <select id="ParentyearFilter" style="border-radius: 0px;
                                    height: 40px;">
                                                        <option value="">Select Type</option>
                                                        @foreach(range(date('Y'), 2000) as $year)
                                                            <option value="option 1">option 1</option>
                                                        @endforeach
                                                    </select>
                                                </div>



                                            </div>


                                            <!-- Search Button -->

                                        </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div> 
                    </div>



                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                        <div class="ds-content-head">
                            <div class="sec-head">
                                <h3 class="h2-title">Student Fees Student (4 students)</h3>
                            </div>

                        </div>
                        <div class="fees-status">
                            <div class="student-details-card">
                                <div class="student-info-left">
                                    <strong class="student-name">Student's name</strong>
                                    <span class="student-contact"> Phone: 9876543210</span>
                                    <span class="student-id"> Student ID: 24646</span>
                                </div>

                                <!-- Right Side Button -->
                                <div class="student-info-right">
                                    <button class="reminder-btn">Set Reminder</button>
                                </div>
                            </div>

                            <div class="ds-cmn-tble count-row">

                                <table>
                                    <thead>
                                        <tr>
                                            <th>Fees Detail</th>
                                            <th>Total Amount</th>
                                            <th>Pending Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Status</th>
                                            <th>Installment</th>
                                            <th>Last Payment</th>
                                            <th>View Detail</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td><span style="    color: var(--primary-clr); font-weight: 600;">Fees
                                                    Group</span><br><span style="color: var(--secondary-clr);">Fees
                                                    Type</span>
                                            </td>
                                            <td style="color: var(--secondary-clr);">$1500
                                            </td>
                                            <td style="    color: green;font-weight: 700;">$500</td>
                                            <td style="color: var(--secondary-clr);">$1500
                                            </td>
                                            <td><button style="    background-color: red;
                color: white;
                font-size: 12px;
                padding: 6px;
                    font-weight: 600;">Unpaid</button></td>
                                            <td style="color: var(--secondary-clr);">1/3 paid
                                            </td>
                                            <td style="color: var(--secondary-clr);">04/22/2025
                                            </td>
                                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments"
                                                    data-bs-toggle="modal"><img
                                                        src="{{ asset('images/parent/eye-white.svg') }}" alt="Eye Icon">
                                                </button></td>

                                        </tr>
                                        <tr>
                                            <td><span style="    color: var(--primary-clr); font-weight: 600;">Fees
                                                    Group</span><br><span style="color: var(--secondary-clr);">Fees
                                                    Type</span>
                                            </td>
                                            <td style="color: var(--secondary-clr);">$200</td>

                                            <td style="    color: green; font-weight: 700;">$00</td>
                                            <td style="color: var(--secondary-clr);">$1500
                                            </td>
                                            <td>
                                                <button style="background-color: green;
                                                color: white;
                                                font-size: 12px;
                                                padding: 6px;
                                                    font-weight: 600;">Paid</button>
                                            </td>
                                            <td style="color: var(--secondary-clr);">1/3 paid
                                            </td>
                                            <td style="color: var(--secondary-clr);">04/22/2025
                                            </td>
                                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments"
                                                    data-bs-toggle="modal"><img
                                                        src="{{ asset('images/parent/eye-white.svg') }}" alt="Eye Icon">
                                                </button></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="student-total-section">
                                <div class="student-total-title">
                                    <h3>Student Total</h3>
                                </div>
                                <div class="student-total-values">
                                    <span style="color: var(--primary-clr);">Total:₹7,000</span>
                                    <span style="color:green;">Paid: ₹5,000</span>
                                    <span style="color:red;">Pending: ₹2,000</span>
                                 
                                </div>
                            </div>




                        </div>


                                                <div class="fees-status">
                            <div class="student-details-card">
                                <div class="student-info-left">
                                    <strong class="student-name">Student's name</strong>
                                    <span class="student-contact"> Phone: 9876543210</span>
                                    <span class="student-id"> Student ID: 24646</span>
                                </div>

                                <!-- Right Side Button -->
                                <div class="student-info-right">
                                    <button class="reminder-btn">Set Reminder</button>
                                </div>
                            </div>

                            <div class="ds-cmn-tble count-row">

                                <table>
                                    <thead>
                                        <tr>
                                            <th>Fees Detail</th>
                                            <th>Total Amount</th>
                                            <th>Pending Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Status</th>
                                            <th>Installment</th>
                                            <th>Last Payment</th>
                                            <th>View Detail</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td><span style="    color: var(--primary-clr); font-weight: 600;">Fees
                                                    Group</span><br><span style="color: var(--secondary-clr);">Fees
                                                    Type</span>
                                            </td>
                                            <td style="color: var(--secondary-clr);">$1500
                                            </td>
                                            <td style="    color: green;font-weight: 700;">$500</td>
                                            <td style="color: var(--secondary-clr);">$1500
                                            </td>
                                            <td><button style="    background-color: red;
                color: white;
                font-size: 12px;
                padding: 6px;
                    font-weight: 600;">Unpaid</button></td>
                                            <td style="color: var(--secondary-clr);">1/3 paid
                                            </td>
                                            <td style="color: var(--secondary-clr);">04/22/2025
                                            </td>
                                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments"
                                                    data-bs-toggle="modal"><img
                                                        src="{{ asset('images/parent/eye-white.svg') }}" alt="Eye Icon">
                                                </button></td>

                                        </tr>
                                        <tr>
                                            <td><span style="    color: var(--primary-clr); font-weight: 600;">Fees
                                                    Group</span><br><span style="color: var(--secondary-clr);">Fees
                                                    Type</span>
                                            </td>
                                            <td style="color: var(--secondary-clr);">$200</td>

                                            <td style="    color: green; font-weight: 700;">$00</td>
                                            <td style="color: var(--secondary-clr);">$1500
                                            </td>
                                            <td>
                                                <button style="background-color: green;
                                                color: white;
                                                font-size: 12px;
                                                padding: 6px;
                                                    font-weight: 600;">Paid</button>
                                            </td>
                                            <td style="color: var(--secondary-clr);">1/3 paid
                                            </td>
                                            <td style="color: var(--secondary-clr);">04/22/2025
                                            </td>
                                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments"
                                                    data-bs-toggle="modal"><img
                                                        src="{{ asset('images/parent/eye-white.svg') }}" alt="Eye Icon">
                                                </button></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="student-total-section">
                                <div class="student-total-title">
                                    <h3>Student Total</h3>
                                </div>
                                <div class="student-total-values">
                                    <span style="color: var(--primary-clr);">Total:₹7,000</span>
                                    <span style="color:green;">Paid: ₹5,000</span>
                                    <span style="color:red;">Pending: ₹2,000</span>
                                 
                                </div>
                            </div>




                        </div>


                        <div class="tablepagination">
                            <div class="tbl-pagination-inr">
                                <ul>
                                    <li><a href="#url"><img src="{{ asset('images/fees/arrow-left.svg') }}"></a></li>
                                    <li class="active"><a href="#url">1</a></li>
                                    <li><a href="#url">2</a></li>
                                    <li><a href="#url">3</a></li>
                                    <li><a href="#url"><img src="{{ asset('images/fees/arrow-right.svg') }}"></a></li>
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

            </div>
        </div>

    </div>

@endsection