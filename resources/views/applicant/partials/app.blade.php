<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <title>School Management System | Notifications</title>

    <!-- fabicon -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="{{ asset('student/css/style.css') }}">
    <style>
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
</head>

<body>
    <div class="dashboard-main light-bg">
        @include('applicant.partials.sidebar')
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('student/js/common.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                    allPages.push({ text: linkText, href: link.href });
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
            searchForm.addEventListener('submit', function (event) {
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
 
    @stack('script')
</body>

</html>
