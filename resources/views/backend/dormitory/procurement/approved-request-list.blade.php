    <div class="ds-cmn-tble count-row">
        <table id="pending-request">
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Request Id</th>
                    <th>User Name</th> {{-- staff firstname + lastname --}}
                    <th>Staff Id</th> {{-- staff table id --}}
                    <th>Item Name</th>
                    <th>Asset Type</th>
                    <th>No of Asset</th>
                    <th>Requested Quantity</th>
                    <th>Requested Date</th>
                </tr>
            </thead>

            <tbody id="approvedRequestBody">
                @foreach ($requests as $index => $req)
                    @php
                        // Map status and assign text
                        $statusMap = [
                            0 => 'Pending',
                            1 => 'Assign',
                            2 => 'Available',
                            3 => 'Rejected',
                            4 => 'Approved',
                        ];
                        $assignStatusMap = [
                            0 => 'Not Assigned',
                            1 => 'Assigned',
                        ];

                        $statusText = $statusMap[$req->status] ?? 'Unknown';
                        $assignText = $assignStatusMap[$req->assign_status] ?? 'Unknown';
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $req->id }}</td>
                        <td>{{ $req->staff_name ?? '—' }}</td> {{-- Display staff full name --}}
                        <td>{{ $req->staff_id ?? '—' }}</td> {{-- Display staff ID --}}
                        <td>{{ $req->asset_name ?? 'Unknown' }}</td> {{-- Item Name --}}
                        <td>{{ $req->asset_model ?? 'N/A' }}</td> {{-- Asset Type --}}
                        <td>{{ $req->quantity }}</td>
                        <td>{{ $req->quantity }}</td>
                        <td>
                        {{ \Carbon\Carbon::parse($req->created_at)->format('d-m-Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>



    </div>
