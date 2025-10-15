@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

                   <div class="ds-breadcrumb">
                        <h1>Applicant</h1>
                        <ul>
                            <li><a href="dashboard.html">Dashboard</a> /</li>
                            <li><a href="#url">Applicantion</a> /</li>
                            <li><a href="#url">Applicants List</a> /</li>
                            <li>Applicant Info</li>
                        </ul>

                         <button onclick="window.location.href='{{ route('applicant.index') }}'" class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                    <div class="ds-pr-body">
                        <div class="atndnc-filter-wrp w-100">
                            <div class="sec-head">
                                <h2>Applicant Information</h2>
                            </div>
                            <div class="atndnc-filter student-filter">
                              
                              <a  class="cmn-btn" href="#"><img src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon">Edit Applicant</a>
                               <a href="#" class="cmn-btn ">
                                    <i class="fa-solid fa-plus"></i> Add New Applicant
                                </a>
                            </div> 
                        </div>
                       

                        <div class="dspr-bdy-content w-100">
                            <div class="dspr-bdy-content-sec border-0">
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td>ID</td>
                                            <td>1564564</td>
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
                                            <td>edwardthomas09@gmail.com</td>
                                          </tr>
                                          <tr>
                                            <td>Birthdate</td>
                                            <td>High School</td>
                                          </tr>
                                          <tr>
                                            <td>USA Cell</td>
                                            <td>Infection</td>
                                          </tr>
                                          <tr>
                                            <td>Email</td>
                                            <td>Edward Thomas</td>
                                          </tr>
                                          <tr>
                                            <td>High School (Application)</td>
                                            <td>USA</td>
                                          </tr>
                                         
                                          
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                            <div class="dspr-bdy-content-sec">
                                <h2>Camp (S) Attended</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                     <table style="width:100%; border-collapse:collapse; font-family:sans-serif; font-size:14px;">
                                        <thead>
                                            <tr style="background-color:#f9f9f9; text-align:left;">
                                                <th>Camp</th>
                                                <th>Position</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Lorem ipsum</td>
                                                <td>λ</td>  
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="dspr-bdy-content-sec">
                                <h2>Application Check List</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td>Fee</td>
                                            <td>$1200.00</td>
                                          </tr>
                                          <tr>
                                            <td>CC Last 4</td>
                                            <td>Lorem Ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Date Deposited</td>
                                            <td>12/11/2001</td>
                                          </tr>
                                          <tr>
                                            <td>Transcript Hebrew</td>
                                            <td><input type="checkbox"></td>
                                          </tr>
                                          <tr>
                                            <td>Transcript English</td>
                                            <td><input type="checkbox" ></td>
                                          </tr>
                                          <tr>
                                            <td>References</td>
                                            <td>Lorem ipsum </td>
                                          </tr>
                                          <tr>
                                            <td>Pictures</td>
                                            <td>59</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                             <div class="dspr-bdy-content-sec">
                                <h2>Application Processing</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td>Interview Date</td>
                                            <td>12/11/2001</td>
                                          </tr>
                                          <tr>
                                            <td>Interview Time</td>
                                            <td>02:30 PM</td>
                                          </tr>
                                          <tr>
                                            <td>Interview Location</td>
                                            <td>Lorem ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Status</td>
                                            <td>Lorem ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Letter Sent</td>
                                            <td><input type="checkbox" ></td>
                                          </tr>
                                          <tr>
                                            <td>Coming</td>
                                            <td>Lorem ipsum </td>
                                          </tr>
                                          <tr>
                                            <td>Application Comment</td>
                                            <td>Lorem ipsum </td>
                                          </tr>
                                          <tr>
                                            <td>Scholarship Comment</td>
                                            <td>Lorem ipsum </td>
                                          </tr>
                                          <tr>
                                            <td>Tuition Comment
                                                 <div class="ibtn">
                                                    <button type="button" class="ibtn-icon">
                                                        <img src="{{ asset('backend/assets/images/i-icon.svg') }}" alt="Icon">
                                                    </button>
                                                    <div class="ibtn-info lg rt p15">
                                                        <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                                            <img src="{{ asset('backend/assets/images/fa-times.svg') }}" alt="icon">
                                                        </button>
                                                        <h3 class="txt-primary mb-2">Important Notice:</h3>
                                                        <p> This comment carries over to the tuition form as tuition notes.</p>
                                                    </div>
                                                 </div>    
                                            </td>
                                            <td>Lorem ipsum </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                            <div class="dspr-bdy-content-sec">
                                <h2>Parents Information</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td>ID</td>
                                            <td>1564564</td>
                                          </tr>
                                          <tr>
                                            <td>Last Name</td>
                                            <td>Mr. Edward Thomas </td>
                                          </tr>
                                          <tr>
                                            <td>Father Title</td>
                                            <td>Mr. Edward Thomas </td>
                                          </tr>
                                          <tr>
                                            <td>Father Name</td>
                                            <td>Mr. Edward Thomas</td>
                                          </tr>
                                           <tr>
                                            <td>Mother  Title</td>
                                            <td>Mrs. Caroline Thomas</td>
                                          </tr>
                                           <tr>
                                            <td>Mother  Name</td>
                                            <td>Mrs. Caroline Thomas</td>
                                          </tr>
                                          <tr>
                                            <td>Maiden Name</td>
                                            <td>Nudell</td>
                                          </tr>
                                          <tr>
                                            <td>Address</td>
                                            <td>56 Main Street, Suite 3, Brooklyn, NY 11210‑0000</td>
                                          </tr>
                                          <tr>
                                            <td>City</td>
                                            <td>Cedarhurst</td>
                                          </tr>
                                          <tr>
                                            <td>State</td>
                                            <td>Lorem Ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Zip Code</td>
                                            <td>24546</td>
                                          </tr>
                                          <tr>
                                            <td>Country</td>
                                            <td>Lorem Ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Marital Status</td>
                                            <td>Married </td>
                                          </tr>
                                          <tr>
                                            <td>Marital Comment</td>
                                            <td>Lorem Ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Home Phone</td>
                                            <td>98654646</td>
                                          </tr>
                                          <tr>
                                            <td>Father Cell</td>
                                            <td>98654646</td>
                                          </tr>
                                          <tr>
                                            <td>Mother Cell</td>
                                            <td>98654646</td>
                                          </tr>
                                          <tr>
                                            <td>Father Email</td>
                                            <td>olivierthomas@gmail.com</td>
                                          </tr>
                                          <tr>
                                            <td>Mother Email</td>
                                            <td>carolinethomas@gmail.com</td>
                                          </tr>
                                           <tr>
                                            <td>Father Occupation</td>
                                            <td>Lawyer</td>
                                          </tr>
                                           <tr>
                                            <td>Mother Occupation</td>
                                            <td>Teacher</td>
                                          </tr>
                                           <tr>
                                            <td>Additional Phone Numbers</td>
                                            <td>23489632, 1641556456</td>
                                          </tr>
                                           <tr>
                                            <td>Additional Email Addresses</td>
                                            <td>carolinethomas@gmail.com, olivierthomas@gmail.com</td>
                                          </tr>
                                         
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                          

                        </div>
                    </div>
@endsection