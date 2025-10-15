@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')

<style>
.header{
display:flex;
flex-direction: row;
}
.right-section button{
    border: 1px solid var(--primary-clr);
    width: 80px;
    padding: 0px;
    color: var(--primary-clr);
    font-size: 14px;
    position: relative;
    left: -67px;

}
.left-section p{
color: var(--primary-clr);
    font-size: 14px;
    font-weight: 700;
    /* min-width: 27px; */
    width: 300px;
}

</style>


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
                        <img src="{{ asset('images/fees/fullscreen-toggler-icon.svg') }}" alt="Icon">
                    </button>
                    <div class="profile-ctrl">
                        <button class="profile-ctrl-toggler">
                            <div class="pr-pic">
                                <img src="{{ asset('images/fees/profile-picture.png') }}" alt="Profile Picture">
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

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>IT assets</h3>
                                        <p>Track access request raised by students or teachers with approval and issue status.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.itassets') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Requested assets</h3>
                                        <p>Track access request raised by students or teachers with approval and issue status.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.requestedassets') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                              <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Assigned assets</h3>
                                        <p>Track assigned IT assets and manage replacement within system.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.assignedassets') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                       <div class="ds-cmn-info-cards-wrp">
                        <div class="row mt-4">
                              <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Issue Report</h3>
                                        <p>View report of damanged,lost or malfunctining assets submitted by users</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.issuereports') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
    <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Return assets</h3>
                                        <p>Manage It assets and replacement within the system.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.returnassets') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                  <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Procurement</h3>
                                        <p>Manage purchase request for new IT assets and replacement in the system.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.procurement') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                       <div class="ds-cmn-info-cards-wrp">
                        <div class="row mt-4">
                              <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Maintanence Request</h3>
                                        <p>Track access request raised by students or teachers with approval and issue status.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.mantainenceRequest') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                                
                            </div>
                               <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Late curfew request</h3>
                                        <p>Track access request raised by students or teachers with approval and issue status.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.lateEntry') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                                
                            </div>
                               <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Doctor's visit</h3>
                                        <p>Track access request raised by students or teachers with approval and issue status.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.doctorVisit') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                                
                            </div>
                        
                          
                        </div>
                    </div>

                </div>
                  
            </div>
        </div>

        


@endsection