@extends('staff.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

<div class="ds-breadcrumb">
    <h1>My Profile</h1>
    <ul>
        <li><a href="{{ route('staff.dashboard') }}">Dashboard</a> /</li>
        <li>My Profile</li>
    </ul>
</div>

<div class="ds-pr-body">
    <div class="ds-pr-profile-card">

        <div class="dspr-profile-cd-upr">
            <div class="dspr-profile-cd-img">
                <img src="{{ asset($data['staff']->upload?->path ?? 'images/default.png') }}" alt="Profile Image">
            </div>
            <div class="dspr-profile-cd-info">
                <h2>{{ $data['staff']->first_name }} {{ $data['staff']->last_name }}</h2>
                <p>{{ $data['staff']->hebrew_first_name }} {{ $data['staff']->hebrew_last_name }}</p>
            </div>
        </div>

        <div class="dspr-profile-cd-btm">
            <div class="dsprprofile-course-info">
                <table>
                    <tr>
                        <td>Staff Name</td>
                        <td>{{ $data['staff']->first_name }} {{ $data['staff']->last_name }}</td>
                    </tr>
                    <tr>
                        <td>Position</td>
                        <td>{{ $data['staff']->position ?? ''}}</td>
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
                            <td>{{ $data['staff']->dob ? \Carbon\Carbon::parse($data['staff']->dob)->format('d/m/Y') : '' }}</td>
                        </tr>
                        <tr>
                            <td>Hebrew Birthday</td>
                            <td>{{ $data['staff']->hebrew_dob ? \Carbon\Carbon::parse($data['staff']->hebrew_dob)->format('d/m/Y') : '' }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $data['staff']->email ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Neighborhood</td>
                            <td>{{ $data['staff']->neighborhood ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ $data['staff']->city ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                            <td>{{ $data['staff']->zip_code ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Cell Phone</td>
                            <td>{{ $data['staff']->cell_phone ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Home Phone</td>
                            <td>{{ $data['staff']->phone ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>SSN</td>
                            <td>{{ $data['staff']->ssn ?? ''}}</td>
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
                            <td>{{ $data['staff']->current_address ?? ''}}</td>
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