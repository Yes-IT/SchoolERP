@extends('staff.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

<div class="ds-breadcrumb">
    <h1>My Profile</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>My Profile</li>
    </ul>
</div>

<div class="ds-pr-body">
    <div class="ds-pr-profile-card">

        <div class="dspr-profile-cd-upr">
            <div class="dspr-profile-cd-img">
                <img src="./images/user-round.svg" alt="Profile Image">
            </div>
            <div class="dspr-profile-cd-info">
                <h2>Madelyn Lubin</h2>
                <p>מדלין לובין</p>
            </div>
        </div>

        <div class="dspr-profile-cd-btm">
            <div class="dsprprofile-course-info">
                <table>
                    <tr>
                        <td>Staff Name</td>
                        <td>Madelyn Lubin</td>
                    </tr>
                    <tr>
                        <td>Position</td>
                        <td>Lorem Ipsum</td>
                    </tr>
                    <tr>
                        <td>Year</td>
                        <td>2025-26</td>
                    </tr>
                    <tr class="lasttr">
                        <td>Year Status</td>
                        <td>
                            <div>
                                <p class="tickpara"><img src="./images/true.svg" class="tick" /> Shana Alef </p>
                                <p><img src="./images/blanktick.svg" class="tick" /> Shana Bais  </p>
                            </div>
                        </td>
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
                        <td>Neighborhood</td>
                        <td>Lorem Ipsum</td>
                        </tr>
                        <tr>
                        <td>City</td>
                        <td>USA</td>
                        </tr>
                        <tr>
                        <td>Zip Code</td>
                        <td>1564564</td>
                        </tr>
                        <tr>
                        <td>Cell Phone</td>
                        <td>+972 50-123-4567</td>
                        </tr>
                        <tr>
                        <td>Home Phone</td>
                        <td>+972 50-123-4567</td>
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

    </div>

</div>

@endsection

@push('script')
    
@endpush