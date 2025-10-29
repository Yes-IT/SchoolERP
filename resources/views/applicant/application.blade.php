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
            <h1> Application</h1>
            <ul>
                <li><a href="./process.html">Dashboard</a> /</li>
                <li>Application</li>
            </ul>
            <div class="btn-wrp">
                <a href="#url" class="cmn-btn sm-btn" style="width: 99px;">
                    <img src="{{asset('student/images/lucide_edit.svg')}}" class="edit-img" />
                    Draft</a>
                <a href="#url" class="cmn-btn btn-sm back-btn"><img src="{{asset('student/images/back-icon.svg')}}" alt="Icon">
                    Back</a>
            </div>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">

                <div class="application-accr lbl-primary">
                    <div class="accr-item">
                        <div class="accr-head">
                            <h3>Application Information</h3>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accr-content">
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label>Legal Name (first) *</label>
                                    <input type="text" name="first_name" placeholder="Enter First Name">
                                </div>
                                <div class="input-grp">
                                    <label>Last Name *</label>
                                    <input type="text" name="last_name" placeholder="Enter Last Name">
                                </div>
                                <div class="input-grp">
                                    <label>You prefer to be called: *</label>
                                    <input type="text" name="prefered_name" placeholder="You prefer to be called:">
                                </div>
                            </div>
                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label>שם בעברית *</label>
                                    <input type="text" name="hebrew_name" placeholder="שם בעברית ">
                                </div>
                                <div class="input-grp">
                                    <label>שם פרטי</label>
                                    <input type="text" name="hebrew_first_name" placeholder="שם פרטי">
                                </div>
                            </div>
                            <div class="input-grp">
                                <label>Address *</label>
                                <input type="text" name="address" placeholder="Enter Address">
                            </div>
                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label>City *</label>
                                    <input type="text" name="city" placeholder="Enter City">
                                </div>
                                <div class="input-grp">
                                    <label>State</label>
                                    <select>
                                        <option value="1">Select State</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label>Country</label>
                                    <select>
                                        <option value="1">Select Country</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label>Zip/Postal Code</label>
                                    <input type="text" placeholder="Zip/Postal Code">
                                </div>
                            </div>
                            <div class="input-grp">
                                <label><span class="w-100 txt-primary d-block"><strong>City (for interviews) *
                                        </strong></span>This is used for setting up interviews and may be different than
                                    your mailing address. If you don’t see an option that looks correct for you, please let
                                    us know.</label>
                                <select class="w-50">
                                    <option value="1">-Select a city-</option>
                                </select>
                            </div>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label>Applicant's email</label>
                                    <input type="text" placeholder="Enter Email">
                                </div>
                                <div class="input-grp">
                                    <label>Applicant's cell</label>
                                    <input type="text" placeholder="Enter Applicant's cell">
                                </div>
                                <div class="input-grp">
                                    <label>Home Phone*</label>
                                    <input type="text" placeholder="Enter Phone ">
                                </div>
                                <div class="input-grp">
                                    <label>Place of birth *</label>
                                    <input type="text" placeholder="Place of birth ">
                                </div>
                                <div class="input-grp">
                                    <label>Date of birth *</label>
                                    <input type="text" placeholder="mm/dd/yyyy">
                                </div>
                                <div class="input-grp">
                                    <label>Hebrew date of birth (בעברית) *</label>
                                    <input type="text" placeholder="mm/dd/yyyy">
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="accr-item">
                        <div class="accr-head">
                            <h3>Family</h3>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accr-content">
                            <div class="input-grp has-multi-radio">
                                <h4 class="txt-primary cmn-accr-head">Parent's marital status *</h4>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Married</label>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Widowed</label>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Divorced</label>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Separated</label>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Remarried</label>
                            </div>
                            <div class="input-grp w-50">
                                <label>How many siblings do you have? *</label>
                                <input type="number" placeholder="0">
                                <p>Please enter a number from 0 to 22.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accr-item">
                        <div class="accr-head">
                            <h3>School</h3>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accr-content">
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label>Current school *</label>
                                    <select>
                                        <option value="-Select-" selected disabled>-Select-</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label>School phone *</label>
                                    <input type="tel" placeholder="Enetr School phone ">
                                </div>
                                <div class="input-grp">
                                    <label>Grade *</label>
                                    <input type="text" placeholder="Enter Grade">
                                </div>
                            </div>
                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label>Sem advisor's name *</label>
                                    <input type="text" placeholder="Enter Sem advisor's name">
                                </div>
                                <div class="input-grp">
                                    <label>Home #</label>
                                    <input type="text" placeholder="Home #">
                                </div>
                                <div class="input-grp">
                                    <label>Cell #</label>
                                    <input type="tel" placeholder="Enter Cell ">
                                </div>
                                <div class="input-grp">
                                    <label>Email address *</label>
                                    <input type="email" placeholder="Enter Email address">
                                </div>
                            </div>
                            <div class="accr-cmn-inr-wrp">
                                <h4 class="cmn-accr-head">List all schools you have attended, starting from elementary *
                                </h4>
                                <div class="multi-input-grp-list">
                                    <div class="multi-input-grp">
                                        <div class="input-grp">
                                            <label>Name of school</label>
                                            <input type="text" placeholder="Name of school">
                                        </div>
                                        <div class="input-grp">
                                            <label>Grades attended</label>
                                            <input type="text" placeholder="Enter Grades">
                                        </div>
                                    </div>
                                    <div class="action-wrp">
                                        <button><i class="fa-solid fa-plus"></i></button>
                                        <button><i class="fa-solid fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="multi-input-grp-list">
                                    <div class="multi-input-grp">
                                        <div class="input-grp">
                                            <label>Name of school</label>
                                            <input type="text" placeholder="Name of school">
                                        </div>
                                        <div class="input-grp">
                                            <label>Grades attended</label>
                                            <input type="text" placeholder="Enter Grades">
                                        </div>
                                    </div>
                                    <div class="action-wrp">
                                        <button><i class="fa-solid fa-plus"></i></button>
                                        <button><i class="fa-solid fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">Did you receive modified schoolwork in high
                                        school?</h4>
                                    <label><input type="radio" name="maritalStatus" id="maritalStatus"> Yes</label>
                                    <label><input type="radio" name="maritalStatus" id="maritalStatus"> No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accr-item">
                        <div class="accr-head">
                            <h3>Other</h3>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accr-content">
                            <div class="input-grp has-multi-radio">
                                <h4 class="txt-primary cmn-accr-head">Have you ever suffered from a serious injury, illness
                                    or eating disorder, or undergone a surgery? *</h4>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Yes</label>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> No</label>
                            </div>
                            <div class="input-grp has-multi-radio">
                                <h4 class="txt-primary cmn-accr-head">Do you or have you taken any medication for a period
                                    of 3 months or more during the past 3 years? *</h4>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Yes</label>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> No</label>
                            </div>
                            <div class="input-grp has-multi-radio">
                                <h4 class="txt-primary cmn-accr-head">Do you have any allergies or medically required
                                    dietary needs? *</h4>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> Yes</label>
                                <label><input type="radio" name="maritalStatus" id="maritalStatus"> No</label>
                            </div>

                            <div class="accr-cmn-inr-wrp">
                                <h4 class="cmn-accr-head">Relatives or close friends living in Israel:</h4>
                                <div class="multi-input-grp-list">
                                    <div class="multi-input-grp grp-4">
                                        <div class="input-grp">
                                            <label>Name</label>
                                            <input type="tel" placeholder="Name">
                                        </div>
                                        <div class="input-grp">
                                            <label>Address</label>
                                            <input type="text" placeholder="Name">
                                        </div>
                                        <div class="input-grp">
                                            <label>Phone</label>
                                            <input type="tel" placeholder="Enter Phone">
                                        </div>
                                        <div class="input-grp">
                                            <label>Relationship</label>
                                            <input type="text" placeholder="Relationship">
                                        </div>
                                    </div>
                                    <div class="action-wrp">
                                        <button><i class="fa-solid fa-plus"></i></button>
                                        <button><i class="fa-solid fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accr-item">
                        <div class="accr-head">
                            <h3>School</h3>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accr-content">
                            <div class="warning-box">
                                <strong>BLACK PEN ONLY </strong>
                                FOR QUESTIONS, BIO, AND RECOMMENDATION LETTERS. If it cannot be read, your application will
                                not be accepted. Please double-check your scans to ensure they are clear! Pictures are not
                                acceptable. Files should be scanned using a flatbed scanner or a scanning app. Please save
                                them as letter size, not A4.
                            </div>
                            <div class="accr-cmn-inr-wrp">
                                <h4 class="cmn-accr-head">About you: Questions *</h4>
                                <div class="input-grp mb-lg">
                                    <label>Please upload the handwritten question page of the application, downloadable
                                        here. <br><i>We can only accept pdf files. If you need help getting a pdf, scan your
                                            file, open it on a computer, and click to print. In the printer settings, change
                                            the printer to PDF.</i></label>
                                    <div class="file-upload-lg">
                                        <input type="file"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                        <div class="file-upld-lg-design">
                                            <div class="fupld-lg-icon">
                                                <img src="../images/upload-file-icon.svg" alt="Icon">
                                            </div>
                                            <p>Click to browse or drag and drop your files</p>
                                        </div>
                                    </div>
                                    <div class="note">
                                        <p>Accepted file types: pdf, Max. file size: 256 MB, Max. files: 2.</p>
                                        <div class="ibtn">
                                            <button type="button" class="ibtn-icon">
                                                <img src="../images/i-icon.svg" alt="Icon">
                                            </button>
                                            <div class="ibtn-info">
                                                <button type="button" class="ibtn-close">
                                                    <img src="../images/fa-times.svg" alt="icon">
                                                </button>
                                                <h3>Upload Guidelines</h3>
                                                <ul>
                                                    <li>Images larger than 5 MB are not accepted.</li>
                                                    <li>Videos must be under 10 MB in size.</li>
                                                    <li>If your files are larger, please upload them to your Google Drive
                                                        and share the link here. This helps ensure smooth uploads and better
                                                        convenience for you.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-grp mb-lg">
                                    <label>Please upload the handwritten question page of the application, downloadable
                                        here. <br><i>We can only accept pdf files. If you need help getting a pdf, scan your
                                            file, open it on a computer, and click to print. In the printer settings, change
                                            the printer to PDF.</i></label>
                                    <div class="file-upload-lg">
                                        <input type="file"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                        <div class="file-upld-lg-design">
                                            <div class="fupld-lg-icon">
                                                <img src="../images/upload-file-icon.svg" alt="Icon">
                                            </div>
                                            <p>Click to browse or drag and drop your files</p>
                                        </div>
                                    </div>
                                    <div class="note">
                                        <p>Accepted file types: pdf, Max. file size: 256 MB, Max. files: 2.</p>
                                        <div class="ibtn">
                                            <button type="button" class="ibtn-icon">
                                                <img src="../images/i-icon.svg" alt="Icon">
                                            </button>
                                            <div class="ibtn-info">
                                                <button type="button" class="ibtn-close">
                                                    <img src="../images/fa-times.svg" alt="icon">
                                                </button>
                                                <h3>Upload Guidelines</h3>
                                                <ul>
                                                    <li>Images larger than 5 MB are not accepted.</li>
                                                    <li>Videos must be under 10 MB in size.</li>
                                                    <li>If your files are larger, please upload them to your Google Drive
                                                        and share the link here. This helps ensure smooth uploads and better
                                                        convenience for you.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="cmn-suggestion-btn">Click to browse or drag and drop your files</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="btn-wrp justify-content-end">
                    <button class="cmn-btn btn-sm">Save and Continue Later</button>
                    <button class="cmn-btn btn-sm">Submit My Application</button>
                </div>

            </div>
        </div>
    </div>
@endsection
