<div class="ds-cmn-tble count-row">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>College Name</th>
                <th>Funded</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($colleges as $index => $college)
                <tr>
                    <td style="color: #000">{{ $colleges->firstItem() + $index }}</td>
                    <td>{{ $college->name }}</td>
                    <td>{{ $college->is_funded ? 'Yes' : 'No' }}</td>
                    <td>{{ number_format($college->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($college->date)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="color: #000">No college records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>