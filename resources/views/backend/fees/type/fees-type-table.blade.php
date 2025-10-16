@forelse ($data['fees_types'] as $key => $row)
    <tr  class="fees-type-row" data-category="{{ $row->category ?? '' }}" id="row_{{ $row->id }}">
        <td>{{ ++$key }}</td>
        <td>{{ $row->name ?? '' }}</td>
        <td>{{ $row->category ?? '' }}</td>
        <td>{{ $row->type ?? '' }}</td>
        <td>
            <div class="dsbdy-filter-wrp p-0 align-items-start">
                <a href="#url" class="cmn-btn btn-sm flex-shrink-0"
                    style="width: 90px; height: 25px; font-size: 12px; padding: 2px;">
                    Recurring
                </a>
            </div>
        </td>
        <td>
            <div class="actions-wrp">
                @if($row->status == 1)
                    <span class="cmn-tbl-btn green-bg">Active</span>
                @else
                    <span class="cmn-tbl-btn red-bg">Inactive</span>
                @endif
            </div>
        </td>
        <td>
            <div class="btn-wrp">
               <button  type="button" 
                    class="edit-btn" 
                    data-id="{{ $row->id }}"
                    data-name="{{ $row->name }}"
                    data-category="{{ $row->category }}"
                    data-description="{{ $row->description }}"
                    data-status="{{ $row->status }}"
                    onclick="show_edit_modal('{{ $row->id }}','{{ $row->name }}','{{ $row->category }}','{{ $row->description }}')"
                    data-bs-toggle="modal" 
                    data-bs-target="#edittype">
                    <img src="{{ asset('images/fees/edit-icon-primary.svg') }}" alt="Icon">
                </button>

                <button type="button"  data-id="{{ $row->id }}"  onclick="deletetypegroup(this)"><img src="{{ asset('images/fees/bin-icon.svg') }}" alt="Icon"></button>
              
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No Fee Types Found</td>
    </tr>
@endforelse