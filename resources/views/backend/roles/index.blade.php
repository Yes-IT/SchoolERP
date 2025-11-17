@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

    <div class="ds-breadcrumb">
        <h1>Assigned Roles</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li>Assigned Roles</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter student-filter">
                <form>
                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options grp-3 multi-input-grp">
                            <div class="input-grp">
                                <input type="text" placeholder="Search Users..." />
                            </div>
                            <div class="input-grp">
                                <select>
                                    <option value="select-year">Select Role</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                            <div class="input-grp">
                                <select>
                                    <option value="select-year">Select Module</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                            
                        </div>
                    
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div> 
        </div>

        <div class="ds-cmn-table-wrp">
            
            <div class="ds-content-head has-drpdn">
                <div class="sec-head">
                    <h2>View Assigned Roles</h2>
                </div>
                <div class="ds-cmn-filter-wrp">
                    <div class="dsbdy-filter-wrp p-0">
                        <button  data-bs-toggle="modal" data-bs-target="#addNewUserModal" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add New User</button>
                    </div>
                </div>
            </div>

            <div class="ds-cmn-tble count-row">
                <table>
                    <thead>
                        <tr>
                            <th>S. No</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Assigned Roles</th>
                            <th>Assigned Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    
                        <tbody>
                        
                            <tr>
                                <td>1</td>
                                <td>Lorem</td>
                                    <td>Lorem</td>
                                    <td>Lorem</td>
                                <td>
                                    <a href="#" class="view-attachment-btn">
                                        <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                    </a>
                                </td>
                            
                                <td>
                                    
                                    <div class="actions-wrp">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editNewUser">
                                            <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Icon">
                                        </button>

                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteLeaveRequest">
                                            <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Icon">
                                        </button>

                                    </div>
                                </td>
                            </tr>
                    
                        </tbody>
                    

                </table>
            </div>

        

                <div id="class-pagination">
                {{-- @include('backend.academic.class.partials.class-pagination', ['classes' => $data['classes']]) --}}
            </div>
        </div>
            
    </div>


    <!-- Add addNewUserModal  Begin -->
    <div class="modal fade cmn-popwrp pop800" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="addNewUserModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{global_asset('backend/assets/images/cross-icon.svg')}}" alt="Icon"></span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Add New User</h2>
                        </div>

                        <div class="cmn-pop-inr-content-wrp">
                            

                            <div class="cmn-tab-content">
                                <div class="upload-list">
                                    
                                    <div class="multi-input-grp grp-2 mt-3">
                                        <div class="input-grp">
                                            <label for="title">Full Name</label>
                                            <input id="title" name="title" type="text" placeholder="Full Name" />
                                        </div>
                                        
                                        <div class="input-grp">
                                            <label for="author">Email Id</label>
                                            <input id="author" name="author" type="text" placeholder="Email Id" />
                                        </div>
                                        </div>
                                        
                                        <div class="multi-input-grp grp-2">
                                        <div class="input-grp">
                                            <label for="categories">Designation</label>
                                            <input id="categories" name="categories" type="text" placeholder="Designation" />
                                        </div>
                                        
                                        <div class="input-grp">
                                            <label for="date">Password</label>
                                            <input  type="text" placeholder="Password" />
                                        </div>
                                        </div>

                                        {{-- <div class="multi-input-grp ">
                                        <div class="input-grp">
                                            <label for="date">Confirm Password</label>
                                            <input  type="text" placeholder="Confirm Password" />
                                        </div>
                                        </div> --}}
                                        <div class="multi-input-grp ">
                                        <div class="input-grp">
                                            <label for="date">Role Selection</label>
                                                <select name="" id="">
                                                <option value="">Select Role</option>
                                                <option value="">Lorem</option>
                                                <option value="">Lorem</option>
                                                </select>
                                        </div>
                                        <div class="input-grp">
                                            <label for="date">Role Modules</label>
                                                <select name="" id="">
                                                <option value="">Select Module</option>
                                                <option value="">Lorem</option>
                                                <option value="">Lorem</option>
                                                </select>
                                        </div>
                                        </div>
                                        
                                    <div class="btn-wrp justify-content-end">
                                        
                                        <button class="btn-sm cmn-btn">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- End Of addNewUser Modal -->

@endsection


@push('script')
    
@endpush
