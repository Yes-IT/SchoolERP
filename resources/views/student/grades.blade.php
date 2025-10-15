@extends('student.Layout.app')

@section('content')
<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>My Grades</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>My Grades</li>
    </ul>
</div>
<div class="ds-pr-body">
    <div class="ds-cmn-table-wrp grades-pg">
        <div class="ds-content-head has-drpdn">
            <div class="sec-head">
                <h2>Grades</h2>
            </div>
            <div class="ds-cmn-filter-wrp">
                <form method="GET" id="filterForm">
                    {{-- Hidden inputs will hold selected values --}}
                    <input type="hidden" name="year" id="yearInput" value="{{ $selectedYear }}">
                    <input type="hidden" name="semester" id="semesterInput" value="{{ $selectedSemester }}">

                    <div class="dsbdy-filter-wrp p-0">
                        {{-- Year Dropdown --}}
                        <div class="dropdown-year" data-selected="{{ $yearOptions[$selectedYear] ?? '2024-25' }}">
                            <div class="dropdown-trigger">
                                <span class="dropdown-label">{{ $yearOptions[$selectedYear] ?? '2024-25' }}</span>
                                <i class="dropdown-arrow"></i>
                            </div>
                            <div class="dropdown-options">
                                @foreach($yearOptions as $key => $label)
                                <div class="dropdown-option" data-value="{{ $key }}">{{ $label }}</div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Semester Dropdown --}}
                        <div class="dropdown-period" data-selected="{{ $semesterOptions[$selectedSemester] ?? 'Full Year' }}">
                            <div class="dropdown-trigger minw-160">
                                <span class="dropdown-label">{{ $semesterOptions[$selectedSemester] ?? 'Full Year' }}</span>
                                <i class="dropdown-arrow"></i>
                            </div>
                            <div class="dropdown-options">
                                @foreach($semesterOptions as $key => $label)
                                <div class="dropdown-option" data-value="{{ $key }}">{{ $label }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="ds-cmn-tble count-row">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Class</th>
                        <th>Average</th>
                        <th>Personal Absences</th>
                        <th>Excused Absences</th>
                        <th>Reduced</th>
                        <th>Percentage</th>
                        <th>Report Card</th>
                        <th>Transcript</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $index => $grade)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $grade->class }}</td>
                        <td>{{ $grade->average }}</td>
                        <td>{{ $grade->personal_absences }}</td>
                        <td>{{ $grade->excused_absences }}</td>
                        <td>{{ $grade->reduced }}</td>
                        <td>{{ $grade->percentage }}%</td>
                        <td>{{ $grade->report_card }}</td>
                        <td>{{ $grade->transcript }}</td>
                    </tr>

                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="tablepagination">
            <div class="tbl-pagination-inr">
                {{ $grades->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>

            <div class="pages-select">
                <form method="GET" id="perPageForm">
                    {{-- Keep filters in request --}}
                    <input type="hidden" name="year" value="{{ request('year') }}">
                    <input type="hidden" name="semester" value="{{ request('semester') }}">

                    <div class="formfield">
                        <label>Per page</label>
                        <select name="perPage" onchange="document.getElementById('perPageForm').submit()">
                            @foreach([1,2,3,4,5,10,15,20,25,50] as $size)
                            <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <p>
                    Showing {{ $grades->firstItem() }} - {{ $grades->lastItem() }}
                    of {{ $grades->total() }} results
                </p>
            </div>
        </div>

    </div>
</div>
<!-- End Of Dashboard -->


@endsection

@push('page_script')
<script>
    document.querySelectorAll('.dropdown-year .dropdown-option').forEach(opt => {
        opt.addEventListener('click', function() {
            document.getElementById('yearInput').value = this.dataset.value;
            document.getElementById('filterForm').submit();
        });
    });

    document.querySelectorAll('.dropdown-period .dropdown-option').forEach(opt => {
        opt.addEventListener('click', function() {
            document.getElementById('semesterInput').value = this.dataset.value;
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush