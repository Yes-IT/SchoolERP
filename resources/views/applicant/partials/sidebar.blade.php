<div class="sidebar">
    <div class="sidebar-head">
        <a href="dashboard.html" class="logo">
            <img src="{{ asset('student/images/logo.png') }}" alt="Logo">
        </a>
        <button class="sidebar-toggler"><i class="fa-solid fa-chevron-left"></i></button>
    </div>
    <div class="sidebar-body">
        <ul>
            <li class="{{ request()->routeIs('applicant.process') ? 'active' : '' }}">
                <a href="{{ route('applicant.process') }}">
                    <img src="{{ asset('student/images/sidebar-icon-1.svg') }}" alt="Sidebar Icon">
                    Process
                </a>
            </li>

            <li class="{{ request()->routeIs('applicant.application') ? 'active' : '' }}">
                <a href="{{ route('applicant.application') }}">
                    <img src="{{ asset('student/images/sidebar-icon-2.svg') }}" alt="Sidebar Icon">
                    Application Form
                </a>
            </li>

            <li class="{{ request()->routeIs('applicant.interview') ? 'active' : '' }}">
                <a href="{{ route('applicant.interview') }}">
                    <img src="{{ asset('student/images/sidebar-icon-3.svg') }}" alt="Sidebar Icon">
                    Interview Details
                </a>
            </li>

            <li class="{{ request()->routeIs('applicant.registration') ? 'active' : '' }}">
                <a href="{{ route('applicant.registration') }}">
                    <img src="{{ asset('student/images/sidebar-icon-4.svg') }}" alt="Sidebar Icon">
                    Registration Form
                </a>
            </li>

            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="{{ asset('student/images/sidebar-icon-12.svg') }}" alt="Sidebar Icon">
                    Logout
                </a>
            </li>
        </ul>
    </div>

</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
