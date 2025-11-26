@extends('staff.master')

@section('content')

<div class="ds-breadcrumb">
    <h1>Notice Board</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>Notice Board</li>
    </ul>
</div>

<div class="ds-pr-body">
    
    <div class="ds-cmn-table-wrp notice-board-pg">
        <div class="dsbdycmncd-body">
            <div class="notice-list">

                <a href="{{ route('staff.communicate.message.add') }}" class="open-modal-btn session-btn" >+  Post New Message </a>

                <ul>
                    <li class="has-info-card"><a href="#url"><img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Icon"> Upcoming Assignment (04/01/2025)</a>
                        <div class="notice-info-wrp">
                            <div class="overlay"></div>
                            <div class="notice-info">
                                <div class="nc-info-head">
                                    <button type="button" class="btn-back"><i class="fa-solid fa-arrow-left"></i></button>
                                    <h2>Upcoming Assignment</h2>
                                    <button type="button" class="notice-btn-close">
                                        <img src="{{ asset('staff/assets/images/cross-icon.svg') }}" alt="Close">
                                    </button>
                                </div>
                                <div class="nc-info-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <div class="nc-doc-wrap">
                                        <button type="button" class="doc-download cmn-btn">
                                            <img src="{{ asset('staff/assets/images/file-icon.svg') }}" alt="Icon"></i>
                                            <span>Doc_0481</span>
                                            <a href="javascript:void(0)" download="{{ asset('staff/assets/image/download-icon-light.svg') }}"><img src="{{ asset('staff/assets/images/download-icon-light.svg') }}" alt="Icon"></a>
                                        </button>
                                    </div>
                                </div>
                                <div class="nc-info-footer">
                                    <div class="notice-date">
                                        <img src="{{ asset('staff/assets/images/calender-primary.svg') }}" alt="Icon">
                                        <span>Notice Date: 04/01/2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="active"><a href="#url"><img src="{{ asset('staff/assets/images/notice-icon-2.svg') }}" alt="Icon">  Change of Schedule (04/01/2025)</a></li>
                    <li><a href="#url"><img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Icon"> Upcoming Activities (04/01/2025)</a></li>
                    <li><a href="#url"><img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Icon"> Miscellaneous (04/01/2025)</a></li>
                    <li><a href="#url"><img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Icon"> Upcoming Assignment (04/01/2025)</a></li>
                    <li class="active"><a href="#url"><img src="{{ asset('staff/assets/images/notice-icon-2.svg') }}" alt="Icon">  Change of Schedule (04/01/2025)</a></li>
                    <li><a href="#url"><img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Icon"> Upcoming Activities (04/01/2025)</a></li>
                    <li><a href="#url"><img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Icon"> Miscellaneous (04/01/2025)</a></li>
                
                </ul>
            </div>
        </div>
    </div>
        
</div>

@endsection