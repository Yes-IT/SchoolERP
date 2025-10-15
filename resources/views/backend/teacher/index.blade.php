@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

 <div class="ds-breadcrumb">
                <h1>Teachers</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="./dashboard.html">Teachers</a> /</li>
                    <li>Teachers List</li>
                </ul>
            </div>
            <div class="ds-pr-body">

                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Teachers List</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0">
                                <div class="dropdown-year" data-selected="Select Teacher">
                                    <div class="dropdown-trigger">
                                      <span class="dropdown-label">Select Teacher</span>
                                      <i class="dropdown-arrow"></i>
                                    </div>
                                    <div class="dropdown-options">
                                      {{-- <div class="dropdown-option">Teacher 1</div>
                                      <div class="dropdown-option">Teacher 2</div>
                                      <div class="dropdown-option">Teacher 3</div> --}}

                                      <div class="dropdown-option" data-id="all">All</div>
                                            @foreach($data['teachers'] as $teacher)
                                                <div class="dropdown-option" data-id="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</div>
                                            @endforeach
                                       </div>
                                  </div>
                                
                                  <a href="{{route('teacher.create')}}" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add Teacher</a>
                                  <a href="#" class="cmn-btn btn-sm">Generate Report</a>
                            </div>
                        </div>
                    </div>

                    <div class="ds-cmn-tble count-row tbl-5_4k">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>View Details</th>
                                    <th>Title</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Neighborhood</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Zip Code</th>
                                    <th>Home Phone</th>
                                    <th>Email ID</th>
                                    <th>Cell Phone</th>
                                    <th>SSN</th>
                                    <th>Position</th>
                                    <th>Inactive</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                
                                 @forelse($data['teachers'] as $index => $teacher)
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
                                            <input type="checkbox" 
                                                {{ $teacher->inactive ? 'checked' : '' }} disabled>
                                        </td>
                                        <td>
                                           
                                            <div class="actions-wrp">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editLeaveRequest">
                                                    <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Icon">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="17" class="text-center">No teacher records found</td>
                                    </tr>
                                @endforelse
                               
                            </tbody> --}}

                            <tbody id="teacher-table-body">
                                @include('backend.teacher.partials.teacher-rows', ['teachers' => $data['teachers']])
                            </tbody>

                        </table>
                    </div>

                    {{-- <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                        
                            <ul>
                             
                                @if ($data['teachers']->onFirstPage())
                                    <li class="disabled"><span><img src="{{ global_asset('backend/assets/images/arrow-left.svg') }}" alt="Icon"></span></li>
                                @else
                                    <li>
                                        <a href="{{ $data['teachers']->previousPageUrl() }}">
                                            <img src="{{ global_asset('backend/assets/images/arrow-left.svg') }}" alt="Icon">
                                        </a>
                                    </li>
                                @endif

                                
                                @foreach ($data['teachers']->getUrlRange(1, $data['teachers']->lastPage()) as $page => $url)
                                    <li class="{{ $page == $data['teachers']->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                
                                @if ($data['teachers']->hasMorePages())
                                    <li>
                                        <a href="{{ $data['teachers']->nextPageUrl() }}">
                                            <img src="{{ global_asset('backend/assets/images/arrow-right.svg') }}" alt="Icon">
                                        </a>
                                    </li>
                                @else
                                    <li class="disabled"><span><img src="{{ global_asset('backend/assets/images/arrow-right.svg') }}" alt="Icon"></span></li>
                                @endif
                            </ul>

                        </div>

                        <div class="pages-select">
                            
                             <form method="GET">
                                    <div class="formfield">
                                        <label>Per page</label>
                                        <select name="per_page" onchange="this.form.submit()">
                                            @foreach([5,10,15,20] as $size)
                                               <option value="{{ $size }}" {{ request('per_page', \App\Enums\Settings::PAGINATE) == $size ? 'selected' : '' }}>
                                                    {{ $size }}
                                                </option>

                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                                <p>of {{ $data['teachers']->total() }} results</p>
                        </div>
                    </div> --}}

                    <div id="teacher-pagination">
                        @include('backend.teacher.partials.teacher-pagination', ['teachers' => $data['teachers']])
                    </div>

                </div>
                  
            </div>


@endsection

@push('script')

<script>
// $(document).ready(function () {
//     $(".dropdown-option").on("click", function () {
//         let teacherId = $(this).data("id");
//         $(".dropdown-label").text($(this).text());

//         $.ajax({
//             url: "{{ route('teachers.filter') }}",
//             type: "GET",
//             data: { id: teacherId },
//             success: function (response) {
//                 $("#teacher-table-body").html(response.html);
//             },
//             error: function (xhr) {
//                 console.error("Error fetching teacher data", xhr);
//             }
//         });
//     });
// });

$(document).ready(function () {
   
    $(".dropdown-option").on("click", function () {
        let teacherId = $(this).data("id");
        $(".dropdown-label").text($(this).text());
        
        let perPage = $('select[name="per_page"]').val() || 10;
        
        filterTeachers(teacherId, perPage, 1);
    });
    
    $('select[name="per_page"]').on('change', function() {
        let perPage = $(this).val();
        let teacherId = $('.dropdown-option.selected')?.data('id') || 'all';
        
        filterTeachers(teacherId, perPage, 1);
    });

    $(document).on('click', '#teacher-pagination a', function(e) {
        e.preventDefault();
        
        let url = $(this).attr('href');
        let teacherId = $('.dropdown-option.selected')?.data('id') || 'all';
        let perPage = $('select[name="per_page"]').val() || 10;
        
        let page = new URL(url).searchParams.get('page') || 1;
        
        filterTeachers(teacherId, perPage, page);
    });
    
    function filterTeachers(teacherId, perPage, page) {
        $.ajax({
            url: "{{ route('teachers.filter') }}",
            type: "GET",
            data: { 
                id: teacherId,
                per_page: perPage,
                page: page
            },
            beforeSend: function() {
                
                $('#teacher-table-body').html('<tr><td colspan="17" class="text-center">Loading...</td></tr>');
            },
            success: function (response) {
                $("#teacher-table-body").html(response.html);
                $("#teacher-pagination").html(response.pagination);
        
                $('.dropdown-option').removeClass('selected');
                $(`.dropdown-option[data-id="${teacherId}"]`).addClass('selected');
            },
            error: function (xhr) {
                console.error("Error fetching teacher data", xhr);
                $('#teacher-table-body').html('<tr><td colspan="17" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }
});
</script>



@endpush


