@extends('applicant.partials.app')

@section('content')
    <form action="{{ route('applicant.application.form.save') }}" id="application" method="POST" enctype="multipart/form-data">
        @csrf
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
                    <a href="javascript:void(0)" class="cmn-btn sm-btn" id="saveDraftLink" style="width: 99px;">
                        <img src="{{ asset('student/images/lucide_edit.svg') }}" class="edit-img" />
                        Draft
                    </a>
                    <a href="{{ route('applicant.process') }}" class="cmn-btn btn-sm back-btn"><img
                            src="{{ asset('student/images/back-icon.svg') }}" alt="Icon">
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
                                        <input name="city" placeholder="City *" class="form-control">
                                    </div>

                                    <div class="input-grp">
                                        <label>State</label>
                                        <select name="state" class="form-control select2">
                                            <option value="">Select State</option>
                                            @foreach ($data['states'] as $state)
                                                <option value="{{ $state->state }}">{{ $state->state }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-grp">
                                        <label>Country</label>
                                        <select name="country" class="form-control select2">
                                            <option value="">Select Country</option>
                                            @foreach ($data['countries'] as $country)
                                                <option value="{{ $country->country_name }}">{{ $country->country_name }}
                                                </option>
                                            @endforeach
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
                                        your mailing address. If you don’t see an option that looks correct for you,
                                        please let
                                        us know.</label>
                                    <select class="w-50">
                                        <option value="1">-Select a city-</option>
                                    </select>
                                </div>
                                <div class="multi-input-grp grp-3">
                                    <div class="input-grp">
                                        <label>Applicant's email</label>
                                        <input type="text" name="email" placeholder="Enter Email">
                                    </div>
                                    <div class="input-grp">
                                        <label>Applicant's cell</label>
                                        <input type="text" name="cell" placeholder="Enter Applicant's cell">
                                    </div>
                                    <div class="input-grp">
                                        <label>Home Phone*</label>
                                        <input type="text" name="number" placeholder="Enter Phone ">
                                    </div>
                                    <div class="input-grp">
                                        <label>Place of birth *</label>
                                        <input type="text" name="birth_place" placeholder="Place of birth ">
                                    </div>
                                    <div class="input-grp">
                                        <label>Date of birth *</label>
                                        <input type="date" name="dob" class="form-control" value="">
                                    </div>

                                    <div class="input-grp">
                                        <label>Hebrew date of birth (בעברית) *</label>
                                        <input type="date" id="hdob" name="hdob" class="form-control"
                                            value="">
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
                                    <label><input type="radio" name="maritalStatus" value="Married"
                                            id="maritalStatus">
                                        Married</label>
                                    <label><input type="radio" name="maritalStatus" value="Widowed"
                                            id="maritalStatus">
                                        Widowed</label>
                                    <label><input type="radio" name="maritalStatus" value="Divorced"
                                            id="maritalStatus">
                                        Divorced</label>
                                    <label><input type="radio" name="maritalStatus" value="Separated"
                                            id="maritalStatus">
                                        Separated</label>
                                    <label><input type="radio" name="maritalStatus" value="Remarried"
                                            id="maritalStatus">
                                        Remarried</label>
                                </div>
                                <div class="input-grp w-50">
                                    <label>How many siblings do you have? *</label>
                                    <input type="number" name="sibling" value="0" placeholder="0">
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
                                        <select name="school">
                                            <option value="-Select-" selected disabled>-Select-</option>
                                            <option value="carmel">Carmel</option>
                                            <option value="dav">Dav</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>School phone *</label>
                                        <input type="tel" name="s_tel" placeholder="Enetr School phone ">
                                    </div>
                                    <div class="input-grp">
                                        <label>Grade *</label>
                                        <input type="text" name="grade" placeholder="Enter Grade">
                                    </div>
                                </div>
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>Sem advisor's name *</label>
                                        <input type="text" name="advisor_name" placeholder="Enter Sem advisor's name">
                                    </div>
                                    <div class="input-grp">
                                        <label>Home #</label>
                                        <input type="text" name="home" placeholder="Home #">
                                    </div>
                                    <div class="input-grp">
                                        <label>Cell #</label>
                                        <input type="tel" name="home_cell" placeholder="Enter Cell ">
                                    </div>
                                    <div class="input-grp">
                                        <label>Email address *</label>
                                        <input type="email" name="email_address" placeholder="Enter Email address">
                                    </div>
                                </div>
                                <div class="accr-cmn-inr-wrp">
                                    <h4 class="cmn-accr-head">List all schools you have attended, starting from elementary
                                        *
                                    </h4>
                                    <div class="multi-input-section">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp">
                                                <div class="input-grp">
                                                    <label>Name of school</label>
                                                    <input type="text" placeholder="Name of school"
                                                        name="school_name[]">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Grades attended</label>
                                                    <input type="text" placeholder="Enter Grades" name="grades[]">
                                                </div>
                                            </div>

                                            <div class="action-wrp">
                                                <button type="button" class="add-list"><i
                                                        class="fa-solid fa-plus"></i></button>
                                                <button type="button" class="remove-list"><i
                                                        class="fa-solid fa-minus"></i></button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="input-grp has-multi-radio">
                                        <h4 class="txt-primary cmn-accr-head">Did you receive modified schoolwork in high
                                            school?</h4>
                                        <label><input type="radio" value="1" name="modified" id="modified">
                                            Yes</label>
                                        <label><input type="radio" value="0" name="modified" id="modified">
                                            No</label>
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
                                    <h4 class="txt-primary cmn-accr-head">Have you ever suffered from a serious injury,
                                        illness
                                        or eating disorder, or undergone a surgery? *</h4>
                                    <label><input type="radio" value="1" name="surgery" id="surgery">
                                        Yes</label>
                                    <label><input type="radio" value="0" name="surgery" id="surgery">
                                        No</label>
                                </div>
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">Do you or have you taken any medication for a
                                        period
                                        of 3 months or more during the past 3 years? *</h4>
                                    <label><input type="radio" value="1" name="medication" id="medication">
                                        Yes</label>
                                    <label><input type="radio" value="0" name="medication" id="medication">
                                        No</label>
                                </div>
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">Do you have any allergies or medically required
                                        dietary needs? *</h4>
                                    <label><input type="radio" value="1" name="allergies" id="allergies">
                                        Yes</label>
                                    <label><input type="radio" value="0" name="allergies" id="allergies">
                                        No</label>
                                </div>

                                <div class="accr-cmn-inr-wrp">
                                    <h4 class="cmn-accr-head">Relatives or close friends living in Israel:</h4>
                                    <div id="multiInputContainer">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp grp-4">
                                                <div class="input-grp">
                                                    <label>Name</label>
                                                    <input type="text" name="relation_name[]" placeholder="Name">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Address</label>
                                                    <input type="text" name="relation_address[]"
                                                        placeholder="Address">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Phone</label>
                                                    <input type="tel" name="relation_phone[]"
                                                        placeholder="Enter Phone">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Relationship</label>
                                                    <input type="text" name="relation_relationship[]"
                                                        placeholder="Relationship">
                                                </div>
                                            </div>
                                            <div class="action-wrp">
                                                <button class="addBtn"><i class="fa-solid fa-plus"></i></button>
                                                <button class="removeBtn"><i class="fa-solid fa-minus"></i></button>
                                            </div>
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
                                    FOR QUESTIONS, BIO, AND RECOMMENDATION LETTERS. If it cannot be read, your application
                                    will
                                    not be accepted. Please double-check your scans to ensure they are clear! Pictures are
                                    not
                                    acceptable. Files should be scanned using a flatbed scanner or a scanning app. Please
                                    save
                                    them as letter size, not A4.
                                </div>
                                <div class="accr-cmn-inr-wrp">
                                    <h4 class="cmn-accr-head">About you: Questions *</h4>
                                    <div class="input-grp mb-lg">
                                        <label>Please upload the handwritten question page of the application, downloadable
                                            here. <br><i>We can only accept pdf files. If you need help getting a pdf, scan
                                                your
                                                file, open it on a computer, and click to print. In the printer settings,
                                                change
                                                the printer to PDF.</i></label>
                                        <div class="file-upload-lg">
                                            <input type="file" name="about" id="fileInput" accept=".pdf" hidden>
                                            <div class="file-upld-lg-design" id="dropArea">
                                                <div class="fupld-lg-icon">
                                                    <img src="{{ asset('student/images/upload-file-icon.svg') }}"
                                                        alt="Icon">
                                                </div>
                                                <p id="fileText">Click to browse or drag and drop your files</p>
                                            </div>
                                        </div>

                                        <div class="note">
                                            <p>Accepted file types: pdf, Max. file size: 256 MB, Max. files: 2.</p>
                                            <div class="ibtn">
                                                <button type="button" class="ibtn-icon">
                                                    <img src="{{ asset('student/images/i-icon.svg') }}" alt="Icon">
                                                </button>
                                                <div class="ibtn-info">
                                                    <button type="button" class="ibtn-close">
                                                        <img src="{{ asset('student/images/fa-times.svg') }}"
                                                            alt="icon">
                                                    </button>
                                                    <h3>Upload Guidelines</h3>
                                                    <ul>
                                                        <li>Images larger than 5 MB are not accepted.</li>
                                                        <li>Videos must be under 10 MB in size.</li>
                                                        <li>If your files are larger, please upload them to your Google
                                                            Drive
                                                            and share the link here. This helps ensure smooth uploads and
                                                            better
                                                            convenience for you.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-grp mb-lg">
                                        <label>Please upload the handwritten question page of the application, downloadable
                                            here. <br><i>We can only accept pdf files. If you need help getting a pdf, scan
                                                your
                                                file, open it on a computer, and click to print. In the printer settings,
                                                change
                                                the printer to PDF.</i></label>
                                        <div class="file-upload-lg">
                                            <input type="file" name="question" id="questionFile" accept=".pdf"
                                                hidden>
                                            <div class="file-upld-lg-design" id="questionDropArea">
                                                <div class="fupld-lg-icon">
                                                    <img src="{{ asset('student/images/upload-file-icon.svg') }}"
                                                        alt="Icon">
                                                </div>
                                                <p id="questionFileText">Click to browse or drag and drop your files</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="note">
                                        <p>Accepted file types: pdf, Max. file size: 256 MB, Max. files: 2.</p>
                                        <div class="ibtn">
                                            <button type="button" class="ibtn-icon">
                                                <img src="{{ asset('student/images/i-icon.svg') }}" alt="Icon">
                                            </button>
                                            <div class="ibtn-info">
                                                <button type="button" class="ibtn-close">
                                                    <img src="{{ asset('student/images/fa-times.svg') }}" alt="icon">
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
                    <button type="button" class="cmn-btn btn-sm" id="saveDraftBtn">
                        Save and Continue Later
                    </button>
                    <button type="button" id="saveBtn" class="cmn-btn btn-sm">
                        Save and Continue Later
                    </button>

                </div>
            </div>

        </div>
        </div>
    </form>
@endsection
@push('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Hebcal Library -->
    <script src="https://unpkg.com/hebcal/dist/hebcal.browser.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#hdob').datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '5600:5900', // Hebrew years roughly equivalent to 1840–2140
                onSelect: function(dateText, inst) {
                    const gDate = new Date(dateText);
                    const hebrewDate = new JewishCalendar(gDate);
                    alert("Hebrew Date: " + hebrewDate.toString()); // You can display or store this
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // ➕ Add a new whole block (without duplicating buttons)
            $(document).on('click', '.add-list', function() {
                let newBlock = $('.multi-input-grp-list:first').clone();
                newBlock.find('input').val(''); // clear inputs
                $('.multi-input-section').find('.multi-input-grp-list:last').after(newBlock);
            });

            // ➖ Remove a whole block
            $(document).on('click', '.remove-list', function() {
                if ($('.multi-input-grp-list').length > 1) {
                    $('.multi-input-grp-list:last').remove();
                } else {
                    alert('At least one entry is required.');
                }
            });
        });
    </script>

    <script>
        document.addEventListener("click", function(e) {
            if (e.target.closest(".addBtn")) {
                e.preventDefault();
                const currentBlock = e.target.closest(".multi-input-grp-list");
                const container = document.getElementById("multiInputContainer");
                const clone = currentBlock.cloneNode(true);

                // clear input values in the clone
                clone.querySelectorAll("input").forEach(input => input.value = "");

                container.appendChild(clone);
            }

            if (e.target.closest(".removeBtn")) {
                e.preventDefault();
                const container = document.getElementById("multiInputContainer");
                const currentBlock = e.target.closest(".multi-input-grp-list");

                if (container.children.length > 1) {
                    currentBlock.remove();
                }
            }
        });
    </script>
    <script>
        const dropArea = document.getElementById("dropArea");
        const fileInput = document.getElementById("fileInput");
        const fileText = document.getElementById("fileText");

        // Click on area opens file dialog
        dropArea.addEventListener("click", () => fileInput.click());

        // Handle file selection via input
        fileInput.addEventListener("change", () => {
            if (fileInput.files.length) {
                fileText.textContent = `Selected: ${fileInput.files[0].name}`;
            }
        });

        // Drag over effect
        dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropArea.classList.add("dragover");
        });

        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove("dragover");
        });

        // Handle dropped file
        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            dropArea.classList.remove("dragover");

            if (e.dataTransfer.files.length) {
                const file = e.dataTransfer.files[0];
                if (file.type === "application/pdf") {
                    fileInput.files = e.dataTransfer.files;
                    fileText.textContent = `Selected: ${file.name}`;
                } else {
                    alert("Please upload a PDF file only.");
                }
            }
        });
    </script>
    <script>
        const dropAreaQ = document.getElementById("questionDropArea");
        const fileInputQ = document.getElementById("questionFile");
        const fileTextQ = document.getElementById("questionFileText");

        // Click to open file picker
        dropAreaQ.addEventListener("click", () => fileInputQ.click());

        // On file input change
        fileInputQ.addEventListener("change", () => {
            if (fileInputQ.files.length) {
                fileTextQ.textContent = `Selected: ${fileInputQ.files[0].name}`;
            }
        });

        // Drag enter / over
        dropAreaQ.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropAreaQ.classList.add("dragover");
        });

        // Drag leave
        dropAreaQ.addEventListener("dragleave", () => {
            dropAreaQ.classList.remove("dragover");
        });

        // Drop event
        dropAreaQ.addEventListener("drop", (e) => {
            e.preventDefault();
            dropAreaQ.classList.remove("dragover");

            if (e.dataTransfer.files.length) {
                const file = e.dataTransfer.files[0];
                if (file.type === "application/pdf") {
                    fileInputQ.files = e.dataTransfer.files;
                    fileTextQ.textContent = `Selected: ${file.name}`;
                } else {
                    alert("Please upload a PDF file only.");
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('application');
            const draftUrl = "{{ route('applicant.application.form.draft') }}";

            // Common AJAX save function
            function saveDraft() {
                const formData = new FormData(form);

                fetch(draftUrl, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Draft saved successfully!");
                        } else {
                            alert(data.message || "Failed to save draft.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while saving the draft.");
                    });
            }

            // Draft link click
            document.getElementById('saveDraftLink').addEventListener('click', function(e) {
                e.preventDefault();
                saveDraft();
            });

            // Save and Continue Later button click
            document.getElementById('saveDraftBtn').addEventListener('click', function(e) {
                e.preventDefault();
                saveDraft();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('application');
            const saveUrl = "{{ route('applicant.application.form.save') }}";

            function saveFormData() {
                const formData = new FormData(form);
                const fields = {
                    first_name: formData.get('first_name')?.trim(),
                    last_name: formData.get('last_name')?.trim(),
                    prefered_name: formData.get('prefered_name')?.trim(),
                    hebrew_name: formData.get('hebrew_name')?.trim(),
                    address: formData.get('address')?.trim(),
                    City: formData.get('City')?.trim(),
                    number: formData.get('number')?.trim(),
                    birth_place: formData.get('birth_place')?.trim(),
                    dob: formData.get('dob')?.trim(),
                    hdob: formData.get('hdob')?.trim(),
                    maritalStatus: formData.get('maritalStatus')?.trim(),
                    sibling: formData.get('sibling')?.trim(),
                    school: formData.get('school')?.trim(),
                    s_tel: formData.get('s_tel')?.trim(),
                    grade: formData.get('grade')?.trim(),
                    advisor_name: formData.get('advisor_name')?.trim(),
                    email_address: formData.get('email_address')?.trim(),
                    school_name: formData.get('school_name')?.trim(),
                    grades: formData.get('grades')?.trim(),
                    surgery: formData.get('surgery')?.trim(),
                    medication: formData.get('medication')?.trim(),
                    allergies: formData.get('allergies')?.trim(),
                };

                // ✅ 1. Check for empty required fields
                for (const [key, value] of Object.entries(fields)) {
                    if (!value) {
                        alert(`Please fill in the ${key.replace('_', ' ')} field.`);
                        return;
                    }
                }

                // ✅ 2. Validate the last two PDF fields
                const questionFile = formData.get('question');
                const aboutFile = formData.get('about');

                // Helper: validate each PDF
                function validatePDF(file, fieldName) {
                    if (!file || file.size === 0) {
                        alert(`Please upload the ${fieldName} PDF file.`);
                        return false;
                    }

                    const fileType = file.type;
                    const fileSizeMB = file.size / (1024 * 1024);

                    if (fileType !== 'application/pdf') {
                        alert(`${fieldName} must be a PDF file.`);
                        return false;
                    }

                    if (fileSizeMB > 10) {
                        alert(`${fieldName} file must not exceed 10 MB.`);
                        return false;
                    }

                    return true;
                }

                if (!validatePDF(questionFile, 'Question') || !validatePDF(aboutFile, 'About')) {
                    return; // Stop form submission
                }


                // Disable buttons to prevent double-click
                document.getElementById('saveBtn').disabled = true;

                fetch(saveUrl, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Form saved successfully!");
                        } else {
                            alert(data.message || "Something went wrong while saving the form.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while saving the form.");
                    })
                    .finally(() => {
                        // Re-enable buttons after completion
                        document.getElementById('saveBtn').disabled = false;

                    });
            }



            // “Save and Continue Later” button click
            document.getElementById('saveBtn').addEventListener('click', function(e) {
                e.preventDefault();
                saveFormData();
            });
        });
    </script>
@endpush
