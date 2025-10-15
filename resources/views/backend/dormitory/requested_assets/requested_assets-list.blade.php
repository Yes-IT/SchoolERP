  @php
        $filteredRequests = $requests->whereIn('status', [3, 4]);
    @endphp

    @if ($filteredRequests->isEmpty())
        <tr>
            <td colspan="5" class="text-center text-gray-500 py-3">
                No data found
            </td>
        </tr>
    @else
        @foreach ($filteredRequests as $index => $request)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $request->asset_id }}</td>
                <td>{{ $request->quantity }}</td>
                <td>{{ $request->reason }}</td>

                <td class="action-buttons">
                    @if ($request->status == 3)
                        <p class="btn-approve" data-id="{{ $request->id }}">
                            <i class="fa-solid fa-check"></i> Approve
                        </p>
                    @elseif($request->status == 4)
                        <p class="btn-reject" data-id="{{ $request->id }}">
                            <i class="fa-solid fa-xmark"></i> Reject
                        </p>
                    @endif
                </td>
            </tr>
        @endforeach
    @endif
