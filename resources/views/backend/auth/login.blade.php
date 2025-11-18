@extends('backend.auth.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')

<style>
    .tablist-below {
        display: flex;
        align-items: center;
        border-radius: 5px;
        margin: 24px 0 20px;
        overflow: hidden;
        background: var(--secondary-clr);
    }
    
    .tablist-below button {
        background: transparent;
        border: 0;
        padding: 5px 12px;
        margin: 0;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        color: var(--text-clr);
        transition: all ease-in-out .3s;
        font-size: 15px;
    }

    .tablist-below button:first-child {
        border-right: 1px solid var(--primary-clr);
    }

    .tablist-below button:hover,
    .tablist-below button.active {
        color: var(--white);
        background: var(--primary-clr);
    }

    .tablist-below button img {
        transition: all ease-in-out .3s;
    }

    .tablist-below button:hover img,
    .tablist-below button.active img {
        filter: brightness(0) invert(1);
    }

    /* Responsive font size adjustments */
    @media screen and (min-width:1201px) and (max-width:1400px) {
        .tablist-below button {
            font-size: 12px;
        }
    }

    @media screen and (min-width:901px) and (max-width:1200px) {
        .tablist-below button {
            font-size: 10px;
        }
    }

    @media screen and (min-width:600px) and (max-width:900px) {
        .tablist-below button {
            font-size: 9px;
        }
    }
</style>

    <div class="login-flow has-texture">
        <div class="container">
            <div class="textures">
                <img src="{{ asset('backend') }}/assets/images/new_images/login-flow-shape-1.png" alt="Image" class="texture-1 texture">
                <img src="{{ asset('backend') }}/assets/images/new_images/login-flow-shape-2.png" alt="Image" class="texture-2 texture">
            </div>
            <div class="login-flow-inr">
                <div class="row">
                    <div class="login-flow-left-wrp col-lg-6">
                        <div class="login-panel-outer">
                            <div class="logo">
                                <img src="{{ asset('backend') }}/assets/images/new_images/logo.png" alt="Logo">
                            </div>
                            <div class="login-panel">
                                <h2 class="login-heading">User Login</h2>
                                <form id="login-form" action="{{ route('login.auth') }}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="email" class="ot-input @error('email') is-invalid @enderror" id="username" placeholder="{{ ___('common.enter_mobile_or_email') }}" />
                                        @error('email')
                                            <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-group password-wrapper">
                                        <input type="password" name="password" class="password-field ot-input @error('password') is-invalid @enderror" id="password" placeholder="******************" />
                                        <button type="button" aria-label="Show or hide password" class="toggle-password-visibility">
                                            <img src="{{ asset('backend') }}/assets/images/new_images/eye-close.svg" alt="Icon">
                                        </button>
                                        @error('password')
                                            <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn-submit">Submit <i class="fa-solid fa-arrow-right"></i></button>
                                </form>
                                <!-- Student / Parent / Alumni Tabs -->
                                <div role="tablist" aria-label="Student login type" class="tablist-container">
                                    <button role="tab" id="tab-student"   aria-selected="true"  aria-controls="panel-student"   class="active" tabindex="0">
                                        <img src="{{ asset('backend') }}/assets/images/new_images/user-icon.svg" alt="Student icon"> Student
                                    </button>
                                    <button role="tab" id="tab-parent"    aria-selected="false" aria-controls="panel-parent"    class="" tabindex="-1">
                                        <img src="{{ asset('backend') }}/assets/images/new_images/multi-user-icon.svg" alt="Parent icon"> Parent
                                    </button>
                                    <button role="tab" id="tab-alumni"    aria-selected="false" aria-controls="panel-alumni"    class="" tabindex="-1">
                                        <img src="{{ asset('backend') }}/assets/images/new_images/alumni-icon.svg" alt="Alumni icon"> Alumni
                                    </button>
                                </div>

                                <!-- Teacher / Dormitory Tabs -->
                                <div role="tablist" aria-label="Staff login type" class="tablist-container">
                                    <button role="tab" id="tab-teacher"    aria-selected="true"  aria-controls="panel-teacher"    class="" tabindex="0">
                                        <img src="{{ asset('staff') }}/assets/images/teacher.svg" alt="Teacher icon"> Teacher
                                    </button>
                                    <button role="tab" id="tab-dormitory"  aria-selected="false" aria-controls="panel-dormitory"  class="" tabindex="-1">
                                        <img src="{{ asset('staff') }}/assets/images/Dormitory.svg" alt="Dormitory icon"> Dormitory
                                    </button>
                                </div>

                                <!-- Chinuch & Administration / Executive Tabs -->
                                <div role="tablist" aria-label="Administration login type" class="tablist-below">
                                    <button role="tab" id="tab-chinuch"     aria-selected="true"  aria-controls="panel-chinuch"     class="" tabindex="0">
                                        <img src="{{ asset('staff') }}/assets/images/Group.svg" alt="Chinuch icon"> Chinuch &amp; Administration
                                    </button>
                                    <button role="tab" id="tab-executive"   aria-selected="false" aria-controls="panel-executive"   class="" tabindex="-1">
                                        <img src="{{ asset('staff') }}/assets/images/executive.svg" alt="Executive icon"> Executive
                                    </button>
                                </div>
                                <p class="forgot-password">
                                    <a href="forgot-password.html">Forgot your password?</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="login-right-wrp col-lg-6">
                        <div class="login-flow-right">
                            <div class="lfr-logo-cover">
                                <img src="{{ asset('backend') }}/assets/images/new_images/login-flow-texture-sm-1.svg" alt="Image" class="login-lg-cover-texture">
                                <div class="lfr-logo">
                                    <img src="{{ asset('backend') }}/assets/images/new_images/logo.png" alt="Logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="company-info-label">
                <div class="company-address">Address: <p class="txt-primary">Me’ohr Bais Yaakov, Rechov Hagai 1, Beit Hakerem Yerushalayim</p></div>
                <div class="company-contact">Phone Number: <a href="tel:+972026300900">+972 02-630-0900</a> <span class="txt-primary"></span>/ ADSL #:</span> <a href="tel:8452620020">845-262-0020</a></div>
                <div class="company-email">Email: <a href="mailto:office@meohr.org">office@meohr.org</a></div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    {!! NoCaptcha::renderJs() !!}
@endsection
