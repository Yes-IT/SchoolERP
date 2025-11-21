@extends('backend.master')
@section('title')
{{ ___('common.School Management System | Teacher') }}
@endsection

@section('content')
                   <div class="ds-breadcrumb">
                        <h1>Teachers</h1>
                        <ul>
                            <li><a href="../dashboard.html">Dashboard</a> /</li>
                            <li><a href="{{route('teacher.index')}}">Teachers</a> /</li>
                            <li>Teachers Info</li>
                        </ul>

                        <button  class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>

                    <div class="ds-pr-body">
                         
                        <div class="ds-pr-profile-card">
                            <div class="dspr-profile-cd-upr">
                                <div class="dspr-profile-cd-img">
                                   
                                      <img src="{{ global_asset(optional($teacher->upload)->path ?? 'backend/assets/images/default-user.png') }}"
                                          alt="{{ $teacher->first_name }}">

                                </div>
                                <div class="dspr-profile-cd-info">
                                    <h2>{{ $teacher->first_name }} {{ $teacher->last_name }}</h2>
                                    <p>{{ $teacher->hebrew_first_name }} {{ $teacher->hebrew_last_name }}</p>
                                   
                                </div>
                            </div>
                            

                             <div class="dspr-profile-cd-btm">
                                <div class="img-link">
                                    <h3>Image Link</h3>
                                    <a href="{{ global_asset($teacher->upload->path ?? 'backend/assets/images/default-user.png') }}">
                                        {{ $teacher->upload->path ?? 'No image available' }}
                                    </a>
                                </div>
                                <div class="dsprprofile-course-info">
                                    <table>
                                        <tr>
                                            <td>ID</td>
                                            <td>{{ $teacher->identification_number ?? '-' }}</td>

                                        </tr>
                                         <tr>
                                            <td>Position</td>
                                            <td>{{ $teacher->position ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Year</td>
                                            <td>2025-26</td>
                                        </tr>
                                        <tr>
                                            <td>Inactive</td>
                                           
                                             <td>
                                                <input 
                                                    type="checkbox" 
                                                    id="inactiveCheckbox" 
                                                    {{ $teacher->inactive ? 'checked' : '' }}
                                                >
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="btn-wrp small-btn">
                                   
                                    <a href="{{ route('teacher.edit', $teacher->id) }}" class="cmn-btn">
                                        <img src="{{ global_asset('backend/assets/images/edit-icon.svg') }}" alt="Icon"> Edit Teacher
                                    </a>

                                    <button type="button" class="cmn-btn img-white deleteTeacherBtn" 
                                        data-id="{{ $teacher->id }}"
                                        data-route="{{ route('teacher.delete', $teacher->id) }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteStudent"><img src="{{global_asset('backend/assets/images/bin-icon.svg')}}" alt="Icon"> Delete Teacher</button>
                                </div>
                            </div>
                        </div>

                        <div class="dspr-bdy-content">
                            <div class="dspr-bdy-content-sec border-remover">
                                
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Title</td>
                                            <td class="td-lineremover" >{{ $teacher->title ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >First Name</td>
                                            <td class="td-lineremover" >{{ $teacher->first_name ?? '-' }}</td>
                                          </tr>
                                         <tr class="table-tr">
                                            <td class="td-lineremover" >Last Name</td>
                                            <td class="td-lineremover" >{{ $teacher->last_name ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Hebrew Title</td>
                                            <td class="td-lineremover" >{{ $teacher->hebrew_title ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Hebrew First Name</td>
                                            <td class="td-lineremover" >{{ $teacher->hebrew_first_name ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Date of Birth</td>
                                            <td class="td-lineremover" >{{ $teacher->dob ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Hebrew Birthdate</td>
                                            <td class="td-lineremover" >{{ $teacher->hebrew_dob ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Neighborhood</td>
                                            <td class="td-lineremover" >{{ $teacher->neighborhood ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Home Phone</td>
                                            <td class="td-lineremover" >{{ $teacher->phone ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Email</td>
                                            <td class="td-lineremover" >{{ $teacher->email ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Cell Phone</td>
                                            <td class="td-lineremover" >{{ $teacher->cell_phone ?? '-' }}</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >SSN</td>
                                            <td class="td-lineremover" >{{ $teacher->ssn ?? '-' }} </td>
                                          </tr>
                                         
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                           

                            <div class="dspr-bdy-content-sec">
                                <h2>Address</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td class="td-lineremover" >Address</td>
                                            <td class="td-lineremover" >{{ $teacher->current_address ?? '-' }}</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >City</td>
                                            <td class="td-lineremover" >{{ $cityName ?? '-' }}</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Zip Code</td>
                                            <td class="td-lineremover" >{{ $teacher->zip_code ?? '-' }}</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Country</td>
                                            <td class="td-lineremover" >{{ $countryName ?? '-' }} </td>
                                          </tr>
                                         
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                          
                              <div class="dspr-bdy-content-sec">
                                <h2>Classes Detail</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                       <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>School Year</th>
                                            <th>Year Status</th>
                                            <th>Semester</th>
                                        </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($classes as $classe)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $classe->name }}</td>
                                                <td>{{ $classe->subject->name }}</td>
                                                <td>{{ $classe->session->name }}</td>
                                                <td>{{ $classe->yearStatus->name }}</td>
                                                <td>{{ $classe->semester->name }}</td>
                                                
                                            </tr>
                                        @endforeach
                                       </tbody>

                                      </table>
                                </div>
                            </div>

                        </div>

                        
                    </div>


  <!-- Delete Room Modal Begin -->
    <div class="modal fade cmn-popwrp popwrp w400" id="deleteStudent" tabindex="-1" role="dialog" aria-labelledby="deleteStudent" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                    </span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <div class="modal-icon">
                            <img src="{{ global_asset('backend/assets/images/bin-primary.svg') }}" alt="Bin Icon">
                        </div>
                        <div class="sec-head head-center">
                            <h2>Delete!</h2>
                            <p>Are you sure you want to delete this Teacher?</p>
                            <form id="deleteTeacherForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="btn-wrp">
                                    <button type="submit" class="cmn-btn">Delete</button>
                                    <button type="button" class="cmn-btn" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
  <!-- End Of Delete Room Modal -->      
  
  
  <!-- Inactive/Active Status Modal Begin -->
  <div class="modal fade cmn-popwrp popwrp w400" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img id="modalIcon" src="{{ global_asset('backend/assets/images/Vector.svg') }}" alt="Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2 id="modalTitle">Change Status</h2>
                        <p id="modalMessage">Are you sure?</p>
                        <div class="btn-wrp">
                            <button type="button" id="confirmStatus" class="cmn-btn">Save</button>
                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
  </div>
  <!-- End Of Inactive/Active  Status Modal -->


@endsection

@push('script')
 <script>
  $(document).ready(function () {
    let $checkbox = $('#inactiveCheckbox');
    let intendedStatus = null; 
    let originalStatus =  $checkbox.is(':checked');

    let $modal = $('#statusModal');
    let $modalTitle = $('#modalTitle');
    let $modalMessage = $('#modalMessage');
    let $confirmBtn = $('#confirmStatus');
    let $modalIcon = $('#modalIcon');

    // When checkbox is toggled
    $checkbox.on('change', function () {
        originalStatus = !$(this).is(':checked'); 

        if ($checkbox.is(':checked')) {
            intendedStatus = true;
            $modalTitle.text("Inactive");
            $modalMessage.text("Are you sure you want to inactive this teacher?");
            $confirmBtn.text("Save");
            $modalIcon.attr('src', "{{ global_asset('backend/assets/images/Vector.svg') }}");

        } else {
            intendedStatus = false;
            $modalTitle.text("Active");
            $modalMessage.text("Are you sure you want to active this teacher permanently?");
            $confirmBtn.text("Save");
            $modalIcon.attr('src', "{{ global_asset('backend/assets/images/Group.svg') }}");

        }

        $modal.modal('show');
    });

    // When "Save" button is clicked
    $confirmBtn.on('click', function () {
      $.ajax({
          url: "{{ route('teachers.toggleInactive', $teacher->id) }}",
          type: "POST",
          data: {
              _token: "{{ csrf_token() }}",
              inactive: intendedStatus ? 1 : 0
          },
          beforeSend: function () {
                $confirmBtn.prop('disabled', true).text("Saving...");
          },
          success: function (response) {
             $modal.modal('hide');
                $confirmBtn.prop('disabled', false).text("Save");

                //  Update checkbox based on DB response
                $checkbox.prop('checked', response.inactive == 1);
                originalStatus = response.inactive == 1;

          },
          error: function () {
                $checkbox.prop('checked', originalStatus); 
                $modal.modal('hide');
                $confirmBtn.prop('disabled', false).text("Save");
          }
      });
    });

    // If modal is closed without confirmation -> revert checkbox
    $modal.on('hidden.bs.modal', function () {
        if (intendedStatus !== null) {
            $checkbox.prop('checked', originalStatus);
        }
    });
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteTeacherBtn');
    const deleteForm = document.getElementById('deleteTeacherForm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const route = this.getAttribute('data-route');
            deleteForm.setAttribute('action', route);
        });
    });
});
</script>






@endpush
