<div class="sidebar">
    <div class="sidebar-head">
        <a href="dashboard.html" class="logo">
            <img src="{{ asset('staff') }}/assets/images/logo.png" alt="Logo">
        </a>
        <button class="sidebar-toggler"><i class="fa-solid fa-chevron-left"></i></button>
    </div>

    <div class="sidebar-body">
        <ul>
            <li class="active">
                <a href="dashboard.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-1.svg" alt="Sidebar Icon">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="profile.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-2.svg" alt="Sidebar Icon">
                    My Profile
                </a>
            </li>
            <li>
                <a href="profile.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-2.svg" alt="Sidebar Icon">
                    Students
                </a>
            </li>
            <li class="classes">
                <a href="my-classes.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-3.svg" alt="Sidebar Icon">
                    <div class="myclasses">
                    My Classes <img src="{{ asset('staff') }}/assets/images/dropdown-arrow.svg" alt="arrow-down" class="downArrow" />
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('staff.attendance.index') }}">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-4.svg" alt="Sidebar Icon">
                    Attendance
                </a>
            </li>
            <li>
                <a href="my-attendance.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-5.svg" alt="Sidebar Icon">
                    Assignments
                </a>
            </li>
            <li class="classes">
                <a href="my-grades.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-6.svg" alt="Sidebar Icon">
                    <div class="myclasses">Reports <img src="{{ asset('staff') }}/assets/images/dropdown-arrow.svg" alt="arrow-down"
                        class="downArrow" />
                    </div>
                </a>
            </li>
            <li>
                <a href="my-fees.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-7.svg" alt="Sidebar Icon">
                    Grades
                </a>
            </li>
            <li>
                <a href="request-transcript.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-8.svg" alt="Sidebar Icon">
                    Communicate
                </a>
            </li>
            <li>
                <a href="apply-leaves.html">
                    <img src="{{ asset('staff') }}/assets/images/sidebar-icon-9.svg" alt="Sidebar Icon">
                    Apply Leave
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