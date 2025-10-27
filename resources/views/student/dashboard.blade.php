@extends('student.Layout.app')

@section('content')
<!-- Dashboard Begin -->
<div class="ds-bdy-content-wrp">
    <div class="ds-bdy-content">
        <div class="dsbdy-cmn-card w55">
            <div class="dsbdy-student-card">
                <div class="dsbdy-student-img">
                    @if(!empty($upload->path))
                    <img src="{{ asset($upload->path) }}" alt="Profile Photo">
                    @else
                    <img src="{{ asset('backend/assets/images/new-version.jpg') }}" alt="Default Profile Image">
                    @endif
                </div>
                <div class="dsbdy-student-content">
                    <h1>Welcome, <span class="dsbdy-student-nm">{{ "$student->first_name $student->last_name" }}</span> Keep Going</h1>
                    <p>Stay on top of your studies with instant access to attendance, assignments, grades,
                        and class schedules.Everything you need for a smooth academic journey — all in one
                        place.</p>
                </div>
            </div>
        </div>

        <div class="dsbdy-cmn-card w45">
            <div class="dsbdycmncd-head">
                <h2>Notice Board</h2>
            </div>
            <div class="dsbdycmncd-body">
                <div class="notice-list">
                    <ul>
                        <li><a href="notice-board.html"><img src="{{asset('student/images/envelope.svg')}}"
                                    alt="Icon">
                                Upcoming Assignment (04/01/2025)</a></li>
                        <li><a href="notice-board.html"><img src="{{asset('student/images/notice-icon-2.svg')}}"
                                    alt="Icon">
                                Change of Schedule (04/01/2025)</a></li>
                        <li><a href="notice-board.html"><img src="{{asset('student/images/envelope.svg')}}"
                                    alt="Icon">
                                Upcoming Activities (04/01/2025)</a></li>
                        <li><a href="notice-board.html"><img src="{{asset('student/images/envelope.svg')}}"
                                    alt="Icon">
                                Miscellaneous (04/01/2025)</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="dsbdy-cmn-card w65">
            <div class="dsbdycmncd-head">
                <h2 class="df">
                    Attendance <span class="green-txt">(90.00%)</span>
                    <div class="ibtn">
                        <button type="button" class="ibtn-icon">
                            <img src="{{asset('student/images/i-icon.svg')}}" alt="Icon">
                        </button>
                        <div class="ibtn-info sm mdl p15 txt-black">
                            <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                <img src="{{asset('student/images/fa-times.svg')}}" alt="icon">
                            </button>
                            <h3 class="mb-2">Note:</h3>
                            <p>For details, check <a href="my-attendance.html" class="txt-primary">My
                                    Attendance</a></p>
                        </div>
                    </div>
                </h2>
            </div>
            <div class="dsbdycmncd-body">
                <div class="dsbdy-cmn-table attendance-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Subject (320)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">40%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject (240)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">30%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject (120)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">75%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject (320)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">75%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject (320)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">40%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject (240)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">30%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject (120)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">75%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject (320)</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-txt">75%</div>
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="dsbdy-cmn-card w35">
            <div class="dsbdycmncd-head">
                <h2>Upcoming Class</h2>
            </div>
            <div class="dsbdycmncd-body">
                <div class="dsbdy-cmn-table table-secondary">
                    <table>

                        <tbody>
                            <tr>
                                <td>
                                    <div class="ds-class-card">
                                        <div class="ds-cls-left">
                                            <div class="ds-class-img">
                                                <img src="{{asset('student/images/class-img.png')}}"
                                                    alt="Image">
                                            </div>
                                            <div class="ds-class-left-content">
                                                <p>English (210)</p>
                                                <h3>Jason Sharlton</h3>
                                            </div>
                                        </div>
                                        <div class="ds-cls-right">
                                            <div class="ds-cls-info">
                                                <div class="dscls-room-no">Room No.:12</div>
                                                <div class="dscls-timing">9:00 AM-09:45 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ds-class-card">
                                        <div class="ds-cls-left">
                                            <div class="ds-class-img">
                                                <img src="{{asset('student/images/class-img.png')}}"
                                                    alt="Image">
                                            </div>
                                            <div class="ds-class-left-content">
                                                <p>English (210)</p>
                                                <h3>Jason Sharlton</h3>
                                            </div>
                                        </div>
                                        <div class="ds-cls-right">
                                            <div class="ds-cls-info">
                                                <div class="dscls-room-no">Room No.:12</div>
                                                <div class="dscls-timing">9:00 AM-09:45 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ds-class-card">
                                        <div class="ds-cls-left">
                                            <div class="ds-class-img">
                                                <img src="{{asset('student/images/class-img.png')}}"
                                                    alt="Image">
                                            </div>
                                            <div class="ds-class-left-content">
                                                <p>English (210)</p>
                                                <h3>Jason Sharlton</h3>
                                            </div>
                                        </div>
                                        <div class="ds-cls-right">
                                            <div class="ds-cls-info">
                                                <div class="dscls-room-no">Room No.:12</div>
                                                <div class="dscls-timing">9:00 AM-09:45 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ds-class-card">
                                        <div class="ds-cls-left">
                                            <div class="ds-class-img">
                                                <img src="{{asset('student/images/class-img.png')}}"
                                                    alt="Image">
                                            </div>
                                            <div class="ds-class-left-content">
                                                <p>English (210)</p>
                                                <h3>Jason Sharlton</h3>
                                            </div>
                                        </div>
                                        <div class="ds-cls-right">
                                            <div class="ds-cls-info">
                                                <div class="dscls-room-no">Room No.:12</div>
                                                <div class="dscls-timing">9:00 AM-09:45 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ds-class-card">
                                        <div class="ds-cls-left">
                                            <div class="ds-class-img">
                                                <img src="{{asset('student/images/class-img.png')}}"
                                                    alt="Image">
                                            </div>
                                            <div class="ds-class-left-content">
                                                <p>English (210)</p>
                                                <h3>Jason Sharlton</h3>
                                            </div>
                                        </div>
                                        <div class="ds-cls-right">
                                            <div class="ds-cls-info">
                                                <div class="dscls-room-no">Room No.:12</div>
                                                <div class="dscls-timing">9:00 AM-09:45 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ds-class-card">
                                        <div class="ds-cls-left">
                                            <div class="ds-class-img">
                                                <img src="{{asset('student/images/class-img.png')}}"
                                                    alt="Image">
                                            </div>
                                            <div class="ds-class-left-content">
                                                <p>English (210)</p>
                                                <h3>Jason Sharlton</h3>
                                            </div>
                                        </div>
                                        <div class="ds-cls-right">
                                            <div class="ds-cls-info">
                                                <div class="dscls-room-no">Room No.:12</div>
                                                <div class="dscls-timing">9:00 AM-09:45 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="dsbdy-cmn-card w65">
            <div class="dsbdycmncd-head">
                <h2>Student Fees</h2>
            </div>
            <div class="dsbdycmncd-body">
                <div class="dsbdy-cmn-table tbl-text-left tbl-text-primary">
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>21/12/2024</td>
                                <td>--</td>
                                <td><span class="green-txt">Uniform</span></td>
                                <td><span class="green-txt">Upcoming</span></td>
                                <td>$7,000</td>
                            </tr>
                            <tr>
                                <td>21/12/2024</td>
                                <td>--</td>
                                <td><span class="green-txt">Uniform</span></td>
                                <td><span class="green-txt">Upcoming</span></td>
                                <td>$7,000</td>
                            </tr>
                            <tr>
                                <td>21/12/2024</td>
                                <td>--</td>
                                <td><span class="green-txt">Uniform</span></td>
                                <td><span class="green-txt">Upcoming</span></td>
                                <td>$7,000</td>
                            </tr>
                            <tr>
                                <td>21/12/2024</td>
                                <td>--</td>
                                <td><span class="green-txt">Uniform</span></td>
                                <td><span class="green-txt">Upcoming</span></td>
                                <td>$7,000</td>
                            </tr>
                            <tr>
                                <td>21/12/2024</td>
                                <td>--</td>
                                <td><span class="green-txt">Uniform</span></td>
                                <td><span class="green-txt">Upcoming</span></td>
                                <td>$7,000</td>
                            </tr>
                            <tr>
                                <td>21/12/2024</td>
                                <td>--</td>
                                <td><span class="green-txt">Uniform</span></td>
                                <td><span class="green-txt">Upcoming</span></td>
                                <td>$7,000</td>
                            </tr>
                            <tr>
                                <td>21/12/2024</td>
                                <td>--</td>
                                <td><span class="green-txt">Uniform</span></td>
                                <td><span class="green-txt">Upcoming</span></td>
                                <td>$7,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="dsbdy-cmn-card w35">
            <div class="dsbdycmncd-head">
                <h2>Teachers List</h2>
            </div>
            <div class="dsbdycmncd-body">
                <div class="dsbdy-cmn-table table-secondary teachers-tbl">
                    <table>
                        <tbody>
                            @forelse($staff as $member)
                            <tr>
                                <td>
                                    <div class="ds-class-card">
                                        <div class="ds-class-img">
                                            @if(!empty($member->image))
                                            <img src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                                            @else
                                            <img src="{{ asset('student/images/teacher-img.png') }}" alt="Default Image">
                                            @endif
                                        </div>
                                        <div class="ds-class-left-content">
                                            <h3 class="df">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                                <div class="ibtn">
                                                    <button type="button" class="ibtn-icon">
                                                        <img src="{{ asset('student/images/i-icon.svg') }}" alt="Icon">
                                                    </button>
                                                    <div class="ibtn-info sm mdl p15">
                                                        <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                                            <img src="{{ asset('student/images/fa-times.svg') }}" alt="icon">
                                                        </button>
                                                        <p>Email Id:
                                                            <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                                                        </p>
                                                        <p>Phone Number:
                                                            <a href="tel:{{ $member->phone }}">{{ $member->phone }}</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </h3>
                                            @if(!empty($member->subject))
                                            <p>{{ $member->subject }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>No teachers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Dashboard -->
@endsection

@push('page_script')

@endpush