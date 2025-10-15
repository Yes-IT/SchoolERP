@extends('student.Layout.app')
 
@section('content')
 
<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>My Classes</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>My Classes</li>
    </ul>
</div>
 
<div class="ds-pr-body">
    <div class="classes-schedule-container">
        <div class="classes-schedule-filter">
            <div class="datepicker">
                <div class="datepicker__header">
                    <img src="{{asset('student/images/calender-icon.svg')}}" alt="Icon">
                    <span id="range-display">Jan 01, 2025 - Jan 05, 2025</span>
                </div>
                <div class="datepicker-body-wrp">
                    <div class="datepicker__body">
                        <select id="year-select"></select>
                        <select id="month-select"></select>
                        <select id="week-select"></select>
                    </div>
                    <div class="datepicker__footer">
                        <button class="datepicker__btn datepicker__btn--cancel cmn-btn" id="btn-cancel">Cancel</button>
                        <button class="datepicker__btn datepicker__btn--apply cmn-btn" id="btn-apply">Apply</button>
                    </div>
                </div>
            </div>
 
            <button class="cmn-btn print-btn">Print Now <img src="{{'student/images/printer-icon.svg'}}"
                    alt="Icon"></button>
        </div>
 
        <div id="printArea">
            <div class="boxtbl-outer">
                <div class="box-table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>Day/Time</th>
                            @foreach($times as $time)
                                <th>{{ $time }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($weekDays as $day)
                                <tr>
                                    <th>{{ $day }}</th>
                                    @foreach($times as $time)
                                        <td>
                                            @if(isset($grouped[$day][$time]))
                                                <strong>{{ $grouped[$day][$time]->subject_name }}</strong><br>
                                                {{ $grouped[$day][$time]->staff_first_name }} {{ $grouped[$day][$time]->staff_last_name }}<br>
                                                Room No. {{ $grouped[$day][$time]->room }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
 
                            <!-- Shabbos -->
                            {{-- <tr>
                                <th>Shabbos</th>
                                <td colspan="12" style="background: var(--secondary-clr);"></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!-- End Of Dashboard -->
 
@endsection
 
@push('page_script')
<script>
    document.querySelector('.print-btn').addEventListener('click', function () {
        window.print();
    });
</script>
 
@endpush