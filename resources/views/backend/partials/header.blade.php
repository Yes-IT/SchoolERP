
<div class="dashboard-body-head">

    <div class="dsbdy-head-left">
        <div class="dsbdy-search-form">
            <div class="input-grp search-field">
                <input type="text" id="search_field" placeholder="Search Page" onkeyup="searchParentMenu()">
                <input type="submit" value="Search">
            </div>
            <div id="autoCompleteData" class="d-none">
                <ul class="search_suggestion">
                </ul>
            </div>
        </div>
    </div>

    <div class="dsbdy-head-right">

        <button class="tgl-flscrn" aria-label="Toggle fullscreen" onclick="javascript:toggleFullScreen()">
            <img src="{{ global_asset('backend/assets/images/new_images/fullscreen-toggler-icon.svg') }}" alt="Icon">
        </button>

        <button id="alertToggler" class="alert-toggler" aria-label="Toggle Alerts" onclick="toggleAlertPopup()">
            <img src="{{ global_asset('backend/assets/images/new_images/bell-icon.svg') }}" alt="Alert Icon">
        </button>

        <div class="profile-ctrl">
            <button class="profile-ctrl-toggler">
                <div class="pr-pic">
                    {{-- <img src="{{ @globalAsset(Auth::user()->upload->path, '40X40.webp') }}" alt="{{ Auth::user()->name }}"> --}}
                     <img src="{{ global_asset('backend/assets/images/new_images/profile-picture.png') }}" alt="Profile Picture">
                </div>
                <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="pr-ctrl-menu">
                <ul>
                    <li>
                        <a href="profile.html">My Profile</a>
                    </li>
                    <li>
                        <a href="set-password.html">Change Password</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    
</div>