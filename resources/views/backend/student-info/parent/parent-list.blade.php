@forelse ($data['parents'] as $key => $row)
  <tr id="row_{{ $row->id }}">
    <td class="serial">{{ ++$key }}</td>
    <td class="serial"><a class="view-attachment-btn" href="{{ route('student.show',optional($row->children->first())->id) }}"><img src="{{ asset('images/parent/eye-white.svg') }}"   alt="Eye Icon"> </a></td>
    <td>{{ @$row->father_title }}</td>
    <td>{{ @$row->father_name }}</td>
    <td>{{ @$row->mother_title }}</td>
    <td>{{ @$row->mother_name }}</td>
    <td>{{ @$row->maiden_name }}</td>
    <td>{{ optional($row->children->first())->first_name }}</td>
    <td>{{ optional($row->children->first())->residance_address }}</td>
    <td>{{ optional($row->children->first())->city }}</td>
    <td>{{ optional($row->children->first())->state }}</td>
    <td>{{ optional($row->children->first())->zip_code }}</td>
    <td>{{ optional($row->children->first())->country }}</td>
    <td>{{ @$row->guardian_mobile }}</td>
    <td>{{ @$row->father_mobile }}</td>
    <td>{{ @$row->mother_mobile }}</td>
    <td>{{ @$row->father_email }}</td>
    <td>{{ @$row->mother_email }}</td>
    <td>{{ @$row->father_hebrew_name }}</td>
    <td>{{ @$row->mother_hebrew_name }}</td>
    <td>{{ @$row->father_dob }}</td>
    <td>{{ @$row->mother_dob }}</td>
    <td>{{ @$row->father_profession }}</td>
    <td>{{ @$row->mother_profession }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>{{ @$row->guardian_name }}</td>
    <td>{{ @$row->guardian_address }}</td>
    <td>{{ @$row->guardian_mobile }}</td>
    <td>
      <div class="actions-wrp">
        <a href="{{ route('parent.edit', optional($row->children->first())->id) }}">
          <img src="{{ asset('images/parent/edit-icon-primary.svg') }}" alt="Icon">
        </a>
      </div>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="100%" class="text-center gray-color">
        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
        <p class="mb-0 text-center text-secondary font-size-90">
            {{ ___('common.please_add_new_entity_regarding_this_table') }}</p>
    </td>
  </tr>
@endforelse