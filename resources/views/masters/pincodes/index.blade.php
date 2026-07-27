@extends('layouts.app')
@section('title', 'Pincodes')
@section('content')

<x-page-header title="Pincodes" parent="Masters" :parent-route="route('countries.index')">
  <x-import-export feature="Pincodes" :export="route('pincodes.export')" :import="route('pincodes.import')" table="#dt" />
  @userCan('Pincodes','add')
    <a href="{{ route('pincodes.create') }}" class="btn-primary">
      <span class="material-symbols-outlined text-base">add</span> Add Pincode
    </a>
  @enduserCan
</x-page-header>

<div class="card">
  <div class="flex justify-between items-center mb-4">
    <h3 class="font-heading font-semibold text-lg text-on-surface">Pincode List</h3>
    <input type="text" id="dtSearch" placeholder="Search Pincode..." class="w-64 bg-surface-container-low border-none rounded-lg px-4 text-sm h-9 focus:ring-1 focus:ring-primary">
  </div>
  <table id="dt" class="w-full">
    <thead>
      <tr class="text-left text-[11px] uppercase text-gray-500 border-b border-border">
        <th class="py-2">#</th><th>Country</th><th>State</th><th>City</th><th>Pincode</th><th>Status</th><th class="text-right">Action</th>
      </tr>
    </thead>
  </table>
</div>
@endsection
@push('scripts')
<script>
$(function () {
  var table = $('#dt').DataTable({
    processing: true, serverSide: true, ajax: '{{ route("pincodes.data") }}',
    dom: 't<"flex items-center justify-between mt-4"ip>',
    columns: [
      { data: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'country_name', orderable: false },
      { data: 'state_name', orderable: false },
      { data: 'city_name', orderable: false },
      { data: 'pincode' },
      { data: 'status', orderable: false, searchable: false },
      { data: 'action', orderable: false, searchable: false, className: 'text-right' },
    ],
    language: { emptyTable: 'No Pincodes Found' }
  });
  $('#dtSearch').on('keyup', function () { table.search(this.value).draw(); });
});
</script>
@endpush
