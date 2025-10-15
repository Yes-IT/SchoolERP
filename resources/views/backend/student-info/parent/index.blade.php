@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
        <!-- Dashboard Body Begin -->
        <div class="dashboard-body dspr-body-outer">
            <div class="ds-breadcrumb">
                <h1>Parents</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="./dashboard.html">Parents</a> /</li>
                    <li>Parents List</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Filters</h2>
                    </div>
                    <div class="atndnc-filter student-filter">
                        <form method="POST" action="{{ route('parent.search') }}">
                            @csrf
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options multi-input-grp">
                                    <div class="input-grp">
                                        <select id="ParentyearFilter" name="year">
                                            <option value="">Select Year</option>
                                            @foreach(range(date('Y'), 2000) as $year)
                                                @php
                                                    $academicYear = $year . '-' . ($year + 1);
                                                @endphp
                                                <option value="{{ $academicYear }}" {{ request('year') == $academicYear ? 'selected' : '' }}>
                                                    {{ $academicYear }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="year_status">
                                            <option value="">Select Year Status</option>
                                            <option value="active" {{ request('year_status') == 'active' ? 'selected' : '' }}>active</option>
                                            <option value="inactive" {{ request('year_status') == 'inactive' ? 'selected' : '' }}>inactive</option>
                                        </select>
                                    </div>
                                </div>
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
                                <form method="POST" action="{{ route('parent.search') }}">
                                    @csrf
                                    <div class="dropdown-year h-100" data-selected="Select Student">
                                        <div class="dropdown-trigger">
                                            <span class="dropdown-label-parent" id="selectedStudentLabel">
                                                @if (request()->has('student_name') && request('student_name') === '')
                                                    All
                                                @else
                                                    {{ request('student_name') ?? 'Select Student' }}
                                                @endif
                                            </span>
                                            <i class="dropdown-arrow"></i>
                                        </div>
                                    
                                        <div class="dropdown-options">
                                            <div class="dropdown-option dropdown-option-parent"
                                                 data-id=""
                                                 data-name="">
                                                All
                                            </div>
                                            @forelse ($data['students'] as $student)
                                                @php
                                                    $fullName = $student->first_name . ' ' . $student->last_name;
                                                @endphp
                                                <div class="dropdown-option dropdown-option-parent"
                                                     data-id="{{ $student->id }}"
                                                     data-name="{{ $fullName }}">
                                                    {{ $fullName }}
                                                </div>
                                            @empty
                                                <div class="dropdown-option">No students found</div>
                                            @endforelse
                                        </div>
                                        <input type="hidden" name="student_name" id="studentNameInput" value="{{ request('student_name') }}">
                                    </div>
                                </form>
                                <a href="{{ route('parent.create') }}" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add Parent</a>
                                {{-- <a href="{{ route('parent.phoneLog') }}" class="cmn-btn btn-sm">Phone Log</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="ds-cmn-tble count-row tbl-5_4k">
                        <table>
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>
                                    <th class="purchase">View Details</th>
                                    <th class="purchase">Father Title</th>
                                    <th class="purchase">Father Name</th>
                                    <th class="purchase">Mother Title</th>
                                    <th class="purchase">Mother Name</th>
                                    <th class="purchase">Maiden Name</th>
                                    <th class="purchase">Student Name</th>
                                    <th class="purchase">Address</th>
                                    <th class="purchase">City</th>
                                    <th class="purchase">State</th>
                                    <th class="purchase">Zip Code</th>
                                    <th class="purchase">Country</th>
                                    <th class="purchase">Home Phone</th>
                                    <th class="purchase">Father Cell</th>
                                    <th class="purchase">Mother Cell</th>
                                    <th class="purchase">Father Email</th>
                                    <th class="purchase">Mother Email</th>
                                    <th class="purchase">Father Hebrew Name</th>
                                    <th class="purchase">Mother Hebrew Name</th>
                                    <th class="purchase">Father Birth Date</th>
                                    <th class="purchase">Mother Birth Date</th>
                                    <th class="purchase">Father Occupation</th>
                                    <th class="purchase">Mother Occupation</th>
                                    <th class="purchase">Father Information</th>
                                    <th class="purchase">Mother Information</th>
                                    <th class="purchase">Marital Status</th>
                                    <th class="purchase">Marital Comment</th>
                                    <th class="purchase">Relative Name</th>
                                    <th class="purchase">Relative Address</th>
                                    <th class="purchase">Relative Phone</th>
                                    <th class="purchase">Action</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTable" class="tbody">
                                @include('backend.student-info.parent.parent-list')
                            </tbody>
                        </table>
                    </div>
                    <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                            @if ($data['parents']->total() > 0)
                                <ul>
                                    @if ($data['parents']->onFirstPage())
                                        <li><span><img src="{{ asset('images/parent/arrow-left.svg') }}" alt="Icon"></span></li>
                                    @else
                                        <li>
                                            <a href="{{ $data['parents']->previousPageUrl() }}">
                                                <img src="{{ asset('images/parent/arrow-left.svg') }}" alt="Icon">
                                            </a>
                                        </li>
                                    @endif
                                    
                                    @foreach ($data['parents']->getUrlRange(1, $data['parents']->lastPage()) as $page => $url)
                                        <li class="{{ $page == $data['parents']->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                    
                                    @if ($data['parents']->hasMorePages())
                                        <li>
                                            <a href="{{ $data['parents']->nextPageUrl() }}">
                                                <img src="{{ asset('images/parent/arrow-right.svg') }}" alt="Icon">
                                            </a>
                                        </li>
                                    @else
                                        <li><span><img src="{{ asset('images/parent/arrow-right.svg') }}" alt="Icon"></span></li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                        <div class="pages-select">
                            @if ($data['parents']->total() > 0)
                                <p>
                                    Showing {{ $data['parents']->firstItem() }} - {{ $data['parents']->lastItem() }}
                                    of {{ $data['parents']->total() }} results
                                </p>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- Dashboard Body End -->

        <script>
            document.querySelectorAll('.dropdown-option-parent').forEach(option => {
                option.addEventListener('click', function() {
                    var studentName = this.getAttribute('data-name');
                    document.getElementById('studentNameInput').value = studentName;
                    document.getElementById('selectedStudentLabel').innerText = studentName;
                    this.closest('form').submit();
                });
            });
        </script>
@endsection