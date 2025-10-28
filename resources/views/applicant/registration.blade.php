@extends('applicant.partials.app')

@section('content')
    <div class="dashboard-body dspr-body-outer">
        <div class="dashboard-body-head">
            <div class="dsbdy-head-left">
                <div class="dsbdy-search-form">
                    <div class="input-grp search-field">
                        <input type="text" placeholder="Search Page">
                        <input type="submit" value="Search">
                    </div>
                </div>
            </div>
            <div class="dsbdy-head-right">
                <button class="tgl-flscrn" aria-label="Toggle fullscreen">
                    <img src="{{ asset('student\images\fullscreen-toggler-icon.svg') }}" alt="Icon">
                </button>
                <div class="profile-ctrl">
                    <button class="profile-ctrl-toggler">
                        <div class="pr-pic">
                            <img src="{{ asset('student\images\profile-picture.png') }}" alt="Profile Picture">
                        </div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="pr-ctrl-menu">
                        <ul>
                            <li><a href="profile.html">My Profile</a></li>
                            <li><a href="set-password.html">Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="ds-breadcrumb text-light">
            <h1>Registration</h1>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-card-item completed">
                <div class="ds-cmn-card-item-left">
                    <div class="ds-cmn-card-item-icon">
                        <img src="{{ asset('students/images/pen-white.svg') }}" alt="Icon">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h3>Student Agreement Signed</h3>
                </div>
                <a href="student-agreement.html" class="ds-cmn-card-item-icon">
                    <img src="{{ asset('students/images/arrow-upright.svg') }}" alt="Icon">
                </a>
            </div>
            <div class="ds-cmn-card-item">
                <div class="ds-cmn-card-item-left">
                    <div class="ds-cmn-card-item-icon">
                        <img src="{{ asset('students/images/pen-white.svg') }}" alt="Icon">
                    </div>
                    <h3>Tuition Contract (F) </h3>
                </div>
                <a href="tuttion-contract-f.html" class="ds-cmn-card-item-icon">
                    <img src="{{ asset('students/images/arrow-upright.svg') }}" alt="Icon">
                </a>
            </div>
            <div class="ds-cmn-card-item">
                <div class="ds-cmn-card-item-left">
                    <div class="ds-cmn-card-item-icon">
                        <img src="{{ asset('students/images/pen-white.svg') }}" alt="Icon">
                    </div>
                    <h3>Tuition Contract (M) </h3>
                </div>
                <a href="student-agreement.html" class="ds-cmn-card-item-icon">
                    <img src="{{ asset('students/images/arrow-upright.svg') }}" alt="Icon">
                </a>
            </div>
            <div class="ds-cmn-card-item">
                <div class="ds-cmn-card-item-left">
                    <div class="ds-cmn-card-item-icon">
                        <img src="{{ asset('students/images/pen-white.svg') }}" alt="Icon">
                    </div>
                    <h3>Set up payment method</h3>
                </div>
                <a href="#url" class="ds-cmn-card-item-icon">
                    <img src="{{ asset('students/images/arrow-upright.svg') }}" alt="Icon">
                </a>
            </div>
        </div>
    </div>
@endsection
