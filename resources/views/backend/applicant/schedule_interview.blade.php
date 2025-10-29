@extends('backend.master')
@section('title')

    {{ @$data['title'] }}
@endsection

@section('content')
<div class="ds-breadcrumb">
                <h1>Schedule Interview</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="./dashboard.html">Student Application Forms</a> /</li>
                    <li>Schedule Interview</li>
                </ul>
            </div>
            <div class="ds-pr-body tab-wrapper">
                
                <div class="ds-cmn-table-wrp">
                    <div class="ds-cmn-upr-wrp gr-bg">
                        <h2>Student Details</h2>
                        <div class="ds-cmn-details-cd-outer">
                            <div class="ds-cmn-details-cd">
                                <h3>Full Name:</h3>
                                <p>Lorem ipsum</p>
                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Address:</h3>
                                <p>Lorem ipsum dolor sit amet, Texas, United States, 75001</p>
                            </div>
                        </div>
                    </div>

                    <div class="date-range-wrp">
                        <div class="date-range-picker">
                            <label class="dr-label">Date Range</label>
                            <div class="dr-row">
                              <div class="dr-input-wrap">
                                <input class="dr-input" readonly placeholder="DD/MM/YYYY - DD/MM/YYYY" />
                                <button class="dr-icon-btn" type="button" aria-label="Open calendar">📅</button>
                              </div>
                              <button class="dr-search-btn cmn-btn" type="button">Search</button>
                            </div>
                          
                            <!-- popup -->
                            <div class="dr-popup" aria-hidden="true" role="dialog" aria-label="Select date range">
                                <div class="dr-popup-inner">
                                    <div class="dr-header">
                                        <button class="dr-nav dr-prev" type="button" aria-label="Previous months">‹</button>
                                        <div class="dr-months">
                                            <div class="dr-month dr-month-left"></div>
                                            <div class="dr-month dr-month-right"></div>
                                        </div>
                                        <button class="dr-nav dr-next" type="button" aria-label="Next months">›</button>
                                    </div>
                                    <div class="dr-calendars">
                                        <div class="dr-cal dr-cal-left"></div>
                                        <div class="dr-cal dr-cal-right"></div>
                                    </div>
                                    <div class="dr-footer">
                                        <div class="dr-selected">—</div>
                                        <div class="dr-actions">
                                            <button class="dr-btn dr-cancel" type="button">CANCEL</button>
                                            <button class="dr-btn dr-apply" type="button">Apply</button>
                                        </div>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ds-content-head">
                        <div class="cmn-tab-head">
                            <ul>
                                <li class="tab-bg"></li>
                                <li class="active">Online Mode</li>
                                <li>Offline Mode</li>
                            </ul>
                        </div>
                    </div>
                    <div class="cmn-tab-content online-mode">
                        <div class="cmn-tab-content-head">
                            <h3>Available Slots</h3>
                            {{-- <button type="button">View Details</button> --}}
                            <a href="{{route('applicant.calender')}}">View Details</a>
                        </div>
                    
                        <div class="avaiable-slots-cd-wrp">
                            <form>
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
                            </form>
                        </div>
                        <div class="interview-location-row">
                            <label class="interview-location-label" for="interview-location">Interview Location</label>
                            <input id="interview-location" class="interview-location-input" type="text" name="interview_location" placeholder="Location Name" />
                        
                        </div>
                        <div class="avaiable-slots-actions">
                            <button type="button" class="cmn-btn cancel-btn">Cancel</button>
                            <button type="button" class="cmn-btn primary-assign-btn">Offer 3 Slots</button>
                        </div>
                    </div>
  
                </div>
                  
            </div>
@endsection