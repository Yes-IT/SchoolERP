@extends('backend.master')

@section('title')
{{ @$data->first_name }} {{ @$data->last_name }} {{ ___('report.details_view') }}
@endsection
@section('content')
<style>
    .img-link a {
        display: block;
        word-wrap: break-word;
        overflow-wrap: anywhere;
        white-space: normal;
    }
</style>

<div class="dashboard-body dspr-body-outer">


    <div class="ds-breadcrumb">
        <h1>Students Info</h1>
        <ul>
            <li><a href="dashboard.html">Dashboard</a> /</li>
            <li><a href="#url">Students</a> /</li>
            <li>Students Info</li>
        </ul>
    </div>
    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100 p12">
            <div class="sec-head d-flex">
                <h2>Student</h2>
                <a href="#url" class="cmn-btn">Parents Info</a>
            </div>
        </div>

        <div class="ds-pr-profile-card">
            <div class="dspr-profile-cd-upr">
                <div class="dspr-profile-cd-img">
                    @if($data->imageUpload)
                    <img src="{{ asset($data->imageUpload->path) }}" alt="Profile Image">
                    @else
                    <img src="{{ asset('backend/assets/images/new-version.jpg') }}" alt="Default Profile Image">
                    @endif
                </div>

                <div class="dspr-profile-cd-info">
                    <h2>{{ $data->last_name }} {{ $data->first_name }}</h2>
                    <p>{{ $data->hebrew_last_name }} {{ $data->hebrew_first_name }} </p>
                    <div class="user-id">Student ID {{ $data->id }}</div>
                </div>
            </div>



            <div class="dspr-profile-cd-btm">
                <div class="img-link">
                    <h3>Image Link</h3>
                    @if($data->imageUpload)
                    <a href="{{ asset($data->imageUpload->path) }}" target="_blank">
                        {{ asset($data->imageUpload->path) }}
                    </a>
                    @else
                    <!-- <span>No Image Link</span> -->
                    <a href="">No image link</a>
                    @endif
                </div>
                <div class="dsprprofile-course-info">
                    <table>
                        <tr>
                            <td>Diploma name</td>
                            <td>{{ $data->diploma_name }}</td>
                        </tr>
                        <tr>
                            <td>Year</td>
                            <td>{{ $data->school_year}}</td>
                        </tr>
                        <tr>
                            <td>Hold Transcript</td>
                            <td><input type="checkbox" name="hold-transcript" id="hold-transcript"></td>
                        </tr>
                    </table>
                </div>

                <div class="btn-wrp small-btn">
                    <!-- <button type="button" class="cmn-btn"><img src="{{ asset('backend') }}/assets/images/new_images/edit-icon.svg" alt="Icon"> Edit Student</button> -->

                    <a href="{{ route('student.edit', $data->id) }}" class="cmn-btn">
                        <img src="{{ asset('backend/assets/images/new_images/edit-icon.svg') }}" alt="Icon">
                        Edit Student
                    </a>

                    <button type="button" class="cmn-btn img-white" data-bs-toggle="modal" data-bs-target="#deleteStudent"><img src="{{ asset('backend') }}/assets/images/new_images/bin-icon.svg" alt="Icon"> Delete Student</button>
                </div>
            </div>
        </div>

        <div class="dspr-bdy-content">
            <div class="dspr-bdy-content-sec border-0">
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr>
                                <td>Admission Date</td>
                                <td>03/18/2021</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ $data->dob ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Hebrew Birthday</td>
                                <td>{{ $data->hebrew_dob ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>hebrew_dob{{ $data->email ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>High School</td>
                                <td>{{ $data->high_school ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Passport No.</td>
                                <td>{{ $data->passport_no ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Passport Name</td>
                                <td>{{ $data->passport_name ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Passport Country</td>
                                <td>{{ $data->passport_country ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Birth Country</td>
                                <td>{{ $data->place_of_birth ?? '-s-' }}</td>
                            </tr>
                            <tr>
                                <td>Passport Exp. Date</td>
                                <td>{{ $data->passport_exp_date ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Teudat Zehut</td>
                                <td>{{ $data->teudat_zehut ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Insurance ID</td>
                                <td>{{ $data->insurance ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Insurance Type</td>
                                <td>{{ $data->insurance_type ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Cell (Israel)</td>
                                <td>{{$data->cell_israel ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Cell (USA)</td>
                                <td>{{$data->cell_usa ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Home Phone</td>
                                <td>{{$data->mobile ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>SSN</td>
                                <td>{{$data->ssn ?? '--'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="dspr-bdy-content-sec">
                <h2>Address</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr>
                                <td>Home Address</td>
                                <td>{{ $data -> residance_address ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>{{$data->city ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>{{$data->state ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td>{{$data->zip_code ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>{{$data->country ?? '--'}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dspr-bdy-content-sec">
                <h2>Parent Details</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr>
                                <td>Father Name</td>
                                <td>{{$data->father_name ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Father Hebrew Name</td>
                                <td>{{$data->father_hebrew_name ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Mother Name</td>
                                <td>{{$data->mother_name ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Mother Hebrew Name</td>
                                <td>{{ $data->mother_hebrew_name ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Maiden Name</td>
                                <td>{{$data->maiden_name ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Father Birth Date</td>
                                <td>{{$data->father_dob ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Mother Birth Date</td>
                                <td>{{$data->mother_dob ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Father Phone Number</td>
                                <td>{{$data->father_mobile ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Mother Phone Number</td>
                                <td>{{$data->mother_mobile ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Additional Phone Number</td>
                                <td>{{$data->additional_mobile_numbers ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Father Email</td>
                                <td>{{$data->father_email ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Mother Email</td>
                                <td>{{$data->mother_email ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Additional Email Addresses</td>
                                <td>{{$data->additional_emails ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Father Occupation</td>
                                <td>{{$data->father_profession ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Marital Status</td>
                                <td>{{$data->marital_status ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Marital Comment</td>
                                <td>example@gmail.com</td>
                            </tr>
                            <tr>
                                <td>Mother Occupation</td>
                                <td>{{$data->mother_profession ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Parrent Address</td>
                                <td>{{$data->guardian_address ?? '--'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dspr-bdy-content-sec">
                <h2>Camp (S) Attended</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <thead>
                            <tr>
                                <th>Camp</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lorem Ipsum</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Lorem Ipsum</td>
                                <td>2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dspr-bdy-content-sec">
                <h2>Relative Details</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{$data->guardian_name ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Relationship</td>
                                <td>{{$data->guardian_relation ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Home Phone</td>
                                <td>{{$data->guardian_home_phone ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Cell Phone</td>
                                <td>{{$data->guardian_mobile ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$data->guardian_email ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{$data->guardian_address ?? '--'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dspr-bdy-content-sec">
                <h2>School Year (s)</h2>
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{{$data->school_id ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>School Year</td>
                                <td>{{$data->school_year ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Year Status</td>
                                <td>{{$data->year_status ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>College</td>
                                <td>{{$data->college ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Withraw Date</td>
                                <td>{{$data->withdraw_date ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Homeroom class</td>
                                <td>{{$data->homeroom_class ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Group</td>
                                <td>{{$data->group ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Division</td>
                                <td>{{$data->division ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Floor</td>
                                <td>{{$data->floor ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td>Room</td>
                                <td>{{$data->room ?? '--'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- chnage tab added  -->


            <div class="ds-cmn-table-wrp tab-wrapper">
                <div class="cmn-tab-head d-inline-block">
                    <ul>
                        <li class="tab-bg"></li>
                        <li class="active" data-tab="classes">Classes</li>
                        <li data-tab="transcript">Transcript Requests</li>
                        <li data-tab="checklist">Forms Checklist</li>
                    </ul>
                </div>
            </div>




            <!-- Classes Table -->
            <div class="ds-cmn-tble small-tbl count-row dspr-bdy-content-sec tab-content classes active">
                <table>
                    <thead>
                        <tr>
                            <th>S. No</th>
                            <th>Class</th>
                            <th>Teacher</th>
                            <th>School Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data->classMappings as $i => $map)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $map->class->name ?? '--' }}</td>
                            <td>{{ $map->teacher->first_name ?? '' }} {{ $map->teacher->last_name ?? '' }}</td>
                            <td>{{$data->school_year ?? '--'}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No classes assigned</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <!-- Transcript Requests Table -->
            <div class="ds-cmn-tble small-tbl count-row tab-content dspr-bdy-content-sec transcript" style="display:none;">
                <table>
                    <thead>
                        <tr>
                            <th>S. No</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data->requestTranscripts as $i => $req)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $req->request_date ?? '--' }}</td>
                            <td>
                                @if($req->destination == 1)
                                Destination 1
                                @elseif($req->destination == 2)
                                Destination 2
                                @elseif($req->destination == 3)
                                Destination 3
                                @else
                                --
                                @endif
                            </td>
                            <td>{{ $req->type == 1 ? 'Paid' : 'Unpaid' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No transcript requests</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <!-- Forms Checklist Table -->
            <!-- <div class="ds-cmn-tble small-tbl tab-content dspr-bdy-content-sec checklist  " style="display:none;">
                <h2>Forms Checklist</h2>

                <table>
                    <tbody>
                        <tr>
                            <td>School Year</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Year Status</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Medical Form</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Waiver</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Travel Form</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Flight Date</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Flight Information</td>
                            <td></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div> -->

            <!-- <div class="ds-cmn-tble small-tbl tab-content dspr-bdy-content-sec checklist" style="display:none;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>School Year</th>
                            <th>Year Status</th>
                            <th>Travel Form</th>
                            <th>Flight Date</th>
                            <th>Flight Information</th>
                            <th>Checklist</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data->formChecklists as $i => $checklist)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $checklist->school_year }}</td>
                            <td>{{ ucfirst($checklist->year_status) }}</td>
                            <td>{{ $checklist->travel_from }}</td>
                            <td>{{ $checklist->flight_date ? \Carbon\Carbon::parse($checklist->flight_date)->format('d-m-Y') : '' }}</td>
                            <td>{{ $checklist->flight_info }}</td>
                            <td>
                                @php
                                $items = explode(',', $checklist->checklist);
                                $labels = [
                                1 => 'Waiver',
                                2 => 'Medical Form'
                                ];
                                @endphp
                                @foreach($items as $item)
                                {{ $labels[$item] ?? $item }}<br>
                                @endforeach
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No checklist records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> -->

            <div class="ds-cmn-tble small-tbl tab-content dspr-bdy-content-sec checklist" style="display:none;">
                @forelse($data->formChecklists as $checklist)
                <table>
                    <tbody>
                        <tr>
                            <td>School Year</td>
                            <td>{{ $checklist->school_year }}</td>
                        </tr>
                        <tr>
                            <td>Year Status</td>
                            <td>{{ $checklist->year_status }}</td>
                        </tr>
                        <tr>
                            <td>Medical Form</td>
                            <td>
                                @php
                                $items = explode(',', $checklist->checklist);
                                @endphp
                                @if(in_array(2, $items)) Medical Form @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Waiver</td>
                            <td>
                                @if(in_array(1, $items)) Waiver @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Travel Form</td>
                            <td>{{ $checklist->travel_from }}</td>
                        </tr>
                        <tr>
                            <td>Flight Date</td>
                            <td>
                                @if($checklist->flight_date)
                                {{ \Carbon\Carbon::parse($checklist->flight_date)->format('d-m-Y') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Flight Information</td>
                            <td>{{ $checklist->flight_info }}</td>
                        </tr>
                    </tbody>
                </table>

                <br>
                @if(!$loop->last)
                <div style="border-top:1px solid #ccc; margin:15px 0;"></div>
                @endif
                @empty
                <p class="text-center mt-3 mb-2">No checklist records found</p>

                @endforelse
            </div>





        </div>
    </div>
</div>

<!-- End Of Dashboard Body -->

</div>

<!-- End Of Dashboard -->




<div class="modal fade cmn-popwrp popwrp w400" id="deleteStudent" tabindex="-1" role="dialog" aria-labelledby="deleteStudent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{ asset('backend') }}/assets/images/new_images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{ asset('backend') }}/assets/images/new_images/bin-primary.svg" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this Leave Request?</p>
                        <div class="btn-wrp">
                            <!-- <button type="submit" class="cmn-btn">Delete</button> -->
                            <button type="button" class="cmn-btn delete-student-btn" data-id="{{ $data->id }}">
                                Delete
                            </button>

                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>




@endsection

@push('script')
<!-- <script>
    $(document).ready(function() {
        $('.delete-student-btn').click(function(e) {
            e.preventDefault();
            var studentId = $(this).data('id');

            if (confirm('Are you sure you want to delete this student?')) {
                $.ajax({
                    url: "/student/delete/" + studentId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response[1] === 'success') {
                            alert(response[0]);
                            window.location.href = "{{ route('student.index') }}"; // redirect to student list
                        } else {
                            alert(response[0]);
                        }
                    },
                    error: function() {
                        alert('Something went wrong!');
                    }
                });
            }
        });
    });
</script> -->


<script>
    $(document).ready(function() {
        $('.delete-student-btn').click(function(e) {
            e.preventDefault();
            var studentId = $(this).data('id');

            $.ajax({
                url: "/student/delete/" + studentId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#deleteStudent').modal('hide');

                    window.location.href = "{{ route('student.index') }}";
                },
                error: function() {
                    console.error('Something went wrong!');
                }
            });
        });
    });
</script>

<script>
    document.querySelectorAll('.cmn-tab-head ul li').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            document.querySelectorAll('.cmn-tab-head ul li').forEach(t => t.classList.remove('active'));

            // Hide all tables
            document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');

            // Activate clicked tab
            this.classList.add('active');
            let tabClass = this.getAttribute('data-tab');

            // Show corresponding table
            document.querySelector('.' + tabClass).style.display = 'block';
        });
    });
</script>



@endpush