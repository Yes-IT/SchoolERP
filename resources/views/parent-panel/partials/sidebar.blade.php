<div class="sidebar">
    <div class="sidebar-head">
        <a href="{{ route('parent-panel-dashboard.index') }}" class="logo">
            <img src="{{ global_asset('parent') }}/images/logo.png" alt="Logo">
        </a>
        <button class="sidebar-toggler"><i class="fa-solid fa-chevron-left"></i></button>
    </div>

    <div class="sidebar-body">
        <ul>
            <li class="{{ request()->routeIs('parent-panel-dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-dashboard.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-1.svg" alt="">
                    Dashboard
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel.profile*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel.profile') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-2.svg" alt="">
                    My Profile
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-class-routine*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-class-routine.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-3.svg" alt="">
                    Classes
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-assignment*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-assignment.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-4.svg" alt="">
                    Assignments
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-attendance*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-attendance.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-5.svg" alt="">
                    Attendance
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-grades*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-grades.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-6.svg" alt="">
                    Grades
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-fees*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-fees.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-7.svg" alt="">
                    Tuition Fees
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-transcript*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-transcript.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-8.svg" alt="">
                    Request Transcript
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-extendedLeaves*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-extendedLeaves.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-9.svg" alt="">
                    Extended Leaves
                </a>
            </li>

            <li class="{{ request()->routeIs('parent-panel-notices*') ? 'active' : '' }}">
                <a href="{{ route('parent-panel-notices.index') }}">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-10.svg" alt="">
                    Notice Board
                </a>
            </li>

            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="{{ global_asset('parent') }}/images/sidebar-icon-12.svg" alt="">
                    Logout
                </a>

                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>