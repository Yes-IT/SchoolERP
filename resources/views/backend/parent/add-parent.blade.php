@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Add Parent') }}
@endsection


@section('content')

<div class="ds-breadcrumb">
    <h1>Add Form</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li><a href="#url">Students</a> /</li>
        <li><a href="#url">Students Info</a> /</li>
        <li>Add Form</li>
    </ul>
</div>

<div class="ds-pr-body">
    <div class="ds-cmn-table-wrp">
        
        <div class="request-leave-form">
            
            <form>
                <div class="new-request-form">
                    <h3>Student Details</h3>
                    <div class="input-grp h48 paylink">
                        <label>Payment Link</label>
                        <div class="has-submit">
                            <input type="url" placeholder="https://pay.example.com/share/invoice123xyz">
                            <input type="submit" value="Upload">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <button type="button" value="Submit" class="cmn-btn btn-sm" data-bs-target="#success" data-bs-toggle="modal">Submit</button>
                </div>

                <div class="new-request-form mt-4">
                    <h3>Address Details</h3>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <button type="button" value="Submit" class="cmn-btn btn-sm" data-bs-target="#success" data-bs-toggle="modal">Submit</button>
                </div>

                <div class="new-request-form mt-4">
                    <h3>Marital Status</h3>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <div class="multi-input-grp grp-3">
                        <div class="input-grp">
                            <label>First Name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="input-grp">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                        <div class="input-grp">
                            <label>Hebrew Last Name</label>
                            <input type="text" placeholder="Hebrew Last Name">
                        </div>
                    </div>
                    <button type="button" value="Submit" class="cmn-btn btn-sm" data-bs-target="#success" data-bs-toggle="modal">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection