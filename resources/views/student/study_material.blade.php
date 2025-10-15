@extends('student.Layout.app')

@section('content')


<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>Study Material</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>Study Material</li>
    </ul>
</div>
<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Study Material List</h2>
            </div>
            <div class="btn-wrp align-items-start">
                <div class="ibtn">
                    <button type="button" class="ibtn-icon">
                        <img src="{{asset('student/images/i-icon.svg')}}" alt="Icon">
                    </button>
                    <div class="ibtn-info lg rt p15">
                        <button type="button" class="ibtn-close" style="filter: brightness(0);">
                            <img src="{{asset('student/images/fa-times.svg')}}" alt="icon">
                        </button>
                        <h3 class="txt-primary mb-2">Note:</h3>
                        <p>Select the subjects you want to pay for using the checkboxes. The "Pay Now" button will only be active if at least one subject is selected.</p>
                    </div>
                </div>

                <button class="cmn-btn btn-sm" data-bs-target="#payNow" data-bs-toggle="modal">Pay Now
                </button>
            </div>
        </div>

        <div class="ds-cmn-tble count-row w1200">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Subject</th>
                        <th>Book Name</th>
                        <th>Publisher</th>
                        <th>Author</th>
                        <th>Rental Price</th>
                        <th>Status</th>
                        <th>Online Resources</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($materials as $key => $material)
                    <tr>
                        <td>{{ $key + 1 }}</td>

                        <!-- <td>
                            <div class="cstm-checkbox">
                                <label>
                                    <input type="checkbox" name="subject[]" value="{{ $material->id }}">
                                    <span title="{{ $material->subject }}">
                                        {{ \Illuminate\Support\Str::limit($material->subject, 20) }}
                                    </span>
                                </label>
                            </div>
                        </td> -->




                        <td>
                            <div class="cstm-checkbox">
                                <label>
                                    <input type="checkbox" name="subject[]" value="{{ $material->id }}"
                                        @if($material->status === 'paid') disabled @endif>
                                    <span title="{{ $material->subject }}">
                                        {{ \Illuminate\Support\Str::limit($material->subject, 20) }}
                                    </span>
                                </label>
                            </div>
                        </td>


                        <td title="{{ $material->book_name }}">{{ \Illuminate\Support\Str::limit($material->book_name, 20) }}</td>
                        <td title="{{ $material->publisher }}">{{ \Illuminate\Support\Str::limit($material->publisher, 20) }}</td>
                        <td title="{{ $material->author }}">{{ \Illuminate\Support\Str::limit($material->author, 20) }}</td>

                        <td>${{ number_format($material->rental_price, 2) }}</td>

                        <td>
                            @if($material->status === 'paid')
                            <p class="green-bg cmn-tbl-btn">Paid</p>
                            @else
                            <p class="red-bg cmn-tbl-btn">Pending</p>
                            @endif
                        </td>

                        <td>
                            @if($material->status === 'paid' && $material->resource_link)
                            <button class="cmn-tbl-btn"
                                data-bs-target="#viewAttachedLinks"
                                data-bs-toggle="modal"
                                data-title="{{ $material->subject }}"
                                data-link="{{ $material->resource_link }}">
                                View
                            </button>
                            @else
                            <button class="cmn-tbl-btn btn-disabled">View</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        <!-- <div class="tablepagination">
            <div class="tbl-pagination-inr">
                {{ $materials->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>

            <div class="pages-select">
                <form method="GET" id="perPageForm">
                    <div class="formfield">
                        <label>Per page</label>
                        <select name="perPage" onchange="document.getElementById('perPageForm').submit()">
                            @foreach([1,2,3,4,5,10,15,20,25,50] as $size)
                            <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <p>
                    Showing {{ $materials->firstItem() }} - {{ $materials->lastItem() }}
                    of {{ $materials->total() }} results
                </p>
            </div>
        </div> -->
    </div>
</div>
<!-- End Of Dashboard -->

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="payNow" tabindex="-1" role="dialog" aria-labelledby="payNow" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Rental Payment</h2>
                    <div class="request-leave-form-wrp">
                        <form>
                            <div class="request-leave-form">
                                <!-- <div class="study-material-info-wrp">
                                    <div class="study-material-info"><span class="txt-primary">Subject-</span> Child Development</div>
                                    <div class="study-material-info"><span class="txt-primary">Rental Price-</span> $99</div>
                                </div> -->

                                <div class="study-material-info-wrp" id="payNowSubjects">
                                    <!-- Selected subjects will be injected here -->
                                </div>
                                <div class="study-material-info-wrp">
                                    <div class="study-material-info"><span class="txt-primary">Total Price: $</span><span id="totalPrice">0.00</span></div>
                                </div>

                                <div class="input-grp">
                                    <label>Payment Link</label>
                                    <div class="has-submit">
                                        <input type="url" placeholder="https://pay.example.com/share/invoice123xyz">
                                        <input type="submit" value="Pay Now">
                                    </div>
                                </div>
                                <button type="button" value="Submit" class="cmn-btn btn-sm" data-bs-target="#success" data-bs-toggle="modal">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->



<!-- viewAttachedDocs Modal Begin -->
<div class="modal fade cmn-popwrp pop800 links" id="viewAttachedLinks" tabindex="-1" role="dialog" aria-labelledby="viewAttachedLinks" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <!-- <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>Attached Links</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="viewAttachedDocs">
                            <div class="attached-doc-card">
                                <div class="attached-doc-info">
                                    <p>Title: Lorem Ipsum</p>
                                    <p>Link - <a href="#url">example.com</a></p>
                                </div>
                            </div>
                            <div class="attached-doc-card">
                                <div class="attached-doc-info">
                                    <p>Title: Lorem Ipsum</p>
                                    <p>Link - <a href="#url">example.com</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>Attached Links</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="viewAttachedDocs" id="linksContainer">
                            <!-- Dynamic links will be injected here -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Of viewAttachedDocs Modal -->

<!-- Success Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="success" tabindex="-1" role="dialog" aria-labelledby="success" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{asset('student/images/check-circle-primary.svg')}}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center w100">
                        <h2>Successful</h2>
                        <p>Your transcript request has been submitted successfully.</p>
                        <div class="btn-wrp">
                            <button type="submit" data-bs-dismiss="modal" aria-label="Close" class="cmn-btn btn-sm">Okay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Success Modal -->

@endsection

@push('page_script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const viewButtons = document.querySelectorAll("[data-bs-target='#viewAttachedLinks']");

        viewButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                const title = this.getAttribute("data-title");
                const links = this.getAttribute("data-link");
                const container = document.getElementById("linksContainer");

                container.innerHTML = '';

                const linkArray = links.split(',');

                linkArray.forEach(link => {
                    const card = document.createElement('div');
                    card.classList.add('attached-doc-card');
                    card.innerHTML = `
                    <div class="attached-doc-info">
                        <p>Title: ${title}</p>
                        <p>Link - <a href="${link.trim()}" target="_blank">${link.trim()}</a></p>
                    </div>
                `;
                    container.appendChild(card);
                });
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const payNowBtn = document.querySelector("[data-bs-target='#payNow']");

        payNowBtn.addEventListener("click", function() {
            const selectedSubjects = document.querySelectorAll("input[name='subject[]']:checked");
            const container = document.getElementById("payNowSubjects");
            const totalPriceEl = document.getElementById("totalPrice");

            container.innerHTML = ''; // clear previous content
            let totalPrice = 0;

            selectedSubjects.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const subject = row.querySelector("td:nth-child(2) span").title;
                const priceText = row.querySelector("td:nth-child(6)").innerText.replace('$', '');
                const price = parseFloat(priceText);

                totalPrice += price;

                // Add subject info to modal
                const div = document.createElement('div');
                div.classList.add('study-material-info');
                div.innerHTML = `<span class="txt-primary">Subject-</span> ${subject} <span style="margin-left:10px;"><span class="txt-primary">Rental Price-</span> $${price.toFixed(2)}</span>`;
                container.appendChild(div);
            });

            totalPriceEl.innerText = totalPrice.toFixed(2);
        });
    });
</script>
@endpush