@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Parent') }}
@endsection


@section('content')
    
    <div class="ds-breadcrumb">
        <h1>Parents</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="./dashboard.html">Parents</a> /</li>
            <li>Parents List</li>
        </ul>
    </div>

    {{-- @dump($parents->toArray()); --}}

    <div class="ds-pr-body">
        
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter student-filter">
                <form>
                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options multi-input-grp">

                            {{-- Session / Year --}}
                            <div class="input-grp">
                                <select name="session_year" class="form-control">
                                    <option value="">Select Year</option>
                                    @foreach ($sessions as $session)
                                        <option value="{{ $session->id }}">
                                            {{ $session->name }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Year Status --}}
                            <div class="input-grp">
                                <select name="year_status" class="form-control">
                                    <option value="">Select Year Status</option>
                                    @foreach ($yearStatuses as $status)
                                        <option value="{{ $status->id }}">
                                            {{ $status->name }}   {{-- Active / Completed etc --}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div> 
        </div>

        <div class="ds-cmn-table-wrp">
            
            <div class="ds-content-head has-drpdn">
                <div class="sec-head">
                    <h2>Parents List</h2>
                </div>
                <div class="ds-cmn-filter-wrp">
                    <div class="dsbdy-filter-wrp p-0">
                        <div class="dropdown-year" data-selected="Select Student">
                            <div class="dropdown-trigger">
                                <span class="dropdown-label">Select Student</span>
                                <i class="dropdown-arrow"></i>
                            </div>

                            <div class="dropdown-options">
                                @foreach ($students as $student)
                                    <div 
                                        class="dropdown-option" 
                                        data-value="{{ $student->id }}">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                            <a href="{{ route('parent_flow.parent.add') }}" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add Parent</a>
                            <a href="./phone-log.html" class="cmn-btn btn-sm">Phone Log</a>
                    </div>
                </div>
            </div>

            <div>
                @include('backend.parent.parent-list')
            </div>

        </div>
            
    </div>

@endsection

@push('script')
    
@endpush