@extends('backend.master')

@section('title')
{{ ___('common.School Management System |  Parent Info') }}
@endsection

@section('content')
<div class="dashboard-body dspr-body-outer">

   <div class="ds-breadcrumb">
        <h1>Parents Info</h1>
        <ul>
            <li><a href="dashboard.html">Dashboard</a> /</li>
            <li><a href="{{route('parent_flow.index')}}">Parents</a> /</li>
            <li>Parents Info</li>
        </ul>
    </div>
    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Parents Info</h2>
               
                <div class="atndnc-filter student-filter">
                    <a href="#" class="cmn-btn">Student Info</a>
                    {{-- <a href="#url" class="cmn-btn">Student's Name (ID-32465)</a> --}}
                    <select class="cmn-btn" id="studentSelect">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->first_name }} {{ $student->last_name }}
                                (ID-{{ $student->student_code ?? $student->student_id }})
                            </option>
                        @endforeach
                    </select>

                    <a class="cmn-btn" href="#">
                        <img src="{{ global_asset('backend/assets/images/edit-icon.svg') }}" style="margin-right: 6px;" alt="Icon">Edit Parents
                    </a>
                    

                </div> 
            </div>
        </div>
        <div class="ds-pr-profile-card">
            <div class="dspr-profile-cd-upr">
                <div class="dspr-profile-cd-img">
                   
                    <img
                        id="studentImage"
                        src="{{ $selectedStudent->image_path
                                ? asset($selectedStudent->image_path)
                                : global_asset('backend/assets/images/student-img.png') }}"
                        alt="Profile Image"
                    >
                </div>
                <div class="dspr-profile-cd-info">
                   
                    <h2 id="studentName">
                        {{ $selectedStudent->first_name }} {{ $selectedStudent->last_name }}
                    </h2>
                  
                    <p id="studentHebrew">
                        {{ $selectedStudent->hebrew_first_name }} {{ $selectedStudent->hebrew_last_name ?? '-' }}
                    </p>
                    
                    <div class="user-id" id="studentCode">
                        Student ID {{ $selectedStudent->student_id ?? '-' }}
                    </div>
                </div>
            </div>
            <div class="dspr-profile-cd-btm">
                <div class="img-link">
                    <h3>Image Link</h3>
                   
                    @if($selectedStudent->image_path)
                        <a id="imageLink" href="{{ asset($selectedStudent->image_path) }}" target="_blank">
                            {{ $selectedStudent->image_path }}
                        </a>
                    @else
                        <span id="imageLink">-</span>
                    @endif
                </div>
                <div class="dsprprofile-course-info">
                    <table>
                        <tr>
                            <td>Diploma name</td>
                            <td>{{ $selectedStudent->diploma_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Year</td>
                            <td>{{ $schoolDetails->school_year ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Year Status</td>
                            <td>{{ $schoolDetails->year_status ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="btn-wrp small-btn">
                    {{-- <button type="button" class="cmn-btn"><img src="../../images/edit-icon.svg" alt="Icon"> Edit Student</button> --}}
                    {{-- <button type="button" class="cmn-btn img-white" data-bs-toggle="modal" data-bs-target="#deleteStudent"><img src="../../images/bin-icon.svg" alt="Icon"> Delete Student</button> --}}
                </div>
            </div>
        </div>

        <div class="dspr-bdy-content">
            @php
                $maritalStatus = $parent->marital_status ?? '';
            @endphp

            @if(in_array($maritalStatus, ['married', 'unmarried', 'widowed']))
          
                <div class="dspr-bdy-content-sec">
                    <h2>Parent Details</h2>
                    <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Father Name</td>
                                    <td>{{ $parent->father_title }} {{ $parent->father_name }}</td>
                                </tr>
                                <tr>
                                    <td>Father Hebrew Name</td>
                                    <td>{{ $parent->father_hebrew_name }}</td>
                                </tr>
                                <tr>
                                    <td>Mother Name</td>
                                    <td> {{ $parent->mother_title }} {{ $parent->mother_name }}</td>
                                </tr>
                                <tr>
                                    <td>Mother Hebrew Name</td>
                                    <td>{{ $parent->mother_hebrew_name }}</td>
                                </tr>
                                <tr>
                                    <td>Maiden Name </td>
                                    <td>{{ $parent->maiden_name }}</td>
                                </tr>
                                <tr>
                                    <td>Father Birth Date</td>
                                    <td>{{ \Carbon\Carbon::parse($parent->father_dob)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Mother Birth Date</td>
                                    <td>{{ \Carbon\Carbon::parse($parent->mother_dob)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Father Phone Number</td>
                                    <td>{{ $parent->father_mobile }}</td>
                                </tr>
                                <tr>
                                    <td>Mother Phone Number</td>
                                    <td>{{ $parent->mother_mobile }}</td>
                                </tr>
                                <tr>
                                    <td>Additional Phone Numbers</td>
                                    <td>{{ $parent->additional_mobile_numbers }}</td>
                                </tr>
                                <tr>
                                    <td>Father Email</td>
                                    <td>{{ $parent->father_email }}</td>
                                </tr>
                                <tr>
                                    <td>Mother Email</td>
                                    <td>{{ $parent->mother_email }}</td>
                                </tr>
                                <tr>
                                    <td>Additional Email Addresses</td>
                                    <td>{{ $parent->additional_emails }}</td>
                                </tr>
                                <tr>
                                    <td>Father Occupation</td>
                                    <td>{{ $parent->father_profession }}</td>
                                </tr>
                                <tr>
                                    <td>Marital Status</td>
                                    <td>{{ ucfirst($maritalStatus) }}</td>
                                </tr>
                                <tr>
                                    <td>Marital Comment</td>
                                    <td>-</td>
                                </tr>
                               
                                <tr>
                                    <td>Mother Occupation</td>
                                    <td>{{ $parent->mother_profession }}</td>
                                </tr>
                                <tr>
                                    <td>Parents Address</td>
                                    <td>{{ $parent->address_line }} {{ $parent->city }} {{ $parent->state }} {{ $parent->country }} {{ $parent->zip_code }}</td>
                                </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            @endif



         
            <div class="dspr-bdy-content-sec">
                <h2>Daughter Info</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr>
                                <td>Student Name</td>
                                <td>{{ $selectedStudent->first_name }} {{ $selectedStudent->last_name }}</td>
                            </tr>
                             <tr>
                                <td>School Year</td>
                                <td>{{ $schoolDetails->school_year ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Year Status</td>
                                <td>{{ $schoolDetails->year_status ?? '-' }}</td>
                            </tr>
                             <tr>
                                <td>Birthdate</td>
                                <td>{{ \Carbon\Carbon::parse($selectedStudent->dob)->format('m/d/Y') }}</td>
                            </tr>
                             
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="dspr-bdy-content-sec">
                <h2>Second Parent Details</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                       <tbody>
                            <tr>
                                <td>Parent Name</td>
                                <td>Caroline Thomas</td>
                            </tr>

                             <tr>
                                <td>Home Phone Number</td>
                                <td>98654646</td>
                            </tr>
                            <tr>
                                <td>Cell number</td>
                                <td>98654646</td>
                            </tr>
                             <tr>
                                <td>Email</td>
                                <td>example@gmail.com</td>
                            </tr>
                             <tr>
                                <td>Address</td>
                                <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}
   

            <div class="dspr-bdy-content-sec">
                <h2>Relative Details</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr>
                            <td>Name</td>
                            <td>{{$parent->guardian_name}}</td>
                            </tr>
                            <tr>
                            <td>Relationship</td>
                            <td>{{$parent->guardian_relation}}</td>
                            </tr>
                            <tr>
                            <td>Home Phone</td>
                            <td>{{$parent->guardian_home_phone}}</td>
                            </tr>
                            <tr>
                            <td>Cell Phone</td>
                            <td>{{$parent->guardian_mobile}}</td>
                            </tr>
                            <tr>
                            <td>Email</td>
                            <td>{{$parent->guardian_email}}</td>
                            </tr>
                            <tr>
                            <td>Address</td>
                            <td>{{$parent->guardian_address}}</td>
                            </tr>
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>    

@endsection
@push('script')
<script>
document.getElementById('studentSelect').addEventListener('change', function () {
    const studentId = this.value;

    fetch(`/parent-flow/student-info/${studentId}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) return;

            document.getElementById('studentName').innerText =
                data.first_name + ' ' + data.last_name;

            document.getElementById('studentHebrew').innerText =
                (data.hebrew_first_name ?? '') + ' ' + (data.hebrew_last_name ?? '');

            document.getElementById('diplomaName').innerText =
                data.diploma_name ?? '-';

            document.getElementById('schoolYear').innerText =
                data.school_year ?? '-';

            document.getElementById('yearStatus').innerText =
                data.year_status ?? '-';

            const img = document.getElementById('studentImage');
            const link = document.getElementById('imageLink');

            if (data.image_path) {
                img.src = '/' + data.image_path;
                link.href = '/' + data.image_path;
                link.innerText = data.image_path;
            } else {
                img.src = "{{ global_asset('backend/assets/images/student-img.png') }}";
                link.innerText = '-';
                link.removeAttribute('href');
            }    
        })
        .catch(err => console.error(err));
});
</script>

    
@endpush