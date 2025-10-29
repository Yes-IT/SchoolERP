    <div class="ds-cmn-tble count-row" >
                                <table id="pending-request">
                                        <thead>
                <tr>
                    <th>S. No</th>
                    <th>Request Id</th>
                    <th>User Name</th> {{-- staff firstname + lastname --}}
                    <th>Product Name</th> {{-- staff table id --}}
                    <th>Category</th>
                 
                    <th>Requested Quantity</th>
                    <th>Requested Date</th>
                </tr>
            </thead>

                                    <tbody id="ProcurementBody">
                                          @foreach ($requests as $index => $req)
           <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $req->request_id }}</td>
            <td>{{ $req->user_name ?? '—' }}</td>
            <td>{{ $req->product_name ?? '—' }}</td>
            <td>{{ $req->category_name ?? '—' }}</td>
          
            <td>{{ $req->requested_qty ?? $req->inventory_qty ?? '0' }}</td>
            <td>{{ \Carbon\Carbon::parse($req->created_at)->format('d-m-Y') }}</td>
        </tr>
    @endforeach
                                    </tbody>
                                </table>



                            </div>

                            <div class="ds-cmn-tble count-row" >
                                <table id="request-status" style="display: none;">
                                              <thead>
                <tr>
                    <th>S. No</th>
                    <th>Request Id</th>
                    <th>User Name</th> {{-- staff firstname + lastname --}}
                    <th>Product Name</th> {{-- staff table id --}}
                    <th>Category</th>
                 
                    <th>Requested Quantity</th>
                    <th>Requested Date</th>
                </tr>
            </thead>

                                  <tbody id="ProcurementBody">
                                         @foreach ($requests as $index => $req)
               <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $req->request_id }}</td>
            <td>{{ $req->user_name ?? '—' }}</td>
            <td>{{ $req->product_name ?? '—' }}</td>
            <td>{{ $req->category_name ?? '—' }}</td>
          
            <td>{{ $req->requested_qty ?? $req->inventory_qty ?? '0' }}</td>
            <td>{{ \Carbon\Carbon::parse($req->created_at)->format('d-m-Y') }}</td>
        </tr>
    @endforeach
                                    </tbody>
                                </table>

                            </div>