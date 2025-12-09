@extends('parent-panel.partials.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

<style>
    

    /* Primary Color */
    .bg-primary-custom {
        background-color: #660000 !important;
    }
    .text-primary-custom {
        color: #660000 !important;
    }
    .btn-primary-custom {
        background-color: #660000 !important;
        border-color: #660000 !important;
    }
    .btn-primary-custom:hover {
        background-color: #4d0000 !important;
    }

    /* Menu Active Style */
    .menu-active {
        background-color: #660000 !important;
        color: white !important;
    }

    /* Card styling */
    .custom-card {
        background: #ffffff !important;
        border-radius: 10px;
        box-shadow: 0px 2px 6px rgba(0,0,0,0.08);
    }
</style>

<div class="page-content mt-5" >

    <div class="profile-content">

        <div class="d-flex flex-column flex-lg-row gap-4">

            <!-- LEFT PROFILE MENU -->
            <div class="profile-menu shadow-sm rounded p-3 custom-card" style="min-width: 260px">

                <!-- USER HEADER -->
                <div class="profile-menu-head text-center mb-4">
                    <img class="img-fluid rounded-circle border shadow-sm mb-2"
                         src="{{ @globalAsset(Auth::user()->upload->path, '80X80.webp') }}"
                         alt="{{ Auth::user()->name }}"
                         style="width: 80px; height: 80px; object-fit: cover;">

                    <h4 class="fw-bold mt-2 text-primary-custom">{{ Auth::user()->name }}</h4>
                    <p class="text-muted small">{{ Auth::user()->role->name }}</p>
                </div>

                <!-- MENU ITEMS -->
                <div class="profile-menu-body">
                    <ul class="nav flex-column gap-2">

                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded 
                                {{ request()->routeIs('my.profile') ? 'menu-active' : 'text-dark' }}"
                               href="{{ route('parent-panel.profile') }}">
                                <i class="fa-solid fa-user me-2"></i> {{ ___('common.my_profile') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded 
                                {{ request()->routeIs('passwordUpdate') ? 'menu-active' : 'text-dark' }}"
                               href="{{ route('parent-panel.password-update') }}">
                                <i class="fa-solid fa-lock me-2"></i> {{ ___('common.update_password') }}
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
            <!-- END LEFT MENU -->


            <!-- RIGHT SIDE -->
            <div class="profile-body flex-grow-1">

                <div class="card custom-card">
                    <div class="card-header bg-primary-custom text-white">
                        <h4 class="mb-0">
                            <i class="fa-solid fa-lock me-2"></i>{{ ___('common.update_password') }}
                        </h4>
                    </div>

                    <div class="card-body">

                        {{-- SUCCESS ALERT --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-2">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- ERROR ALERT --}}
                        @if (session('danger'))
                            <div class="alert alert-danger alert-dismissible fade show mt-2">
                                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                {{ session('danger') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif


                        <!-- FORM -->
                        <form action="{{ route('parent-panel.password-update-store') }}" enctype="multipart/form-data" method="post"
                            id="visitForm">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <!-- CURRENT PASSWORD -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label fw-semibold text-primary-custom">
                                        {{ ___('common.current_password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           name="current_password"
                                           class="form-control form-control-lg @error('current_password') is-invalid @enderror"
                                           placeholder="{{ ___('common.current_password') }}">

                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- NEW PASSWORD -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label fw-semibold text-primary-custom">
                                        {{ ___('common.new_password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           name="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           placeholder="{{ ___('common.new_password') }}">

                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- CONFIRM PASSWORD -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label fw-semibold text-primary-custom">
                                        {{ ___('common.confirm_password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                           placeholder="{{ ___('common.confirm_password') }}">

                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- SUBMIT BUTTON -->
                                <div class="col-12 text-end">
                                    <button class="btn btn-primary-custom btn-lg px-4">
                                        <i class="fa-solid fa-save me-2"></i> {{ ___('common.update') }}
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
            <!-- END RIGHT SIDE -->

        </div>

    </div>

</div>
@endsection
