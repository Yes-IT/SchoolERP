@extends('applicant.partials.app')

@section('content')
    <div class="dashboard-body dspr-body-outer">
        @include('applicant.partials.header')

        <div class="ds-breadcrumb">
            <h1>Interview Details</h1>
        </div>
        <div class="ds-pr-body">
            @if ($data['interviews'] == null)
                <div class="alert alert-info">
                    No interview scheduled.
                </div>
            @else
                <div class="ds-cmn-table-wrp">
                    <div class="sec-head has-brdr">
                        <h2>Details</h2>
                    </div>
                    <div class="ds-cmn-tble txt-primary-2nd txt-semibold w1200">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Interview Date</td>
                                    <td>{{ $data['interviews']->interview_date }}</td>
                                </tr>
                                <tr>
                                    <td>Interview Time</td>
                                    <td>{{ $data['interviews']->interview_time }}</td>
                                </tr>
                                <tr>
                                    <td>Mode</td>
                                    <td>{{ $data['interviews']->interview_mode }}</td>
                                </tr>
                                <tr>
                                    <td>Interview Location</td>
                                    <td>{{ $data['interviews']->interview_location }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection
