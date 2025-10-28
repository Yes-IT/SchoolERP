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
        <div class="ds-breadcrumb">
            <h1>Interview Details</h1>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <div class="sec-head has-brdr">
                    <h2>Details</h2>
                </div>
                <div class="ds-cmn-tble txt-primary-2nd txt-semibold w1200">
                    <table>
                        <tbody>
                            <tr>
                                <td>Interview Date</td>
                                <td>12/11/2001</td>
                            </tr>
                            <tr>
                                <td>Interview Time</td>
                                <td>02:30 PM</td>
                            </tr>
                            <tr>
                                <td>Mode</td>
                                <td>Offline</td>
                            </tr>
                            <tr>
                                <td>Interview Location</td>
                                <td>Lorem ipsum dolor sit amet, Texas, United States, 75001 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
