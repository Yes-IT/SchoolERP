@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
                   <div class="ds-breadcrumb">
                        <h1>Applicant</h1>
                        <ul>
                            <li><a href="dashboard.html">Dashboard</a> /</li>
                            <li><a href="#">Applicantion</a> /</li>
                            <li><a href="{{route('applicant.index')}}">Applicants List</a> /</li>
                            <li>Applicants Info</li>
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
                                <a  class="cmn-btn" href="#">
                                    <img src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon">Edit Applicant
                                </a>
                                <a href="{{ route('applicant.add_new_applicant') }}" class="cmn-btn ">
                                    <i class="fa-solid fa-plus"></i> Add New Applicant
                                </a>

                            </div> 
                        </div>

                        <div class="ds-cmn-table-wrp">
                            <div class="dspr-bdy-content-sec border-0">
                                <div class="dsbdy-cmn-table table-full-height ">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td>ID</td>
                                            <td>{{ $applicant->custom_id }}</td>
                                          </tr>
                                          <tr>
                                            <td>Last Name</td>
                                            <td>{{ $applicant->last_name ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>First Name</td>
                                             <td>{{ $applicant->first_name ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>High School</td>
                                            <td>{{ $applicant->high_school ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Birthdate</td>
                                             <td>{{ $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('d/m/Y') : 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>USA Cell</td>
                                            <td>{{ $applicant->usa_cell ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Email</td>
                                           <td>{{ $applicant->email ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>High School (Application)</td>
                                            <td>{{ $applicant->highschool_application ?? 'N/A' }}</td>
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
                                                <td>Sunday</td>
                                                <td>2</td>
                                               
                                            </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                            <div class="dspr-bdy-content-sec border-0">
                                 <h2>Application Check List</h2>
                                <div class="dsbdy-cmn-table table-full-height ">
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
                                            <td> <input  type="checkbox"></td>
                                          </tr>
                                          <tr>
                                            <td>Transcript English</td>
                                            <td> <input  type="checkbox"></td>
                                          </tr>
                                          <tr>
                                            <td>References</td>
                                            <td>Lorem Ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Pictures</td>
                                            <td>59</td>
                                          </tr>
                                         
                                          
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                               <div class="dspr-bdy-content-sec border-0">
                                 <h2>Application Processing</h2>
                                <div class="dsbdy-cmn-table table-full-height ">
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
                                            <td>12/11/2001</td>
                                          </tr>
                                          <tr>
                                            <td>Status</td>
                                            <td> lorem</td>
                                          </tr>
                                          <tr>
                                            <td>Letter Sent</td>
                                            <td> <input  type="checkbox"></td>
                                          </tr>
                                          <tr>
                                            <td>Coming</td>
                                            <td>Lorem Ipsum</td>
                                          </tr>
                                          <tr>
                                            <td>Application Comment </td>
                                            <td>Lorem ipsum dolor sit amet</td>
                                          </tr>
                                         <tr>
                                            <td> Scholarship Comment</td>
                                            <td>Lorem ipsum dolor sit amet</td>
                                          </tr>
                                          <tr>
                                            <td> Tuition Comment</td>
                                            <td>Lorem ipsum dolor sit amet</td>
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
                                            <td class="td-lineremover" >ID</td>
                                            <td class="td-lineremover" >1564564</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Last Name</td>
                                            <td class="td-lineremover" >Mr. Olivier Thomas </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Father Title</td>
                                            <td class="td-lineremover" >Mr. Olivier Thomas</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Father Name</td>
                                            <td class="td-lineremover" >Mr. Olivier Thomas </td>
                                          </tr>

                                          <tr>
                                            <td class="td-lineremover" >Mother  Title</td>
                                            <td class="td-lineremover" >Mrs. Caroline Thomas </td>
                                          </tr>

                                          <tr>
                                            <td class="td-lineremover" >Mother  Name</td>
                                            <td class="td-lineremover" >Mrs. Caroline Thomas </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Maiden Name</td>
                                            <td class="td-lineremover" >Nudell </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Address</td>
                                            <td class="td-lineremover" >56 Main Street, Suite 3, Brooklyn, NY 11210-0000 </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >City</td>
                                            <td class="td-lineremover" >Cedarhurst </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >State</td>
                                            <td class="td-lineremover" >Lorem Ipsum </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Zip Code</td>
                                            <td class="td-lineremover" >24546 </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Country</td>
                                            <td class="td-lineremover" >lorem ipsum </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Marital Status</td>
                                            <td class="td-lineremover" >Married </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Marital Comment</td>
                                            <td class="td-lineremover" >Nudell </td>
                                          </tr>

                                           <tr>
                                            <td class="td-lineremover" >Home Phone</td>
                                            <td class="td-lineremover" >98654646 </td>
                                          </tr>
                                           <tr>
                                            <td class="td-lineremover" >Father Cell</td>
                                            <td class="td-lineremover" >98654646 </td>
                                          </tr>
                                           <tr>
                                            <td class="td-lineremover" >Mother Cell</td>
                                            <td class="td-lineremover" >Nudell </td>
                                          </tr>
                                           <tr>
                                            <td class="td-lineremover" >Father Email</td>
                                            <td class="td-lineremover" >olivierthomas@gmail.com </td>
                                          </tr>
                                           <tr>
                                            <td class="td-lineremover" >Mother Email</td>
                                            <td class="td-lineremover" >olivierthomas@gmail.com </td>
                                          </tr>
                                           <tr>
                                            <td class="td-lineremover" >Father Occupation</td>
                                            <td class="td-lineremover" >Lawyer </td>
                                          </tr>
                                           <tr>
                                            <td class="td-lineremover" >Mother Occupation</td>
                                            <td class="td-lineremover" >Teacher </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Additional Phone Numbers</td>
                                            <td class="td-lineremover" >23489632, 1641556456 </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Additional Email Addresses</td>
                                            <td class="td-lineremover" >carolinethomas36@gmail.com, olivierthomas55@gmail.com  </td>
                                          </tr>
                                         
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                           

                        </div>
                    </div>
@endsection