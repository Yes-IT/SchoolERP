    <table id="pending-request">
        <thead>
            <tr>
                <th>S. No</th>
                <th>Date</th>
                <th>Time</th>
                <th>Student Name</th>
                <th>Room</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody id="latecurfewBody">
            @foreach ($entries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $entry->date }}</td>
                    <td>{{ $entry->time }}</td>
                    <td>{{ $entry->student_name }}</td>
                    <td>{{ $entry->room }}</td>
                  @php
    $words = explode(' ', $entry->reason);
    $shortText = implode(' ', array_slice($words, 0, 2));
    $hasMore = count($words) > 2;
@endphp
<td>
    <span class="short-text">{{ $shortText }}</span>
    @if ($hasMore)
        <span class="full-text" style="display:none;">{{ $entry->reason }}</span>
        <a href="javascript:void(0);" class="read-more" onclick="toggleReadMore(this)">Read more</a>
    @endif
</td>

                </tr>
            @endforeach

            @if ($entries->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No records found</td>
                </tr>
            @endif
        </tbody>
    </table>

    <table id="request-status" style=" display:none;">
        <thead>
            <tr>
                <th>S. No</th>
                <th>Date</th>
                <th>Time</th>
                <th>Student Name</th>
                <th>Room</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="latecurfewBody">
            @foreach ($entries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $entry->date }}</td>
                    <td>{{ $entry->time }}</td>
                    <td>{{ $entry->student_name }}</td>
                    <td>{{ $entry->room }}</td>
                    <td>{{ $entry->reason }}</td>
                    <td>
                        @php
                            $statusText = '';
                            $statusClass = '';
                            switch ($entry->status) {
                                case 1:
                                    $statusText = 'Approved';
                                    $statusClass = 'btn-success';
                                    break;
                                case 2:
                                    $statusText = 'Rejected';
                                    $statusClass = 'btn-danger';
                                    break;
                                default:
                                    $statusText = 'Pending';
                                    $statusClass = 'btn-warning';
                                    break;
                            }
                        @endphp
                        <button class="btn {{ $statusClass }} btn-sm">
                            {{ $statusText }}
                        </button>
                    </td>
                </tr>
            @endforeach

            @if ($entries->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No records found</td>
                </tr>
            @endif
        </tbody>
    </table>
