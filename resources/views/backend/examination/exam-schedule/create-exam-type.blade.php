@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection



@section('content')
        <!-- Dashboard Body Begin -->
        <div class="dashboard-body dspr-body-outer">
            
            <div class="ds-breadcrumb">
                <h1>Create Exam Types</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="dashboard.html">Exam Schedule</a> /</li>
                    <li>Exam Types</li>
                    
                </ul>
            </div>
            <div class="ds-pr-body">

                <div class="ds-cmn-table-wrp tab-wrapper">
                    <div class="ds-content-head">
                        <div class="sec-head">
                            <h2>Existing Exam Types</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0">
                                <div class="dropdown-year" data-selected="Select Teacher">
                                  <button type="button" class="cmn-btn btn-sm"  data-bs-target="#createNewExamTypeModal" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> Create New Type</button>
                            </div>
                        </div>

                       

                    </div>

                    {{-- <div class="ds-cmn-tble" >
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Exam Name</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Lorem</td>
                                        <td>Lorem</td>
                                        <td>05/02/2025</td>
                                    <td>
                                        <button class="upcoming cmn-tbl-btn green-bg ">Active</button>
                                    </td>
                                
                                    <td>
                                        <div class="actions-wrp">
                                            <button type="button" data-bs-target="#EditNewExamTypeModal" data-bs-toggle="modal" >
                                                <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Icon">
                                            </button>

                                            <button type="button"  data-bs-target="#deleteNewExamTypeModal" data-bs-toggle="modal">
                                                <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Icon">
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lorem</td>
                                        <td>Lorem</td>
                                        <td>05/02/2025</td>
                                    <td>
                                        <button class="upcoming cmn-tbl-btn dim-gray-bg">Inactive</button>
                                    </td>
                                
                                    <td>
                                        <div class="actions-wrp">
                                            <button type="button" >
                                                <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Icon">
                                            </button>

                                            <button type="button">
                                                <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Icon">
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}

                    <div class="ds-cmn-tble">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Exam Name</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data['exam_types'] as $index => $exam)
                                    <tr>
                                        <td>{{ $data['exam_types']->firstItem() + $index }}</td>
                                        <td>{{ $exam->name }}</td>
                                        <td>{{ $exam->description ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($exam->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($exam->status == 1)
                                                <button class="upcoming cmn-tbl-btn green-bg">Active</button>
                                            @else
                                                <button class="upcoming cmn-tbl-btn dim-gray-bg">Inactive</button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions-wrp">
                                                <button type="button"
                                                    data-bs-target="#EditNewExamTypeModal"
                                                    data-bs-toggle="modal"
                                                    class="edit-exam-btn editExamTypeBtn"
                                                    data-id="{{ $exam->id }}">
                                                    <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Icon">
                                                </button>

                                                <button type="button" data-bs-target="#deleteNewExamTypeModal" data-bs-toggle="modal" class="delete-exam-btn deleteExamTypeBtn" data-id="{{ $exam->id }}">
                                                    <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Icon">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No exam types found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                  

                    {{-- <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                            <ul>
                                <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-left.svg" alt="Icon"></a></li>
                                <li class="active"><a href="#url">1</a></li>
                                <li><a href="#url">2</a></li>
                                <li><a href="#url">3</a></li>
                                <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-right.svg" alt="Icon"></a></li>
                            </ul>
                        </div>

                        <div class="pages-select">
                            <form>
                                <div class="formfield">
                                    <label>Per page</label>
                                    <select>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </form>
                            <p>of 2 results</p>
                        </div>
                    </div> --}}

                    <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                            <ul>
                                {{-- Previous Page Link --}}
                                @if ($data['exam_types']->onFirstPage())
                                    <li class="disabled">
                                        <a><img src="{{ asset('backend/assets/images/new_images/arrow-left.svg') }}" alt="Icon"></a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $data['exam_types']->previousPageUrl() }}">
                                            <img src="{{ asset('backend/assets/images/new_images/arrow-left.svg') }}" alt="Icon">
                                        </a>
                                    </li>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($data['exam_types']->getUrlRange(1, $data['exam_types']->lastPage()) as $page => $url)
                                    <li class="{{ $page == $data['exam_types']->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($data['exam_types']->hasMorePages())
                                    <li>
                                        <a href="{{ $data['exam_types']->nextPageUrl() }}">
                                            <img src="{{ asset('backend/assets/images/new_images/arrow-right.svg') }}" alt="Icon">
                                        </a>
                                    </li>
                                @else
                                    <li class="disabled">
                                        <a><img src="{{ asset('backend/assets/images/new_images/arrow-right.svg') }}" alt="Icon"></a>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="pages-select">
                            <form>
                                <div class="formfield">
                                    <label>Per page</label>
                                    <select onchange="window.location.href='?page=1&per_page='+this.value">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </div>
                            </form>
                            <p>
                                Showing {{ $data['exam_types']->firstItem() }} to {{ $data['exam_types']->lastItem() }}
                                of {{ $data['exam_types']->total() }} results
                            </p>
                        </div>
                    </div>


                  


                </div>

            </div>
        </div>
    <!-- End Of Dashboard Body -->

    
    <!-- Add Room Modal Begin -->
            <div class="modal fade cmn-popwrp pop800" id="createNewExamTypeModal"  tabindex="-1" role="dialog" aria-labelledby="createNewExamTypeModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                            </span>
                        </button>

                        <div class="modal-body">
                            <div class="cmn-pop-inr-content-wrp">
                                <h2>Create New Exam Type</h2>
                                <div class="request-leave-form-wrp">

                                    <form action="{{ route('exam-type.storeExamType') }}" method="post">
                                        @csrf
                                        <div class="request-leave-form">

                                            <div class="multi-input-grp">
                                                <div class="input-grp">
                                                    <label for="room_name">Exam Name</label>
                                                    <input type="text" id="exam_name" name="exam_name" placeholder="Exam Name">
                                                </div>

                                            </div>
                                            <div  class="multi-input-grp">   
                                                <div class="input-grp">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>

                                            <div class="multi-input-grp">
                                               
                                                <div class="input-grp">
                                                        <label for="status">Status</label>
                                                        <input type="checkbox" name="status" id="status" value="1" checked>  
                                                </div>
                                            </div>
                                        

                                            <button type="submit" class="btn-sm">Create Exam Type</button>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
    <!-- End Of Add Room Modal -->


            <!-- Edit Room Modal Begin -->
            <div class="modal fade cmn-popwrp pop800" id="EditNewExamTypeModal" tabindex="-1" role="dialog" aria-labelledby="EditNewExamTypeModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                            </span>
                        </button>

                         <div class="modal-body">
                            <div class="cmn-pop-inr-content-wrp">
                                <h2>Edit New Exam Type</h2>
                                <div class="request-leave-form-wrp">

                                    <form method="post" id="editExamTypeForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="request-leave-form">

                                            <div class="multi-input-grp">
                                                <div class="input-grp">
                                                    <label for="exam_name">Exam Name</label>
                                                    <input type="text" id="exam_names" name="exam_name" >
                                                </div>

                                            </div>
                                            <div  class="multi-input-grp">   
                                                <div class="input-grp">
                                                    <label for="capacity">Description</label>
                                                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>

                                             <div  class="multi-input-grp">   
                                                <div class="input-grp">
                                                    <label for="capacity">Status</label>
                                                    <input type="checkbox" name="status" id="status" value="1" checked>  
                                                 
                                                </div>
                                            </div>

                                            <input type="submit" value="Update Exam Type" class="btn-sm">

                                        </div>
                                    </form>

                                </div>
                            </div>
                         </div>
                        
                    </div>
                </div>
            </div>
            <!-- End Of Edit Room Modal -->


            <!-- Delete Room Modal Begin -->
            <div class="modal fade cmn-popwrp popwrp w400" id="deleteNewExamTypeModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewExamTypeModal" aria-hidden="true">
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
                                    <p>Are you sure you want to delete exam type?</p>
                                    <form method="post" id="deleteExamTypeForm">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-wrp">
                                            <button type="submit" class="cmn-btn">Delete</button>
                                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- End Of Delete Room Modal -->
@endsection

@push('script')
 <script>
$(document).ready(function () {
    $('.editExamTypeBtn').on('click', function () {
        let id = $(this).data('id');

        let url = "{{ route('exam-type.editExamType', ':id') }}";
        url = url.replace(':id', id);
        console.log('url', url);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                console.log('data in edit',response);
                if (response.status) {
                    console.log(response.data);
                    $('#exam_names').val(response.data.name);
                    $('textarea[name="description"]').val(response.data.description);
                    $('#status').prop('checked', response.data.status == 1);

                    let updateUrl = "{{ route('exam-type.updateExamType', ':id') }}";
                    updateUrl = updateUrl.replace(':id', id);
                    $('#editExamTypeForm').attr('action', updateUrl);
                } else {
                    alert('Exam type not found');
                }
            },
            error: function () {
                alert('Something went wrong while fetching data.');
            }
        });
    });
});
</script>

<script>
     $(document).ready(function(){
        $('.deleteExamTypeBtn').on('click', function () {
            let examTypeId = $(this).data('id');
            let url = "{{ route('exam-schedule.deleteExamType', ':id') }}";
            url = url.replace(':id', examTypeId);
            $('#deleteExamTypeForm').attr('action', url);
        });
    });
</script>


@endpush
