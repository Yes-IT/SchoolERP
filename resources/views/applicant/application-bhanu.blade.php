@extends('applicant.partials.app')

@section('content')
    <style>
        .signature-area {
            position: relative;
            /* required for ::after */
            width: 100%;
            max-width: 600px;
            height: 200px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            box-sizing: border-box;
            touch-action: none;
            /* prevents scroll while drawing on touch devices */
        }

        /* canvas fills the container */
        .signature-area canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        /* visible Clear button via ::after */
        .signature-area::after {
            content: "Clear";
            position: absolute;
            bottom: 8px;
            right: 10px;
            background: #007bff;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            user-select: none;
            z-index: 5;
        }

        .signature-area::after:hover {
            background: #0056b3;
        }
    </style>
    <form action="{{ route('applicant.application.form.save.bhanu') }}" id="application" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="dashboard-body dspr-body-outer">
            @include('applicant.partials.header')

            <div class="ds-breadcrumb">
                <h1> Application Bhanu</h1>
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
                                        <input type="text" name="first_name" placeholder="Enter First Name"
                                            value="{{ isset($data['applicant']) ? $data['applicant']->first_name : '' }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>Last Name *</label>
                                        <input type="text" name="last_name" placeholder="Enter Last Name"
                                            value="{{ old('last_name', isset($data['applicant']) ? $data['applicant']->last_name : '') }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>You prefer to be called: *</label>
                                        <input type="text" name="prefered_name" placeholder="You prefer to be called:"
                                            value="{{ old('prefered_name', isset($data['applicant']) ? $data['applicant']->prefered_name : '') }}">
                                    </div>
                                </div>

                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>שם בעברית *</label>
                                        <input type="text" name="hebrew_name" placeholder="שם בעברית"
                                            value="{{ old('hebrew_name', isset($data['applicant']) ? $data['applicant']->hebrew_name : '') }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>שם פרטי</label>
                                        <input type="text" name="hebrew_first_name" placeholder="שם פרטי"
                                            value="{{ old('hebrew_first_name', isset($data['applicant']) ? $data['applicant']->hebrew_first_name : '') }}">
                                    </div>
                                </div>

                                <div class="input-grp">
                                    <label>Address *</label>
                                    <input type="text" name="address" placeholder="Enter Address"
                                        value="{{ old('address', isset($data['applicant']) ? $data['applicant']->address : '') }}">
                                </div>

                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>City *</label>
                                        <input name="city" placeholder="City *" class="form-control"
                                            value="{{ old('city', isset($data['applicant']) ? $data['applicant']->city : '') }}">
                                    </div>

                                    <div class="input-grp">
                                        <label>State</label>
                                        <select name="state" class="form-control select2">
                                            <option value="">Select State</option>
                                            @foreach ($data['states'] as $state)
                                                <option value="{{ $state->state }}"
                                                    {{ old('state', isset($data['applicant']) ? $data['applicant']->state : '') == $state->state ? 'selected' : '' }}>
                                                    {{ $state->state }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-grp">
                                        <label>Country</label>
                                        <select name="country" class="form-control select2">
                                            <option value="">Select Country</option>
                                            @foreach ($data['countries'] as $country)
                                                <option value="{{ $country->country_name }}"
                                                    {{ old('country', isset($data['applicant']) ? $data['applicant']->country : '') == $country->country_name ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-grp">
                                        <label>Zip/Postal Code</label>
                                        <input type="text" name="zip" placeholder="Zip/Postal Code"
                                            value="{{ old('zip', isset($data['applicant']) ? $data['applicant']->zip : '') }}">
                                    </div>
                                </div>

                                <div class="input-grp">
                                    <label>
                                        <span class="w-100 txt-primary d-block"><strong>City (for interviews)
                                                *</strong></span>
                                        This is used for setting up interviews and may be different than your mailing
                                        address.
                                        If you don’t see an option that looks correct for you, please let us know.
                                    </label>
                                   
                                    <select class="w-50" name="interview_city">
                                        <option value="">-Select a city-</option>
                                        @foreach ($data['cities'] as $city)
                                            <option value="{{ $city->city }}"
                                                {{ old('interview_city', isset($data['applicant']) ? $data['applicant']->interview_city : '') == $city->city ? 'selected' : '' }}>
                                                {{ $city->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="multi-input-grp grp-3">
                                    <div class="input-grp">
                                        <label>Applicant's email</label>
                                        <input type="text" name="email" placeholder="Enter Email"
                                            value="{{ old('email', isset($data['applicant']) ? $data['applicant']->email : '') }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>Applicant's cell</label>
                                        <input type="text" name="usa_cell" placeholder="Enter Applicant's cell"
                                            value="{{ old('cell', isset($data['applicant']) ? $data['applicant']->usa_cell : '') }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>Home Phone*</label>
                                        <input type="text" name="cell" placeholder="Enter Phone"
                                            value="{{ old('cell', isset($data['applicant']) ? $data['applicant']->cell : '') }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>Place of birth *</label>
                                        <input type="text" name="birth_place" placeholder="Place of birth"
                                            value="{{ old('birth_place', isset($data['applicant']) ? $data['applicant']->birth_place : '') }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>Date of birth *</label>
                                        <input type="date" name="dob" class="form-control"
                                            value="{{ old('dob', isset($data['applicant']) ? $data['applicant']->date_of_birth : '') }}">
                                    </div>
                                    <div class="input-grp">
                                        <label>Hebrew date of birth (בעברית) *</label>
                                        <input type="date" id="hdob" name="hdob" class="form-control"
                                            value="{{ old('hdob', isset($data['applicant']) ? $data['applicant']->hdob : '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="accr-item">
                            <div class="accr-head">
                                <h3>Family</h3>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            @php
                                $maritalStatus = $data['applicant_parents']->marital_status ?? '';
                            @endphp
                            <div class="accr-content">
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">Parent's marital status *</h4>
                                    <label><input type="radio" name="maritalStatus" value="Married" id="maritalStatus"
                                            {{ $maritalStatus === 'Married' ? 'checked' : '' }}>
                                        Married</label>
                                    <label><input type="radio" name="maritalStatus" value="Widowed" id="maritalStatus"
                                            {{ $maritalStatus === 'Widowed' ? 'checked' : '' }}>
                                        Widowed</label>
                                    <label><input type="radio" name="maritalStatus" value="Divorced"
                                            id="maritalStatus" {{ $maritalStatus === 'Divorced' ? 'checked' : '' }}>
                                        Divorced</label>
                                    <label><input type="radio" name="maritalStatus" value="Separated"
                                            id="maritalStatus" {{ $maritalStatus === 'Separated' ? 'checked' : '' }}>
                                        Separated</label>
                                    <label><input type="radio" name="maritalStatus" value="Remarried"
                                            id="maritalStatus" {{ $maritalStatus === 'Remarried' ? 'checked' : '' }}>
                                        Remarried</label>
                                </div>
                                <div class="input-grp w-50">
                                    <label>How many siblings do you have? *</label>
                                    <input type="number" name="sibling"
                                        value="{{ $data['applicant_parents']->siblings ?? 0 }}" placeholder="0">
                                    <p>Please enter a number from 0 to 22.</p>
                                </div>
                            </div>
                        </div>
                        @php
                            $schoolData = $data['aplicant_history'] ?? null;

                            // Decode arrays if stored as JSON strings
                            $schoolNames = !empty($schoolData->school_name)
                                ? json_decode($schoolData->school_name, true)
                                : [''];
                            $schoolGrades = !empty($schoolData->school_grades)
                                ? json_decode($schoolData->school_grades, true)
                                : [''];
                        @endphp

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
                                            <option value="-Select-" disabled>-Select-</option>
                                            <option value="carmel"
                                                {{ ($schoolData->school ?? '') == 'carmel' ? 'selected' : '' }}>Carmel
                                            </option>
                                            <option value="dav"
                                                {{ ($schoolData->school ?? '') == 'dav' ? 'selected' : '' }}>Dav</option>
                                        </select>
                                    </div>

                                    <div class="input-grp">
                                        <label>School phone *</label>

                                        <input type="tel" name="s_tel" placeholder="Enter School phone"
                                            value="{{ $schoolData->school_tel ?? '' }}">
                                    </div>

                                    <div class="input-grp">
                                        <label>Grade *</label>
                                        <input type="text" name="grade" placeholder="Enter Grade"
                                            value="{{ $schoolData->grade ?? '' }}">
                                    </div>
                                </div>

                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>Sem advisor's name *</label>
                                        <input type="text" name="advisor_name" placeholder="Enter Sem advisor's name"
                                            value="{{ $schoolData->advisor_name ?? '' }}">
                                    </div>

                                    <div class="input-grp">
                                        <label>Home #</label>
                                        <input type="text" name="home" placeholder="Home #"
                                            value="{{ $schoolData->home ?? '' }}">
                                    </div>

                                    <div class="input-grp">
                                        <label>Cell #</label>
                                        <input type="tel" name="home_cell" placeholder="Enter Cell"
                                            value="{{ $schoolData->home_cell ?? '' }}">
                                    </div>

                                    <div class="input-grp">
                                        <label>Email address *</label>
                                        <input type="email" name="email_address" placeholder="Enter Email address"
                                            value="{{ $schoolData->email_address ?? '' }}">
                                    </div>
                                </div>

                                <div class="accr-cmn-inr-wrp">
                                    <h4 class="cmn-accr-head">List all schools you have attended, starting from elementary
                                        *</h4>

                                    <div class="multi-input-section">
                                        @foreach ($schoolNames as $index => $name)
                                            <div class="multi-input-grp-list">
                                                <div class="multi-input-grp">
                                                    <div class="input-grp">
                                                        <label>Name of school</label>
                                                        <input type="text" name="school_name[]"
                                                            placeholder="Name of school" value="{{ $name }}">
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Grades attended</label>
                                                        <input type="text" name="grades[]" placeholder="Enter Grades"
                                                            value="{{ $schoolGrades[$index] ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="action-wrp">
                                                    <button type="button" class="add-list"><i
                                                            class="fa-solid fa-plus"></i></button>
                                                    <button type="button" class="remove-list"><i
                                                            class="fa-solid fa-minus"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="input-grp has-multi-radio">
                                        <h4 class="txt-primary cmn-accr-head">
                                            Did you receive modified schoolwork in high school?
                                        </h4>

                                        <label>
                                            <input type="radio" name="modified" value="1"
                                                {{ ($schoolData->modified ?? 0) == 1 ? 'checked' : '' }}>
                                            Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="modified" value="0"
                                                {{ ($schoolData->modified ?? 0) == 0 ? 'checked' : '' }}>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $otherData = $data['aplicant_history'] ?? null;

                            // Decode the relatives arrays (if stored as JSON strings)
                            $relationNames = !empty($otherData->relation_name)
                                ? json_decode($otherData->relation_name, true)
                                : [''];
                            $relationAddresses = !empty($otherData->relation_address)
                                ? json_decode($otherData->relation_address, true)
                                : [''];
                            $relationPhones = !empty($otherData->relation_phone)
                                ? json_decode($otherData->relation_phone, true)
                                : [''];
                            $relationRelationships = !empty($otherData->relation_relationship)
                                ? json_decode($otherData->relation_relationship, true)
                                : [''];
                        @endphp

                        <div class="accr-item">
                            <div class="accr-head">
                                <h3>Other</h3>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>

                            <div class="accr-content">
                                <!-- Surgery -->
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">
                                        Have you ever suffered from a serious injury, illness or eating disorder, or
                                        undergone a surgery? *
                                    </h4>
                                    <label>
                                        <input type="radio" value="1" name="surgery"
                                            {{ ($otherData->surgery ?? 0) == 1 ? 'checked' : '' }}>
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" value="0" name="surgery"
                                            {{ ($otherData->surgery ?? 0) == 0 ? 'checked' : '' }}>
                                        No
                                    </label>
                                </div>

                                <!-- Medication -->
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">
                                        Do you or have you taken any medication for a period of 3 months or more during the
                                        past 3 years? *
                                    </h4>
                                    <label>
                                        <input type="radio" value="1" name="medication"
                                            {{ ($otherData->medication ?? 0) == 1 ? 'checked' : '' }}>
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" value="0" name="medication"
                                            {{ ($otherData->medication ?? 0) == 0 ? 'checked' : '' }}>
                                        No
                                    </label>
                                </div>

                                <!-- Allergies -->
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">
                                        Do you have any allergies or medically required dietary needs? *
                                    </h4>
                                    <label>
                                        <input type="radio" value="1" name="allergies"
                                            {{ ($otherData->allergies ?? 0) == 1 ? 'checked' : '' }}>
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" value="0" name="allergies"
                                            {{ ($otherData->allergies ?? 0) == 0 ? 'checked' : '' }}>
                                        No
                                    </label>
                                </div>

                                <!-- Relatives/Friends -->
                                <div class="accr-cmn-inr-wrp">
                                    <h4 class="cmn-accr-head">Relatives or close friends living in Israel:</h4>

                                    <div id="multiInputContainer">
                                        @foreach ($relationNames as $index => $name)
                                            <div class="multi-input-grp-list">
                                                <div class="multi-input-grp grp-4">
                                                    <div class="input-grp">
                                                        <label>Name</label>
                                                        <input type="text" name="relation_name[]" placeholder="Name"
                                                            value="{{ $name }}">
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Address</label>
                                                        <input type="text" name="relation_address[]"
                                                            placeholder="Address"
                                                            value="{{ $relationAddresses[$index] ?? '' }}">
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Phone</label>
                                                        <input type="tel" name="relation_phone[]"
                                                            placeholder="Enter Phone"
                                                            value="{{ $relationPhones[$index] ?? '' }}">
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Relationship</label>
                                                        <input type="text" name="relation_relationship[]"
                                                            placeholder="Relationship"
                                                            value="{{ $relationRelationships[$index] ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="action-wrp">
                                                    <button type="button" class="addBtn"><i
                                                            class="fa-solid fa-plus"></i></button>
                                                    <button type="button" class="removeBtn"><i
                                                            class="fa-solid fa-minus"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accr-item">
                            <div class="accr-head">
                                <h3>Uploads</h3>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="accr-content">
                                <div class="warning-box">
                                    <strong>BLACK PEN ONLY </strong>
                                    FOR QUESTIONS, BIO, AND RECOMMENDATION LETTERS. If it cannot be read, your
                                    application will not be accepted. Please double-check your scans to ensure they are
                                    clear!
                                    Pictures are not acceptable. Files should be scanned using a flatbed scanner or a
                                    scanning app.
                                    Please save them as letter size, not A4.
                                </div>

                                <div class="accr-cmn-inr-wrp">
                                    <h4 class="cmn-accr-head">About you: Questions *</h4>
                                    <div class="input-grp mb-lg">
                                        <label>Please upload the handwritten question page of the application,
                                            downloadable here. <br><i>We can only accept pdf files. If you need help getting
                                                a pdf,
                                                scan your file, open it on a computer, and click to print. In the printer
                                                settings, change the printer to PDF.</i></label>
                                        <div class="file-upload-lg">
                                            <input type="file" name="about" id="fileInput" accept=".pdf" hidden>
                                            <div class="file-upld-lg-design" id="dropArea">
                                                <div class="fupld-lg-icon">
                                                    <img src="{{ asset('student/images/upload-file-icon.svg') }}"
                                                        alt="Icon">
                                                </div>
                                                <p id="fileText">
                                                    @if (!empty($data['aplicant_history']->about))
                                                        {{ basename($data['aplicant_history']->about) }}
                                                    @else
                                                        Click to browse or drag and drop your files
                                                    @endif
                                                </p>
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
                                                            and share the link here.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-grp mb-lg">
                                        <label>Please upload the handwritten question page of the application,
                                            downloadable here. <br><i>We can only accept pdf files. If you need help getting
                                                a pdf,
                                                scan your file, open it on a computer, and click to print. In the printer
                                                settings, change the printer to PDF.</i></label>
                                        <div class="file-upload-lg">
                                            <input type="file" name="question" id="questionFile" accept=".pdf"
                                                hidden>
                                            <div class="file-upld-lg-design" id="questionDropArea">
                                                <div class="fupld-lg-icon">
                                                    <img src="{{ asset('student/images/upload-file-icon.svg') }}"
                                                        alt="Icon">
                                                </div>
                                                <p id="questionFileText">
                                                    @if (!empty($data['aplicant_history']->question))
                                                        {{ basename($data['aplicant_history']->question) }}
                                                    @else
                                                        Click to browse or drag and drop your files
                                                    @endif
                                                </p>
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
                                                        and share the link here.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 1 -->
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">Hebrew and secular studies high school attendance
                                        records *</h4>
                                    <label><input type="radio" value="school" name="attendance_upload"> My school will
                                        upload them.</label>
                                    <label><input type="radio" value="self"
                                            @if (!empty($data['aplicant_history']->attendance_upload)) checked @endif name="attendance_upload"> I
                                        will upload
                                        them here.</label>
                                </div>

                                <div class="file-upload-lg" id="attendance_upload_box"
                                    @if (empty($data['aplicant_history']->attendance_upload)) style="display:none;" @endif>
                                    <input type="file" name="attendance_upload" id="attendance_file" accept=".pdf"
                                        hidden>
                                    <div class="file-upld-lg-design" id="attendance_dropArea">
                                        <div class="fupld-lg-icon">
                                            <img src="{{ asset('student/images/upload-file-icon.svg') }}" alt="Icon">
                                        </div>
                                        <p id="attendance_fileText">
                                            @if (!empty($data['aplicant_history']->attendance_upload))
                                                {{ basename($data['aplicant_history']->attendance_upload) }}
                                            @else
                                                Click to browse or drag and drop your files
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Section 2 -->
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">Hebrew and secular studies high school
                                        transcripts *</h4>
                                    <label><input type="radio" value="school" name="transcript_upload"> My school will
                                        upload them.</label>
                                    <label><input type="radio" value="self" name="transcript_upload"
                                            @if (!empty($data['aplicant_history']->transcript_upload)) checked @endif> I will upload
                                        them here.</label>
                                </div>

                                <div class="file-upload-lg" id="transcript_upload_box"
                                    @if (empty($data['aplicant_history']->transcript_upload)) style="display:none;" @endif>
                                    <input type="file" name="transcript_upload" id="transcript_file" accept=".pdf"
                                        hidden>
                                    <div class="file-upld-lg-design" id="transcript_dropArea">
                                        <div class="fupld-lg-icon">
                                            <img src="{{ asset('student/images/upload-file-icon.svg') }}" alt="Icon">
                                        </div>
                                        <p id="transcript_fileText">
                                            @if (!empty($data['aplicant_history']->transcript_upload))
                                                {{ basename($data['aplicant_history']->transcript_upload) }}
                                            @else
                                                Click to browse or drag and drop your files
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Section 3 -->
                                <div class="input-grp has-multi-radio">
                                    <h4 class="txt-primary cmn-accr-head">How will you send your recommendation letters? *
                                    </h4>
                                    <h4 class="txt-primary cmn-accr-head">
                                        Two recommendation letters are required. It is highly recommended to keep a copy
                                        of all recommendation letters submitted.
                                    </h4>
                                    <label><input type="radio" value="school" name="recommendation_upload"> My school
                                        will upload them.</label>
                                    <label><input type="radio" value="self" name="recommendation_upload"
                                            @if (!empty($data['aplicant_history']->recommendation_upload)) checked @endif> I will
                                        upload them here.</label>
                                </div>

                                <div class="file-upload-lg" id="recommendation_upload_box"
                                    @if (empty($data['aplicant_history']->recommendation_upload)) style="display:none;" @endif>
                                    <input type="file" name="recommendation_upload" id="recommendation_file"
                                        accept=".pdf" hidden>
                                    <div class="file-upld-lg-design" id="recommendation_dropArea">
                                        <div class="fupld-lg-icon">
                                            <img src="{{ asset('student/images/upload-file-icon.svg') }}" alt="Icon">
                                        </div>
                                        <p id="recommendation_fileText">
                                            @if (!empty($data['aplicant_history']->recommendation_upload))
                                                {{ basename($data['aplicant_history']->recommendation_upload) }}
                                            @else
                                                Click to browse or drag and drop your files
                                            @endif
                                        </p>
                                    </div>
                                </div>


                                
                                <div class="input-grp" id="school_office_mail_box" style="display:none;">
                                    <label>School office email address*</label>
                                    <label>We will email your school to with a form to upload your letters/records. Please check with your school for the correct email address for the person who can upload this information.</label>
                                    <input type="text" name="address" placeholder="Enter Address"
                                        value="{{ old('address', isset($data['applicant']) ? $data['applicant']->address : '') }}">
                                </div>

                                <h4 class="txt-primary cmn-accr-head">Please upload a photo of yourself *</h4>
                                <h4 class="txt-primary cmn-accr-head">
                                    Picture must be in color. You will be able to crop and resize your photo after
                                    uploading.
                                    Please center it on your face. JPEG/JPG format required.
                                </h4>
                                <button class="cmn-suggestion-btn">Click to browse or drag and drop your files</button>

                            </div>
                        </div>

                        <!-- Tuition Information & Confirmation -->
                        <div class="accr-item">
                            <div class="accr-head">
                                <h3>Tuition Information & Confirmation</h3>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="accr-content">
                                <p>Tuition for the school year 2024-2025 is  $27,800.00 in U.S. funds. There is an
                                    option to
                                    pay tuition in British Sterling via a UK Charity.  Tuition includes dormitory
                                    accommodations and full board. The school also takes responsibility for providing
                                    meals
                                    for Shabbos, Yom Tov and when classes are not in session during the academic year.
                                    Any
                                    questions or concerns regarding tuition payments should be directed to our
                                    administrator
                                    Mr. Friedman ONLY, either by email admin@meohr.org or USA phone number 718-564-6777.
                                </p>

                                <div class="accr-cmn-inr-wrp">
                                    <h4 class="cmn-accr-head">Email address for parental communication *</h4>
                                    <h4 class="cmn-accr-head">As important school information is sent to parents via
                                        group
                                        emails, please indicate the email address you would like us to use for this
                                        purpose:
                                    </h4>
                                    <div id="multiInputContainer">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp grp-4">
                                                <div class="input-grp">
                                                    <input type="text" name="parent_email" placeholder="Enter Email"
                                                        value="{{ old('parent_email', $data['aplicant_confirmation']->parent_email ?? '') }}">
                                                    <label>Enter Email</label>
                                                </div>

                                                <div class="input-grp">
                                                    <input type="text" name="confirm_email"
                                                        placeholder="Confirm Email"
                                                        value="{{ old('confirm_email', $data['aplicant_confirmation']->parent_email ?? '') }}">
                                                    <label>Confirm Email</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                        <!-- Letter from Me'ohr Hanhala & Staff -->
                        <div class="accr-item">
                            <div class="accr-head">
                                <h3>Letter from Me'ohr Hanhala & Staff</h3>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="accr-content">
                                <p>Dear Applicant,</p>
                                <p>Thank you for considering Me’ohr Bais Yaakov as a possibility for Seminary next year.
                                    We
                                    will review your application with great care and consideration.</p>
                                <p>We are taking the liberty of providing a few words of practical advice to the many
                                    young
                                    women who are about to make some very important decisions. We are doing so after
                                    witnessing the great heartbreak and misery that have somehow become synonymous with
                                    a
                                    decision that is essentially one of aspiration for growth and success.</p>

                                <p>1. While coming to Eretz Yisroel has a great deal of potential for growth in all
                                    areas of
                                    life, there are also potential dangers of the same magnitude. You should know
                                    yourself
                                    well and consider carefully if this year will be best spent at home or away from
                                    home.
                                    This consideration must be magnified when applying to Me’ohr where the high level of
                                    trust is not good for every girl</p>
                                <p>2. You may have heard that the work in Me’ohr is not on a high level and you can come
                                    and
                                    have a great year without fulfilling educational responsibilities. If that is your
                                    hope
                                    for this coming year, please take back your application. While it is true that there
                                    is
                                    wonderful exciting and happy environment. Me’ohr has always been and will Bez”H,
                                    continue to be a school for girls interested in what we have to offer in the
                                    classroom,
                                    In general, girls who are overly absorbed in “appearance”, “fun” and “reputation”
                                    will
                                    probably not do very well in that environment.</p>
                                <p>3. Me’ohr is also known for having fewer rules. If because there are FEWER
                                    consequences
                                    you do not feel the need to conform to the standards of the Seminary; we once again
                                    respectfully request that you do not proceed with filling out this application. We
                                    are
                                    ONLY interested in young women who WANT TO AND ARE READY to live by the standards of
                                    a
                                    serious Bais Yaakov School.</p>
                                <p>4. Surely you are aware of the cost of Seminary education and the concomitant
                                    expenses of
                                    travel etc. We believe it is your responsibility not to put pressure on your
                                    parents, if
                                    the cost is beyond their means. Many wonderful students attend the local seminaries
                                    and
                                    do very well.</p>
                                <p>5. While there are some scholarships available, Me’ohr is not in the “business” of
                                    “buying” girls to come to our seminary. If you are interested in applying and you
                                    get
                                    accepted, you can then speak to our administration regarding the scholarship.</p>
                                <p>6. Please make certain to apply to at least three seminaries that are real
                                    considerations. Even those students, who are confident that they will be accepted to
                                    their “first choice”, should be sure to apply to other “first choices.” It is
                                    presumptuous to assume that there is only one seminary at which you can do well.
                                    Boruch
                                    HaShem, Eretz Yisroel is blessed with many fine seminaries, each offering fantastic
                                    educational opportunities. The derech of each one may differ in some measure, but in
                                    each one a young woman can grow and develop her spiritual and educational potential.
                                </p>
                                <p>7. Finally, we ask you to understand that the selection process is not always fair.
                                    Sometimes it seems to us that almost everyone who applied would be perfect. The
                                    number
                                    of special young women who apply far exceeds the amount we can accept due to limited
                                    space. This very uncomfortable reality often forces us to choose between two
                                    wonderful
                                    young women, both of whom we would be happy to have as students. When we make the
                                    final
                                    choices it is difficult to define how or why we made some of the decisions. We are
                                    but
                                    flesh and blood and obviously we make mistakes.</p>
                                <br>
                                <p>So now, as you embark on this journey, we wish you great הצלחה and sincerely hope you
                                    will see the Yad HaShem in the way things work out at the end of this process.</p>
                                <br><br>
                                <p>Sincerely,</p>
                                <p><strong>The Hanhala and Staff of Me’ohr Bais Yaakov</strong></p>



                            </div>
                        </div>
                        <!-- Signatures -->
                        <div class="accr-item">
                            <div class="accr-head">
                                <h3>Signatures</h3>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="accr-content">
                                <p>
                                    I hereby submit my application to Me’ohr Bais Yaakov Teachers Seminary and undertake
                                    to comply with all rules, regulations and standards set by the school.
                                    I certify that all the statements in this application are complete and accurate to
                                    the best of my knowledge.
                                    I am aware that omitting or providing false information could jeopardize my
                                    enrollment in Me’ohr.
                                </p>
                                <input type="checkbox" name="agree" value="1">
                                <label for="">By checking this box, you are agreeing to our terms of
                                    service.</label>
                                <br><br><br>

                                <div class="accr-cmn-inr-wrp">
                                    <div id="multiInputContainer">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp grp-4">
                                                <div class="input-grp">
                                                    <label>Applicant Name</label>
                                                    <input type="text" name="confirm_applicant"
                                                        placeholder="Applicant Name"
                                                        value="{{ old('confirm_applicant', $data['aplicant_confirmation']->confirm_applicant ?? '') }}">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Date</label>
                                                    <input type="date" name="applicant_date" placeholder="Enter Date"
                                                        value="{{ old('applicant_date', $data['aplicant_confirmation']->applicant_date ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="">Applicant's signature</label>
                                <div class="signature-fields-wrp">
                                    <div class="signature-area" id="signatureArea"
                                        @if (!empty($data['aplicant_confirmation']?->applicant_signature)) style="display:none;" @endif>
                                        <canvas id="signatureCanvas" name="applicant_signature" width="600"
                                            height="200"></canvas>
                                    </div>

                                    <div id="signaturePreview"
                                        @if (empty($data['aplicant_confirmation']?->applicant_signature)) style="display:none;" @endif>
                                        @if (!empty($data['aplicant_confirmation']?->applicant_signature))
                                            <img src="{{ asset($data['aplicant_confirmation']->applicant_signature) }}"
                                                alt="Applicant Signature" id="signatureImage"
                                                style="max-width: 600px; border: 1px solid #ccc; border-radius: 6px; display:block;">
                                        @endif
                                    </div>

                                    @if (!empty($data['aplicant_confirmation']?->applicant_signature))
                                        <button type="button" id="editSignatureBtn"
                                            class="btn btn-primary mt-2">Edit</button>
                                    @endif
                                </div>

                                <div class="accr-cmn-inr-wrp">
                                    <div id="multiInputContainer">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp grp-4">
                                                <div class="input-grp">
                                                    <label>Parent/Guardian name *</label>
                                                    <input type="text" name="guardian_name"
                                                        value="{{ old('guardian_name', $data['aplicant_confirmation']->guardian_name ?? '') }}"
                                                        placeholder="Enter Parent/Guardian name">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Date</label>
                                                    <input type="date" name="gaurdian_date" placeholder="Enter Date"
                                                        value="{{ old('gaurdian_date', $data['aplicant_confirmation']->gaurdian_date ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="">Parent/Guardian signature</label>
                                <div class="signature-fields-wrp">
                                    <div id="signaturePreview2"
                                        @if (empty($data['aplicant_confirmation']?->guardian_signature)) style="display:none;" @endif>
                                        @if (!empty($data['aplicant_confirmation']?->guardian_signature))
                                            <img src="{{ asset($data['aplicant_confirmation']->guardian_signature) }}"
                                                alt="Guardian Signature" id="signatureImage"
                                                style="max-width: 600px; border: 1px solid #ccc; border-radius: 6px; display:block;">
                                        @endif
                                    </div>

                                    <div class="signature-area" id="signatureArea2"
                                        @if (!empty($data['aplicant_confirmation']?->guardian_signature)) style="display:none;" @endif>
                                        <canvas id="signatureCanvas2" name="guardian_signature" width="600"
                                            height="200"></canvas>
                                    </div>

                                    @if (!empty($data['aplicant_confirmation']?->guardian_signature))
                                        <button type="button" id="editSignatureBtn2"
                                            class="btn btn-primary mt-2">Edit</button>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- Application Fee -->
                        <div class="accr-item">
                            <div class="accr-head">
                                <h3>Application Fee</h3>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="accr-content">
                                <p>
                                    By submitting this form, I hereby authorize Me’ohr Bais Yaakov to charge the
                                    non-refundable application fee of $150 to my credit card. This will be credited
                                    towards your tuition if you come to Me’ohr.
                                </p>

                                <div class="accr-cmn-inr-wrp">
                                    <div class="input-grp">
                                        <label>Billing Email *</label>
                                        <input type="text" name="billing_email"
                                            value="{{ old('billing_email', $data['aplicant_confirmation']->billing_email ?? '') }}"
                                            placeholder="Enter Billing Email">
                                    </div>
                                    <div class="input-grp">
                                        <label>Street Address</label>
                                        <input type="text" name="billing_address"
                                            value="{{ old('billing_address', $data['aplicant_confirmation']->billing_address ?? '') }}"
                                            placeholder="Street Address">
                                    </div>
                                </div>

                                <div class="accr-cmn-inr-wrp">
                                    <div id="multiInputContainer">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp grp-4">
                                                <div class="input-grp">
                                                    <label>State / Province / Region</label>
                                                    <select name="billing_state" class="form-control select2">
                                                        <option value="">Select State</option>
                                                        @foreach ($data['states'] as $state)
                                                            <option value="{{ $state->state }}"
                                                                {{ old('billing_state', $data['aplicant_confirmation']->billing_state ?? '') == $state->state ? 'selected' : '' }}>
                                                                {{ $state->state }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-grp">
                                                    <label>City</label>
                                                    <input type="text" name="billing_city"
                                                        value="{{ old('billing_city', $data['aplicant_confirmation']->billing_city ?? '') }}"
                                                        placeholder="Enter City">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accr-cmn-inr-wrp">
                                    <div id="multiInputContainer">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp grp-4">
                                                <div class="input-grp">
                                                    <label>ZIP / Postal Code</label>
                                                    <input type="text" name="billing_zip"
                                                        value="{{ old('billing_zip', $data['aplicant_confirmation']->billing_zip ?? '') }}"
                                                        placeholder="ZIP / Postal Code">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Country</label>
                                                    <select name="billing_country" class="form-control select2">
                                                        <option value="">Select Country</option>
                                                        @foreach ($data['countries'] as $country)
                                                            <option value="{{ $country->country_name }}"
                                                                {{ old('billing_country', $data['aplicant_confirmation']->billing_country ?? '') == $country->country_name ? 'selected' : '' }}>
                                                                {{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accr-cmn-inr-wrp mt-3">
                                    <div class="input-grp">
                                        <label for="">Secure Credit Card Payments via Authorize.net *</label>
                                        <br>
                                        <label>Card Number</label>
                                        <input type="text" name="billing_card"
                                            value="{{ old('billing_card', $data['aplicant_confirmation']->billing_card ?? '') }}"
                                            placeholder="Enter Card Number">
                                    </div>
                                </div>
                                <div class="accr-cmn-inr-wrp">
                                    <div id="multiInputContainer">
                                        <div class="multi-input-grp-list">
                                            <div class="multi-input-grp grp-4">
                                                <div class="input-grp">
                                                    <label>Expiration Date</label>
                                                    <input type="date" name="exp_date"
                                                        value="{{ old('exp_date', $data['aplicant_confirmation']->exp_date ?? '') }}"
                                                        placeholder="Expiration Date">
                                                </div>
                                                <div class="input-grp">
                                                    <label>Security Code</label>
                                                    <input type="text" name="security_code"
                                                        value="{{ old('security_code', $data['aplicant_confirmation']->security_code ?? '') }}"
                                                        placeholder="Security Code">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accr-cmn-inr-wrp">
                                    <div class="input-grp">
                                        <label>Cardholder Name</label>
                                        <input type="text" name="card_holder_name"
                                            value="{{ old('card_holder_name', $data['aplicant_confirmation']->card_holder_name ?? '') }}"
                                            placeholder="Enter Cardholder Name">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="btn-wrp justify-content-end">
                    <button type="button" class="cmn-btn btn-sm" id="saveDraftBtn">
                        Save and Continue Later
                    </button>
                    <button type="button" id="saveBtn" class="cmn-btn btn-sm">
                        Submit Application
                    </button>

                </div>
            </div>

        </div>
        </div>
    </form>
    {{-- Starting Modal --}}
    <!-- Status Modal -->
    <div class="modal fade" id="lms_view_modal2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div id="modalStatusIcon" class="mb-3"></div>
                <h4 id="modalStatusTitle" class="modal-title mb-2"></h4>
                <p id="modalStatusMessage" class="text-muted"></p>

                <div class="mt-4">
                    <button type="button" class="cmn-btn btn-sm back-btn" data-bs-dismiss="modal">
                        Okay
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Ending  Modal --}}
@endsection
@push('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Hebcal Library -->
    <script src="https://unpkg.com/hebcal/dist/hebcal.browser.min.js"></script>

    {{-- date piker --}}
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
    {{-- add or subtract form  --}}
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
    {{-- add or subtract form 2  --}}
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
    <!-- File Upload Scripts -->
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
    {{-- file upload script for question file --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropAreaQ = document.getElementById("questionDropArea");
            const fileInputQ = document.getElementById("questionFile");
            const fileTextQ = document.getElementById("questionFileText");

            if (!dropAreaQ || !fileInputQ || !fileTextQ) return; // Safety check

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
        });
    </script>
    {{-- daft submit script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('application');
            const draftUrl = "{{ route('applicant.application.form.draft') }}";

            // Common AJAX save function
            function saveDraft() {
                const formData = new FormData(form);
                const pads = window.__pads || {}; // This holds references from your initSignaturePad()

                const applicantPad = pads['signatureCanvas'];
                const guardianPad = pads['signatureCanvas2'];

                if (applicantPad && !applicantPad.isEmpty()) {
                    formData.append('applicant_signature', applicantPad.toDataURL('image/png'));
                }

                if (guardianPad && !guardianPad.isEmpty()) {
                    formData.append('guardian_signature', guardianPad.toDataURL('image/png'));
                }

                fetch(draftUrl, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        const modalTitle = document.getElementById('modalStatusTitle');
                        const modalMessage = document.getElementById('modalStatusMessage');
                        const modalIcon = document.getElementById('modalStatusIcon');
                        const modal = new bootstrap.Modal(document.getElementById('lms_view_modal2'));
                        modalIcon.innerHTML =
                            '<img src="{{ asset('images/okay.png') }}" alt="Success" width="60">';
                        modalTitle.textContent = "Success!";
                        modalMessage.textContent = "Form Drafted successfully!";
                        modal.show();
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        const modalTitle = document.getElementById('modalStatusTitle');
                        const modalMessage = document.getElementById('modalStatusMessage');
                        const modalIcon = document.getElementById('modalStatusIcon');
                        const modal = new bootstrap.Modal(document.getElementById('lms_view_modal2'));

                        modalIcon.innerHTML =
                            '<img src=""{{ asset('images/notOkay.png') }}"" alt="Error" width="60">';
                        modalTitle.textContent = "Error!";
                        modalMessage.textContent = "An error occurred while Drafting the form.";

                        modal.show();
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
    {{-- final submit script  --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('application');
            const saveUrl = "{{ route('applicant.application.form.save.bhanu') }}";

            function saveFormData() {
                const formData = new FormData(form);
                const fields = {
                    Application_Information_first_name: formData.get('first_name')?.trim(),
                    Application_Information_last_name: formData.get('last_name')?.trim(),
                    Application_Information_prefered_name: formData.get('prefered_name')?.trim(),
                    Application_Information_hebrew_name: formData.get('hebrew_name')?.trim(),
                    Application_Information_address: formData.get('address')?.trim(),
                    Application_Information_city: formData.get('city')?.trim(),
                    Application_Information_zip: formData.get('zip')?.trim(),
                    Application_Information_birth_place: formData.get('birth_place')?.trim(),
                    Application_Information_dob: formData.get('dob')?.trim(),
                    Application_Information_hdob: formData.get('hdob')?.trim(),
                    Application_Information_interview_city: formData.get('interview_city')?.trim(),
                    Application_Information_cell: formData.get('cell')?.trim(),
                    Family_marital_status: formData.get('maritalStatus')?.trim(),
                    Family_sibling: formData.get('sibling')?.trim(),
                    School_current_school: formData.get('school')?.trim(),
                    School_school_phone: formData.get('s_tel')?.trim(),
                    School_grade: formData.get('grade')?.trim(),
                    School_advisor_name: formData.get('advisor_name')?.trim(),
                    School_email_address: formData.get('email_address')?.trim(),
                    Other_surgery: formData.get('surgery')?.trim(),
                    Other_medication: formData.get('medication')?.trim(),
                    Other_allergies: formData.get('allergies')?.trim(),
                    Tuition_Information_and_Confirmation_Email: formData.get('parent_email')?.trim(),
                    Tuition_Information_and_Confirmation_Email: formData.get('confirm_email')?.trim(),
                    Signatures_confirm_applicant: formData.get('confirm_applicant')?.trim(),
                    Signatures_applicant_date: formData.get('applicant_date')?.trim(),
                    Signatures_guardian_name: formData.get('guardian_name')?.trim(),
                    Signatures_gaurdian_date: formData.get('gaurdian_date')?.trim(),
                    Application_Fee_Billing_email: formData.get('billing_email')?.trim(),
                };

                // ✅ 1. Check for empty required fields
                for (const [key, value] of Object.entries(fields)) {
                    if (!value) {
                        const modalTitle = document.getElementById('modalStatusTitle');
                        const modalMessage = document.getElementById('modalStatusMessage');
                        const modalIcon = document.getElementById('modalStatusIcon');
                        const modal = new bootstrap.Modal(document.getElementById('lms_view_modal2'));

                        modalIcon.innerHTML =
                            '<img src="{{ asset('images/notOkay.png') }}" alt="Error" width="60">';
                        modalTitle.textContent = "Missing Field!";
                        modalMessage.textContent = `Please fill in the ${key.replace(/_/g, ' ')} field.`;


                        modal.show();
                        return; // stop further execution
                    }
                }

                // ✅ 2. Validate the last two PDF fields
                const questionFile = formData.get('question');
                const aboutFile = formData.get('about');

                // Helper: validate each PDF
                // function validatePDF(file, fieldName) {
                //     if (!file || file.size === 0) {
                //         alert(`Please upload the ${fieldName} PDF file.`);
                //         return false;
                //     }

                //     const fileType = file.type;
                //     const fileSizeMB = file.size / (1024 * 1024);

                //     if (fileType !== 'application/pdf') {
                //         alert(`${fieldName} must be a PDF file.`);
                //         return false;
                //     }

                //     if (fileSizeMB > 10) {
                //         alert(`${fieldName} file must not exceed 10 MB.`);
                //         return false;
                //     }

                //     return true;
                // }

                // if (!validatePDF(questionFile, 'Question') || !validatePDF(aboutFile, 'About')) {
                //     return; // Stop form submission
                // }


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
                        const modalTitle = document.getElementById('modalStatusTitle');
                        const modalMessage = document.getElementById('modalStatusMessage');
                        const modalIcon = document.getElementById('modalStatusIcon');
                        const modal = new bootstrap.Modal(document.getElementById('lms_view_modal2'));
                        modalIcon.innerHTML =
                            '<img src="{{ asset('images/okay.png') }}" alt="Success" width="60">';
                        modalTitle.textContent = "Success!";
                        modalMessage.textContent = "Form Saved successfully!";
                        modal.show();

                    })
                    .catch(error => {
                        console.error("Error:", error);
                        const modalTitle = document.getElementById('modalStatusTitle');
                        const modalMessage = document.getElementById('modalStatusMessage');
                        const modalIcon = document.getElementById('modalStatusIcon');
                        const modal = new bootstrap.Modal(document.getElementById('lms_view_modal2'));

                        modalIcon.innerHTML =
                            '<img src=""{{ asset('images/notOkay.png') }}"" alt="Error" width="60">';
                        modalTitle.textContent = "Error!";
                        modalMessage.textContent = "An error occurred while Drafting the form.";

                        modal.show();
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
    {{-- file upload script for multiple sections  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const schoolBox = document.getElementById('school_office_mail_box');

            const sections = [{
                    name: 'attendance_upload',
                    box: 'attendance_upload_box',
                    input: 'attendance_file',
                    text: 'attendance_fileText',
                    drop: 'attendance_dropArea'
                },
                {
                    name: 'transcript_upload',
                    box: 'transcript_upload_box',
                    input: 'transcript_file',
                    text: 'transcript_fileText',
                    drop: 'transcript_dropArea'
                },
                {
                    name: 'recommendation_upload',
                    box: 'recommendation_upload_box',
                    input: 'recommendation_file',
                    text: 'recommendation_fileText',
                    drop: 'recommendation_dropArea'
                },
            ];

            function toggleSchoolBox() {
                // Check if ANY radio group has value = 'school'
                const anySchool = sections.some(section => {
                    const checked = document.querySelector(`input[name="${section.name}"]:checked`);
                    return checked && checked.value === 'school';
                });

                schoolBox.style.display = anySchool ? 'block' : 'none';
            }

            sections.forEach(section => {
                // ✅ Handle show/hide for each upload box
                document.querySelectorAll(`input[name="${section.name}"]`).forEach(radio => {
                    radio.addEventListener('change', function() {
                        const box = document.getElementById(section.box);
                        if (this.value === 'self') {
                            box.style.display = 'block';
                        } 
                        else {
                            box.style.display = 'none';
                        }
                        
                        toggleSchoolBox();
                    });
                });

                // ✅ File upload handling
                const fileInput = document.getElementById(section.input);
                const dropArea = document.getElementById(section.drop);
                const fileText = document.getElementById(section.text);

                if (fileInput && dropArea && fileText) {

                    // Click opens file picker
                    dropArea.addEventListener('click', () => fileInput.click());

                    // Show selected file name
                    fileInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            fileText.textContent = this.files[0].name;
                        } else {
                            fileText.textContent = 'Click to browse or drag and drop your files';
                        }
                    });

                    // Drag events
                    dropArea.addEventListener('dragover', e => {
                        e.preventDefault();
                        dropArea.classList.add('dragover');
                    });

                    dropArea.addEventListener('dragleave', e => {
                        e.preventDefault();
                        dropArea.classList.remove('dragover');
                    });

                    dropArea.addEventListener('drop', e => {
                        e.preventDefault();
                        dropArea.classList.remove('dragover');
                        const files = e.dataTransfer.files;
                        if (files.length) {
                            fileInput.files = files;
                            fileText.textContent = files[0].name;
                        }
                    });
                }
            });

        });
    </script>
    {{-- signature pad script  --}}
    <script>
        (function() {
            'use strict';

            // List of signature pads to initialize: canvasId, areaId
            const pads = [{
                    canvasId: 'signatureCanvas',
                    areaId: 'signatureArea'
                },
                {
                    canvasId: 'signatureCanvas2',
                    areaId: 'signatureArea2'
                },
            ];

            // utility: debounce
            function debounce(fn, wait = 150) {
                let t;
                return function() {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, arguments), wait);
                };
            }

            // Initialize on window load to ensure layout/rendered
            window.addEventListener('load', function() {
                pads.forEach(({
                    canvasId,
                    areaId
                }) => {
                    initPad(canvasId, areaId);
                });
            });

            function initPad(canvasId, areaId) {
                const canvas = document.getElementById(canvasId);
                const area = document.getElementById(areaId);

                if (!canvas || !area) {
                    console.warn('Signature elements missing:', canvasId, areaId);
                    return;
                }

                // create pad
                const signaturePad = new SignaturePad(canvas, {
                    backgroundColor: '#fff',
                    penColor: '#000'
                });

                // resize logic (preserve data)
                function resizeCanvas() {
                    try {
                        const ratio = Math.max(window.devicePixelRatio || 1, 1);
                        const rect = canvas.getBoundingClientRect();

                        // get existing strokes
                        const data = signaturePad.isEmpty() ? null : signaturePad.toData();

                        // set proper pixel size
                        canvas.width = Math.round(rect.width * ratio);
                        canvas.height = Math.round(rect.height * ratio);

                        // scale so drawing uses CSS pixels
                        const ctx = canvas.getContext('2d');
                        ctx.setTransform(1, 0, 0, 1, 0, 0); // reset transforms
                        ctx.scale(ratio, ratio);

                        signaturePad.clear();
                        if (data) {
                            // restore strokes
                            signaturePad.fromData(data);
                        }
                        // debug
                        // console.log('Resized', canvasId, canvas.width, canvas.height, 'ratio', ratio);
                    } catch (err) {
                        console.error('resizeCanvas error for', canvasId, err);
                    }
                }

                // call resize once now if visible; if hidden, we rely on observer to call when visible
                if (isElementVisible(area)) {
                    resizeCanvas();
                }

                // debounced window resize
                const debouncedResize = debounce(() => {
                    // only resize if element currently has non-zero size
                    if (area.offsetWidth && area.offsetHeight) resizeCanvas();
                }, 180);

                window.addEventListener('resize', debouncedResize);

                // IntersectionObserver to detect when area becomes visible in viewport (handles hidden-by-tabs/sections)
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // area appears -> ensure correct size
                            resizeCanvas();
                        }
                    });
                }, {
                    threshold: 0.01
                });

                observer.observe(area);

                // Click on clear (::after) region — calculate using area rect
                area.addEventListener('click', function(e) {
                    const rect = area.getBoundingClientRect();
                    // hit box size should match CSS ::after visually
                    const clearWidth = 70; // px - tune if your Clear text width differs
                    const clearHeight = 28; // px - tune if font-size/padding changed
                    const padding = 8; // px between edge and button

                    const insideClearBtn =
                        e.clientX >= rect.right - (clearWidth + padding) &&
                        e.clientX <= rect.right - padding &&
                        e.clientY >= rect.bottom - (clearHeight + padding) &&
                        e.clientY <= rect.bottom - padding;

                    if (insideClearBtn) {
                        signaturePad.clear();
                        // optional: dispatch an event or set a hidden input value to notify cleared
                        console.log('Signature cleared on', canvasId);
                    }
                });

                // Optional: expose the pad for debug in console window.__pads
                window.__pads = window.__pads || {};
                window.__pads[canvasId] = signaturePad;
            }

            // helper: element visible (has layout & visible)
            function isElementVisible(el) {
                if (!el) return false;
                return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
            }
        })();
    </script>
    {{-- Edit signature pad script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Applicant signature toggle
            const editBtn1 = document.getElementById("editSignatureBtn");
            const signatureArea1 = document.getElementById("signatureArea");
            const signaturePreview1 = document.getElementById("signaturePreview");

            if (editBtn1) {
                editBtn1.addEventListener("click", function() {
                    const showingCanvas = signatureArea1.style.display === "block";
                    signatureArea1.style.display = showingCanvas ? "none" : "block";
                    signaturePreview1.style.display = showingCanvas ? "block" : "none";
                });
            }

            // Guardian signature toggle
            const editBtn2 = document.getElementById("editSignatureBtn2");
            const signatureArea2 = document.getElementById("signatureArea2");
            const signaturePreview2 = document.getElementById("signaturePreview2");

            if (editBtn2) {
                editBtn2.addEventListener("click", function() {
                    const showingCanvas = signatureArea2.style.display === "block";
                    signatureArea2.style.display = showingCanvas ? "none" : "block";
                    signaturePreview2.style.display = showingCanvas ? "block" : "none";
                });
            }
        });
    </script>
@endpush
