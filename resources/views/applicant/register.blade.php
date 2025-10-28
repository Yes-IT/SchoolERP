<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <title>School Management System | Login</title>

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

    <link rel="stylesheet" href="{{ asset('student/css/style.css') }}">
</head>

<body>
    <div class="login-flow has-texture">
        <div class="container">
            <div class="textures">
                <img src="{{ asset('student/images/login-flow-shape-1.png') }}" alt="Image"
                    class="texture-1 texture">
                <img src="{{ asset('student/images/login-flow-shape-2.png') }}" alt="Image"
                    class="texture-2 texture">
            </div>
            <div class="login-flow-inr">
                <div class="row">
                    <div class="login-flow-left-wrp col-lg-6">
                        <div class="login-panel-outer">
                            <div class="logo">
                                <img src="{{ asset('student/images/logo.png') }}" alt="Logo">
                            </div>
                            <div class="login-panel">
                                <h2 class="login-heading">Create Account</h2>
                                <form id="login-form" method="post" action="{{ route('register') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" id="name" name="ma,e" placeholder="Full Name *"
                                            required />
                                    </div>
                                    <div class="input-group">
                                        <input type="email" id="email" name="email"
                                            placeholder="Email Address *" required />
                                    </div>
                                    <div class="input-group password-wrapper">
                                        <input type="password" class="password-field" id="password" name="password"
                                            placeholder="Password *" required />
                                        <button type="button" aria-label="Show or hide password"
                                            class="toggle-password-visibility">
                                            <img src="{{ asset('student/images/eye-close.svg') }}" alt="Icon">
                                        </button>
                                    </div>
                                    <div class="input-group password-wrapper">
                                        <input type="password" class="password-field" id="password" name="password"
                                            placeholder="Confirm Password *" required />
                                        <button type="button" aria-label="Show or hide password"
                                            class="toggle-password-visibility">
                                            <img src="{{ asset('student/images/eye-close.svg') }}" alt="Icon">
                                        </button>
                                    </div>
                                    <button type="submit" class="btn-submit">Submit <i
                                            class="fa-solid fa-arrow-right"></i></button>
                                </form>

                                <p class="forgot-password">
                                    <a href="{{ route('applicant.login') }}">Already have a account?</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="login-right-wrp col-lg-6">
                        <div class="login-flow-right">
                            <div class="lfr-logo-cover">
                                <img src="{{ asset('student/images/login-flow-texture-sm-1.svg') }}" alt="Image"
                                    class="login-lg-cover-texture">
                                <div class="lfr-logo">
                                    <img src="{{ asset('student/images/logo.png') }}" alt="Logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="company-info-label">
                <div class="company-address">Address: <p class="txt-primary">Me’ohr Bais Yaakov, Rechov Hagai 1, Beit
                        Hakerem Yerushalayim</p>
                </div>
                <div class="company-contact">Phone Number: <a href="tel:+972026300900">+972 02-630-0900</a> <span
                        class="txt-primary"></span>/ ADSL #:</span> <a href="tel:8452620020">845-262-0020</a></div>
                <div class="company-email">Email: <a href="mailto:office@meohr.org">office@meohr.org</a></div>
            </div>
        </div>
    </div>


    <!-- Jquery-->
   
</body>

</html>
