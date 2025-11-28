<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <title>@yield('title', 'School Management System')</title>
 <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- fabicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/regular.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <!-- slick slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- custom -->
    <link rel="stylesheet" href="{{ asset('staff/assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

     <!-- ckeditor cdn -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    
    @stack('styles')
</head>

<body>
    <!-- Dashboard Begin -->
    <div class="dashboard-main light-bg">
        <!-- start sidebar -->
        @include('staff.partials.sidebar')
        <!-- end sidebar -->

        <div class="dashboard-body">
            <!-- start header -->
            @include('staff.partials.header')
            <!-- end header -->

            <!-- start main content -->
            @yield('content')
            <!-- end main content -->
        </div>
    </div>

    <!-- Session Selection Modal (Your Exact Design) -->
    <div id="sessionModal" class="popup-overlay" style="display:none;">
        <div class="popup-box">
            <img src="{{ asset('staff') }}/assets/images/material-cancel.svg" class="cancelpopup" onclick="closeSessionModal()">

            <h2>Selection Semester</h2>

            <!-- Year Dropdown -->
            <div class="form-row">
                <label class="form-label">Year</label>
                <div class="studentBtns">
                    <div class="dropdown-week">
                        <button type="button" class="subjectbox-session" id="yearBtn">
                            {{ currentSession()->session_name ?? '2024-2025' }}
                            <img src="{{ asset('staff') }}/assets/images/sessionarrow.svg" alt="Icon">
                        </button>
                        <ul class="dropdown-menu-dash" id="yearList">
                            @foreach(\App\Models\Session::where('status', 1)->orderByDesc('end_date')->get() as $s)
                                <li data-id="{{ $s->id }}" 
                                    class="{{ currentSession()->session_id == $s->id ? 'active-week' : '' }}">
                                    {{ $s->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Year Status Dropdown -->
            <div class="form-row">
                <label class="form-label">Year Status</label>
                <div class="studentBtns">
                    <div class="dropdown-week">
                        <button type="button" class="subjectbox-session" id="statusBtn">
                            {{ currentSession()->year_status_name ?? 'Shana Alef' }}
                            <img src="{{ asset('staff') }}/assets/images/sessionarrow.svg" alt="Icon">
                        </button>
                        <ul class="dropdown-menu-dash" id="statusList">
                            @foreach(\App\Models\Academic\YearStatus::all() as $ys)
                                <li data-id="{{ $ys->id }}" 
                                    class="{{ currentSession()->year_status_id == $ys->id ? 'active-week' : '' }}">
                                    {{ $ys->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Semester Dropdown -->
            <div class="form-row">
                <label class="form-label">Semester</label>
                <div class="studentBtns">
                    <div class="dropdown-week">
                        <button type="button" class="subjectbox-session" id="semesterBtn">
                            {{ currentSession()->semester_name ?? 'First Semester' }}
                            <img src="{{ asset('staff') }}/assets/images/sessionarrow.svg" alt="Icon">
                        </button>
                        <ul class="dropdown-menu-dash" id="semesterList">
                            @foreach(\App\Models\Academic\Semester::where('status', 1)->orderBy('id')->get() as $sem)
                                <li data-id="{{ $sem->id }}" 
                                    class="{{ currentSession()->semester_id == $sem->id ? 'active-week' : '' }}">
                                    {{ $sem->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Modal -->

    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <script src="{{ global_asset('staff/assets/js/common.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    @include('staff.partials.ajax-alert')

    @stack('script')

    <!-- Session Modal Logic -->
    <script>
        function closeSessionModal() {
            document.getElementById("sessionModal").style.display = "none";
        }

        function openSessionModal() {
            document.getElementById("sessionModal").style.display = "flex";
        }

        // Auto-save when any option is selected
        function saveSession() {
            const yearId     = document.querySelector('#yearList .active-week')?.dataset.id;
            const statusId   = document.querySelector('#statusList .active-week')?.dataset.id;
            const semesterId = document.querySelector('#semesterList .active-week')?.dataset.id;

            fetch('{{ route("staff.set-session") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: yearId,
                    semester_id: semesterId,
                    year_status_id: statusId
                })
            });
        }

        // Open/close dropdowns
        document.querySelectorAll('.subjectbox-session').forEach(btn => {
            btn.onclick = function(e) {
                e.stopPropagation();
                const menu = this.nextElementSibling;
                document.querySelectorAll('.dropdown-menu-dash').forEach(m => m.style.display = 'none');
                menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            };
        });

        // Click on any list item
        document.querySelectorAll('.dropdown-menu-dash li').forEach(li => {
            li.onclick = function() {
                const menu = this.parentElement;
                const btn = menu.previousElementSibling;

                // Update button text
                btn.innerHTML = this.textContent + ' <img src="{{ asset('staff') }}/assets/images/dropdown-arrow.svg" alt="Icon">';

                // Set active
                menu.querySelectorAll('li').forEach(l => l.classList.remove('active-week'));
                this.classList.add('active-week');

                // Close & save
                menu.style.display = 'none';
                saveSession();
            };
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', e => {
            if (!e.target.closest('.dropdown-week')) {
                document.querySelectorAll('.dropdown-menu-dash').forEach(m => m.style.display = 'none');
            }
        });

        // Show modal only if no session is set
        document.addEventListener('DOMContentLoaded', () => {
            @if(! session()->has('staff_active_session'))
                document.getElementById('sessionModal').style.display = 'flex';
            @endif
        });
    </script>


</body>
</html>