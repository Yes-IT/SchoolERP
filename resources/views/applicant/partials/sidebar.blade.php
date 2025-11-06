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

            {{-- <li class="{{ request()->routeIs('applicant.registration') ? 'active' : '' }}">
                <a href="{{ route('applicant.registration') }}">
                    <img src="{{ asset('student/images/sidebar-icon-4.svg') }}" alt="Sidebar Icon">
                    Registration Form
                </a>
            </li> --}}

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
@push('page_script')
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Find the search form in the dashboard body
        const searchForm = document.querySelector('.dsbdy-search-form');
 
        if (searchForm) {
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting traditionally
 
                const searchInput = searchForm.querySelector('input[type="text"]');
                const query = searchInput.value.trim().toLowerCase();
 
                if (!query) {
                    return; // Do nothing if search is empty
                }
 
                // Get all sidebar links
                const sidebarLinks = document.querySelectorAll('.sidebar-body ul li a');
                let found = false;
 
                for (const link of sidebarLinks) {
                    const linkText = link.textContent.trim().toLowerCase();
                    // Check if the link's text includes the search query
                    if (linkText.includes(query)) {
                        window.location.href = link.href; // Redirect to the found page
                        found = true;
                        break; // Stop after finding the first match
                    }
                }
 
                if (!found) {
                    alert('No page found matching your search.');
                }
            });
        }
    });
</script>
@endpush