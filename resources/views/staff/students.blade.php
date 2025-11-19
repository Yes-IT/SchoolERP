@extends('staff.master')

@section('content')
                <div class="dashboard-body dspr-body-outer">
                    <div class="ds-breadcrumb">
                        <h1>My Classes</h1>
                        <ul>
                            <li><a href="{{route('staff.dashboard')}}">Dashboard</a> /</li>
                            <li>My Classes</li>
                        </ul>
                    </div>
                    <div class="ds-pr-body">
                        <div class="table-container">
                            <div class="student-list"><h2>Students List</h2>
                                       <div class="filters">
                                            <div class="studentBtns">
                                                <div class="dropdown-week">
                                                    <button class="subjectbox" onclick="toggleDropdownSubject()">Select Year Status<img
                                                      src="{{global_asset('staff/assets/images/dropdown-arrow.svg')}}" alt="Icon"></button>
                                                    <ul class="dropdown-menu-subject">
                                                        <li>All </li>
                                                        <li class="active-week">Shana Alef</li>
                                                        <li>Shana Bais</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <div class="studentBtns">
                                                <div class="dropdown-week">
                                                    <button class="subjectbox" onclick="toggleDropdownstatus()">Select Subject <img
                                                        src="./images/dropdown-arrow.svg" alt="Icon"></button>
                                                    <ul class="dropdown-menu-status">
                                                        <li>All</li>
                                                        <li class="active-week">Melachim</li>
                                                        <li>Principles of Education</li>
                                                        <li>Lorem ipsum dolor sit amet </li>
                                                        <li>Lorem ipsum dolor sit amet </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                            </div>

                            <div class="responsive-table-wrapper">
                                <table class="student-table">
                                    <thead>
                                        <tr>
                                        <th>S. No</th>
                                        <th>Year Status</th>
                                        <th>Name</th>
                                        <th>High School</th>
                                        <th>Attendance</th>
                                        <th>Grades</th>
                                        <th>Mobile Number</th>
                                        <th>Email ID</th>
                                        <th>Parent Name</th>
                                        <th>Parent Mobile Number</th>
                                        <th>Current Address</th>
                                        <th>Hebrew Name</th>
                                        <th>Birth Country</th>
                                        <th>D.O.B</th>
                                        <th>Hebrew Birth</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td>1</td>
                                        <td>Shana Bais</td>
                                        <td>Edward Thomas</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>90%</td>
                                        <td>A</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>USA</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>

                                        <tr>
                                        <td>2</td>
                                        <td>Shana Alef</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>20%</td>
                                        <td>A-</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>Israel</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>

                                        <tr>
                                        <td>3</td>
                                        <td>Shana Bais</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>50%</td>
                                        <td>B</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>USA</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>

                                        <tr>
                                        <td>4</td>
                                        <td>Shana Bais</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>70%</td>
                                        <td>F</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>USA</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>


                                        <tr>
                                        <td>5</td>
                                        <td>Shana Alef</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>88%</td>
                                        <td>C</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>USA</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>


                                        <tr>
                                        <td>6</td>
                                        <td>Shana Alef</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>90%</td>
                                        <td>A+</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>Israel</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>


                                        <tr>
                                        <td>7</td>
                                        <td>Shana Bais</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>91.6%</td>
                                        <td>A</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>Israel</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>


                                        <tr>
                                        <td>8</td>
                                        <td>Shana Alef</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>55%</td>
                                        <td>B-</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>Israel</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>


                                        <tr>
                                        <td>9</td>
                                        <td>Shana Bais</td>
                                        <td>Lorem ipsum</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>78%</td>
                                        <td>I</td>
                                        <td>87446334747</td>
                                        <td>example@gmail.com</td>
                                        <td>Lorem ipsum</td>
                                        <td>87446334747</td>
                                        <td>56 Main Street, Suite 3, Brooklyn, NY 11210-0000</td>
                                        <td>Lorem ipsum</td>
                                        <td>USA</td>
                                        <td>10-02-1997</td>
                                        <td>׳ג אדר׳ תשנ״ז</td>
                                        </tr>
                                        <!-- Add more <tr> rows as needed -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="paginationdiv">
                                <div class="pagination-leftside">
                                    <img src="./images/leftArrowstu.svg" class="paginationArrow" />
                                    <p class="page1">1</p>
                                    <p>2</p>
                                    <p>3</p>
                                    <img src="./images/rightArrowstu.svg" class="paginationArrow" />
                                </div>

                                <div class="pagination-rightside">
                                    <p>Per page</p>
                                    <p class="paginationsecond">09 <img src="./images/heroicons.svg" class="heroicons" /></p>
                                    <p>of 170 results</p>
                                </div>
                            </div>
                        </div>

                            
                    </div>
                </div>
                    

          


 @endsection