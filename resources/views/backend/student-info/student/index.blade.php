@extends('backend.master')
@section('title')
{{ @$data['title'] }}
@endsection
@section('content')


<!-- Dashboard Body Begin -->
<div class="dashboard-body dspr-body-outer">
    <!-- <div class="dashboard-body-head">
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
                <img src="{{ asset('backend') }}/assets/images/new_images/fullscreen-toggler-icon.svg" onclick="javascript:toggleFullScreen()" alt="Icon">
            </button>
            <div class="profile-ctrl">
                <button class="profile-ctrl-toggler">
                    <div class="pr-pic">
                        <img src="{{ asset('backend') }}/assets/images/new_images/profile-picture.png" alt="Profile Picture">
                    </div>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="pr-ctrl-menu">
                    <ul>
                        <li><a href="profile.html">My Profile</a></li>
                        <li><a href="../../set-password.html">Change Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->

    <div class="ds-breadcrumb">
        <h1>Students</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="dashboard.html">Students</a> /</li>
            <li>Students List</li>
        </ul>
    </div>
    <div class="ds-pr-body">

        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter student-filter">
                <form action="{{ route('student.search') }}" method="post" id="marksheed" enctype="multipart/form-data">
                    @csrf
                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options grp-2 multi-input-grp">
                            <!-- <div class="input-grp">
                                <select>
                                    <option value="select-year">Select Year</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                            <div class="input-grp">
                                <select>
                                    <option value="select-year">Select Year Status</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div> -->


                            <div class="input-grp">
                                <select name="school_year">
                                    <option value="">Select Year</option>
                                    <option value="2015-2016">2015-2016</option>
                                    <option value="2016-2017">2016-2017</option>
                                    <option value="2017-2018">2017-2018</option>
                                    <option value="2018-2019">2018-2019</option>
                                    <option value="2019-2020">2019-2020</option>
                                    <option value="2021-2022">2021-2022</option>
                                    <option value="2022-2023">2022-2023</option>
                                    <option value="2022-2023">2022-2023</option>
                                    <option value="2023-2024">2023-2024</option>
                                    <option value="2024-2025">2024-2025</option>
                                </select>
                            </div>

                            <div class="input-grp">
                                <select name="year_status">
                                    <option value="">Select Year Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>




                            <!-- <div class="input-grp">
                                <select>
                                    <option value="select-year">Select Semester</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div> -->
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="ds-cmn-table-wrp">

            <div class="ds-content-head has-drpdn">
                <div class="sec-head">
                    <h2>Students List</h2>
                </div>
                <div class="ds-cmn-filter-wrp">
                    <div class="dsbdy-filter-wrp p-0">
                        <div class="dropdown-year" data-selected="Select Student">
                            <div class="dropdown-trigger">
                                <span class="dropdown-label">Select Student</span>
                                <i class="dropdown-arrow"></i>
                            </div>
                            <div class="dropdown-options">
                                <div class="dropdown-option">Student 1</div>
                                <div class="dropdown-option">Student 2</div>
                                <div class="dropdown-option">Student 3</div>
                            </div>
                        </div>
                        @if (hasPermission('student_create'))

                        <a href="{{ route('student.create') }}" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add Student</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="ds-cmn-tble count-row tbl-5_4k">
                <table>
                    <thead>
                        <tr>
                            <th>S. No</th>
                            <th>View Details</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>School Year</th>
                            <th>Year Status</th>
                            <th>Hebrew Last Name</th>
                            <th>Hebrew First Name</th>
                            <th>Diploma</th>
                            <th>High School</th>
                            <th>Parent Name</th>
                            <th>Birth Date</th>
                            <th>Hebrew Birth Date</th>
                            <th>Birth Country</th>
                            <th>SSN</th>
                            <th>Passport</th>
                            <th>Passport Name</th>
                            <th>Passport Country</th>
                            <th>Passport Expiry Date</th>
                            <th>Teudat Zehut</th>
                            <th>Insurance</th>
                            <th>Insurance Type</th>
                            <th>Email ID</th>
                            <th>Cell USA</th>
                            <th>Cell Israel</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip Code</th>
                            <th>Country</th>
                            <th>Home Phone</th>
                            <th>Hold Transcript</th>
                            <th>Image File Path</th>
                            <th>Class</th>
                            <th>Group</th>
                            <th>Division</th>
                            <th>Floor</th>
                            <th>Room</th>
                            <th>Waiver</th>
                            <th>Medical Form</th>
                            <th>Travel Form</th>
                            <th>Flight Date</th>
                            <th>Flight Information</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>


                        @forelse ($data['students'] as $key => $row)
                        <tr id="row_{{ @$row->student->id }}">
                            <td class="serial">{{ ++$key }}</td>
                            <td class="serial">
                                <a href="{{ route('student.show', $row->student->id) }}" class="view-attachment-btn">
                                    <img src="{{ asset('backend/assets/images/new_images/eye-white.svg') }}" alt="Eye Icon">
                                </a>
                            </td>

                            <td class="serial">{{ @$row->student->last_name }}</td>
                            <td class="serial">{{ @$row->student->first_name }}</td>
                            <td>{{ $row->school_year }}</td>
                            <td>{{ $row->year_status }}</td>
                            <!-- <td>
                                @if (@$row->student->status == App\Enums\Status::ACTIVE)
                                <span
                                    class="badge-basic-success-text">{{ ___('common.active') }}</span>
                                @else
                                <span
                                    class="badge-basic-danger-text">{{ ___('common.inactive') }}</span>
                                @endif
                            </td> -->
                            <td>{{ @$row->student->hebrew_last_name }}</td>
                            <td>{{ @$row->student->hebrew_first_name }}</td>
                            <td>{{ @$row->student->diploma_name }}</td>
                            <td>{{ @$row->student->high_school }}</td>
                            <td>{{ $row->father_name }}</td>

                            <td>{{ dateFormat(@$row->student->dob)}}</td>
                            <td>{{ @$row->student->hebrew_dob }}</td>
                            <td>{{ @$row->student->place_of_birth }}</td>
                            <td>{{ @$row->student->ssn }}</td>
                            <td>{{ @$row->student->passport_no }}</td>
                            <td>{{ @$row->student->passport_name }}</td>
                            <td>{{ @$row->student->passport_country }}</td>
                            <td>{{ dateFormat(@$row->student->passport_exp_date)}}</td>
                            <td>{{ @$row->student->teudat_zehut }}</td>
                            <td>{{ @$row->student->insurance }}</td>
                            <td>{{ @$row->student->insurance_type }}</td>
                            <td>{{ @$row->student->email }}</td>
                            <td>{{ @$row->student->cell_usa }}</td>
                            <td>{{ @$row->student->cell_israel }}</td>
                            <td>{{ @$row->student->residance_address }}</td>
                            <td>{{ @$row->student->city }}</td>
                            <td>{{ @$row->student->state }}</td>
                            <td>{{ @$row->student->zip_code }}</td>
                            <td>{{ @$row->student->country }}</td>
                            <td>{{ @$row->student->mobile }}</td>
                            <td>{{-- if hold transcript --}}</td>
                            <!-- <td>
                                @if($row->student && $row->student->imageUpload)
                                <a href="{{ asset($row->student->imageUpload->path) }}" target="_blank">
                                    View Image
                                </a>
                                {{ asset($row->student->imageUpload->path) }}
                                @else
                                No Image
                                @endif
                            </td> -->
                            <td style="max-width: 185px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                @if($row->student && $row->student->imageUpload)
                                <a href="{{ asset($row->student->imageUpload->path) }}" target="_blank" title="{{ asset($row->student->imageUpload->path) }}">
                                    {{ asset($row->student->imageUpload->path) }}
                                </a>
                                @else
                                No Image
                                @endif
                            </td>

                            <td>{{ $row->homeroom_class }}</td>
                            <td>{{ $row->group }}</td>
                            <td>{{ $row->division }}</td>
                            <td>{{ $row->floor }}</td>
                            <td>{{ $row->room }}</td>
                            <td>
                                @if($row->checklist == 1)
                                Waiver
                                @else
                                --
                                @endif
                            </td>
                            <td>
                                @if($row->checklist == 2)
                                Medical
                                @else
                                --
                                @endif
                            </td>
                            <td>{{ $row->travel_from }}</td>
                            <td>{{ $row->flight_date }}</td>
                            <td>{{ $row->flight_info }}</td>
                            @if (hasPermission('student_update') || hasPermission('student_delete'))
                            <td>
                                <div class="actions-wrp">
                                    <a href="{{ route('student.edit', $row->student->id) }}">
                                        <img src="{{ asset('backend/assets/images/new_images/edit-icon-primary.svg') }}" alt="Icon">
                                    </a>
                                </div>

                            </td>
                            @endif
                        </tr>


                        @empty
                        <tr>
                            <td colspan="100%" class="text-center gray-color">
                                <img src="{{ asset('images/no_data.svg') }}" alt=""
                                    class="mb-primary" width="100">
                                <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                <p class="mb-0 text-center text-secondary font-size-90">
                                    {{ ___('common.please_add_new_entity_regarding_this_table') }}
                                </p>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!--  pagination start -->
            <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-between">
                        {!! $data['students']->appends(\Request::capture()->except('page'))->links() !!}
                    </ul>
                </nav>
            </div>
            <!--  pagination end -->

            {{-- <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                            <ul>
                                <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-left.svg" alt="Icon"></a></li>
            <li class="active"><a href="#url">1</a></li>
            <li><a href="#url">2</a></li>
            <li><a href="#url">3</a></li>
            <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-right.svg" alt="Icon"></a></li>
            </ul>
        </div>

        <div class="pages-select">
            <form>
                <div class="formfield">
                    <label>Per page</label>
                    <select>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </form>
            <p>of 2 results</p>
        </div>
    </div> --}}
</div>

</div>
</div>

<!-- End Of Dashboard Body -->
@endsection