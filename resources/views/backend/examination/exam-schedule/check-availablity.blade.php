@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

     <div class="ds-breadcrumb">
                <h1>Check Availability</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="./dashboard.html">Exam Schedule</a> /</li>
                    <li>Check Availability</li>
                </ul>
            </div>
            <div class="ds-pr-body tab-wrapper">
                
                <div class="ds-cmn-table-wrp">
                    <div class="ds-cmn-upr-wrp gr-bg">
                        <h2>Exam Request Details</h2>
                        <div class="ds-cmn-details-cd-outer justify-content-between mb-3">
                            <div class="ds-cmn-details-cd">
                                <h3>Exam Type:</h3>
                                <p>Mid-Term</p>
                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Class:</h3>
                                <p>Class Name</p>
                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Subject:</h3>
                                <p>Subject Name</p>
                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Teacher:</h3>
                                <p>Teacher Name</p>
                            </div>
                        </div>

                        <div class="ds-cmn-white-label-txt">
                            <i class="fa-solid fa-location-dot"></i>
                            Requested: Room 101 at 10:00 AM - 12:00 PM
                        </div>
                    </div>

                    <form class="availability-form-container">
                        <div class="mb-4 align-items-end">
                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label for="examDate">Date</label>
                                    <input type="date" id="examDate" placeholder="dd-mm-yyyy">
                                </div>
                                <div class="input-grp">
                                    <label for="examTime">Time</label>
                                    <input type="time" id="examTime" placeholder="e.g. 09:00 - 11:00">
                                </div>
                            </div>
                            <div class="input-grp has-btn">
                                <label for="studentCount">Total Number of Students</label>
                                <input type="number" id="studentCount" value="50">
                                <button type="button" class="cmn-btn btn-sm">Auto Distribute</button>
                            </div>
                        </div>

                        <div class="cmn-tab-content online-mode">
                            <div class="cmn-tab-content-head">
                                <h3>Available Slots</h3>
                                <button type="button">View Details</button>
                            </div>
                        
                            <div class="avaiable-slots-cd-wrp">
                                    <div class="available-slots-form">
                                        <fieldset class="avaiable-slots-cd-form" aria-labelledby="available-slots-heading">
                                        <legend id="available-slots-heading" class="sr-only">Available Slots</legend>
                                
                                        <div class="avaiable-slots-cd-grid">
                                            <div class="avaiable-slots-cd" data-slot="2024-09-14T10:00">
                                                <label for="avaiable-slot-1" tabindex="0">
                                                    <span class="avlble-slot-date">Thursday, September 14, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-1" type="radio" name="avaiable-slot" value="2024-09-14T10:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-14T14:00">
                                                <label for="avaiable-slot-2" tabindex="0">
                                                    <span class="avlble-slot-date">Thursday, September 14, 2024</span>
                                                    <span class="avlble-slot-time">02:00 PM - 03:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-2" type="radio" name="avaiable-slot" value="2024-09-14T14:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-15T10:00">
                                                <label for="avaiable-slot-3" tabindex="0">
                                                    <span class="avlble-slot-date">Friday, September 15, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-3" type="radio" name="avaiable-slot" value="2024-09-15T10:00" />
                                            </div>
                                            <div class="avaiable-slots-cd" data-slot="2024-09-15T12:00">
                                                <label for="avaiable-slot-4" tabindex="0">
                                                    <span class="avlble-slot-date">Friday, September 15, 2024</span>
                                                    <span class="avlble-slot-time">12:00 PM - 01:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-4" type="radio" name="avaiable-slot" value="2024-09-15T12:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-17T10:00">
                                                <label for="avaiable-slot-5" tabindex="0">
                                                    <span class="avlble-slot-date">Sunday, September 17, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-5" type="radio" name="avaiable-slot" value="2024-09-17T10:00" />
                                            </div>
                                            <div class="avaiable-slots-cd" data-slot="2024-09-17T14:00">
                                                <label for="avaiable-slot-6" tabindex="0">
                                                    <span class="avlble-slot-date">Sunday, September 17, 2024</span>
                                                    <span class="avlble-slot-time">02:00 PM - 03:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-6" type="radio" name="avaiable-slot" value="2024-09-17T14:00" />
                                            </div>
                                        </div>
                                
                                        </fieldset>
                                    </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="section-heading mb-3">Student Distribution</h4>
                                <div class="distribution-summary">
                                    <span class="me-3"><strong>Allocated:</strong> 0 / 34</span>
                                    <span><strong>Capacity:</strong> 50</span>
                                </div>
                            </div>

                            <div class="distribution-item">
                                <div class="room-name">Room 101</div>
                                <div class="student-input-wrapper">
                                    <input type="number" class="form-control text-center" value="25">
                                    <i class="fas fa-sync-alt reset-icon"></i>
                                </div>
                                <div class="utilization-label">Utilization</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="capacity-info">Capacity: 50 <span class="percent ms-2">50%</span></div>
                            </div>

                            <div class="distribution-item">
                                <div class="room-name">Room 202</div>
                                <div class="student-input-wrapper">
                                    <input type="number" class="form-control text-center" value="25">
                                    <i class="fas fa-sync-alt reset-icon"></i>
                                </div>
                                <div class="utilization-label">Utilization</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="capacity-info">Capacity: 50 <span class="percent ms-2">50%</span></div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cmn-btn btn-sm">Cancel</button>
                            <button type="submit" class="cmn-btn btn-sm">Submit</button>
                        </div>
                    </form>
  
                </div>
                  
            </div>

@endsection