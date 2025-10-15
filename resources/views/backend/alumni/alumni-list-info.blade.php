@extends('backend.master')

@section('title')
    {{-- {{ @$data['title'] }} --}}
{{ ___('common.School Management System | Profile') }}

@endsection

@section('content')
                   <div class="ds-breadcrumb">
                        <h1>Alumni</h1>
                        <ul>
                            <li><a href="../dashboard.html">Dashboard</a> /</li>
                            <li><a href="#">Alumni</a> /</li>
                            <li>Alumni Info</li>
                        </ul>

                     <button  class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>

                    <div class="ds-pr-body">
                          <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Alumni Info</h2>
                    </div>
                    <div class="atndnc-filter student-filter">
                      
                       <button id="saveChangesBtn" class="cmn-btn" >
                            Parents Info
                        </button>
                    </div> 
                </div>


                        <div class="ds-pr-profile-card">
                            <div class="dspr-profile-cd-upr">
                                <div class="dspr-profile-cd-img">
                                    <img src="{{global_asset('backend/assets/images/new_images/student-img.png')}}" alt="Profile Image">
                                </div>
                                <div class="dspr-profile-cd-info">
                                    <h2>Edward Thomas</h2>
                                    <p>אדוארד תומס</p>
                                    <div class="user-id">Student ID 18001</div>
                                </div>
                            </div>
                            <div class="dspr-profile-cd-btm">
                                <div class="dsprprofile-img-link">
                                    <label>Image Link</label>
                                    <div class="floating-input-btn input-grp w-70">
                                        <div class="has-submit">
                                        <label class="file-label">
                                            <span class="file-text">L:\DataBase\Shana Aleph Database\Images\5784\84AbrIla.jpg</span>
                                            <input type="file" name="fileUpload" />
                                        </label>
                                       
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="dsprprofile-course-info">
                                    <p>Information from School Records</p>
                                    <table>
                                        <tr>
                                            <td class="td-lineremover" >ID</td>
                                            <td class="td-lineremover" >2572315</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >Last Name</td>
                                            <td class="td-lineremover" >Aaron</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >First Name</td>
                                            <td class="td-lineremover" >Dina</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >High School</td>
                                            <td class="td-lineremover" >Lorem Ipsum</td>
                                        </tr>
                                         <tr>
                                            <td class="td-lineremover" >Birth Date</td>
                                            <td class="td-lineremover" >06/27/2005</td>
                                        </tr>
                                         <tr>
                                            <td class="td-lineremover" >Parents</td>
                                            <td class="td-lineremover" >Aaron</td>
                                        </tr>
                                         <tr>
                                            <td class="td-lineremover" >Address</td>
                                            <td class="td-lineremover" >Lorem Ipsum</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >City</td>
                                            <td class="td-lineremover" >New City</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >State</td>
                                            <td class="td-lineremover" >New York</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >Zip Code</td>
                                            <td class="td-lineremover" >10956</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >Country</td>
                                            <td class="td-lineremover" >United States</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >Home Phone</td>
                                            <td class="td-lineremover" >2441455663</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >Cell Phone</td>
                                            <td class="td-lineremover" >2441455663</td>
                                        </tr>
                                        <tr>
                                            <td class="td-lineremover" >Email Id</td>
                                            <td class="td-lineremover" >example@gmail.com</td>
                                        </tr>
                                        

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="dspr-bdy-content">
                            <div class="dspr-bdy-content-sec border-remover">
                                <h2>My Latest Update</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >First Name</td>
                                            <td class="td-lineremover" >Dina</td>
                                          </tr>
                                         <tr class="table-tr">
                                            <td class="td-lineremover" >Last Name</td>
                                            <td class="td-lineremover" >Aaron</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Husband Name</td>
                                            <td class="td-lineremover" >Micheal</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Marital Status</td>
                                            <td class="td-lineremover" >Divorced</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Date Married</td>
                                            <td class="td-lineremover" >06/27/2005</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Parents</td>
                                            <td class="td-lineremover" >Aaron</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Address</td>
                                            <td class="td-lineremover" >56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >City</td>
                                            <td class="td-lineremover" >New City</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >State</td>
                                            <td class="td-lineremover" >New York</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Zip Code</td>
                                            <td class="td-lineremover" >10956</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Country</td>
                                            <td class="td-lineremover" >United States</td>
                                          </tr>
                                          <tr class="table-tr">
                                            <td class="td-lineremover" >Home Phone</td>
                                            <td class="td-lineremover" >123456789</td>
                                          </tr>
                                         
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                           

                            <div class="dspr-bdy-content-sec">
                                <h2>School Year (s)</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td class="td-lineremover" >ID</td>
                                            <td class="td-lineremover" >2356</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >School Year</td>
                                            <td class="td-lineremover" >2023-2024</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Year Status</td>
                                            <td class="td-lineremover" >Shana Alef</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >College</td>
                                            <td class="td-lineremover" >Charter Oak</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Withdraw Date</td>
                                            <td class="td-lineremover" >--</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Homeroom Class</td>
                                            <td class="td-lineremover" >ג</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Group</td>
                                            <td class="td-lineremover" >Mrs. Kaye
                                                
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Division</td>
                                            <td class="td-lineremover" >A</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Floor</td>
                                            <td class="td-lineremover" >2</td>
                                          </tr>
                                          <tr>
                                            <td class="td-lineremover" >Room</td>
                                            <td class="td-lineremover" >201</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                          

                        </div>
                    </div>

@endsection
