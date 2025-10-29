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

    .cmn-tab-head {
        position: relative;
    }

    .cmn-tab-head ul {
        position: relative;
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .cmn-tab-head ul li {
        position: relative;
        padding: 8px 20px;
        cursor: pointer;
        z-index: 2;
    }

    .cmn-tab-head .tab-bg {
        position: absolute;
        top: 4px;
        height: 35px;
        background: #fff;
        /* White highlight */
        border-radius: 6px;
        transition: all 0.3s ease;
        z-index: 1;
    }

    .cmn-tab-head ul li.active {
        font-weight: bold;
    }

    .group-modal {
        display: flex;
        flex-direction: column;
        position: relative;
        left: 15px;
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
        left: -73px;
        top: 11px;
    }

    .file-description {
        border: 1px solid grey;
        padding: 12px;
        border-radius: 11px;
        margin-top: 10px;
    }

    .cmn-pop-content-wrapper {
        padding: 20px;
    }

   .header p {
          font-size: 17px;
    color: black;
    font-weight: 400;
    }
    .footer {
         position: relative;
    left: -89px;
    }

    .footer button {
        background: var(--primary-clr);
        color: white;
        padding: 7px;
        font-size: 12px;
        position: relative;
        left: 544px;
        border-radius: 5px;
        width: 85px;
    }

    .modal-body {
        width: 700px;
    }
    /* Base style for all status buttons */
.status-btn {
    display: inline-block;
    padding: 6px 14px;
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    border: none;
    border-radius: 2px;
    cursor: default;
    transition: all 0.3s ease;
    min-width: 100px;
    text-align: center;
}

/* Hover effect */
.status-btn:hover {
    opacity: 0.9;
}

/* Status-specific colors */
.status-pending {
    background-color: #bd921b; /* Yellow/Amber */
}

.status-inspected {
    background-color: red; /* Blue */
}

.status-returned {
    background-color: #28a745; /* Green */
}

.status-unknown {
    background-color: #6c757d; /* Gray */
}

</style>



@section('content')


            <div class="ds-breadcrumb">
                <h1>IT</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">IT</a> /</li>
                    <li>Return assets</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">



                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                        <div class="ds-content-head">
                            <div class="sec-head">
                                <h3 class="h2-title">Return Assets list</h3>
                            </div>

                        </div>

                        <div class="ds-cmn-tble count-row">
                            <table>
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Return Id</th>
                                        <th>Assigned Id</th>
                                        <th>Staff Id</th>
                                        <th>Return Requested Date</th>
                                        <th>Return Status</th>
                                        <th>Inspected By</th>
                                        <th>Comments</th>
                                        <th>Report Asset Id</th>
                                        <th>Media</th>
                                    </tr>
                                </thead>

                                <tbody id="assetsBody">
                                    @foreach ($returnAssets as $index => $asset)
                                        <tr>
                                            {{-- Serial Number --}}
                                            <td>{{ $index + 1 }}</td>

                                            {{-- Return Id --}}
                                            <td>{{ $asset->id }}</td>

                                            {{-- Assigned Id --}}
                                            <td>{{ $asset->request_id }}</td>

                                            {{-- Staff Id (who returned the asset) --}}
                                            <td>{{ $asset->inspect_by ?? '—' }}</td>

                                            {{-- Return Requested Date --}}
                                            <td>{{ \Carbon\Carbon::parse($asset->request_date)->format('d-m-Y') }}</td>

                                            {{-- Return Status --}}
                                            <td>
                                                @php
                                                    $statusText =
                                                        [
                                                            0 => 'Pending',
                                                            1 => 'Inspected',
                                                            2 => 'Returned',
                                                        ][$asset->return_status] ?? 'Unknown';

                                                    $statusClass = match ($asset->return_status) {
                                                        0 => 'status-pending',
                                                        1 => 'status-inspected',
                                                        2 => 'status-returned',
                                                        default => 'status-unknown',
                                                    };
                                                @endphp

                                                <button class="status-btn {{ $statusClass }}">
                                                    {{ $statusText }}
                                                </button>
                                            </td>


                                            {{-- Inspected By --}}
                                            <td>{{ $asset->inspect_by ?? 'N/A' }}</td>

                                            {{-- Comments --}}
                                            <td>{{ $asset->comments ?? '—' }}</td>

                                            {{-- Report Asset Id --}}
                                            <td>
                                                <button data-bs-target="#reportedasset" data-bs-toggle="modal"
                                                    style="color:var(--primary-clr)">
                                                    {{ $asset->report_id }}
                                                </button>
                                            </td>

                                            {{-- Media (eye icon to view attachments) --}}
                                            <td>
                                                <button class="view-attachment-btn" data-bs-target="#view-issuereport"
                                                    data-bs-toggle="modal" data-id="{{ $asset->id }}"
                                                    data-title="{{ $asset->report_id }}"
                                                    data-file="{{ $asset->file_name ?? '' }}">
                                                    <img src="{{ asset('images/parent/eye-white.svg') }}" alt="Eye Icon">
                                                </button>
                                                     
                                            </td>
                                        </tr>
                                    @endforeach
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
     
    <div class="modal fade cmn-popwrp pop800" id="view-issuereport" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <img src="{{ asset('images/fees/cross-icon.svg') }}" alt="Close"
                            style="position:relative; left:-73px; top:13px;">
                    </span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Attachments </h2>
                        </div>

                          <div id="attachmentsContainer" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    document.querySelectorAll('.view-attachment-btn').forEach(button => {
    button.addEventListener('click', function () {
        const title = this.getAttribute('data-title');
        const file = this.getAttribute('data-file');

        // Extract file extension (format)
        const fileExtension = file.split('.').pop().toUpperCase();

        // Build dynamic HTML
        const attachmentHTML = `
            <div class="file-description">
                <div class="header">
                    <p>Title: ${title}</p>
                    <p>File Format: ${fileExtension} File</p>
                </div>
                <div class="footer">
                    <a href="/uploads/${file}" download>
                        <button>Download</button>
                    </a>
                      <a href="/uploads/${file}" download>
                        <button>View</button>
                    </a>
                </div>
            </div>
        `;

        // Insert into modal container
        document.getElementById('attachmentsContainer').innerHTML = attachmentHTML;
    });
});
    </script>

    <div class="modal fade cmn-popwrp pop800" id="reportedasset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <img src="{{ asset('images/fees/cross-icon.svg') }}" alt="Close"
                            style="position:relative; left:-73px; top:13px;">
                    </span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Attachments </h2>
                        </div>
                        <h5
                            style="style=   font-size: 15px;
    position: relative;
    top: 14px;
    color: var(--primary-clr);">
                            Issue Description</h5>
                        <div class="file-description">
                            <div class="header">
                                <p style="color: gray;">Lorum Ipsum...........</p>

                            </div>

                        </div>

                        <h5
                            style="style=   font-size: 15px;
    position: relative;
    top: 14px;
    color: var(--primary-clr);">
                            Attached Files</h5>
                        <div class="file-description">
                            <div class="header">
                                <p>Title:Lorum Ipsum</p>
                                <p>File Format:MP4 File</p>
                            </div>
                            <div class="footer">
                                <button>Download</button>
                            </div>
                        </div>
                        <div class="file-description">
                            <div class="header">
                                <p>Title:Lorum Ipsum</p>
                                <p>File Format:MP4 File</p>
                            </div>
                            <div class="footer">
                                <button>Download</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
