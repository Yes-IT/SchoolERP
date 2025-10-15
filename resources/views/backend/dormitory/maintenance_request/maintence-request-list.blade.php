

<table id="pending-request" >
    <thead style="background:#f5f5f5;">
        <tr>
            <th>S.No</th>
            <th>Issue Date</th>
            <th>Room No</th>
            <th>Due Date</th>
            <th>Problem</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($requests->where('status', 0) as $index => $req)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($req->issue_date)->format('d-m-Y') }}</td>
                <td>{{ $req->room_no }}</td>
                <td>{{ \Carbon\Carbon::parse($req->due_date)->format('d-m-Y') }}</td>
                <td>{{ $req->problem }}</td>
                <td>
                    <button style="background-color:#ffc107; padding:4px; font-size:14px;">Pending</button>
                </td>
                <td>
                <button 
                    onclick="markAsDone({{ $req->id }})"
                    id="done-btn-{{ $req->id }}"
                    style="background: var(--primary-clr); color: white; padding:9px; position: relative; left:-22px;">
                    Mark as Done
                </button>
            </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;">No pending requests</td></tr>
        @endforelse
    </tbody>
</table>



<table id="request-status"  style=" display:none;">
    <thead style="background:#f5f5f5;">
        <tr>
            <th>S.No</th>
            <th>Issue Date</th>
            <th>Room No</th>
            <th>Due Date</th>
            <th>Problem</th>
            <th>Status</th>
          
        </tr>
    </thead>
    <tbody>
        @forelse ($requests->where('status', 1) as $index => $req)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($req->issue_date)->format('d-m-Y') }}</td>
                <td>{{ $req->room_no }}</td>
                <td>{{ \Carbon\Carbon::parse($req->due_date)->format('d-m-Y') }}</td>
                <td>{{ $req->problem }}</td>
                <td>
                    <button style="background-color:green; color:white; padding:4px; font-size:14px;">Resolved</button>
                </td>
               
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;">No resolved requests</td></tr>
        @endforelse
    </tbody>
</table>


