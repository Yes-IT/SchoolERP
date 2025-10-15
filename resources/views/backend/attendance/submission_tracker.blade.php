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
                    <li>Attendance Submission Tracker</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Select Criteria</h2>
                    </div>
                    <div class="atndnc-filter student-filter">
                        <form method="POST" action="{{ route('parent.search') }}">
                            @csrf
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options multi-input-grp grp-3">
                                    <div class="input-grp">
                                        <select id="ParentyearFilter" name="year">
                                            <option value="">Select Year</option>
                                            @foreach(range(date('Y'), 2000) as $year)
                                                @php
                                                    $academicYear = $year . '-' . ($year + 1);
                                                @endphp
                                                <option value="{{ $academicYear }}" {{ request('year') == $academicYear ? 'selected' : '' }}>
                                                    {{ $academicYear }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="year_status">
                                            <option value="">Select Year Status</option>
                                            <option value="active" {{ request('year_status') == 'active' ? 'selected' : '' }}>active</option>
                                            <option value="inactive" {{ request('year_status') == 'inactive' ? 'selected' : '' }}>inactive</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="year_status">
                                            <option value="">Select Semester</option>
                                            <option value="active" {{ request('year_status') == 'active' ? 'selected' : '' }}>active</option>
                                            <option value="inactive" {{ request('year_status') == 'inactive' ? 'selected' : '' }}>inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="atndnc-filter-options multi-input-grp grp-3">
                                    <div class="input-grp">
                                        <input type="date" placeholder="select month">
                                    </div>
                                </div>

                                <button type="submit" class="btn-search">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ds-cmn-table-wrp">
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Attendance Submission Tracker</h2>
                        </div>
                    </div>
                    <div class="ds-cmn-tble count-row">
                        <table style="min-width:auto ! important;">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>
                                    <th class="purchase">Class</th>
                                    <th class="purchase">Subject</th>
                                    <th class="purchase">Teacher Name</th>
                                    <th class="purchase">Class Time</th>
                                    <th class="purchase">Room No</th>
                                    <th class="purchase">Submission Status</th>
                                    <th class="purchase">Submission Time</th>
                                    <th class="purchase">Attendence View</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <tr>
                                    <td class="serial">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase"><div class="cmn-tbl-btn red-bg">Pending</div></td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">
                                        <a class="view-attachment-btn" href="http://saserp.tgastaging.com/student/show/32">
                                            <img src="http://saserp.tgastaging.com/images/parent/eye-white.svg" alt="Eye Icon"> 
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="serial">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">1</td>
                                    <td class="purchase"><div class="cmn-tbl-btn green-bg">Submitted</div></td>
                                    <td class="purchase">1</td>
                                    <td class="purchase">
                                        <a class="view-attachment-btn" href="http://saserp.tgastaging.com/student/show/32">
                                            <img src="http://saserp.tgastaging.com/images/parent/eye-white.svg" alt="Eye Icon"> 
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard Body End -->
@endsection