
     @foreach ($it_assets as $asset)
            <tr>
                <td>{{ $asset->id }}</td>
                <td>{{ $asset->asset_id }}</td>
                <td>{{ $asset->asset_model }}</td>
                <td>{{ $asset->asset_type }}</td>
           <td>
            @if ($asset->availability_status === 'Available')
                <button class="status-btn bg-green-500 text-white px-2 py-1 available-btn">Available</button>
            @elseif($asset->availability_status === 'Assigned')
                <button class="status-btn bg-yellow-500 text-white px-2 py-1 assigned-btn">Assigned</button>
            @elseif($asset->availability_status === 'Pending')
                <button class="status-btn bg-red-500 text-white px-2 py-1 pending-btn">Pending</button>
            @else
                <button
                    class="status-btn bg-gray-400 text-white px-2 py-1 rounded">{{ $asset->availability_status }}</button>
            @endif
        </td>
                  
                <td>{{ $asset->requested_date }}</td>
            </tr>
        @endforeach
      
           