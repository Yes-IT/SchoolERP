 <div class="dashboard-body-head">
     <div class="dsbdy-head-left">
         <form class="dsbdy-search-form">
             <div class="input-grp search-field" style="position: relative;">
                 <input type="text" id="page-search-input" placeholder="Search Page" autocomplete="off">
                 <input type="submit" value="Search">
                 <div id="search-suggestions" class="search-suggestions-list" style="display: none;">
                     <ul>
                         <!-- Suggestions will be populated by JavaScript -->
                     </ul>
                 </div>
             </div>
         </form>
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
                     <li><a href="{{ route('applicant.profile') }}">My Profile</a></li>
                     <li><a href="{{route('applicant-update-password')}}">Change Password</a></li>
                 </ul>
             </div>
         </div>
     </div>
 </div>
