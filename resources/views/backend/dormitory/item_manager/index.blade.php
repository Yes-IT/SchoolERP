@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .input-grp select {
        width: 150px;
        height: 44px;
        position: relative;
        left: 159px;
        border-radius: 2px;
        background: var(--primary-clr);
        color: white;
    }

    .available-btn {
        background-color: green;
        color: white;
        font-size: 14px;
    }

    .assigned-btn {
        background-color: yellowgreen;
        color: white;
        font-size: 14px;
    }

    .pending-btn {
        background-color: red;
        color: white;
        font-size: 14px;

    }

    .content {
        text-align: center;
        padding: 2px;

    }

    .download-icon i {
        font-size: 28px;
        color: var(--primary-clr);
    }

    .cmn-crd-content p {
        color: grey;
        margin-top: 22px;
        font-weight: 400;
    }

    .choosefile-btn button {
        margin-top: 34px;
        border: 1px solid var(--primary-clr);
        padding: 9px;
        border-radius: 5px;
        width: 100px;
        color: var(--primary-clr);
    }

    .dsbdy-cmn-card {
        border: 1px dotted grey;
    }

    .group-modal {
        display: flex;
        flex-direction: column;
        position: relative;
        left: 15px;
    }

    .modal-body {
        width: 615px;
    }

    .input-grp input {
        height: 37px;
    }

    .input-grp label {
        color: var(--primary-clr);
        font-size: 15px;
    }

    .cmn-btn {
        position: relative;
        left: 31px;
    }

    .cross-icon {
        position: relative;
        left: -161px;
        top: 11px;
    }

    .ds-cmn-info-cards-v2 .col-lg-4:nth-child(n+4) {
        margin-top: 20px;
        /* adjust as per design */
    }

    .multi-input {
        display: flex;
        flex-direction: row;
        margin-top: 27px;
        margin-left: 16px;
        gap: 50px;
    }

    .multi-input input {
        width: 50px;
    }
</style>



@section('content')
    <div class="ds-breadcrumb">
        <h1>Item Manager</h1>
        <ul>
            <li><a href="./dashboard.html">Dashboard</a> /</li>
            <li><a href="./additional-fees.html">Pantry</a> /</li>
            <li>Item Manager</li>
        </ul>
    </div>

    <div class="ds-pr-body">

        <div class="ds-bdy-content w-100 align-items-start">



            <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                <div class="ds-content-head">
                    <div class="sec-head">
                        <h3 class="h2-title">Items</h3>
                    </div>
                    <div class="btn-wrp align-items-start">
                        <div class="dsbdy-filter-wrp p-0 align-items-start">


                            <a href="javascript:void(0);" class="cmn-btn btn-sm flex-shrink-0" id="exportBtn"
                                style="position: relative; left: -12px; height: 41px;" data-bs-toggle="modal"
                                data-bs-target="#addcategory">
                                Add New Item
                            </a>

                        </div>
                    </div>
                </div>

                <div class="ds-cmn-tble count-row">
                    <table id="pending-request">
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Thresold Value</th>
                                <th>Created </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="assetsBody">
                        
                            @forelse ($inventories as $index => $item)
                                
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_name ?? 'N/A' }}</td>
                                    <td>{{ $item->category_name ?? 'N/A' }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <a href="javascript:void(0);" title="Edit" class="edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editcategory"
                                                onclick="showitemdata('{{ $item->id }}','{{ $item->category_id }}','{{ $item->product_name }}','{{ $item->qty }}','{{ $item->unit }}','{{ $item->reason }}')">
                                                <i class="fas fa-edit"
                                                    style="color: var(--primary-clr); font-size: 15px;"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <a href="javascript:void(0);" title="Delete" class="delete-btn"
                                                onclick="itemDelete({{ $item->id }})">
                                                <i class="fas fa-trash" style="color: #dc3545; font-size: 15px;"></i>
                                            </a>

                                            <!-- Hidden Delete Form -->
                                            <form id="deleteForm" action="{{ route('dormitory.itemManager.delete') }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="id" id="delete_id">
                                            </form>


                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center;">No inventory items found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>



                </div>

                <div class="tablepagination">
                    <div class="tbl-pagination-inr">
                      <ul>
                                    <li><a href="#url"><img src="{{ asset('images/parent/arrow-left.svg') }}"></a></li>
                                    <li class="active"><a href="#url">1</a></li>
                                    <li><a href="#url">2</a></li>
                                    <li><a href="#url">3</a></li>
                                    <li><a href="#url"><img src="{{ asset('images/parent/arrow-right.svg') }}"></a></li>
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
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </form>
                        <p>of 2 results</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade cmn-popwrp pop800" id="addcategory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <img src="{{ asset('images/parent/cross-icon.svg') }}" alt="Close"
                            style="position:relative; left:-150px; top:13px;">
                    </span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Add New Item </h2>
                        </div>


                        <form action="{{ route('dormitory.itemManager.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                            @csrf





                            <div class="multi-input-grp grp-2 mt-3 group-modal">
                                <div class="group-modal">
                                    <div class="input-grp">
                                        <label for="edit_name">Category Name</label>
                                        <select name="category_id"  
                                            style="    height: 45px;
        width: 100%;
        background: white;
        color: var(--primary-clr);
        border-radius: 6px;
        position: relative;
        left: 2px;">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="input-grp" style="margin-top: 10px;">
                                        <label for="edit_description">Item Name</label>
                                        <input name="name" type="text" placeholder="Desription"
                                            style="height:50px; width: 500px;" />
                                    </div>
                                    <div class="input-grp" style="margin-top: 10px;">
                                        <label for="edit_description">Quantity</label>
                                        <input name="qty" type="text" placeholder="Desription"
                                            style="height:57px; width: 500px;" />
                                    </div>
                                    <div class="input-grp" style="margin-top: 10px;">
                                        <label for="edit_description">Reason</label>
                                        <input name="reason" type="text" placeholder="Desription"
                                            style="height:57px; width: 500px;" />
                                    </div>

                                    <div class="multi-input">
                                        <div class="input-grp">
                                            <label for="select_room">Unit</label>
                                            <input name="unit" type="text" placeholder="Unit"
                                                style="height:50px; width: 233px;" />
                                        </div>

                                       

                                    </div>

                                </div>
                            </div>

                            <button type="submit" class="btn-sm cmn-btn mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade cmn-popwrp pop800" id="editcategory" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <img src="{{ asset('images/parent/cross-icon.svg') }}" alt="Close"
                            style="position:relative; left:-150px; top:13px;">
                    </span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Edit Item </h2>
                        </div>


                        <form action="{{ route('dormitory.itemManager.update') }}" enctype="multipart/form-data" method="post" id="visitForm">
                            @csrf

                            <input type="hidden" id="edit_id" name="id">





                            <div class="multi-input-grp grp-2 mt-3 group-modal">
                                <div class="group-modal">
                                    <div class="input-grp">
                                        <label for="edit_name">Category Name</label>
                                        <select name="category_id" id="edit_category_id" 
                                            style="    height: 45px;
        width: 100%;
        background: white;
        color: var(--primary-clr);
        border-radius: 6px;
        position: relative;
        left: 2px;">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="input-grp" style="margin-top: 10px;">
                                        <label for="edit_description">Item Name</label>
                                        <input name="name" type="text" placeholder="Desription" id="edit_item_name"
                                            style="height:50px; width: 500px;" />
                                    </div>
                                    <div class="input-grp" style="margin-top: 10px;">
                                        <label for="edit_description">Quantity</label>
                                        <input name="qty" type="text" placeholder="Desription" id="edit_item_quantity"
                                            style="height:57px; width: 500px;" />
                                    </div>
                                    <div class="input-grp" style="margin-top: 10px;">
                                        <label for="edit_description">Reason</label>
                                        <input name="reason" type="text" placeholder="Desription" id="edit_item_reason"
                                            style="height:57px; width: 500px;" />
                                    </div>

                                    <div class="multi-input">
                                        <div class="input-grp">
                                            <label for="select_room">Unit</label>
                                            <input name="unit" type="text" placeholder="Unit" id="edit_item_unit"
                                                style="height:50px; width: 233px;" />
                                        </div>

                                       

                                    </div>

                                </div>
                            </div>

                            <button type="submit" class="btn-sm cmn-btn mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
