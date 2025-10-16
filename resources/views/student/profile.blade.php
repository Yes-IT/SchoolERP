@extends('student.Layout.app')

@section('content')
<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>My Profile</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>My Profile</li>
    </ul>
</div>
<div class="ds-pr-body">
    <div class="ds-pr-profile-card">
        <div class="dspr-profile-cd-upr">
            <div class="dspr-profile-cd-img">
                @if(!empty($upload->path))
                <img src="{{ asset($upload->path) }}" alt="Profile Photo">
                @else
                <img src="{{ asset('backend/assets/images/new-version.jpg') }}" alt="Default Profile Image">
                @endif
                
            </div>
            <div class="dspr-profile-cd-info">
                <h2>{{ "$data->first_name $data->last_name" }}</h2>
                <p>{{ $data->hebrew_name }}</p>
                <div class="user-id">Student ID {{ $data->student_code }}</div>
            </div>
        </div>
        <div class="dspr-profile-cd-btm">
            <div class="dsprprofile-course-info">
                <table>
                    <tr>
                        <td>Diploma name</td>
                        <td>{{$data->diploma_name}}</td>
                    </tr>
                    <tr>
                        <td>Year</td>
                        <td>{{$data->admission_date}}</td>
                    </tr>
                    <tr>
                        <td>Semester</td>
                        <td>1</td>
                    </tr>
                </table>
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
                            <td>03/11/1998</td>
                        </tr>
                        <tr>
                            <td>Hebrew Birthday</td>
                            <td>13 Adar I, 5758</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>edwardthomas09@gmail.com</td>
                        </tr>
                        <tr>
                            <td>High School</td>
                            <td>High School</td>
                        </tr>
                        <tr>
                            <td>Passport No.</td>
                            <td>Infection</td>
                        </tr>
                        <tr>
                            <td>Passport Name</td>
                            <td>Edward Thomas</td>
                        </tr>
                        <tr>
                            <td>Passport Country</td>
                            <td>USA</td>
                        </tr>
                        <tr>
                            <td>Birth Country</td>
                            <td>USA</td>
                        </tr>
                        <tr>
                            <td>Passport Exp. Date</td>
                            <td>03/11/2030</td>
                        </tr>
                        <tr>
                            <td>Teudat Zehut</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td>Insurance ID</td>
                            <td>ACM123456789</td>
                        </tr>
                        <tr>
                            <td>Insurance Type</td>
                            <td>Health Insurance</td>
                        </tr>
                        <tr>
                            <td>Cell (Israel)</td>
                            <td>+972 50‑123‑4567</td>
                        </tr>
                        <tr>
                            <td>Cell (USA)</td>
                            <td>(555) 123‑4567</td>
                        </tr>
                        <tr>
                            <td>Home Phone</td>
                            <td>+972 50‑123‑4567</td>
                        </tr>
                        <tr>
                            <td>SSN</td>
                            <td>34826841</td>
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
                            <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
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
                            <td>Parents Name</td>
                            <td>Mr. Edward Thomas & Mrs. Allison Thomas</td>
                        </tr>
                        <tr>
                            <td>Home Phone Number</td>
                            <td>98654646</td>
                        </tr>
                        <tr>
                            <td>Father Cell Number</td>
                            <td>98654646</td>
                        </tr>
                        <tr>
                            <td>Mother Cell Number</td>
                            <td>98654646</td>
                        </tr>
                        <tr>
                            <td>Father Email</td>
                            <td>example@gmail.com</td>
                        </tr>
                        <tr>
                            <td>Mother Email</td>
                            <td>example@gmail.com</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
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
                            <td>Craig Curtis</td>
                        </tr>
                        <tr>
                            <td>Relationship</td>
                            <td>Uncle</td>
                        </tr>
                        <tr>
                            <td>Home Phone</td>
                            <td>3218410414</td>
                        </tr>
                        <tr>
                            <td>Cell Phone</td>
                            <td>2145124944</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>craigcurtis@gmail.com</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Of Dashboard -->
@endsection

@push('page_script')

@endpush