@extends('backend.auth.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
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
                                <div role="tablist" aria-label="Login type" class="tablist-container">
                                    <button role="tab" id="tab-student" aria-selected="true" aria-controls="panel-student" class="active" tabindex="0">
                                        <img src="{{ asset('backend') }}/assets/images/new_images/user-icon.svg" alt="icon"> Student
                                    </button>
                                    <button role="tab" id="tab-parent" aria-selected="false" aria-controls="panel-parent" tabindex="-1">
                                        <img src="{{ asset('backend') }}/assets/images/new_images/multi-user-icon.svg" alt="Icon"> Parent
                                    </button>
                                    <button role="tab" id="tab-alumni" aria-selected="false" aria-controls="panel-alumni" tabindex="-1">
                                        <img src="{{ asset('backend') }}/assets/images/new_images/alumni-icon.svg" alt="Icon"> Alumni
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
