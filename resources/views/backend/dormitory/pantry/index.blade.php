
@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')

<style>
.header{
display:flex;
flex-direction: row;
}
.right-section button{
    border: 1px solid var(--primary-clr);
    width: 80px;
    padding: 0px;
    color: var(--primary-clr);
    font-size: 14px;
    position: relative;
    left: -67px;

}
.left-section p{
color: var(--primary-clr);
    font-size: 14px;
    font-weight: 700;
    /* min-width: 27px; */
    width: 300px;
}

</style>


    
            
            <div class="ds-breadcrumb">
                <h1>Exam Schedule</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li>Exam Schedule</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-cmn-info-cards-wrp">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Inventory</h3>
                                        <p>Track access request raised by students or teachers with approval and issue status.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.inventory') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Requested Inventory</h3>
                                        <p>Manage Incoming request for pantry item with approval,issue and delivery tracking.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.requestedInventory') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                              <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Low inventory</h3>
                                        <p>Track pantry items that are low in stocks and need restocking.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.lowInventory') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                       <div class="ds-cmn-info-cards-wrp">
                        <div class="row mt-4">
                              <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Usage Report</h3>
                                        <p>Track returs,usage patterns and overdue items issued from pantry</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.usageReport') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
    <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Category Manager</h3>
                                        <p>Organize and manage item categories for efficient tracking and reporting.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.categoryManager') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                  <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Item Manager</h3>
                                        <p>Manage items entries,updates and replacement in pantry system.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.itemManager') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                       <div class="ds-cmn-info-cards-wrp">
                        <div class="row mt-4">
                              <div class="col-lg-4">
                                <div class="ds-cmn-info-card">

                                   <div class="header">
                                     <div class="ds-cmn-ic-body left-section">
                                       <i class="fa-solid fa-tv"></i>
                                        <h3>Procurement</h3>
                                        <p>Manage purchase request for new it assets and replacement in the system.</p>
                                    </div>
                                    <div class="right-section">
                                    <button>12 reports</button>
                                    </div>

                                   </div>    
                                  
                                    <div class="ds-cmn-ic-ftr">
                                      <a href="{{ route('dormitory.pantryprocurement') }}" class="cmn-btn w-100 btn-sm">View Details</a>
                                                                                                                    
                                                                                                                

                                    </div>
                                </div>
                            </div>
                        
                          
                        </div>
                    </div>

                </div>
                  
            </div>
        

        


@endsection