<!-- Sidebar Begin -->
<div class="sidebar">
    <div class="sidebar-head">
        <a href="dashboard.html" class="logo">
            <img src="{{asset('student/images/logo.png')}}" alt="Logo">
        </a>
        <button class="sidebar-toggler"><i class="fa-solid fa-chevron-left"></i></button>
    </div>
    <div class="sidebar-body">
        <ul>
            <li class="{{ Request::is('student_dashboard') ? 'active' : '' }}">
                <a href="{{route('student.dashboard')}}">
                    <img src="{{asset('student/images/sidebar-icon-1.svg')}}" alt="Sidebar Icon">
                    Dashboard
                </a>
            </li>
            <li class="{{ Request::is('student_profile') ? 'active' : '' }}">
                <a href="{{route('student.profile')}}">
                    <img src="{{asset('student/images/sidebar-icon-2.svg')}}" alt="Sidebar Icon">
                    My Profile
                </a>
            </li>
            <li class="{{ Request::is('student_classes') ? 'active' : '' }}">
                <a href="{{route('student.classes')}}">
                    <img src="{{asset('student/images/sidebar-icon-3.svg')}}" alt="Sidebar Icon">
                    My Classes
                </a>
            </li>
            <li class="{{ Request::is('student_assignment') ? 'active' : '' }}">
                <a href="{{route('student.assignment')}}">
                    <img src="{{asset('student/images/sidebar-icon-4.svg')}}" alt="Sidebar Icon">
                    My Assignments
                </a>
            </li>
            <li class="{{ Request::is('student_attendance') ? 'active' : '' }}">
                <a href="{{route('student.attendance')}}">
                    <img src="{{asset('student/images/sidebar-icon-5.svg')}}" alt="Sidebar Icon">
                    My Attendance
                </a>
            </li>
            <li class="{{ Request::is('student_grades') ? 'active' : '' }}">
                <a href="{{route('student.grades')}}">
                    <img src="{{asset('student/images/sidebar-icon-6.svg')}}" alt="Sidebar Icon">
                    My Grades
                </a>
            </li>
            <li class="{{ Request::is('student_fees') ? 'active' : '' }}">
                <a href="{{route('student.fees')}}">
                    <img src="{{asset('student/images/sidebar-icon-7.svg')}}" alt="Sidebar Icon">
                    My Fees
                </a>
            </li>
            <li class="{{ Request::is('student_request_transcript') ? 'active' : '' }}">
                <a href="{{route('student.request_transcript')}}">
                    <img src="{{asset('student/images/sidebar-icon-8.svg')}}" alt="Sidebar Icon">
                    Request Transcript
                </a>
            </li>
            <li class="{{ Request::is('student_apply_leave') ? 'active' : '' }}">
                <a href="{{route('student.apply_leave')}}">
                    <img src="{{asset('student/images/sidebar-icon-9.svg')}}" alt="Sidebar Icon">
                    Apply Leaves (to admin)
                </a>
            </li>
            <li class="{{ Request::is('student_notice_board') ? 'active' : '' }}">
                <a href="{{route('student.notice_board')}}">
                    <img src="{{asset('student/images/sidebar-icon-10.svg')}}" alt="Sidebar Icon">
                    Notice Board
                </a>
            </li>
            <li class="{{ Request::is('student_study_material') ? 'active' : '' }}">
                <a href="{{route('student.study_material')}}">
                    <img src="{{asset('student/images/sidebar-icon-11.svg')}}" alt="Sidebar Icon">
                    Study Material
                </a>
            </li>
            <li class="{{ Request::is('student_late_curfew_request') ? 'active' : '' }}">
                <a href="{{route('student.late_curfew_request')}}">
                    <img src="{{asset('student/images/clock-icon.svg')}}" alt="Sidebar Icon">
                    Late Curfew Request
                </a>
            </li>
            <li>
                <a href="{{route('student.logout')}}">
                    <img src="{{asset('student/images/sidebar-icon-12.svg')}}" alt="Sidebar Icon">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End Of Sidebar -->
