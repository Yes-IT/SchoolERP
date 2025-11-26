<div class="sidebar">
    <div class="sidebar-head">
        <a href="dashboard.html" class="logo">
            <img src="{{ asset('staff') }}/assets/images/logo.png" alt="Logo">
        </a>
        <button class="sidebar-toggler"><i class="fa-solid fa-chevron-left"></i></button>
    </div>

    <div class="sidebar-body">
        <ul>
            <li class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                <a href="{{ route('staff.dashboard') }}">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-1.svg" alt="Sidebar Icon">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{route('staff.students.index')}}">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-2.svg" alt="Sidebar Icon">
                    Students
                </a>
            </li>
            <li>
                <a href="profile.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-2.svg" alt="Sidebar Icon">
                    My Profile
                </a>
            </li>
            <li class="{{ request()->routeIs('staff.attendance.index') ? 'active' : '' }}">
                <a href="{{ route('staff.attendance.index') }}">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-4.svg" alt="Sidebar Icon">
                    Attendance
                </a>
            </li>
            <li class="has-submenu active">
                <a href="javascript:void(0)" class="submenu-toggle">
                    <img src="{{asset('staff/assets/images/sidebar-icon-3.svg')}}" alt="Sidebar Icon">
                    <div class="myclasses">
                        My Classes
                        <img src="{{asset('staff/assets/images/dropdown-arrow.svg')}}" alt="arrow-down" class="downArrow" />
                    </div>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('staff.my-classes.class-schedule') }}">
                        <img src="{{asset('staff/assets/images/dot.svg')}}" class="dot" /> Class Schedule
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{ route('staff.my-classes.exam-schedule') }}">
                        <img src="{{asset('staff/assets/images/dot.svg')}}" class="dot" /> Exam Schedule
                        </a>
                    </li>
                </ul>
           </li>
            <li class="has-submenu">
                <a href="javascript:void(0)" class="submenu-toggle">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-3.svg" alt="Sidebar Icon">
                    <div class="myclasses">
                        Reports
                        <img src="{{ asset('staff') }}/assets/images/dropdown-arrow.svg" alt="arrow-down" class="downArrow">
                    </div>
                </a>
                <ul class="submenu">
                    <li class="active">
                        <a href="{{ route('staff.report.attendance.index') }}">
                            <img src="{{ asset('staff') }}/assets/images/dot.svg" class="dot"> Attendance Report
                        </a>
                    </li>
                    <li>
                        <a href="gradeReport.html">
                            <img src="{{ asset('staff') }}/assets/images/dot.svg" class="dot"> Grade Reports
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="apply-leaves.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-9.svg" alt="Sidebar Icon">
                    Apply Leave
                </a>
            </li>
            <li class="{{ request()->routeIs('staff.grade.index') ? 'active' : '' }}">
                <a href="{{ route('staff.grade.index') }}">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-7.svg" alt="Sidebar Icon">
                    Grades
                </a>
            </li>
            <li class="{{ request()->routeIs('staff.communicate.index') ? 'active' : '' }}">
                <a href="{{ route('staff.communicate.index') }}">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-8.svg" alt="Sidebar Icon">
                    Communicate
                </a>
            </li>
            <li>
                <a href="{{ route('staff.assignment.index') }}">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-5.svg" alt="Sidebar Icon">
                    Assignments
                </a>
            </li>
            <li>
                <a href="login.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-12.svg" alt="Sidebar Icon">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>