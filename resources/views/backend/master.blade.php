<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>School Management System | SuperAdmin | Students | Dashboard</title>

    <!-- fabicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../../favicon.ico">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/regular.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css">
    
    <!-- slick slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
 
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ global_asset('backend') }}/assets/css/style_html.css">
    <link rel="stylesheet" href="{{ global_asset('backend') }}/assets/css/superadmin_html.css"> --}}

    <link rel="stylesheet" href="{{ global_asset('backend') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ global_asset('backend') }}/assets/css/superadmin.css">

</head>

<body>
    <!-- Dashboard Begin -->
    <div class="dashboard-main light-bg">
        <!-- start sidebar -->
        @include('backend.partials.sidebar')
        <!-- end sidebar -->

      <div class="dashboard-body">

            <!-- start header -->
            @include('backend.partials.header')
            <!-- end header -->

            <!-- start main content -->
            @yield('content')
            <!-- end main content -->
            
        </div>
    </div>
    <!-- End Of Dashboard -->

    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <script src="{{ global_asset('backend') }}/assets/js/common.js"></script>

        {{-- theme mode switch --}}
    <script src="{{ global_asset('backend') }}/assets/js/theme.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/popper.min.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/jquery-3.6.0.min.js"></script>

    @if (findDirectionOfLang() == 'rtl')
        <script src="{{ global_asset('backend') }}/assets/js/__dir.js"></script>
    @endif

    <script src="{{ global_asset('backend') }}/assets/js/semantic.min.js"></script>
    <!-- Metis menu for sidebar  -->
    <script src="{{ global_asset('backend') }}/assets/js/metisMenu.min.js"></script>
    <!-- jvectormap js -->
    <script src="{{ global_asset('backend/vendors/jvectormap/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ global_asset('backend/vendors/jvectormap/js/jquery-jvectormap-us-merc-en.js') }}"></script>
    {{-- Chart --}}
    <script src="{{ global_asset('backend') }}/vendors/apexchart/js/apexcharts.min.js"></script>
    <script src="{{ global_asset('backend') }}/vendors/chartjs/js/chart.min.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/ot-charts.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/datepicker.min.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/datepicker.js"></script>
    {{-- All Plugin js --}}
    <script src="{{ global_asset('backend') }}/assets/js/plugin.js"></script>
    <!-- Vendor JS end  -->
    <script src="{{ global_asset('backend') }}/assets/js/main.js"></script>
    {{-- Custom Js --}}
    <script src="{{ global_asset('backend') }}/assets/js/fees-master.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/custom.js"></script>


    <script src="{{ global_asset('backend') }}/vendors/summernote/summernote-lite.min.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/daterangepicker.min.js"></script>
    <script src="{{ global_asset('backend') }}/assets/js/fullcalendar.js"></script>



    {{-- alert message --}}
    @include('backend.partials.alert-message')
    {{-- delete method --}}
    @stack('script')

    @include('pushnotification::script')

    @if (hasModule('MultiBranch'))
        <script>
            $(document).ready(function() {
                $('#branchId').on('change', function() {
                    let selectedValue = $(this).val();

                    if (selectedValue) {
                        $.ajax({
                            url: '{{ route('switch-branch') }}',
                            type: 'GET',
                            data: {
                                branch_id: selectedValue
                            },
                            success: function(response) {
                                window.location.reload();
                            },
                            error: function(xhr, status, error) {
                                window.location.reload();
                            }
                        });
                    } else {
                        $('#output').text('Please select a valid option.');
                    }
                });
            });
        </script>
    @endif

</body>

</html>
