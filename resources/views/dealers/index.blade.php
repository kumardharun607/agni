@extends('layouts.app')
@section('title', 'Dealers')
@section('content')

<x-page-header title="Dealers" parent="Masters" :parent-route="route('countries.index')">
  <x-import-export feature="Dealer" :export="route('dealers.export')" :import="route('dealers.import')" table="#dt" />
  @userCan('Dealer','add')
    <a href="{{ route('dealers.create') }}" class="btn-primary"><span class="material-symbols-outlined text-base">add</span> Add Dealer</a>
  @enduserCan
</x-page-header>

<div class="card">
  <div class="flex justify-between items-center mb-4">
    <h3 class="font-heading font-semibold text-lg text-on-surface">Dealer List</h3>
    <input type="text" id="dtSearch" placeholder="Search Dealer..." class="w-64 bg-surface-container-low border-none rounded-lg px-4 text-sm h-9 focus:ring-1 focus:ring-primary">
  </div>
  <table id="dt" class="w-full">
    <thead>
      <tr class="text-left text-[11px] uppercase text-gray-500 border-b border-border">
        <th class="py-2">#</th>
        <th>Alias ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Parent Dealer</th>
        <th>Mobile</th>
        <th class="text-center">View Map</th>
        <th class="text-right">Action</th>
      </tr>
    </thead>
  </table>
</div>
@endsection
@push('scripts')
<script>
$(function () {
  var table = $('#dt').DataTable({
    processing: true, serverSide: true, ajax: '{{ route("dealers.data") }}',
    dom: 't<"flex items-center justify-between mt-4"ip>',
    columns: [
      { data: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'alias_id' },
      { data: 'name' },
      { data: 'client_type_label', orderable: false },
      { data: 'parent_dealer_name', orderable: false },
      { data: 'mobile' },
      { data: 'view_map', orderable: false, searchable: false, className: 'text-center' },
      { data: 'action', orderable: false, searchable: false, className: 'text-right' },
    ]
  });
  $('#dtSearch').on('keyup', function () { table.search(this.value).draw(); });
});
</script>
@endpush
