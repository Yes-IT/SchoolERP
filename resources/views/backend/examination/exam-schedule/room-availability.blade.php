@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Teacher') }}
@endsection

@section('content')
    
<div class="ds-breadcrumb">
    <h1>Room Management</h1>
    <ul>
        <li><a href="../dashboard.html">Dashboard</a> /</li>
        <li><a href="./dashboard.html">Exam Schedule</a> /</li>
        <li>Room Availability</li>
    </ul>
</div>

<div class="ds-pr-body">
    
    <div class="classes-schedule-container ds-calendar-pg">
        <div class="classes-schedule-filter">
            <div class="sec-head">
                <h2>Room Availability</h2>
            </div>
            <div class="datepicker">
                <div class="datepicker__header">
                    <img src="{{ global_asset('backend/assets/images/calender-icon.svg') }}" alt="Icon">
                    <span id="range-display"> Jan, 2025</span>
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
        </div>

        <div class="boxtbl-outer">
            <div class="box-table-container">
                <table class="calendar-table" role="grid" aria-label="Weekly timetable">
                    <thead>
                        <tr>
                            <th>Room/Time</th>
                            <th>10:00 AM - 10:59 AM</th>
                            <th>11:00 AM - 11:59 AM</th>
                            <th>12:00 PM - 12:59 PM</th>
                            <th>01:00 PM - 01:59 PM</th>
                            <th>02:00 PM - 02:59 PM</th>
                            <th>03:00 PM - 03:59 PM</th>
                            <th>04:00 PM - 04:59 PM</th>
                            <th>05:00 PM - 05:59 PM</th>
                            
                        </tr>
                    </thead>
                
                    <tbody>
                        <tr>
                            <th>
                                <p>Room 101</p>
                                <p>Capacity:40</p>
                                <p>Available Capacity:10</p>
                            </th>
                            <td>
                                <div class="scheduled">
                                    <div class="meta">Class name 01</div>
                                </div>
                                <div class="scheduled">

                                    <div class="meta">Class name 02</div>

                                </div>    
                                <div class="scheduled">

                                    <div class="meta">Class name 03</div>

                                </div>
                                
                            </td>
                            <td>
                                <div class="scheduled">
                                    <div class="meta">Class name 01</div>
                                </div>
                                <div class="scheduled">

                                    <div class="meta">Class name 02</div>

                                </div>    
                                <div class="scheduled">

                                    <div class="meta">Class name 03</div>

                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                           
                        </tr>
                
                        <tr>
                            <th><p>Room 102</p>
                                <p>Capacity:40</p>
                                <p>Available Capacity:10</p>
                            </th>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                  <div class="scheduled">
                                    <div class="meta">Class name 01</div>
                                </div>
                                <div class="scheduled">

                                    <div class="meta">Class name 02</div>

                                </div>    
                                <div class="scheduled">

                                    <div class="meta">Class name 03</div>

                                </div>
                            </td>
                            <td>
                                 <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            
                        </tr>
                
                        <tr>
                            <th>
                                <p>Room 105</p>
                                <p>Capacity:40</p>
                                <p>Available Capacity:10</p>
                            </th>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                 <div class="scheduled">
                                    <div class="meta">Class name 01</div>
                                </div>
                                <div class="scheduled">

                                    <div class="meta">Class name 02</div>

                                </div>    
                                <div class="scheduled">

                                    <div class="meta">Class name 03</div>

                                </div>
                            </td>
                            <td>
                                <div class="scheduled">
                                    <div class="meta">Class name 01</div>
                                </div>
                                <div class="scheduled">

                                    <div class="meta">Class name 02</div>

                                </div>    
                                <div class="scheduled">

                                    <div class="meta">Class name 03</div>

                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                           
                        </tr>
                
                        <tr>
                            <th>
                                <p>Room 106</p>
                                <p>Capacity:40</p>
                                <p>Available Capacity:10</p>
                            </th>
                            <td>
                                 <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                               <div class="scheduled">
                                    <div class="meta">Class name 01</div>
                                </div>
                                <div class="scheduled">

                                    <div class="meta">Class name 02</div>

                                </div>    
                                <div class="scheduled">

                                    <div class="meta">Class name 03</div>

                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            
                        </tr>
                
                        <tr>
                            <th>
                                <p>Room 109</p>
                                <p>Capacity:40</p>
                                <p>Available Capacity:10</p>
                            </th>
                            <td>
                                 <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                 <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                           
                        </tr>
                
                        <tr>
                            <th>
                                <p>Room 201</p>
                                <p>Capacity:40</p>
                                <p>Available Capacity:10</p>
                            </th>
                            <td>
                                <div class="scheduled">
                                    <div class="meta">Class name 01</div>
                                </div>
                                <div class="scheduled">

                                    <div class="meta">Class name 02</div>

                                </div>    
                                <div class="scheduled">

                                    <div class="meta">Class name 03</div>

                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-center">
                                    <div class="available">Available</div>
                                </div>
                            </td>
                           
                        </tr>
                
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection