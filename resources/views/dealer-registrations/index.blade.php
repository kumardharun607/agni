@extends('layouts.app')
@section('title', 'Dealer Registration')
@section('content')

<x-page-header title="Dealer Registration" parent="Masters" :parent-route="route('countries.index')">
  <x-import-export feature="Dealer Registration" :export="route('dealer-registrations.export')" :import="route('dealer-registrations.import')" table="#dt" />
  @userCan('Dealer Registration','add')
    <a href="{{ route('dealer-registrations.create') }}" class="btn-primary">
      <span class="material-symbols-outlined text-base">add</span> Add Dealer Registration
    </a>
  @enduserCan
</x-page-header>

<div class="card">
  <div class="flex justify-between items-center mb-4">
    <h3 class="font-heading font-semibold text-lg text-on-surface">Dealer Registration List</h3>
    <input type="text" id="dtSearch" placeholder="Search..." class="w-64 bg-surface-container-low border-none rounded-lg px-4 text-sm h-9 focus:ring-1 focus:ring-primary">
  </div>
  <div class="overflow-x-auto">
    <table id="dt" class="w-full">
      <thead>
        <tr class="text-left text-[11px] uppercase text-gray-500 border-b border-border">
          <th class="py-2">S.NO</th>
          <th>Apply No</th>
          <th>Alias ID</th>
          <th>Firm Name</th>
          <th>Mobile</th>
          <th>Manager</th>
          <th>SO Name</th>
          <th>Admin Status</th>
          <th class="text-right">Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
  var table = $('#dt').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("dealer-registrations.datatable") }}',
    dom: 't<"flex items-center justify-between mt-4"ip>',
    columns: [
      { data: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'apply_no' },
      { data: 'alias_id' },
      { data: 'n_of_firm' },
      { data: 'mobile_no' },
      { data: 'manager_name' },
      { data: 'so_approved_name' },
      { data: 'admin_status', orderable: false },
      { data: 'action', orderable: false, searchable: false, className: 'text-right' },
    ]
  });
  $('#dtSearch').on('keyup', function () { table.search(this.value).draw(); });
});
</script>
@endpush
