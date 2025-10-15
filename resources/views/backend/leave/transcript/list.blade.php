<div class="ds-cmn-table-wrp tab-wrapper">
    
    <!-- Pending Transcripts Table -->
    <div class="ds-cmn-tble pending count-row {{ $tab == 'pending' ? 'active' : '' }}" style="{{ $tab == 'pending' ? '' : 'display: none;' }}">
        <table>
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Date</th>
                    <th>Destination</th>
                    <th>Payment Requirements</th>
                    <th>Payment Status</th>
                    <th>Payment Receipt</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($pendingTranscripts as $index => $transcript)
                    <tr>
                        <td>{{ $pendingTranscripts->firstItem() + $index }}</td>
                        <td>{{ $transcript->created_at ? \Carbon\Carbon::parse($transcript->created_at)->format('m/d/Y') : 'N/A' }}</td>
                        <td>{{ $transcript->destination ?? 'N/A' }}</td>
                        <td>{{ ucfirst($transcript->payment_requirement ?? 'N/A') }}</td>
                        <td>
                            <div class="upcoming cmn-tbl-btn {{ $transcript->payment_status == 'paid' ? 'green-bg' : ($transcript->payment_status == 'failed' ? 'red-bg' : 'yellow-bg') }}">
                                {{ ucfirst($transcript->payment_status ?? 'N/A') }}
                            </div>
                        </td>
                        <td>
                            @if($transcript->payment_receipt_link)
                                <a href="{{ $transcript->payment_receipt_link }}" class="cmn-tbl-btn gap-10" download>
                                    <img src="{{ asset('backend/assets/images/new_images/download-icon.svg') }}" alt="Icon"> Download
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>
                            @if($transcript->status == 'pending')
                                <button class="upcoming cmn-tbl-btn green-bg approve-transcript" data-id="{{ $transcript->id }}">Approve</button>
                                <button class="upcoming cmn-tbl-btn red-bg reject-transcript" data-id="{{ $transcript->id }}">Reject</button>
                            @else
                                <p class="{{ $transcript->status == 'approved' ? 'green-txt' : 'red-txt' }}">{{ ucfirst($transcript->status ?? 'N/A') }}</p>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="color: black">No pending transcripts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>

    <!-- Final Transcripts Table -->
    <div class="ds-cmn-tble final count-row {{ $tab == 'final' ? 'active' : '' }}" style="{{ $tab == 'final' ? '' : 'display: none;' }}">
        <table>
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Date</th>
                    <th>Destination</th>
                    <th>Payment Requirements</th>
                    <th>Payment Status</th>
                    <th>Payment Receipt</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($finalTranscripts as $index => $transcript)
                    <tr>
                        <td>{{ $finalTranscripts->firstItem() + $index }}</td>
                        <td>{{ $transcript->created_at ? \Carbon\Carbon::parse($transcript->created_at)->format('m/d/Y') : 'N/A' }}</td>
                        <td>{{ $transcript->destination ?? 'N/A' }}</td>
                        <td>{{ ucfirst($transcript->payment_requirement ?? 'N/A') }}</td>
                        <td>
                            <div class="upcoming cmn-tbl-btn {{ $transcript->payment_status == 'paid' ? 'green-bg' : ($transcript->payment_status == 'failed' ? 'red-bg' : 'yellow-bg') }}">
                                {{ ucfirst($transcript->payment_status ?? 'N/A') }}
                            </div>
                        </td>
                        <td>
                            @if($transcript->payment_receipt_link)
                                <a href="{{ $transcript->payment_receipt_link }}" class="cmn-tbl-btn gap-10" download>
                                    <img src="{{ asset('backend/assets/images/new_images/download-icon.svg') }}" alt="Icon"> Download
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>
                            <p class="{{ $transcript->status == 'approved' ? 'green-txt' : 'red-txt' }}">{{ ucfirst($transcript->status ?? 'N/A') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="color: black">No final transcripts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>
</div>