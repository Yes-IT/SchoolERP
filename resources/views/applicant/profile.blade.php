@extends('applicant.partials.app')

@section('content')

@include('applicant.partials.header')
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
                <h2>{{ $data->user_name }}</h2>
                <div class="user-id">Applicant ID - {{ $data->id }} </div>
            </div>
        </div>
        <div class="dspr-profile-cd-btm">
            <div class="dsprprofile-course-info">
                <table>
                    @if( $data->first_name)
                    <tr>
                        <td>First Name</td>
                        <td>{{ $data->first_name}}</td>
                    </tr>
                    @endif
                    @if( $data->last_name)
                    <tr>
                        <td>Last Name</td>
                        <td>{{ $data->last_name}}</td>
                    </tr>
                    @endif
                    @if( $data->prefered_name)
                    <tr>
                        <td>Prefered Name</td>
                        <td>{{ $data->prefered_name}}</td>
                    </tr>
                    @endif

                </table>
            </div>
        </div>
    </div>

    <div class="dspr-bdy-content">
        <div class="dspr-bdy-content-sec border-0">
            <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                <table>
                    <tbody>
                        @if( $data->date_of_birth)
                        <tr>
                            <td>Date of Birth</td>
                            <td>{{$data->date_of_birth}}</td>
                        </tr>
                        @endif
                        @if( $data->hdob)
                        <tr>
                            <td>Hebrew Date of Birth</td>
                            <td>{{$data->hdob}}</td>
                        </tr>
                        @endif
                        @if( $data->birth_place)
                        <tr>
                            <td>Birth place</td>
                            <td>{{$data->birth_place}}</td>
                        </tr>
                        @endif
                        @if( $data->email)
                        <tr>
                            <td>Email</td>
                            <td>{{ $data->email }}</td>
                        </tr>
                        @endif
                        @if( $data->hebrew_first_name)
                        <tr>
                            <td>Hebrew first name</td>
                            <td>{{$data->hebrew_first_name}}</td>
                        </tr>
                        @endif
                        @if( $data->hebrew_name)
                        <tr>
                            <td>Hebrew name</td>
                            <td>{{$data->hebrew_name}}</td>
                        </tr>
                        @endif
                        @if( $data->usa_cell)
                        <tr>
                            <td>Cell (USA)</td>
                            <td>{{$data->usa_cell}}</td>
                        </tr>
                        @endif
                        @if( $data->cell)
                        <tr>
                            <td>Home Phone</td>
                            <td>{{ $data->cell}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="dspr-bdy-content-sec">
            <h2>Address</h2>
            <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                <table>
                    <tbody>
                        @if( $data->address)

                        <tr>
                            <td>Home Address</td>
                            <td>{{ $data->address}}</td>
                        </tr>
                        @endif
                        @if( $data->city)
                        <tr>
                            <td>City </td>
                            <td>{{ $data->city}}</td>
                        </tr>
                        @endif
                        @if( $data->state)
                        <tr>
                            <td>State </td>
                            <td>{{ $data->state}}</td>
                        </tr>
                        @endif
                        @if( $data->country)
                        <tr>
                            <td>Country </td>
                            <td>{{ $data->country}}</td>
                        </tr>
                        @endif
                        @if( $data->zip)
                        <tr>
                            <td>Zip </td>
                            <td>{{ $data->zip}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')

@endpush