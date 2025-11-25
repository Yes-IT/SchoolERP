
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
                <img src="./images/fullscreen-toggler-icon.svg" alt="Icon">
            </button>
            <div class="profile-ctrl">
                <button class="profile-ctrl-toggler">
                    <div class="pr-pic">
                        <img src="./images/profile-picture.png" alt="Profile Picture">
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
        <h1>Notice Board</h1>
        <ul>
            <li><a href="dashboard.html">Dashboard</a> /</li>
            <li>Notice Board</li>
        </ul>
    </div>
    <div class="ds-pr-body">
        
        <div class="ds-cmn-table-wrp notice-board-pg">
            <div class="dsbdycmncd-body">
                <div class="notice-list">
                    <ul>
                        <li class="has-info-card"><a href="#url"><img src="./images/envelope.svg" alt="Icon"> Upcoming Assignment (04/01/2025)</a>
                            <div class="notice-info-wrp">
                                <div class="overlay"></div>
                                <div class="notice-info">
                                    <div class="nc-info-head">
                                        <button type="button" class="btn-back"><i class="fa-solid fa-arrow-left"></i></button>
                                        <h2>Upcoming Assignment</h2>
                                        <button type="button" class="notice-btn-close">
                                            <img src="./images/cross-icon.svg" alt="Close">
                                        </button>
                                    </div>
                                    <div class="nc-info-body">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <div class="nc-doc-wrap">
                                            <button type="button" class="doc-download cmn-btn">
                                                <img src="./images/file-icon.svg" alt="Icon"></i>
                                                <span>Doc_0481</span>
                                                <a href="javascript:void(0)" download="./image/download-icon-light.svg"><img src="./images/download-icon-light.svg" alt="Icon"></a>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="nc-info-footer">
                                        <div class="notice-date">
                                            <img src="./images/calender-primary.svg" alt="Icon">
                                            <span>Notice Date: 04/01/2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        </li>
                        <li class="active"><a href="#url"><img src="./images/notice-icon-2.svg" alt="Icon">  Change of Schedule (04/01/2025)</a></li>
                        <li><a href="#url"><img src="./images/envelope.svg" alt="Icon"> Upcoming Activities (04/01/2025)</a></li>
                        <li><a href="#url"><img src="./images/envelope.svg" alt="Icon"> Miscellaneous (04/01/2025)</a></li>
                        <li><a href="#url"><img src="./images/envelope.svg" alt="Icon"> Upcoming Assignment (04/01/2025)</a></li>
                        <li class="active"><a href="#url"><img src="./images/notice-icon-2.svg" alt="Icon">  Change of Schedule (04/01/2025)</a></li>
                        <li><a href="#url"><img src="./images/envelope.svg" alt="Icon"> Upcoming Activities (04/01/2025)</a></li>
                        <li><a href="#url"><img src="./images/envelope.svg" alt="Icon"> Miscellaneous (04/01/2025)</a></li>
                    </ul>
                </div>
            </div>
        </div>
            
    </div>
</div>
<!-- End Of Dashboard Body -->

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="requestLeave" tabindex="-1" role="dialog" aria-labelledby="requestLeave" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Request Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form>
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea placeholder="Reason"></textarea>
                                </div>
                                <input type="submit" value="Submit" class="btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp popwrp" id="deleteLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="deleteLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="./images/bin-primary.svg" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this Leave Request?</p>
                        <div class="btn-wrp">
                            <button type="submit" class="cmn-btn">Delete</button>
                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->