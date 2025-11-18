@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Teacher') }}
@endsection



@section('content')

<style>
.calendar-table {
    width: 100%;
    table-layout: fixed;  /* ensures widths are respected */
    border-collapse: collapse;
}

.calendar-table thead th.slot-header {
    width: 30% !important;
    white-space: nowrap;
    min-width: 100px;
    text-align: center;
    background-color: #f9f9f9; /* optional */
}

.scheduled {
    width: 130px !important;
}

</style>

<div class="ds-breadcrumb">
    <h1>Room Management</h1>
    <ul>
        <li><a href="../dashboard.html">Dashboard</a> /</li>
        <li><a href="./dashboard.html">Room Management</a> /</li>
        <li>Room Availability</li>
    </ul>
</div>

<div class="ds-pr-body">
    <div class="classes-schedule-container ds-calendar-pg">
        <div class="classes-schedule-filter">
            <div class="sec-head"><h2>Room Availability</h2></div>

            <div class="datepicker">
                <div class="datepicker__header">
                    <img src="{{ global_asset('backend/assets/images/calender-icon.svg') }}" alt="Icon">
                    <span id="range-display">Jan, 2025</span>   {{-- default text – will be overwritten by JS --}}
                </div>

                <div class="datepicker-body-wrp">
                    <div class="datepicker__body">
                        <select id="year-select"></select>
                        <select id="month-select"></select>
                        <select id="week-select"></select>
                    </div>
                    <div class="datepicker__footer">
                        <button class="datepicker__btn datepicker__btn--cancel cmn-btn" id="btn-cancel">Cancel</button>
                        <button class="datepicker__btn datepicker__btn--apply cmn-btn" id="btn-apply">Apply</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="boxtbl-outer">
            <div class="box-table-container">
                <table class="calendar-table" role="grid" aria-label="Room availability">
                    <thead>
                        <tr>
                            <th>Room / Time</th>
                            {{-- time-slot headers are built from JS --}}
                            <th class="slot-header" v-for="label in timeSlots" v-html="label"></th>
                        </tr>
                    </thead>
                    <tbody id="availability-tbody">
                        {{-- rows are injected by renderTable() --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    // --------------------------------------------------------------
    // 1. Helper – turn “Nov 01, 2025” → “2025-11-01”
    // --------------------------------------------------------------
    function parseDateFromText(dateStr) {
        dateStr = dateStr.replace(/[^\w\s,]/g, '').trim();
        const parts = dateStr.split(/\s+/);
        const monthAbbr = parts[0];
        const dayRaw    = parts[1].replace(/,$/, '');
        const year      = parts[2];
        const day       = dayRaw.replace(/[^\d]/g, '').padStart(2, '0');

        const months = {
            Jan:'01',Feb:'02',Mar:'03',Apr:'04',May:'05',Jun:'06',
            Jul:'07',Aug:'08',Sep:'09',Oct:'10',Nov:'11',Dec:'12'
        };
        return `${year}-${months[monthAbbr]}-${day}`;
    }

    // --------------------------------------------------------------
    // 2. AJAX call
    // --------------------------------------------------------------
    function loadAvailability(from, to) {
        $.ajax({
            url: '{{ route("room_management.availability.data") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                from_date: from,
                to_date: to
            },
            success: function (res) {
                renderTable(res.days, res.time_slots);
            },
            error: function (xhr) {
                console.error(xhr.responseJSON);
                alert('Error loading data');
            }
        });
    }

    // --------------------------------------------------------------
    // 3. Render the whole table (days + rooms + slots)
    // --------------------------------------------------------------
    function renderTable(days, timeSlots) {
        // ---- header (time slots) ----
        const thead = $('.calendar-table thead tr');
        thead.find('th.slot-header').remove();               // clear old
        timeSlots.forEach(label => {
            thead.append(`<th class="slot-header">${label}</th>`);
        });

        // ---- body ----
        const tbody = $('#availability-tbody');
        tbody.empty();

        days.forEach(day => {
            // one <tr> per room
            day.rooms.forEach(room => {
                const tr = $('<tr>');

                // first column: Day + Room
                const firstTd = $(`
                    <td class="room-day">
                        <strong>${day.date}</strong><br>
                        <strong>Room: ${room.room_no}</strong><br>
                        <strong>Capacity: ${room.capacity}</strong>
                    </td>
                    `);
                tr.append(firstTd);

                // slots
                room.slots.forEach(slot => {
                    const td = $('<td>');

                    if (slot.status === 'scheduled') {
                        const title = slot.title || '';
                        const meta  = slot.meta  || '';
                        td.html(`
                            <div class="scheduled">
                                <div class="tag">Scheduled</div>
                                <div class="title">${title}</div>
                                <div class="meta">${meta}</div>
                            </div>
                        `);
                    } else {
                        td.html(`<div class="cell-center"><div class="available">Available</div></div>`);
                    }
                    tr.append(td);
                });

                tbody.append(tr);
            });
        });
    }

    // --------------------------------------------------------------
    // 4. “Apply” button
    // --------------------------------------------------------------
    $('#btn-apply').on('click', function () {
        const rangeText = $('#range-display').text().trim();
        if (!rangeText.includes('–')) return;

        const [startPart, endPart] = rangeText.split('–').map(s => s.trim());
        const from = parseDateFromText(startPart);
        const to   = parseDateFromText(endPart);

        loadAvailability(from, to);
    });

    // --------------------------------------------------------------
    // 5. **Load on page ready** – use the default text in #range-display
    // --------------------------------------------------------------
    $(function () {
        const defaultRange = $('#range-display').text().trim();
        if (defaultRange && defaultRange.includes('–')) {
            const [startPart, endPart] = defaultRange.split('–').map(s => s.trim());
            const from = parseDateFromText(startPart);
            const to   = parseDateFromText(endPart);
            loadAvailability(from, to);
        } else {
            // fallback – today + 6 days (you can change)
            const today = moment().format('YYYY-MM-DD');
            const next  = moment().add(6, 'days').format('YYYY-MM-DD');
            loadAvailability(today, next);
        }
    });
</script>
@endpush