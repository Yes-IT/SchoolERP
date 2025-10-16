@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Compose New Message</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="./dashboard.html">Notice Board</a> /</li>
                <li>Compose New Message</li>
            </ul>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <div class="ds-content-head has-drpdn">
                    <div class="sec-head">
                        <h2>Noticeboard</h2>
                    </div>
                    <div class="ds-cmn-filter-wrp">
                        <div class="dsbdy-filter-wrp p-0">
                            <a href="{{ route('notice-board.create') }}" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Post New Message</a>
                        </div>
                    </div>
                </div>

                <div class="table-content table-basic mt-20">
                    <div class="card">
                        <div class="card-body">
                            @forelse ($data['notice-boards'] ?? [] as $key => $row)
                                <div id="row_{{ $row->id }}" class="row">
                                    <div class="d-flex justify-content-between">
                                        <h6>{{ $row->title }} {{ $row->id }} ({{ date('d-m-Y', strtotime(@$row->date)) }})</h6>
                                        <div> 
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    @if (hasPermission('homework_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('notice-board.edit', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    {{-- @if (hasPermission('homework_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('notice-board.translate', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                        class="fa-solid fa-globe"></i></span>
                                                                {{ ___('common.translate') }}</a>
                                                        </li>
                                                    @endif --}}
                                                    @if (hasPermission('homework_delete'))
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                onclick="delete_row('communication/notice-board/delete', {{ $row->id }})">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
                                                                <span>{{ ___('common.delete') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <div class="d-flex justify-content-center"><img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100"></div>
                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                            <!--  pagination start -->
                            <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-between">
                                        {!! $data['notice-boards']->appends(\Request::capture()->except('page'))->links() !!}
                                    </ul>
                                </nav>
                            </div>
                            <!--  pagination end -->
                        </div>
                    </div>
                </div>
                <!--  table content end -->
            </div>
        </div>
    </div>
    <!-- Dashboard Body End -->
@endsection
@push('script')
    @include('backend.partials.delete-ajax')
@endpush