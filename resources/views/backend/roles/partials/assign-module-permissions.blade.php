@forelse($modules as $panelId => $mods)
    <tr class="bg-light">
        <td colspan="6" class="fw-bold">{{ $mods->first()->panel->name ?? 'Unknown Panel' }}</td>
    </tr>

    @foreach($mods as $module)
        @php
            // $permSet = $module->permissions ? $module->permissions->keywords : [];
            $permSet = $module->permissions->first()?->keywords ?? [];
            $permOrder = ['read', 'create', 'update', 'delete'];
        @endphp

        <tr data-panel="{{ $panelId }}">
            <td>
                <input 
                    type="checkbox" 
                    name="module_id[]" 
                    value="{{ $module->id }}" 
                    class="module-select"
                    data-type="module"
                >
            </td>

            <td>{{ $module->name }}</td>

            @foreach($permOrder as $type)
                <td>
                    @if(isset($permSet[$type]))
                        <input 
                            type="checkbox"
                            name="permissions[{{ $module->id }}][{{ $type }}]"
                            value="{{ $permSet[$type] }}"
                            class="module-select"
                            data-type="{{ $type }}"
                            disabled
                        >
                    @else
                        <span class="text-muted"></span>
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
@empty
    <tr>
        <td colspan="6" class="text-center">No panels selected</td>
    </tr>
@endforelse