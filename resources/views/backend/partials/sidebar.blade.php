<!-- Sidebar Begin -->

    <div class="sidebar">
        <div class="sidebar-head">
            <a href="{{route('dashboard')}}" class="logo">
                <img src="{{ asset('backend') }}/assets/images/new_images/logo.png" alt="Logo">
            </a>
            <button class="sidebar-toggler"><i class="fa-solid fa-chevron-left"></i></button>
        </div>
        <div class="sidebar-body">
            <ul>
                <li class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('backend') }}/assets/images/new_images/sidebar-icon-1.svg" alt="Sidebar Icon">
                        Dashboard
                    </a>
                </li>
                <li class="{{ request()->routeIs('student.*') ? 'active' : '' }}" >
                    <a href="{{route('student.index')}}">
                        <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-1.svg" alt="Sidebar Icon">
                        Student
                    </a>
                </li>
                <li class="{{ request()->routeIs('parent.*') ? 'active' : '' }}">
                    <a href="{{route('parent.index')}}">
                        <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-2.svg" alt="Sidebar Icon">
                        Parent
                    </a>
                </li>
                <li class="{{ request()->routeIs('teacher.*') ? 'active' : '' }}">
                    <a href="{{route('teacher.index')}}">
                        <img src="{{ asset('backend/assets/images/superadmin-panel/sidebar-icon-3.svg') }}" alt="Sidebar Icon">
                        Teacher
                    </a>
                </li>
                <li  class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <a href="{{route('classes.index')}}">
                        <img src="{{ asset('backend/assets/images/superadmin-panel/sidebar-icon-4.svg') }}" alt="Sidebar Icon">
                        Class
                    </a>
                </li>
                <li class="{{ request()->routeIs('applicant.*') ? 'active' : '' }}">
                    <a href="{{route('applicant.dashboard')}}">
                        <img src="{{ asset('backend/assets/images/new_images/superadmin-panel/sidebar-icon-5.svg') }}" alt="Sidebar Icon">
                        Applicant
                    </a>
                </li>

            <li class="menu-item-has-children {{ request()->routeIs('alumni_flow.*') ? 'active' : '' }}">
                <a href="{{ route('alumni_flow.index') }}">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-6.svg"
                        alt="Sidebar Icon">
                    Alumni
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('alumni_flow.index') }}">Alumni List</a></li>
                    <li><a href="{{ route('alumni_flow.recorded_class') }}">Recorded Classes</a></li>
                    <li><a href="{{ route('alumni_flow.alumni_gallery') }}">Gallery</a></li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('grade_flow.*') ? 'active' : '' }}">
                <a href="{{ route('grade_flow.index') }}">
                    <img src="{{ asset('backend/assets/images/superadmin-panel/sidebar-icon-7.svg') }}"
                        alt="Sidebar Icon">
                    Grade Flow
                </a>
            </li>

            <li
                class="menu-item-has-children {{ request()->routeIs('leave.student.index', 'leave.student.data') ? 'active' : '' }}">
                <a href="#">
                    <img src="{{ asset('backend/assets/images/new_images/superadmin-panel/sidebar-icon-8.svg') }}"
                        alt="Sidebar Icon">
                    Leave
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('leave.student.index') }}"> <img src="">Student </a></li>
                    <li><a href="{{ route('leave.teacher.index') }}"><img src="">Teacher</a></li>
                </ul>
            </li>

            <li
                class="menu-item-has-children {{ request()->routeIs('transcript.index', 'transcript.college.index') ? 'active' : '' }}">
                <a href="#">
                    <img src="{{ asset('backend/assets/images/new_images/superadmin-panel/sidebar-icon-8.svg') }}"
                        alt="Sidebar Icon">
                    Transcript
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('transcript.index') }}"> <img src="">Request Transcript </a></li>
                    <li><a href="{{ route('transcript.college.index') }}"><img src="">College</a></li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('superadmin.subject.*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.subject.index') }}">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-9.svg"
                        alt="Sidebar Icon">
                    Subject
                </a>
            </li>
            <li class="menu-item-has-children {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <a href="{{ route('alumni_flow.index') }}">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-10.svg"
                        alt="Sidebar Icon">
                    Attendance
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('attendance.index') }}">Attendance View</a></li>
                    <li><a href="{{ route('attendance.report') }}">Attendance Report</a></li>
                    <li><a href="{{ route('alumni_flow.alumni_gallery') }}">Attendance Submission Tracker</a></li>
                </ul>
            </li>

            <li>
                <a href="#url">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-11.svg"
                        alt="Sidebar Icon">
                    Assign Role
                </a>
            </li>
            <li class="{{ request()->routeIs('assignment.*') ? 'active' : '' }}">
                <a href="{{ route('assignment.index') }}">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-12.svg"
                        alt="Sidebar Icon">
                    Assignment
                </a>
            </li>

            <li class="{{ request()->routeIs('room_management.*') ? 'active' : '' }}">
                <a href="{{ route('room_management.index') }}">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-13.svg"
                        alt="Sidebar Icon">
                    Room
                </a>
            </li>

            <li>
                <a href="#url">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-14.svg"
                        alt="Sidebar Icon">
                    Fees
                </a>
            </li>
            <li class="{{ request()->routeIs('exam-schedule.*') ? 'active' : '' }}">
                <a href="{{ route('exam-schedule.index') }}">
                    <img src="{{ asset('backend/assets/images/superadmin-panel/sidebar-icon-13.svg') }}"
                        alt="Sidebar Icon">
                    Exam Schedule
                </a>
            </li>
            <li class="{{ request()->routeIs('report-management.index.*') ? 'active' : '' }}">
                <a href="{{ route('report-management.index') }}">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-16.svg" alt="Sidebar Icon">
                    Report Management
                </a>
            </li>
            <li>
                <a href="#url">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-17.svg"
                        alt="Sidebar Icon">
                    Dormitory
                </a>
            </li>
            <li>
                <a href="#url">
                    <img src="{{ asset('backend') }}/assets/images/new_images/superadmin-panel/sidebar-icon-18.svg"
                        alt="Sidebar Icon">
                    Notice Board
                </a>
            </li>
            <li>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="profile-expand-item">
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
<!-- End Of Sidebar -->
