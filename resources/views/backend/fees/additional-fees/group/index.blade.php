@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')


    <div class="dashboard-main light-bg">

        <!-- Sidebar Begin -->

        @include('backend.partials.sidebar')
        <!-- End Of Sidebar -->

        <!-- Dashboard Body Begin -->

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
                        <img src="../../images/fullscreen-toggler-icon.svg" alt="Icon">
                    </button>
                    <div class="profile-ctrl">
                        <button class="profile-ctrl-toggler">
                            <div class="pr-pic">
                                <img src="../../images/profile-picture.png" alt="Profile Picture">
                            </div>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="pr-ctrl-menu">
                            <ul>
                                <li><a href="profile.html">My Profile</a></li>
                                <li><a href="../../set-password.html">Change Password</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ds-breadcrumb">
                <h1>Exam Schedule</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li>Exam Schedule</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-cmn-info-cards-wrp">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Fees Group</h3>
                                        <p>Student profile,percent-info,class-assignments and teacher-data.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="#url" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Fees Group</h3>
                                        <p>Student profile,percent-info,class-assignments and teacher-data.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="#url" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Fees Group</h3>
                                        <p>Student profile,percent-info,class-assignments and teacher-data.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="#url" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                       <div class="ds-cmn-info-cards-wrp">
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Fees Group</h3>
                                        <p>Student profile,percent-info,class-assignments and teacher-data.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="#url" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">
                                    <div class="ds-cmn-ic-body">
                                        <h3>Fees Group</h3>
                                        <p>Student profile,percent-info,class-assignments and teacher-data.</p>
                                    </div>
                                    <div class="ds-cmn-ic-ftr">
                                        <a href="#url" class="cmn-btn w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>

                </div>
                  
            </div>
        </div>

@endsection