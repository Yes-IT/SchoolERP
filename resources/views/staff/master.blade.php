<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <title>@yield('title', 'School Management System')</title>

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

    <!-- Modal Popup -->
    <div id="customPopup" class="popup-overlay">
    <div class="popup-box">
        <img src="{{ asset('staff') }}/assets/images/material-cancel.svg" class="cancelpopup" onclick="closeCustomPopup()" />
        
        <h2>Selection Session</h2>

        <!-- Year Dropdown -->
        <div class="form-row">
        <label class="form-label" for="customYear">Year</label>
        <div class="studentBtns">
                    <div class="dropdown-week">
                    <button class="subjectbox-session" onclick="toggleDropdowndash()">2024-2025<img
                        src="{{ asset('staff') }}/assets/images/dropdown-arrow.svg" alt="Icon"></button>
                    <ul class="dropdown-menu-dash">
                        <li>2021-2022</li>
                        <li class="active-week">2022-2023</li>
                        <li>2023-2024</li>
                        <li>2024-2025</li>
                    </ul>
                    </div>
                </div>
        </div>

        <!-- Year Status Dropdown -->
        <div class="form-row">
        <label class="form-label" for="customYearStatus">Year Status</label>
        <div class="custom-dropdown custom-year-status" id="customYearStatus">
            <div class="dropdown-selected">Shana Alef</div>
            <img src="{{ asset('staff') }}/assets/images/sessionarrow.svg" class="dropdown-arrow" />
            
            <h2>Selection Session</h2>

            <!-- Year Dropdown -->
            <div class="form-row">
                <label class="form-label" for="customYear">Year</label>
                <div class="studentBtns">
                    <div class="dropdown-week">
                    <button class="subjectbox-session" onclick="toggleDropdownsem()">First Semester<img
                        src="{{ asset('staff') }}/assets/images/dropdown-arrow.svg" alt="Icon"></button>
                    <ul class="dropdown-menu-sem">
                        <li>First Semester</li>
                        <li class="active-week">Second Semester</li>
                    
                    </ul>
                    </div>
                </div>
            </div>

            <!-- Year Status Dropdown -->
            <div class="form-row">
                <label class="form-label" for="customYearStatus">Year Status</label>
                <div class="custom-dropdown custom-year-status" id="customYearStatus">
                    <div class="dropdown-selected">Shana Alef</div>
                    <img src="./images/sessionarrow.svg" class="dropdown-arrow" />
                </div>
            </div>

            <!-- Semester Dropdown -->
            <div class="form-row">
                <label class="form-label" for="customSemester">Semester</label>
                <div class="studentBtns">
                    <div class="dropdown-week">
                        <button class="subjectbox-session" onclick="toggleDropdownsem()">
                            First Semester
                            <img src="./images/dropdown-arrow.svg" alt="Icon">
                        </button>
                        <ul class="dropdown-menu-sem">
                            <li>First Semester</li>
                            <li class="active-week">Second Semester</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Dashboard -->

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

    @include('staff.partials.ajax-alert')

    @stack('script')
</body>
</html>