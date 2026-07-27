@extends('layouts.app')
@section('title', 'Permissions — ' . $role->name)
@section('content')
<div class="card">
  <form method="POST" action="{{ route('permissions.update', $role->id) }}" class="ajax-form" data-index-url="{{ route('permissions.index') }}">
    @csrf
    @method('PUT')
    <table class="w-full">
      <thead>
        <tr class="text-left text-[11px] uppercase text-on-surface/60 border-b border-border">
          <th class="py-2">Feature</th>
          <th class="text-center">View</th>
          <th class="text-center">Add</th>
          <th class="text-center">Edit</th>
          <th class="text-center">Delete</th>
          <th class="text-center">Import</th>
          <th class="text-center">Export</th>
        </tr>
      </thead>
      <tbody>
        @foreach($features as $feature)
          @php $ep = $existing[$feature->id] ?? null; @endphp
          <tr class="border-b border-border/60 feature-row" data-feature="{{ $feature->id }}">
            <td class="py-2 text-sm">{{ $feature->name }}</td>
            <td class="text-center">
              <input type="checkbox" class="perm-view" name="permissions[{{ $feature->id }}][view]" value="1" @checked($ep?->can_view)>
            </td>
            <td class="text-center">
              <input type="checkbox" class="perm-add" name="permissions[{{ $feature->id }}][add]" value="1" @checked($ep?->can_add)>
            </td>
            <td class="text-center">
              <input type="checkbox" class="perm-edit" name="permissions[{{ $feature->id }}][edit]" value="1" @checked($ep?->can_edit)>
            </td>
            <td class="text-center">
              <input type="checkbox" name="permissions[{{ $feature->id }}][delete]" value="1" @checked($ep?->can_delete)>
            </td>
            <td class="text-center">
              <input type="checkbox" name="permissions[{{ $feature->id }}][import]" value="1" @checked($ep?->can_import)>
            </td>
            <td class="text-center">
              <input type="checkbox" name="permissions[{{ $feature->id }}][export]" value="1" @checked($ep?->can_export)>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="flex gap-3 pt-6">
      @userCan('Permissions','edit')
        <button class="btn-primary">Save Permissions</button>
      @enduserCan
      <a href="{{ route('permissions.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
// Unticking "Add" or "Edit" immediately removes that ability for this role —
// the checkbox state itself is the source of truth and is what gets submitted/saved.
// We also keep View in sync: Add/Edit/Delete require View to be checked, since without
// View access a role can't reach the list screen to use Add/Edit/Delete anyway.
document.querySelectorAll('.feature-row').forEach(function (row) {
  const view = row.querySelector('.perm-view');
  const others = row.querySelectorAll('.perm-add, .perm-edit, input[type=checkbox]:not(.perm-view)');

  view.addEventListener('change', function () {
    if (!view.checked) {
      others.forEach(cb => { cb.checked = false; });
    }
  });

  others.forEach(function (cb) {
    cb.addEventListener('change', function () {
      if (cb.checked) view.checked = true;
    });
  });
});
</script>
@endpush
