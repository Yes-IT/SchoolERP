@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
                   <div class="ds-breadcrumb">
                        <h1>Applicant</h1>
                        <ul>
                            <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                            <li><a href="#">Application</a> /</li>
                            <li><a href="{{route('applicant.student_application_form')}}">Applicants List</a> /</li>
                            <li>Applicants Info</li>
                        </ul>
                        <button onclick="window.location.href='{{ route('applicant.student_application_form') }}'" class="cmn-btn" >
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
                                <a  class="cmn-btn" href="{{route('applicant.edit_applicant', $applicant->id)}}">
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
                                             <td>{{ $applicant->date_of_birth ? \Carbon\Carbon::parse($applicant->date_of_birth)->format('d/m/Y') : 'N/A' }}</td>
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
                                                <th>Name of school</th>
                                                <th>Grade attended</th>
                                                
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

                       
                        @if($applicant->transaction || $applicant->confirmation)
                              <div class="dspr-bdy-content-sec border-0">
                                  <h2>Application Check List</h2>
                                  <div class="dsbdy-cmn-table table-full-height">
                                      <table>
                                          <tbody>
                                        
                                              {{-- Payment Info --}}
                                              @if($applicant->transaction)
                                                  <tr>
                                                      <td>Fee</td>
                                                      <td>${{ number_format((float)($applicant->transaction->amount ?? 0), 2) }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>CC Last 4</td>
                                                      <td>{{ $applicant->transaction->card_last4 ?? 'N/A' }}</td>
                                                  </tr>
                                                 
                                              @endif

                                               <tr>
                                                  <td>Date Deposited</td>
                                                  <td>
                                                      {{ $applicant->confirmation->created_at 
                                                          ? \Carbon\Carbon::parse($applicant->confirmation->created_at)->format('d/m/Y')
                                                          : 'N/A' }}
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td>Transcript Hebrew</td>
                                                  <td> <input  type="checkbox" disabled {{ $applicant->confirmation->transcript_hebrew ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                  <td>Transcript English</td>
                                                  <td> <input  type="checkbox" disabled {{ $applicant->confirmation->transcript_english ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                  <td>References</td>
                                                  <td>{{ $applicant->confirmation->reference ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                  <td>Pictures</td>
                                                  <td>{{ $applicant->confirmation->reference ?? 'N/A' }}</td>
                                                </tr>

                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                        @endif


                              @if($applicant->processing)

                               <div class="dspr-bdy-content-sec border-0">
                                 <h2>Application Processing</h2>
                                <div class="dsbdy-cmn-table table-full-height ">
                                    <table>
                                        <tbody>
                                          @php
                                            $statusMap = [
                                                0 => 'Pending',
                                                1 => 'Scheduled',
                                                2 => 'Rescheduled',
                                            ];
                                            $interviewStatus = $applicant->processing->interview_status ?? null;
                                        @endphp
                                          <tr>
                                            <td>Interview Date</td>
                                            <td>{{ $applicant->processing->interview_date ? \Carbon\Carbon::parse($applicant->processing->interview_date)->format('d/m/Y') : 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Interview Time</td>
                                            <td>{{ $applicant->processing->interview_time ?? 'N/A' }}</td>
                                          </tr>
                                          
                                           <tr>
                                              <td>Interview Location / Link</td>
                                              <td>
                                                  @php
                                                      $location = $applicant->processing->interview_location ?? null;
                                                      $link = $applicant->processing->interview_link ?? null;
                                                  @endphp

                                                  @if($location && $link)
                                                      {{ $location }} / <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                                                  @elseif($location)
                                                      {{ $location }}
                                                  @elseif($link)
                                                      <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                                                  @endif
                                              </td>
                                          </tr>

                                          <tr>
                                            <td>Status</td>
                                            <td>{{ $statusMap[$interviewStatus] ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Letter Sent</td>
                                            <td> <input  type="checkbox" disabled {{ $applicant->processing->letter_sent ? 'checked' : '' }}></td>
                                          </tr>
                                          <tr>
                                            <td>Coming</td>
                                            <td>{{ $applicant->processing->coming ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Application Comment </td>
                                            <td>{{ $applicant->processing->application_comment ?? 'N/A' }}</td>
                                          </tr>
                                         <tr>
                                            <td> Scholarship Comment</td>
                                            <td>{{ $applicant->processing->scholarship_comment ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td> Tuition Comment</td>
                                            <td>{{ $applicant->processing->tuition_comment ?? 'N/A' }}</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                          @endif



                            <div class="dspr-bdy-content-sec">
                                <h2>Parents Information</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          @foreach($applicant->parents as $parent)
                                                <tr>
                                                  <td class="td-lineremover" >ID</td>
                                                  <td class="td-lineremover" >153342</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Last Name</td>
                                                  <td class="td-lineremover" >Thomas</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Father Title</td>
                                                  <td class="td-lineremover" >{{ ucfirst($parent->father_title ?? 'N/A') }}</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Father Name</td>
                                                  <td class="td-lineremover" >{{ ucfirst($parent->father_name ?? 'N/A') }} </td>
                                                </tr>

                                                <tr>
                                                  <td class="td-lineremover" >Mother  Title</td>
                                                  <td class="td-lineremover" >{{ ucfirst($parent->mother_title ?? 'N/A') }} </td>
                                                </tr>

                                                <tr>
                                                  <td class="td-lineremover" >Mother  Name</td>
                                                  <td class="td-lineremover" >{{ ucfirst($parent->mother_name ?? 'N/A') }}</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Maiden Name</td>
                                                  <td class="td-lineremover" >{{ ucfirst($parent->maiden_name ?? 'N/A') }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Address</td>
                                                  <td class="td-lineremover" >{{ $parent->pivot->address ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >City</td>
                                                  <td class="td-lineremover" >{{ $parent->pivot->city ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >State</td>
                                                  <td class="td-lineremover" >{{ $parent->pivot->state ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Zip Code</td>
                                                  <td class="td-lineremover" >{{ $parent->pivot->zip_code ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Country</td>
                                                  <td class="td-lineremover" >{{ $parent->pivot->country ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Marital Status</td>
                                                  <td class="td-lineremover" >{{ ucfirst($parent->pivot->marital_status ?? 'N/A') }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Marital Comment</td>
                                                  <td class="td-lineremover" >{{ $parent->pivot->marital_comment ?? 'N/A' }} </td>
                                                </tr>

                                                <tr>
                                                  <td class="td-lineremover" >Home Phone</td>
                                                  <td class="td-lineremover" >{{ $parent->pivot->home_phone ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Father Cell</td>
                                                  <td class="td-lineremover" >{{ $parent->father_mobile ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Mother Cell</td>
                                                  <td class="td-lineremover" >{{ $parent->mother_mobile ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Father Email</td>
                                                  <td class="td-lineremover" > {{ $parent->father_email ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Mother Email</td>
                                                  <td class="td-lineremover" >{{ $parent->mother_email ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Father Occupation</td>
                                                  <td class="td-lineremover" > {{ ucfirst($parent->father_profession ?? 'N/A') }}</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Mother Occupation</td>
                                                  <td class="td-lineremover" >{{ $parent->mother_profession ?? 'N/A' }} </td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Additional Phone Numbers</td>
                                                  <td class="td-lineremover" >{{ $parent->additional_mobile_numbers ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                  <td class="td-lineremover" >Additional Email Addresses</td>
                                                  <td class="td-lineremover" >{{ $parent->additional_emails ?? 'N/A' }}</td>
                                                </tr>
                                                
                                          @endforeach
                                         
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                           

                        </div>
                    </div>
@endsection