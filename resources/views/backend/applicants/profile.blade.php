@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
        <div class="dashboard-body dspr-body-outer">

                    <div class="ds-breadcrumb">
                        <h1>Applicant</h1>
                        <ul>
                            <li><a href="dashboard">Dashboard</a> /</li>
                            <li><a href="#">Application</a> /</li>
                            <li><a href="#">Applicants List</a> /</li>
                            <li>Applicant Info</li>
                        </ul>
                    </div>

                    <div class="ds-pr-body pb-0">
                      <div class="card w-100 p-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <h6 class="mb-0">Applicant Information</h6>
                          <div class="btn-wrp small-btn">
                            <button type="button" class="cmn-btn"><img src="{{ asset('backend') }}/assets/images/new_images/edit-icon.svg" alt="Icon"> Edit Parent</button>
                            <button type="button" class="cmn-btn img-white"><img src="{{ asset('backend') }}/assets/images/new_images/add-icon.svg" alt="Icon"> Add New Application</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="ds-pr-body">
                        <div class="dspr-bdy-content w-100">
                            <div class="dspr-bdy-content-sec applicant-profile border-0">
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                      <tbody>
                                        <tr>
                                          <td class="bg-none">ID</td>
                                          <td class="bg-none">03/18/2021</td>
                                        </tr>
                                        <tr>
                                          <td>Last Name</td>
                                          <td>03/11/1998</td>
                                        </tr>
                                        <tr>
                                          <td>First Name</td>
                                          <td>13 Adar I, 5758</td>
                                        </tr>
                                        <tr>
                                          <td>High School</td>
                                          <td>High School</td>
                                        </tr>
                                        <tr>
                                          <td>Birth Date</td>
                                          <td>Infection</td>
                                        </tr>
                                        <tr>
                                          <td>USA Cell</td>
                                          <td>Edward Thomas</td>
                                        </tr>
                                        <tr>
                                          <td>Email</td>
                                          <td>USA</td>
                                        </tr>
                                        <tr>
                                          <td>High School(Application)</td>
                                          <td>USA</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="dspr-bdy-content-sec applicant-profile-camp w-50">
                                <h2>Camp (S) Attended</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Home Address</td>
                                                <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="dspr-bdy-content-sec applicant-profile border-0 mt-5">
                              <h3>Application Check List</h3>
                              <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                  <table>
                                    <tbody>
                                      <tr>
                                        <td class="bg-none">Fee</td>
                                        <td class="bg-none">03/18/2021</td>
                                      </tr>
                                      <tr>
                                        <td>CC Last 4</td>
                                        <td>03/11/1998</td>
                                      </tr>
                                      <tr>
                                        <td>Date Deposited</td>
                                        <td>13 Adar I, 5758</td>
                                      </tr>
                                      <tr>
                                        <td>Transcript Hebrew</td>
                                        <td>High School</td>
                                      </tr>
                                      <tr>
                                        <td>Transcript English</td>
                                        <td>Infection</td>
                                      </tr>
                                      <tr>
                                        <td>References</td>
                                        <td>Edward Thomas</td>
                                      </tr>
                                      <tr>
                                        <td>Pictures</td>
                                        <td>USA</td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>

                            <div class="dspr-bdy-content-sec applicant-profile border-0 mt-5">
                              <h3>Application Processing</h3>
                              <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                  <table>
                                    <tbody>
                                      <tr>
                                        <td class="bg-none">Interview Date</td>
                                        <td class="bg-none">03/18/2021</td>
                                      </tr>
                                      <tr>
                                        <td>Interview Time</td>
                                        <td>03/11/1998</td>
                                      </tr>
                                      <tr>
                                        <td>Interview Location</td>
                                        <td>13 Adar I, 5758</td>
                                      </tr>
                                      <tr>
                                        <td>Status</td>
                                        <td>High School</td>
                                      </tr>
                                      <tr>
                                        <td>Letter Sent</td>
                                        <td>Infection</td>
                                      </tr>
                                      <tr>
                                        <td>Coming</td>
                                        <td>Edward Thomas</td>
                                      </tr>
                                      <tr>
                                        <td>Application Comment</td>
                                        <td>USA</td>
                                      </tr>
                                      <tr>
                                        <td>Scholarship Comment</td>
                                        <td>USA</td>
                                      </tr>
                                      <tr>
                                        <td>Tuition Comment</td>
                                        <td>USA</td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>

                            <div class="dspr-bdy-content-sec mt-5">
                              <h2>Parents Information</h2>
                              <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                  <table>
                                      <tbody>
                                        <tr>
                                          <td>ID</td>
                                          <td>Craig Curtis</td>
                                        </tr>
                                        <tr>
                                          <td>Last Name</td>
                                          <td>Uncle</td>
                                        </tr>
                                        <tr>
                                          <td>Father Title</td>
                                          <td>3218410414</td>
                                        </tr>
                                        <tr>
                                          <td>Father Name</td>
                                          <td>2145124944</td>
                                        </tr>
                                        <tr>
                                          <td>Mother Title</td>
                                          <td>craigcurtis@gmail.com</td>
                                        </tr>
                                        <tr>
                                          <td>Mother Name</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Maiden Name</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Address</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>City</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>State</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Zip Code</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Country</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Marital Status</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Marital Comment</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Home Phone</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Father Cell</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Mother Cell</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                             <tr>
                                          <td>Father Email</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Mother Email</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Father Occupation</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Mother Occupation</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Additional Phone Numbers</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                        <tr>
                                          <td>Additional Email Addresses</td>
                                          <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                        </tr>
                                      </tbody>
                                    </table>
                              </div>
                            </div>

                        </div>
                    </div>
        </div>
    <!-- End Of Dashboard Body -->

    <div class="modal fade cmn-popwrp popwrp w400" id="deleteStudent" tabindex="-1" role="dialog" aria-labelledby="deleteStudent" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ asset('backend') }}/assets/images/new_images/cross-icon.svg" alt="Icon"></span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <div class="modal-icon">
                            <img src="{{ asset('backend') }}/assets/images/new_images/bin-primary.svg" alt="Bin Icon">
                        </div>
                        <div class="sec-head head-center">
                            <h2>Delete!</h2>
                            <p>Are you sure you want to delete this Leave Request?</p>
                            <div class="btn-wrp">
                                <button type="submit" class="cmn-btn">Delete</button>
                                <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@endsection