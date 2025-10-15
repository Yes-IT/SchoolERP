@forelse($teachers as $index => $teacher)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>
        <a href="{{ route('teacher.teacher_info', $teacher->id) }}" class="view-attachment-btn">
            <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
        </a>
    </td>
    <td>{{ $teacher->title ?? '-' }}</td>
    <td>{{ $teacher->first_name ?? '-' }}</td>
    <td>{{ $teacher->last_name ?? '-' }}</td>
    <td>{{ $teacher->neighborhood ?? '-' }}</td>
    <td>{{ $teacher->current_address ?? '-' }}</td>
    <td>{{ $teacher->city ?? '-' }}</td>
    <td>{{ $teacher->country ?? '-' }}</td>
    <td>{{ $teacher->zip_code ?? '-' }}</td>
    <td>{{ $teacher->phone ?? '-' }}</td>
    <td>{{ $teacher->email ?? '-' }}</td>
    <td>{{ $teacher->cell_phone ?? '-' }}</td>
    <td>{{ $teacher->ssn ?? '-' }}</td>
    <td>{{ $teacher->position ?? '-' }}</td>
    <td>
        <input type="checkbox" {{ $teacher->inactive ? 'checked' : '' }} disabled>
    </td>
    <td>
        <div class="actions-wrp">
            
             <a href="{{ route('teacher.edit', $teacher->id) }}"><img src="{{global_asset('backend/assets/images/edit-icon-primary.svg')}}" alt="Icon"></a>

        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="17" class="text-center">No teacher records found</td>
</tr>
@endforelse
