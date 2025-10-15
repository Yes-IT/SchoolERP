    <tbody id="doctorsDataBody">

        @foreach ($doctors as $index => $doctor)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $doctor->entry_date }}</td>
                <td>{{ $doctor->student_id }}</td>

                <td>{{ $doctor->name }}</td>
                <td>{{ $doctor->description }}</td>
                @php
                    $words = explode(' ', $doctor->description);
                    $shortText = implode(' ', array_slice($words, 0, 2));
                    $hasMore = count($words) > 2;
                @endphp
                <td>
                    <span class="short-text">{{ $shortText }}</span>
                    @if ($hasMore)
                        <span class="full-text" style="display:none;">{{ $doctor->description }}</span>
                        <a href="javascript:void(0);" class="read-more" onclick="toggleReadMore(this)">Read more</a>
                    @endif
                </td>
                <td>
                    {{ $doctor->issue }}
                </td>





            </tr>
        @endforeach

    </tbody>
