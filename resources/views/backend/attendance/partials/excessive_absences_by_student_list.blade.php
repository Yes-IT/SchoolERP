{{-- Table --}}
<h3 style="margin: 0 0 20px 0; font-weight: 600;">
    Excessive Absences by Student
</h3>

<div class="ds-cmn-tble">
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Student Name</th>
                <th>Personal Absences (P)</th>
                <th>P* Absences</th>
                <th>Total Personal</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summary as $i => $row)
                <tr>
                    <td>{{ $summary->firstItem() + $i }}</td>
                    <td><strong>{{ $row->student_name }}</strong></td>
                    <td>{{ $row->personal_absences }}</td>
                    <td>{{ $row->p_star_absences }}</td>
                    <td><strong class="text-danger">{{ $row->total_personal }}</strong></td>
                    <td><span class="text-danger font-weight-bold">{{ $row->percentage }}%</span></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No excessive absences found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Your Full Custom Pagination + Per-page (exactly your original) --}}
<div class="tablepagination" style="margin-top: 20px;">
    @include('backend.partials.pagination', [
        'paginator'  => $summary,
        'routeName'  => 'excessive.student.search'
    ])
</div>