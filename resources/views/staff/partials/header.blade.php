<div class="dashboard-body-head">
    <div class="dsbdy-head-right">

        <button class="open-modal-btn session-btn" onclick="openSessionModal()">Selection Semester</button>

        <button class="tgl-flscrn" aria-label="Toggle fullscreen">
        <img src="{{ asset('staff') }}/assets/images/fullscreen-toggler-icon.svg" alt="Icon">
        </button>

        <button class="bell-icon">
        <img src="{{ asset('staff') }}/assets/images/notification.svg" alt="bell-icon" class="bellImage" />
        </button>

        <div class="profile-ctrl">
            <button class="profile-ctrl-toggler">
                <div class="pr-pic">
                <img src="{{ asset('staff') }}/assets/images/profile-picture.png" alt="Profile Picture">
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
<<<<<<< HEAD
=======
        <i class="fa-solid fa-chevron-down"></i>
    </button>

    <div class="pr-ctrl-menu">
        <ul>
        <li><a href="{{ route('staff.profile.index') }}">My Profile</a></li>
        <li><a href="set-password.html">Change Password</a></li>
        </ul>
>>>>>>> 9e07ed70b107e1f891c3007672b959588ef6be58
    </div>
</div>