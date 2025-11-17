@foreach ($grouped as $panelId => $rows)
    <div class="ds-cmn-tble-in-pop-outer">
        <div class="ds-tbl-wrp-inr-small-head">
            <h3>{{ $rows->first()->panel->name }}</h3>
        </div>

        <div class="ds-cmn-tble">
            <table>
                <thead>
                    <tr>
                        <th>Menus</th>
                        <th>Permissions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($rows as $item)
                        @php
                            $perms = $item->permissions ?? [];

                            $active = [];
                            if (!empty($perms['read']))   $active[] = 'Read';
                            if (!empty($perms['create'])) $active[] = 'Add';
                            if (!empty($perms['update'])) $active[] = 'Edit';
                            if (!empty($perms['delete'])) $active[] = 'Delete';
                        @endphp

                        <tr>
                            <td>{{ $item->module->name }}</td>
                            <td>
                                <div class="permissions-wrp">
                                    @forelse ($active as $p)
                                        <span>{{ $p }}</span>
                                    @empty
                                        <span>-</span>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach