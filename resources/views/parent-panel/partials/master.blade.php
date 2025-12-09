<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ @globalAsset(setting('favicon')) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" name="url" id="url" value="{{ url('') }}">
    <input type="hidden" name="alert_title" id="alert_title" value="{{ ___('common.are_you_sure') }}">
    <input type="hidden" name="alert_subtitle" id="alert_subtitle"
        value="{{ ___('common.you_wont_be_able_to_revert_this') }}">
    <input type="hidden" name="alert_yes_btn" id="alert_yes_btn" value="{{ ___('common.yes_delete_it') }}">
    <input type="hidden" name="alert_cancel_btn" id="alert_cancel_btn" value="{{ ___('common.Cancel') }}">
    <meta name="keywords"
        content="admin, admin dashboard, admin template, parent, bootstrap, crm, laravel, laravel admin, web application">
    <meta name="description" content="{{ setting('application_name') }}">
    <!-- fabicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/regular.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <!-- slick slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">

    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ global_asset('parent') }}/css/style.css">
    <link rel="stylesheet" href="{{ global_asset('parent') }}/css/parent-panel.css">
    @stack('css')
</head>

<body>

    <div class="dashboard-main light-bg">
        <!-- start header -->
        @include('parent-panel.partials.sidebar')
        <div class="dashboard-body">
            @include('parent-panel.partials.header')
            @yield('content')
        </div>
    </div>
    {{-- theme mode switch --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="{{ global_asset('parent') }}/js/common.js"></script>

    @stack('script')
    <script>
        document.getElementById('select_student').addEventListener('change', function() {

            let studentId = this.value;

            fetch("{{ route('parent-panel-student.selectStudent') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        student_id: studentId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    location.reload();

                });

        });
    </script>

</body>

</html>
