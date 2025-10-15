
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <title>School Management System | Forgot Password</title>

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

    <link rel="stylesheet" href="{{asset('student/css/style.css')}}">
</head>
<body>


    <div class="login-flow has-texture">
        <div class="container">
            <div class="textures">
                <img src="{{asset('student/images/login-flow-shape-1.png')}}" alt="Image" class="texture-1 texture">
                <img src="{{asset('student/images/login-flow-shape-2.png')}}" alt="Image" class="texture-2 texture">
            </div>
            <div class="login-flow-inr">
                <div class="row">
                    <div class="login-flow-left-wrp col-lg-6">
                        <div class="login-panel-outer">
                            <div class="logo">
                                <img src="{{asset('student/images/logo.png')}}" alt="Logo">
                            </div>
                            <div class="login-panel">
                                <h2 class="login-heading">Forgot Password</h2>
                                <form id="login-form" action="{{ route('student.otp_verification') }}" method="POST">
                                    @csrf
                                    <div class="otp-container">
                                        <input type="text" name="otp[]" inputmode="numeric" pattern="\d*" maxlength="1" placeholder="-" required />
                                        <input type="text" name="otp[]" inputmode="numeric" pattern="\d*" maxlength="1" placeholder="-" required />
                                        <input type="text" name="otp[]" inputmode="numeric" pattern="\d*" maxlength="1" placeholder="-" required />
                                        <input type="text" name="otp[]" inputmode="numeric" pattern="\d*" maxlength="1" placeholder="-" required />
                                        <input type="text" name="otp[]" inputmode="numeric" pattern="\d*" maxlength="1" placeholder="-" required />
                                    </div>
                                    <button type="submit" class="btn-submit">Submit <i class="fa-solid fa-arrow-right"></i></button>
                                    <div class="resend-code">
                                        Didn’t get a Code?
                                        <button type="button" id="resend_button"> Resend</button>
                                        <span id="timer" style="margin-left:10px; color:gray; font-size:14px;"></span>
                                    </div>

                                    <!-- message placeholder -->
                                    <p id="resend-message" style="display:none; color:green; font-size:14px; margin-top:10px;"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="login-right-wrp col-lg-6">
                        <div class="login-flow-right">
                            <div class="lfr-logo-cover">
                                <img src="{{asset('student/images/login-flow-texture-sm-1.svg')}}" alt="Image" class="login-lg-cover-texture">
                                <div class="lfr-logo">
                                    <img src="{{asset('student/images/logo.png')}}" alt="Logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="company-info-label">
                <div class="company-address">Address: <p class="txt-primary">Me’ohr Bais Yaakov, Rechov Hagai 1, Beit Hakerem Yerushalayim</p></div>
                <div class="company-contact">Phone Number: <a href="tel:+972026300900">+972 02-630-0900</a> <span class="txt-primary">/ ADSL #:</span> <a href="tel:8452620020">845-262-0020</a></div>
                <div class="company-email">Email: <a href="mailto:office@meohr.org">office@meohr.org</a></div>
            </div>
        </div>
    </div>


    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script src="{{asset('student/js/common.js')}}"></script>

    <script>
        $(document).ready(function(){
            let timerDuration = 120; // 2 minutes = 120 seconds
            let timerInterval;

            function startTimer() {
                $("#resend_button").prop("disabled", true); // disable button
                let remaining = timerDuration;

                // update timer immediately
                updateTimerText(remaining);

                timerInterval = setInterval(function(){
                    remaining--;

                    updateTimerText(remaining);

                    if(remaining <= 0){
                        clearInterval(timerInterval);
                        $("#timer").text("");
                        $("#resend_button").prop("disabled", false);
                    }
                }, 1000);
            }

            function updateTimerText(seconds) {
                let minutes = Math.floor(seconds / 60);
                let secs = seconds % 60;
                $("#timer").text(`Resend available in ${minutes}:${secs < 10 ? '0' : ''}${secs}`);
            }

            // Start timer when page loads
            startTimer();

            // Resend OTP
            $("#resend_button").on("click", function(e){
                e.preventDefault();

                // ✅ Show message immediately when button is clicked
                $("#resend-message")
                    .text("Resending OTP... ⏳")
                    .css("color","blue")
                    .fadeIn();

                $.ajax({
                    url: "{{ route('student.resend_otp') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        if(response.status === "success"){
                            $("#resend-message")
                                .text("OTP Resent Successfully ✅")
                                .css("color","green")
                                .fadeIn();

                            // hide after 2 seconds
                            setTimeout(function(){
                                $("#resend-message").fadeOut();
                            }, 3000);
                        } else {
                            $("#resend-message")
                                .text(response.message)
                                .css("color","red")
                                .fadeIn();

                            setTimeout(function(){
                                $("#resend-message").fadeOut();
                            }, 3000);
                        }
                    },
                    error: function(xhr, status, error){
                        $("#resend-message")
                            .text("Something went wrong. Please try again.")
                            .css("color","red")
                            .fadeIn();

                        setTimeout(function(){
                            $("#resend-message").fadeOut();
                        }, 2000);
                    }
                });
            });
        });
    </script>

</body>
</html>
