@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
                    <div class="ds-breadcrumb">
                        <h1>Edit Applicant</h1>
                        <ul>
                             <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                            <li><a href="#">Application</a> /</li>
                            <li><a href="{{route('applicant.student_application_form')}}">Applicants List</a> /</li>
                            {{-- <li><a href="#url">Applicant Info</a> /</li> --}}
                            <li>Edit Applicant </li>
                        </ul>

                         <button onclick="window.location.href='{{ route('applicant.student_application_form') }}'" class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                <form method="POST" action="{{ route('applicant.update_applicant', $applicant->id) }}">
                                    @csrf
                                   
                                    <div class="new-request-form">
                                        <h3>Applicant Details</h3>
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="ID">ID</label>
                                              <input type="text" id="identification_number" name="identification_number" value="{{ old('identification_number', $applicant->custom_id ?? '') }}"  placeholder="ID" readonly >
                                            </div>
                                            <div class="input-grp">
                                              <label for="">Last Name</label>
                                              <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $applicant->last_name ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">First Name</label>
                                              <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $applicant->first_name ?? '') }}">
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="subject">High School</label>
                                               <select id="high_school_id" name="high_school_id">
                                                    <option value=""> Select High School</option>
                                                    @foreach($highSchools as $school)
                                                        <option value="{{ $school->id }}" 
                                                            {{ old('high_school_id', $applicant->high_school_id ?? '') == $school->id ? 'selected' : '' }}>
                                                            {{ $school->hs_name }}
                                                        </option>
                                                    @endforeach
                                                    <option value="other" {{ old('high_school_id') == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                              <label for="subject">Others High School</label>
                                                <input 
                                                    type="text" 
                                                    id="other_high_school" 
                                                    name="high_school" 
                                                    value="{{ old('high_school', $applicant->high_school ?? '') }}" 
                                                    placeholder="Enter other high school name">
                                            </div>

                                            <div class="input-grp">
                                              <label for="">Birthdate</label>
                                              <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $applicant->date_of_birth ?? '') }}">
                                            </div>
                                            
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="">USA Cell</label>
                                              <input type="text" id="usa_cell" name="usa_cell" value="{{ old('usa_cell', $applicant->usa_cell ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Email</label>
                                                <input type="text" id ="email" name="email" value="{{ old('email', $applicant->email ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">High School (Application)</label>
                                                <input type="text" id="highschool_application" name="highschool_application" value="{{ old('highschool_application', $applicant->highschool_application ?? '') }}">
                                            </div>
                                        </div>
                                    </div>

                                  <div class="new-request-form">
                                        <h3>Camp(s) Attended</h3>

                                        <button type="button" id="add-row-btn" class="cmn-btn btn-sm">Add  
                                            <img src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>
                                        
                                        <div class="add-form-element" id="camp-attended-list">
                                            @php
                                                $campRecords = [];
                                                if(isset($applicant->history) && !empty($applicant->history)) {
                                                    foreach($applicant->history as $history) {
                                                        $schoolNames = $history->school_name ?? [];
                                                        $schoolGrades = $history->school_grades ?? [];
                                                        
                                                        if(!empty($schoolNames)) {
                                                            foreach($schoolNames as $key => $schoolName) {
                                                               
                                                                if(!empty(trim($schoolName))) {
                                                                    $campRecords[] = [
                                                                        'history_id' => $history->id,
                                                                        'array_index' => $key,
                                                                        'school_name' => $schoolName,
                                                                        'school_grades' => $schoolGrades[$key] ?? ''
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp

                                            @forelse($campRecords as $index => $record)
                                                <div class="added-element-card schedule-row" style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 15px;">
                                                    <span class="sl-count" style="margin-top: 25px; min-width: 30px;">{{ $index + 1 }}.</span>
                                                    <div class="multi-input-grp input-grp-5" style="display: flex; gap: 15px; flex: 1;">
                                                        <div class="input-grp" style="flex: 1;">
                                                            <label for="">Name of School</label>
                                                            <input type="text" name="school_name[]" 
                                                                value="{{ old("school_name.$index", $record['school_name']) }}" 
                                                                placeholder="Name of School" style="width: 100%;">
                                                        </div>
                                                        <div class="input-grp" style="flex: 1;">
                                                            <label for="">Grades Attended</label>
                                                            <input type="text" name="school_grades[]" 
                                                                value="{{ old("school_grades.$index", $record['school_grades']) }}" 
                                                                placeholder="Grades Attended" style="width: 100%;">
                                                        </div>
                                                      
                                                        <input type="hidden" name="camp_deleted[]" value="0" class="camp-deleted-flag">
                                                    </div>
                                                    <div class="added-elm-actions btn-grp" style="margin-top: 25px;">
                                                        <button type="button" class="cmn-btn btn-sm delete-row-btn">Delete</button>
                                                    </div>
                                                </div>
                                            @empty
                                                {{-- No camp records found --}}
                                            @endforelse
                                        </div>
                                    </div>    

                                   <div class="new-request-form" id="">
                                        <h3>Application Check List</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">Fee</label>
                                                <input id="fee" name="transaction[amount]" type="text" 
                                                    value="{{ old('transaction.amount', $applicant->transaction->amount ?? '') }}" 
                                                    placeholder="$1200.00">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">CC Last 4</label>
                                                <input id="cc_last_4" name="transaction[card_last4]" type="text" 
                                                    value="{{ old('transaction.card_last4', $applicant->transaction->card_last4 ?? '') }}" 
                                                    placeholder="Last 4 digits">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Date Deposited</label>
                                                
                                                <input id="date_deposited" name="checklist[date_deposited]" type="date"
                                                    value="{{ old('checklist.date_deposited', optional($applicant->confirmation)->created_at ? \Carbon\Carbon::parse($applicant->confirmation->created_at)->format('Y-m-d') : '') }}">

                                            </div>

                                            <div class="input-grp">
                                                <label for="">References</label>
                                                <input id="references" name="checklist[reference]" type="text" 
                                                    value="{{ old('checklist.reference', $applicant->confirmation->reference ?? '') }}" 
                                                    placeholder="Enter References">
                                            </div>
                                            
                                            <div class="input-grp">
                                                <label for="">Pictures</label>
                                                <input id="pictures" name="checklist[pictures]" type="text" 
                                                    value="{{ old('checklist.pictures', $applicant->confirmation->pictures ?? '') }}" 
                                                    placeholder="Number of pictures">
                                            </div>
                                        </div>
                                        
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Transcript Hebrew 
                                                    <input id="transcript_hebrew" name="checklist[transcript_hebrew]" type="checkbox" value="1"
                                                        {{ old('checklist.transcript_hebrew', $applicant->confirmation->transcript_hebrew ?? false) ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                            
                                            <div class="input-grp checkbox">
                                                <label>Transcript English 
                                                    <input id="transcript_english" name="checklist[transcript_english]" type="checkbox" value="1"
                                                        {{ old('checklist.transcript_english', $applicant->confirmation->transcript_english ?? false) ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Application Processing</h3>
                                       @php
                                            $statusMap = [
                                                0 => 'Pending',
                                                1 => 'Scheduled', 
                                                2 => 'Rescheduled',
                                            ];
                                            $interviewStatus = $applicant->processing->interview_status ?? null;
                                            $statusText = $statusMap[$interviewStatus] ?? 'N/A';
                                            $interviewMode = $applicant->processing->interview_mode ?? 'offline';

                                        @endphp

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">Interview Date</label>
                                                <input type="date"  name="processing[interview_date]" value="{{ old('processing.interview_date', $applicant->processing->interview_date ? \Carbon\Carbon::parse($applicant->processing->interview_date)->format('Y-m-d') : '') }}">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">Interview Time</label>
                                                <input type="text" name="processing[interview_time]" value="{{ old('processing.interview_time', $applicant->processing->interview_time ?? '') }}">
                                            </div>

                                            {{-- <div class="input-grp">
                                                <label for="">Interview Location</label>
                                                 <input type="text" name="processing[interview_location]" value="{{ old('processing.interview_location', $applicant->processing->interview_location ?? '')}}">
                                            </div> --}}

                                            <div class="input-grp">
                                                <label for="">
                                                    {{ $interviewMode === 'online' ? 'Interview Link' : 'Interview Location' }}
                                                </label>

                                                @if($interviewMode === 'online')
                                                    <input type="text" name="processing[interview_link]"
                                                        value="{{ old('processing.interview_link', $applicant->processing->interview_link ?? '') }}">
                                                @else
                                                    <input type="text" name="processing[interview_location]"
                                                        value="{{ old('processing.interview_location', $applicant->processing->interview_location ?? '') }}">
                                                @endif
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Status</label>
                                                {{-- <input type="text"  value="{{ $statusText }}">
                                                <input type="hidden" name="processing[interview_status]" value="{{ $interviewStatus }}"> --}}
                                                 <select name="processing[interview_status]">
                                                        <option value="0" {{ old('processing.interview_status', $applicant->processing->interview_status ?? 0) == 0 ? 'selected' : '' }}>Pending</option>
                                                        <option value="1" {{ old('processing.interview_status', $applicant->processing->interview_status ?? 0) == 1 ? 'selected' : '' }}>Scheduled</option>
                                                        <option value="2" {{ old('processing.interview_status', $applicant->processing->interview_status ?? 0) == 2 ? 'selected' : '' }}>Rescheduled</option>
                                                        
                                                </select>
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Coming</label>
                                                {{-- <input  type="text" name="processing[coming]" value="{{ old('processing.coming', $applicant->processing->coming ?? '') }}"> --}}
                                                <select name="processing[coming]">
                                                    <option value="">Select Option</option>
                                                    <option value="Yes" {{ old('processing.coming', $applicant->processing->coming ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ old('processing.coming', $applicant->processing->coming ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                     
                                    </div>

                                    <div class="new-request-form" id="">    
                                        <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Application Comment</label>
                                                <textarea  name="processing[application_comment]" >{{ old('processing.application_comment', $applicant->processing->application_comment ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Scholarship Comment</label>
                                                <textarea name="processing[scholarship_comment]" >{{ old('processing.scholarship_comment', $applicant->processing->scholarship_comment ?? '') }}</textarea>
                                            </div>
                                        </div>
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Tuition Comment</label>
                                                <textarea name="processing[tution_comment]" >{{ old('processing.tution_comment', $applicant->processing->tution_comment ?? '') }}</textarea>
                                            </div>
                                        </div>

                                       <div class="input-grp checkbox">
                                            <label>Letter Sent <input  type="checkbox" name="processing[letter_sent]" value="1" {{ old('processing.letter_sent', $applicant->processing->letter_sent ?? false) ? 'checked' : '' }}> </label>
                                        </div>

                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Parents Information</h3>

                                        @php
                                            $parent = $applicant->parents->first();
                                            // dd($parent);
                                        @endphp

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">ID</label>
                                                 <input type="text" id="identification_number" name="identification_number"  value="{{ old('applicant.custom_id', $applicant->custom_id ?? '') }}"  placeholder="ID"    readonly >
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">Last Name</label>
                                                <input id="father_last_name" name="parents[father_last_name]" type="text" value="{{ old('parents.father_last_name', $parent->father_last_name ?? '') }}">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Father Title</label>
                                                <input id="father_title" name="parents[father_title]" type="text" value="{{ old('parents.father_title', $parent->father_title ?? '') }}">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Father Name</label>
                                                <input id="father_name" name="parents[father_name]" type="text" value="{{ old('parents.father_name', $parent->father_name ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Title</label>
                                                <input id="mother_title" name="parents[mother_title]" type="text" value="{{ old('parents.mother_title', $parent->mother_title ?? '') }}"  >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Name</label>
                                                <input id="mother_name" name="parents[mother_name]" type="text" value="{{ old('parents.mother_name', $parent->mother_name ?? '') }}"  >
                                            </div>

                                             <div class="input-grp">
                                                <label for="">Maiden Name</label>
                                                <input id="maiden_name" name="parents[maiden_name]" type="text" value="{{ old('parents.maiden_name', $parent->maiden_name ?? '') }}">
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Address</label>
                                                <input id="address" name="parents[address]" type="text" value="{{ old('parents.address', $parent->address ?? '') }}"  >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">City</label>
                                                <input id="city" name="parents[city]" type="text" value="{{ old('parents.city', $parent->city ?? '') }}">
                                            </div>

                                             <div class="input-grp">
                                                <label for="">State</label>
                                                <input id="state" name="parents[state]" type="text" value="{{ old('parents.state', $parent->state ?? '') }}">
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Zip Code</label>
                                                <input id="zip_code" name="parents[zip_code]" type="text"value="{{ old('parents.zip_code', $parent->zip_code ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Country</label>
                                                <input id="country" name="parents[country]" type="text" value="{{ old('parents.country', $parent->country ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Marital Status</label>
                                                <input id="marital_status" name="parents[marital_status]" type="text" value="{{ old('parents.marital_status', $parent->marital_status ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Marital Comment</label>
                                                <input id="marital_comment" name="parents[marital_comment]" type="text" value="{{ old('parents.marital_comment', $parent->marital_comment ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Home Phone</label>
                                                <input id="home_phone" name="parents[home_phone]" type="text" value="{{ old('parents.home_phone', $parent->home_phone ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Cell</label>
                                                <input id="father_cell" name="parents[father_cell]" type="text" value="{{ old('parents.father_cell', $parent->father_cell ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Cell</label>
                                                <input id="mother_cell" name="parents[mother_cell]" type="text" value="{{ old('parents.mother_cell', $parent->mother_cell ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Email</label>
                                                <input id="father_email" name="parents[father_email]" type="text" value="{{ old('parents.father_email', $parent->father_email ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Email</label>
                                                <input id="mother_email" name="parents[mother_email]" type="text" value="{{ old('parents.mother_email', $parent->mother_email ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Occupation</label>
                                                <input id="father_occupation" name="parents[father_occupation]" type="text" value="{{ old('parents.father_occupation', $parent->father_occupation ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Occupation</label>
                                                <input id="mother_occupation" name="parents[mother_occupation]" type="text" value="{{ old('parents.mother_occupation', $parent->mother_occupation ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Phone No.</label>
                                                <input id="additional_phone_no" name="parents[additional_phone_no]" type="text" value="{{ old('parents.additional_phone_no', $parent->additional_phone_no ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Email Addresses</label>
                                                <input id="additional_emails" name="parents[additional_email_addresses]" type="text" value="{{ old('parents.additional_email_addresses', $parent->additional_email_addresses ?? '') }}" >
                                            </div>
                                            
                                        </div>
                                     
                                    </div>
                                  

                                    <div class="form-submission btn-sm align-right">
                                        <button type="submit" class="cmn-btn btn-sm">Save Applicant</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                   

@endsection

@push('script')

<script>
//  document.addEventListener("DOMContentLoaded", function () {
//     const addRowBtn = document.getElementById("add-row-btn");
//     const campList = document.getElementById("camp-attended-list");

//     // Add new camp row
//     addRowBtn.addEventListener("click", function (e) {
//         e.preventDefault();

//         const rowCount = campList.querySelectorAll('.schedule-row').length;
        
//         const newRow = document.createElement("div");
//         newRow.classList.add("added-element-card", "schedule-row");
//         newRow.style.cssText = "display: flex; align-items: flex-start; gap: 15px; margin-bottom: 15px;";
//         newRow.innerHTML = `
//             <span class="sl-count" style="margin-top: 25px; min-width: 30px;">${rowCount + 1}.</span>
//             <div class="multi-input-grp input-grp-5" style="display: flex; gap: 15px; flex: 1;">
//                 <div class="input-grp" style="flex: 1;">
//                     <label for="">Name of School</label>
//                     <input type="text" name="school_name[]" placeholder="Name of School" style="width: 100%;">
//                 </div>
//                 <div class="input-grp" style="flex: 1;">
//                     <label for="">Grades Attended</label>
//                     <input type="text" name="school_grades[]" placeholder="Grades Attended" style="width: 100%;">
//                 </div>
//             </div>
//             <div class="added-elm-actions btn-grp" style="margin-top: 25px;">
//                 <button type="button" class="cmn-btn btn-sm delete-row-btn">Delete</button>
//             </div>
//         `;
        
//         campList.appendChild(newRow);
//         updateRowNumbers();
//     });

//     // Delete a row
//     campList.addEventListener("click", function (e) {
//         if (e.target.closest(".delete-row-btn")) {
//             e.preventDefault();
//             const row = e.target.closest(".schedule-row");
//             row.remove();
//             updateRowNumbers();
//         }
//     });

//     // Update serial numbers
//     function updateRowNumbers() {
//         campList.querySelectorAll(".schedule-row").forEach((row, index) => {
//             const span = row.querySelector('.sl-count');
//             span.textContent = `${index + 1}.`;
//         });
//     }

//     // Initialize row numbers
//     updateRowNumbers();
// });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const addRowBtn = document.getElementById("add-row-btn");
    const campList = document.getElementById("camp-attended-list");

    // Add new camp row
    addRowBtn.addEventListener("click", function (e) {
        e.preventDefault();

        const rowCount = campList.querySelectorAll('.schedule-row').length;
        
        const newRow = document.createElement("div");
        newRow.classList.add("added-element-card", "schedule-row");
        newRow.style.cssText = "display: flex; align-items: flex-start; gap: 15px; margin-bottom: 15px;";
        newRow.innerHTML = `
            <span class="sl-count" style="margin-top: 25px; min-width: 30px;">${rowCount + 1}.</span>
            <div class="multi-input-grp input-grp-5" style="display: flex; gap: 15px; flex: 1;">
                <div class="input-grp" style="flex: 1;">
                    <label for="">Name of School</label>
                    <input type="text" name="school_name[]" placeholder="Name of School" style="width: 100%;">
                </div>
                <div class="input-grp" style="flex: 1;">
                    <label for="">Grades Attended</label>
                    <input type="text" name="school_grades[]" placeholder="Grades Attended" style="width: 100%;">
                </div>
                <!-- Hidden fields for new records -->
                <input type="hidden" name="history_ids[]" value="">
                <input type="hidden" name="array_indexes[]" value="">
                <input type="hidden" name="camp_deleted[]" value="0" class="camp-deleted-flag">
            </div>
            <div class="added-elm-actions btn-grp" style="margin-top: 25px;">
                <button type="button" class="cmn-btn btn-sm delete-row-btn">Delete</button>
            </div>
        `;
        
        campList.appendChild(newRow);
        updateRowNumbers();
    });

    // Delete a row - SOFT DELETE
    campList.addEventListener("click", function (e) {
        if (e.target.closest(".delete-row-btn")) {
            e.preventDefault();
            const row = e.target.closest(".schedule-row");
            
            // Mark as deleted instead of removing
            const deleteFlag = row.querySelector('.camp-deleted-flag');
            if (deleteFlag) {
                deleteFlag.value = "1";
                console.log('Marked row as deleted:', deleteFlag.value);
            }
            
            // Hide the row instead of removing it
            row.style.display = 'none';
            
            updateRowNumbers();
        }
    });

    // Update serial numbers
    function updateRowNumbers() {
        const visibleRows = campList.querySelectorAll('.schedule-row:not([style*="display: none"])');
        visibleRows.forEach((row, index) => {
            const span = row.querySelector('.sl-count');
            span.textContent = `${index + 1}.`;
        });
    }

    // Initialize row numbers
    updateRowNumbers();
});
</script>



@endpush