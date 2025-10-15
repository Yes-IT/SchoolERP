@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Attendance</h1>
            <ul>
                <li><a href="../dashboard">Dashboard</a> /</li>
                <li><a href="./dashboard">Attendance</a> /</li>
                <li>Attendance View</li>
            </ul>

            <div class="ds-cmn-filter-wrp mt-4 mb-0">
                <div>
                    {{-- <form method="POST" action="{{ route('parent.search') }}">
                        @csrf --}}
                    <select name="attendance_type" class="dropdown-trigger w-auto form-select">
                        <option value="daily_attendance">Daily Attendance</option>
                        <option value="monthly_attendance">Monthly Attendance</option>
                        <option value="semester_attendance">Semester Total Attendance</option>
                    </select>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <div class="ds-pr-body">
            <div class="atndnc-filter-wrp w-100">
                <div class="sec-head">
                    <h2>Select Criteria</h2>
                </div>
                </form>
                <div class="atndnc-filter student-filter">
                    <form method="POST" action="{{ route('attendance.search') }}">
                        @csrf
                        <div class="atndnc-filter-form">
                            <div class="atndnc-filter-options multi-input-grp grp-3">
                                <div class="input-grp">
                                    <select id="ParentyearFilter" name="year">
                                        <option value="">Select Year</option>
                                        @foreach ($data['school_years'] as $year)
                                            <option value="{{ $year->name }}"
                                                {{ request('year') == $year->name ? 'selected' : '' }}>
                                                {{ $year->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select name="attendance">
                                        <option value="">Select attendance</option>
                                        <option value="1" {{ request('attendance') == 1 ? 'selected' : '' }}>
                                            present</option>
                                            <option value="2" {{ request('attendance') == 2 ? 'selected' : '' }}>
                                            late</option>
                                            <option value="4" {{ request('attendance') == 4 ? 'selected' : '' }}>
                                            half_day</option>
                                        <option value="3"
                                            {{ request('attendance') == 3 ? 'selected' : '' }}>absent</option>
                                    </select>
                                </div>
                                {{-- <div class="input-grp">
                                    <select name="Semester">
                                        <option value="">Select Semester</option>
                                        <option value="active" {{ request('year_status') == 'active' ? 'selected' : '' }}>
                                            active</option>
                                        <option value="inactive"
                                            {{ request('year_status') == 'inactive' ? 'selected' : '' }}>inactive</option>
                                    </select>
                                </div>
                            </div> --}}

                            {{-- <div class="atndnc-filter-options multi-input-grp grp-3"> --}}
                                <div class="input-grp">
                                    <select id="ParentyearFilter" name="classes">
                                        <option value="">Select Class</option>
                                        @foreach ($data['classes'] as $classes)
                                            <option value="{{ $classes->id }}"
                                                {{ request('classes') == $classes->id ? 'selected' : '' }}>
                                                {{ $classes->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="input-grp">
                                    <select name="subjects">
                                        <option value="">Select Subject</option>
                                        @foreach ($data['subjects'] as $subjects)
                                            <option value="{{ $subjects->name }}"
                                                {{ request('subjects') == $subjects->name ? 'selected' : '' }}>
                                                {{ $subjects->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                {{-- <div class="input-grp">
                                    <input type="date" placeholder="select month">
                                </div> --}}
                            </div>

                            <button type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ds-cmn-table-wrp">
                <div class="ds-content-head has-drpdn">
                    <div class="sec-head">
                        <h2>Daily Attendance</h2>
                    </div>
                </div>
                <div class="ds-cmn-tble count-row">
                    <table style="min-width:auto ! important;">
                        <thead class="thead">
                            <tr>
                                <th class="serial">{{ ___('common.sr_no') }}</th>
                                <th class="purchase">Student ID</th>
                                <th class="purchase">Student Name</th>
                                <th class="purchase">Class Time</th>
                                <th class="purchase">Attendance</th>
                                <th class="purchase">Approved Leaves</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">

                            @foreach ($data['attendance'] as $key => $attendance)
                                <tr>

                                    <td class="serial">{{ $key }}</td>
                                    <td class="purchase">{{ $attendance->student_id }}</td>
                                    <td class="purchase">{{ $attendance->first_name }} {{ $attendance->last_name }}</td>
                                    <td class="purchase">{{ date('h:i A', strtotime($attendance->start_time)) }}</td>
                                    <td class="purchase">

                                        @if ($attendance->attendance == 1)
                                            <p class="green-bg cmn-tbl-btn">
                                                Present
                                            </p>
                                        @elseif($attendance->attendance == 2)
                                            <p class="cmn-tbl-btn yellow-bg">
                                                Late
                                            </p>
                                        @elseif($attendance->attendance == 3)
                                            <p class="red-bg cmn-tbl-btn">
                                                Absent
                                            </p>
                                        @else
                                            <p class="grey-bg cmn-tbl-btn">
                                                Half Day
                                            </p>
                                        @endif


                                    </td>
                                    <td class="purchase"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tablepagination">
                    <div class="tbl-pagination-inr">
                        @if ($data['attendance']->total() > 0)
                            <ul>
                                @if ($data['attendance']->onFirstPage())
                                    <li><span><img src="{{ asset('images/parent/arrow-left.svg') }}" alt="Icon"></span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $data['attendance']->previousPageUrl() }}">
                                            <img src="{{ asset('images/parent/arrow-left.svg') }}" alt="Icon">
                                        </a>
                                    </li>
                                @endif

                                @foreach ($data['attendance']->getUrlRange(1, $data['attendance']->lastPage()) as $page => $url)
                                    <li class="{{ $page == $data['attendance']->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($data['attendance']->hasMorePages())
                                    <li>
                                        <a href="{{ $data['attendance']->nextPageUrl() }}">
                                            <img src="{{ asset('images/parent/arrow-right.svg') }}" alt="Icon">
                                        </a>
                                    </li>
                                @else
                                    <li><span><img src="{{ asset('images/parent/arrow-right.svg') }}"
                                                alt="Icon"></span></li>
                                @endif
                            </ul>
                        @endif
                    </div>
                    <div class="pages-select">
                        @if ($data['attendance']->total() > 0)
                            <p>
                                Showing {{ $data['attendance']->firstItem() }} - {{ $data['attendance']->lastItem() }}
                                of {{ $data['attendance']->total() }} results
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard Body End -->
@endsection
