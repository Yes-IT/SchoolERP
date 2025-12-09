@extends('parent-panel.partials.master')

@section('title')
    {{-- {{ @$data['title'] }} --}}
@endsection
@section('content')
    <div class="ds-breadcrumb">
        <h1>{{$data->first_name}}’s Profile</h1>
        <ul>
            <li><a href="dashboard.html">Dashboard</a> /</li>
            <li>{{$data->first_name}}’s Profile</li>
        </ul>
    </div>
    <div class="ds-pr-body">
        <div class="ds-pr-profile-card">
            <div class="dspr-profile-cd-upr">
                <div class="dspr-profile-cd-img">
                    <img src="{{asset($data->image_path)}}" alt="Profile Image">
                </div>
                <div class="dspr-profile-cd-info">
                    <h2>{{$data->first_name}} {{$data->last_name}}</h2>
                    <p>{{$data->first_name}} {{$data->last_name}}</p>
                    <div class="user-id">Student ID {{$data->student_id}}</div>
                </div>
            </div>
            <div class="dspr-profile-cd-btm">
                <div class="dsprprofile-course-info">
                    <table>
                        <tr>
                            <td class="td-lineremover">Diploma name</td>
                            <td class="td-lineremover">{{$data->diploma_name}}</td>
                        </tr>
                        <tr>
                            <td class="td-lineremover">Year</td>
                            <td class="td-lineremover">2025-26</td>
                        </tr>
                        <tr>
                            <td class="td-lineremover">Semester</td>
                            <td class="td-lineremover">1</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="dspr-bdy-content">
            <div class="dspr-bdy-content-sec border-remover">
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                    <table>
                        <tbody>
                            <tr class="table-tr">
                                <td class="td-lineremover">Admission Date</td>
                                <td class="td-lineremover">03/18/2021</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Date of Birth</td>
                                <td class="td-lineremover">{{ $data->dob }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Hebrew Birthday</td>
                                <td class="td-lineremover">{{ $data->hebrew_dob }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Email</td>
                                <td class="td-lineremover">{{ $data->email }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">High School</td>
                                <td class="td-lineremover"{{ $data->diploma_name }}</td>
                            </tr>

                            <tr class="table-tr">
                                <td class="td-lineremover">Passport No.</td>
                                <td class="td-lineremover">{{ $data->passport_no }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Passport Name</td>
                                <td class="td-lineremover">{{ $data->passport_name }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Passport Country</td>
                                <td class="td-lineremover">{{ $data->passport_country }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Birth Country</td>
                                <td class="td-lineremover">{{ $data->place_of_birth }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Passport Exp. Date</td>
                                <td class="td-lineremover">{{ $data->passport_exp_date }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Teudat Zehut</td>
                                <td class="td-lineremover">{{ $data->teudat_zehut }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Insurance ID</td>
                                <td class="td-lineremover">{{ $data->insurance }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Insurance Type</td>
                                <td class="td-lineremover">{{ $data->insurance_type }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Cell (Israel)</td>
                                <td class="td-lineremover">{{ $data->cell_israel }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Cell (USA)</td>
                                <td class="td-lineremover">{{ $data->cell_usa }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">Home Phone</td>
                                <td class="td-lineremover">{{ $data->guardian_home_phone }}</td>
                            </tr>
                            <tr class="table-tr">
                                <td class="td-lineremover">SSN</td>
                                <td class="td-lineremover">{{ $data->ssn }}</td>
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
                                <td class="td-lineremover">Home Address</td>
                                <td class="td-lineremover">{{ $data->residance_address }}</td>
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
                                <td class="td-lineremover">Father Name</td>
                                <td class="td-lineremover">{{ $data->father_name }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Mother Name</td>
                                <td class="td-lineremover">{{ $data->mother_name }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Father Cell Number</td>
                                <td class="td-lineremover">{{ $data->father_mobile }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Mother Cell Number</td>
                                <td class="td-lineremover">{{ $data->mother_mobile }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Father Email</td>
                                <td class="td-lineremover">{{ $data->father_email }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Mother Email</td>
                                <td class="td-lineremover">{{ $data->mother_email }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Address</td>
                                <td class="td-lineremover">{{ $data->city }} , {{ $data->state }}
                                    ,{{ $data->country }} ({{ $data->zip_code }})</td>
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
                                <td class="td-lineremover">Name</td>
                                <td class="td-lineremover">{{ $data->guardian_name }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Relationship</td>
                                <td class="td-lineremover">{{ $data->guardian_relation }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Home Phone</td>
                                <td class="td-lineremover">{{ $data->guardian_home_phone }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Cell Phone</td>
                                <td class="td-lineremover">{{ $data->guardian_mobile }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Email</td>
                                <td class="td-lineremover">{{ $data->guardian_email }}</td>
                            </tr>
                            <tr>
                                <td class="td-lineremover">Address</td>
                                <td class="td-lineremover">{{ $data->guardian_address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
