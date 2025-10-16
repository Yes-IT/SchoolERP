@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb d-flex justify-content-between">
          <div>
            <h1>Compose New Message</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="./dashboard.html">Notice Board</a> /</li>
                <li>Compose New Message</li>
            </ul>
          </div>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <div class="ds-content-head has-drpdn">
                    <div class="sec-head">
                        <h2>New Message</h2>
                    </div>
                </div>
                <div class="request-leave-form">
                    <form action="{{ route('notice-board.store') }}" enctype="multipart/form-data" method="post" id="marksheet">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-9">
                                <div class="new-request-form">
                                    <div class="multi-input-grp">
                                        <div class="input-grp w-100">
                                            <label for="exampleDataList" class="form-label ">{{ ___('common.title') }} <span
                                                    class="fillable">*</span> </label>
                                            <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                                value="{{ old('title') }}" list="datalistOptions" id="exampleDataList"
                                                placeholder="{{ ___('account.Notice Title') }}">
                                            @error('title')
                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="multi-input-grp grp-2">
                                        <div class="input-grp">
                                            <label for="exampleDataList" class="form-label ">{{ ___('common.publish_date') }} <span
                                                    class="fillable">*</span></label>
                                            <input class="form-control ot-input @error('publish_date') is-invalid @enderror"
                                                name="publish_date" type="datetime-local" list="datalistOptions"
                                                id="exampleDataList" type="text" placeholder="{{ ___('common.publish_date') }}"
                                                value="{{ old('publish_date') }}">
                                            @error('publish_date')
                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="input-grp h48">
                                            <label>{{ ___('common.attachment') }} <span class="fillable"></span></label>
                                            <div class="floating-input-btn input-grp w-100 p-0">
                                              <div class="has-submit">
                                                <label class="file-label">
                                                    <span class="file-text">No file chosen</span>
                                                    <input type="file" class="form-control" accept="image/*" name="attachment" id="fileUpload">
                                                </label>
                                                <input type="button" id="uploadBtn" value="Upload" style="width: 10%; height: 40px; " class="btn-upload">
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-5 classDiv d-none">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.Class') }} <span
                                                class="fillable"></span></label>
                                        <select id="getSections"
                                            class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                            name="class">
                                            <option value="">{{ ___('student_info.select_class') }} </option>

                                            @foreach ($data['classes'] as $item)
                                                <option
                                                    {{ old('class', @$data['student']->session_class_student->class->id) == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('class')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-5 sectionDiv d-none">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.Section') }} </label>
                                        <select
                                            class="sections section nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                            name="section">
                                            <option value="">{{ ___('student_info.select_section') }} </option>
                                            <option value="all_section">{{ ___('student_info.All Sections') }}</option>

                                        </select>
                                        @error('section')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-5 studentDiv d-none">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.Student') }} <span
                                                class="fillable"></span></label>
                                        <select
                                            class="students nice-select niceSelect bordered_style wide @error('student') is-invalid @enderror"
                                            name="student">
                                            <option value="">{{ ___('student_info.select_student') }}</option>

                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="summernote" class="form-label ">{{ ___('account.description') }} <span
                                                class="fillable">*</span></label>
                                        <textarea class="form-control ot-textarea @error('description') is-invalid @enderror" name="description"
                                            list="datalistOptions" id="summernote" placeholder="{{ ___('account.enter_description') }}">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-24">
                                        <div class="btn-sm p-0">
                                          <input type="submit" value="Send">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div>
                                    <div class="w-100">
                                        <label for="exampleDataList" class="form-label" style="color:var(--primary-clr);">Message To</label>
                                        <div class="input-check-radio visbleSection @error('sections') is-invalid @enderror">
                                            @foreach ($data['roles'] as $item)
                                                <div>
                                                    <input type="checkbox" class="form-check-input visible-to-checkbox" name="visible_to[]" value="{{ $item->id }}" id="flexCheckDefault-{{ $item->id }}" />
                                                    <label class="form-check-label" for="flexCheckDefault-{{ $item->id }}">{{ $item->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </form>
                </div>              
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Listen for changes on checkboxes with the class `.visible-to-checkbox`
            $('.visible-to-checkbox').on('change', function() {
                // Get all selected checkbox values
                let selectedValues = $('.visible-to-checkbox:checked')
                    .map(function() {
                        return $(this).val(); // Extract the value
                    })
                    .get(); // Convert to an array

                // Check if `6` or `7` exists in the selected values
                // if (selectedValues.includes('6') || selectedValues.includes('7')) {
                //     console.log('Values contain 6 or 7.');
                //     $('.classDiv, .sectionDiv, .studentDiv').removeClass('d-none');
                // } else {
                //     $('.classDiv, .sectionDiv, .studentDiv').addClass('d-none');
                // }
            });
        });
    </script>
@endpush
