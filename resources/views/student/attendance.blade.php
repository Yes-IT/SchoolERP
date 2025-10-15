@extends('student.Layout.app')

@section('content')

<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>My Attendance</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>My Attendance</li>
    </ul>
</div>
<div class="ds-pr-body">

    <div class="atndnc-filter-wrp w-100">
        <div class="sec-head">
            <h2>Filters</h2>
        </div>
        <div class="atndnc-filter">
            <form>
                <div class="atndnc-filter-form">
                    <div class="atndnc-filter-options">
                        <!-- Subject Multi‑Select Dropdown -->
                        <div class="dropdown subject-dropdown">
                            <button type="button" class="dropdown-toggle">
                                <span class="label">All Subjects</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <label>
                                    <input type="checkbox" value="all" checked /> All Subjects
                                </label>
                                <label>
                                    <input type="checkbox" value="1" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="2" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="3" /> Lorem ipsum dolor sit amet
                                </label>
                            </div>
                        </div>

                        <!-- Year/Month Picker Dropdown -->
                        <div class="dropdown date-dropdown">
                            <button type="button" class="dropdown-toggle">
                                <span class="label">January, 2025</span>
                                <i class="fa-regular fa-calendar"></i>
                            </button>
                            <div class="dropdown-menu date-menu">
                                <select class="year-select">
                                    <!-- Options 2020–2030 -->
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025" selected>2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                                <select class="month-select">
                                    <option value="1" selected>January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <div class="actions">
                                    <button type="button" class="btn-cancel">Cancel</button>
                                    <button type="button" class="btn-apply">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="btn-search">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="ds-cmn-table-wrp">
        <div class="attendance-calendar">
            <div class="sec-head">
                <h2>Attendance</h2>
                <button class="cmn-btn">Download Report</button>
            </div>
            <div class="ds-cmn-tble pending attendance-pg w1200">
                <table>
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Shabbos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- week 1 -->
                        <tr>
                            <td class="outside">
                                <div class="date-cal-box">
                                    <span class="date-number">29</span>
                                </div>
                            </td>
                            <td class="outside">
                                <div class="date-cal-box">
                                    <span class="date-number">30</span>
                                </div>
                            </td>
                            <td class="outside">
                                <div class="date-cal-box">
                                    <span class="date-number">31</span>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">1</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">2</span>
                                    <div class="status absent">Absent</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">3</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">4</span>
                                </div>
                            </td>
                        </tr>
                        <!-- week 2 -->
                        <tr>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">5</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">6</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">7</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">8</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">9</span>
                                    <div class="status late">Late</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">10</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">11</span>
                                </div>
                            </td>
                        </tr>
                        <!-- week 3 -->
                        <tr>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">12</span>
                                    <div class="status absent">Absent</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">13</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">14</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">15</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">16</span>
                                    <div class="status absent">Absent</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">17</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">18</span>
                                </div>
                            </td>
                        </tr>
                        <!-- week 4 -->
                        <tr>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">19</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">20</span>
                                    <div class="status late">Late</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">21</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">22</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">23</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">24</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">25</span>
                                </div>
                            </td>
                        </tr>
                        <!-- week 5 -->
                        <tr>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">26</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">27</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">28</span>
                                    <div class="status absent">Absent</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">29</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">30</span>
                                    <div class="status late">Late</div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cal-box">
                                    <span class="date-number">31</span>
                                    <div class="status present">Present</div>
                                </div>
                            </td>
                            <td class="outside">
                                <div class="date-cal-box">
                                    <span class="date-number">01</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- End Of Dashboard -->

@endsection

@push('page_script')

@endpush
