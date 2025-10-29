@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .input-grp button {
        position: relative;
        left: 192px;
        background: var(--primary-clr);
        padding: 10px;
        color: white;
        font-size: 14px;
        border-radius: 5px;
    }

    .available-btn {
        background-color: green;
        color: white;
        font-size: 14px;
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
</style>



@section('content')


            <div class="ds-breadcrumb">
                <h1>Issue Reports</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">IT</a> /</li>
                    <li>Issue Report</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">



                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                        <div class="ds-content-head">
                            <div class="sec-head">
                                <h3 class="h2-title">Issue Report list</h3>
                            </div>

                        </div>



                        <div class="ds-cmn-tble count-row">
                            <table>
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Issue Id</th>
                                        <th>Assigned Id</th>

                                        <th>Reported By</th>
                                        <th>Issue Description</th>
                                        <th>Issue Status</th>
                                        <th>Media</th>


                                    </tr>
                                </thead>
                                <tbody id="assetsBody">
                                    @foreach ($issueReports as $index => $report)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $report->asset_id }}</td>
                                            <td>{{ $report->assign_id }}</td>
                                            <td>{{ $report->description }}</td>
                                            <td>{{ $report->reported_by }}</td>

                                            {{-- Status button --}}
                                            <td>
                                                <button class="status-btn bg-green-500 text-white px-2 py-1 available-btn">
                                                    Available
                                                </button>
                                            </td>

                                            {{-- View attachment button --}}
                                            <td>
                                                <button class="view-attachment-btn" data-bs-target="#view-issuereport"
                                                    data-bs-toggle="modal" data-id="{{ $report->id }}"
                                                    data-title="{{ $report->description }}" data-file="{{ $report->file }}">
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



@endsection