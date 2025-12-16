<style>
    select {
        background-color: var(--primary-clr);
        color: white;

    }

    label.error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .search-suggestions-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        border-radius: 0 0 5px 5px;
    }

    .search-suggestions-list ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .search-suggestions-list ul li a {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
    }

    .search-suggestions-list ul li a:hover {
        background-color: #f5f5f5;
    }
</style>
<div class="dashboard-body-head">
    <div class="dsbdy-head-left">
        <form class="dsbdy-search-form">
            <div class="input-grp search-field" style="position: relative;">
                <input type="text" id="page-search-input" placeholder="Search Page" autocomplete="off">
                <input type="submit" value="Search">
                <div id="search-suggestions" class="search-suggestions-list" style="display: none;">
                    <ul>
                        <!-- Suggestions will be populated by JavaScript -->
                    </ul>
                </div>
            </div>
        </form>
    </div>

    {{-- {{ Auth::id() }} --}}
    <div class="dsbdy-head-right">
        <div class="input-grp m-0">
            <select id="select_student">

                
                @if($students->isNotEmpty())
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" 
                            {{ session('selected_student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->first_name }} (ID-{{ $student->id }})
                        </option>
                    @endforeach
                @else

                    <option disabled>No student found</option>
                @endforelse 
            </select>


            <div class="student-info-popup" id="studentInfoPopup">
                <h3>View Student Information</h3>
                <p>
                    Once you've selected a student, use this panel to explore their academic records,
                    attendance, grades, and more.
                    Each section gives you detailed insights tailored to the selected student.
                </p>
                <button class="gotitbtn">Got it</button>
            </div>
        </div>
        <button class="tgl-flscrn" onclick="toggleFullScreen()" aria-label="Toggle fullscreen">
            <img src="{{ asset('student/images/fullscreen-toggler-icon.svg') }}" alt="Icon">
        </button>

        <button id="alertToggler" class="alert-toggler" aria-label="Toggle Alerts" onclick="toggleAlertPopup()">
            <img src="{{ global_asset('parent') }}/images/parent-panel/bell-icon.svg" alt="Alert Icon">
        </button>

    <!-- Popup Box -->
    @php
        $absentChildren = getAbsentChildrenToday();
    @endphp

    @if(count($absentChildren) > 0)

        <div id="alertPopup" class="alert-popup">
            <div class="alert-popup-content">
                <div class="alertDiv">
                    <button class="alert-close" onclick="closeAlertPopup()">
                        <img src="{{ global_asset('parent') }}/images/IconBase.svg" alt="Close" />
                    </button>
                    <div class="headingAlert">
                        <img src="{{ global_asset('parent') }}/images/alert.svg" alt="Alert" />
                        <p>Alert: Child{{ count($absentChildren) > 1 ? 'ren' : '' }} Absent Today</p>
                    </div>
                </div>

                <p class="alertTxt">
                    Your child{{ count($absentChildren) > 1 ? 'ren' : '' }},
                    <strong>{{ implode(', ', $absentChildren) }}</strong>,
                    {{ count($absentChildren) > 1 ? 'have' : 'has' }} been marked absent today, {{ now()->format('d/m/Y') }}.
                </p>

                <p class="alertTxt">
                    Please contact the school if you have any questions or need to provide an excuse.
                </p>
            </div>
        </div>

    @endif
        
        <div class="profile-ctrl">
            <button class="profile-ctrl-toggler">
                <div class="pr-pic">
                    @if (!empty($upload->path))
                        <img src="{{ asset($upload->path) }}" alt="Profile Photo">
                    @else
                        <img src="{{ asset('backend/assets/images/new-version.jpg') }}" alt="Default Profile Image">
                    @endif
                </div>
                <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="pr-ctrl-menu">
                <ul>
                    <li><a href="{{ route('parent-panel.profile') }}">My Profile</a></li>
                    <li><a href="{{ route('parent-panel.password-update') }}">Change Password</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('.dsbdy-search-form');
        const searchInput = document.getElementById('page-search-input');
        const suggestionsContainer = document.getElementById('search-suggestions');
        const suggestionsList = suggestionsContainer.querySelector('ul');
        const sidebarLinks = document.querySelectorAll('.sidebar-body ul li a');
        let allPages = [];

        // 1. Populate suggestions and store page data
        sidebarLinks.forEach(link => {
            const linkText = link.textContent.trim();
            if (linkText.toLowerCase() !== 'logout') {
                allPages.push({
                    text: linkText,
                    href: link.href
                });
                const listItem = document.createElement('li');
                const anchor = document.createElement('a');
                anchor.href = link.href;
                anchor.textContent = linkText;
                listItem.appendChild(anchor);
                suggestionsList.appendChild(listItem);
            }
        });

        // 2. Show/hide suggestions on focus/blur
        searchInput.addEventListener('focus', () => {
            suggestionsContainer.style.display = 'block';
        });

        document.addEventListener('click', (event) => {
            if (!searchForm.contains(event.target)) {
                suggestionsContainer.style.display = 'none';
            }
        });

        // 3. Filter suggestions as user types
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.trim().toLowerCase();
            const listItems = suggestionsList.querySelectorAll('li');
            listItems.forEach(item => {
                const itemText = item.textContent.trim().toLowerCase();
                if (itemText.includes(query)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // 4. Handle form submission (typing and clicking search)
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const query = searchInput.value.trim().toLowerCase();
            if (!query) return;

            let found = false;
            for (const page of allPages) {
                if (page.text.toLowerCase().includes(query)) {
                    window.location.href = page.href;
                    found = true;
                    break;
                }
            }

            if (!found) {
                alert('No page found matching your search.');
            }
        });
    });
</script>
