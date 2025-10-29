@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
.input-grp select{
width: 150px;
    height: 44px;
    position: relative;
    left: 159px;
    border-radius: 2px;
    background: var(--primary-clr);
    color: white;
}
.available-btn{
background-color: green;
color: white;
font-size: 14px;
}

.assigned-btn{
background-color: yellowgreen;
color: white;
font-size: 14px;
}
.pending-btn{
background-color: red;
color: white;
font-size: 14px;

}

</style>



@section('content')

      

            <div class="ds-breadcrumb">
                <h1>It assets</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">IT</a> /</li>
                    <li>IT assets</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">

                  

                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                        <div class="ds-content-head">
                            <div class="sec-head">
                                <h3 class="h2-title">Assets list</h3>
                            </div>
                            <div class="btn-wrp align-items-start">
                                <div class="input-grp search-field mb-0">
                                    <div class="input-grp fees-type">
                                      <select id="assetTypeFilter" onchange="filterAssets()">
                                        <option value="">Asset Type</option>
                                        <option value="Monitor">Monitor</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="Mouse">Mouse</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ds-cmn-tble count-row">
                            <table>
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                      
                                         <th>Asset Model</th>
                                        <th>Asset Type</th>
                                       
                                        <th>Availibility Status</th>
                                        <th>Requested Date</th>
                                       
                                    </tr>
                                </thead>
                                <tbody id="assetsBody">
                                    @include('backend.dormitory.it-assets.it-assets-list')

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
      
@endsection
