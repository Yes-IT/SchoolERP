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
                    {{-- Keep pagination selection when filtering --}}
                    <input type="hidden" name="perPage" value="{{ $perPage }}">

                    <div class="dsbdy-filter-wrp p-0">
                        <select name="school_years_id" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Select Year</option>
                            @foreach($yearOptions as $key => $label)
                            <option value="{{ $key }}" {{ $selectedYear == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>

                        <select name="semester_id" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Select Semester</option>
                            @foreach($semesterOptions as $key => $label)
                            <option value="{{ $key }}" {{ $selectedSemester == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
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
                        <td>{{ $grade->class_name }}</td>
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
                    {{-- Preserve selected filters --}}
                    <input type="hidden" name="school_years_id" value="{{ request('school_years_id') }}">
                    <input type="hidden" name="semester_id" value="{{ request('semester_id') }}">

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
@push('page_script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    const yearSelect = form.querySelector('[name="school_years_id"]');
    const semesterSelect = form.querySelector('[name="semester_id"]');

    yearSelect.addEventListener('change', function () {
        semesterSelect.value = ''; 
        form.submit();
    });

    semesterSelect.addEventListener('change', function () {
        yearSelect.value = ''; 
        form.submit();
    });
});
</script>
@endpush

@endpush