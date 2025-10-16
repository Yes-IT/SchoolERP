  @forelse ($data['fees_masters'] as $key => $row)
            <tr id="row_{{ $row->id }}">
                <td>{{ ++$key }}</td>
                <td>{{ $row->group->name ?? '-' }}</td>
                <td>{{ $row->type->name ?? '-' }}</td>
                <td>{{ $row->amount }}</td>
                <td>{{ $row->total_installment }}</td>
                  <td>
                        @if($row->status == 1)
                            <div class="upcoming cmn-tbl-btn green-bg">Active</div>
                        @else
                            <div class="upcoming cmn-tbl-btn red-bg">Inactive</div>
                        @endif
                </td>

                <td>
                    <div class="actions-wrp">
                        <button type="button" data-bs-toggle="modal"
                            data-bs-target="#editLeaveRequest">
                            <img src="{{ asset('images/fees/edit-icon-primary.svg') }}" alt="Edit">
                        </button>

                       <button type="button" data-id="{{ $row->id }}" onclick="deletemaster(this)">
                        <img src="{{ asset('images/fees/bin-icon.svg') }}" alt="Icon">
                     </button>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No records found</td>
            </tr>
        @endforelse