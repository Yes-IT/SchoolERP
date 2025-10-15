
     @foreach ($it_assets as $asset)
            <tr>
                <td>{{ $asset->request_id }}</td>
               
                <td>{{ $asset->model }}</td>
                <td>{{ $asset->name}}</td>
           <td>
            @if ($asset->request_status === 0)
                <button class="status-btn bg-green-500 text-white px-2 py-1 available-btn">Available</button>
            @elseif($asset->request_status === 1)
                <button class="status-btn bg-yellow-500 text-white px-2 py-1 assigned-btn">Assigned</button>
            @elseif($asset->request_status === 2)
                <button class="status-btn bg-red-500 text-white px-2 py-1 pending-btn">Pending</button>
            @else
                <button
                    class="status-btn bg-gray-400 text-white px-2 py-1 rounded">{{ $asset->request_status }}</button>
            @endif
        </td>
                  
                  <td>{{ $asset->request_created_at }}</td>
            </tr>
        @endforeach
      
           