@extends("layouts.app")
@section("title", "Brands")
@section("content")

<x-page-header title="Brands" parent="Masters" :parent-route="route('countries.index')">
  <x-import-export feature="Brands" :export="route('brands.export')" :import="route('brands.import')" table="#dt" />
  @userCan("Brands","add")
    <a href="{{ route('brands.create') }}" class="btn-primary"><span class="material-symbols-outlined text-base">add</span> Add Brand</a>
  @enduserCan
</x-page-header>

<div class="card">
  <div class="flex justify-between items-center mb-4">
    <h3 class="font-heading font-semibold text-lg text-on-surface">Brands List</h3>
    <input type="text" id="dtSearch" placeholder="Search..." class="w-64 bg-surface-container-low border-none rounded-lg px-4 text-sm h-9 focus:ring-1 focus:ring-primary">
  </div>
  <table id="dt" class="w-full">
    <thead><tr class="text-left text-[11px] uppercase text-gray-500 border-b border-border">
      <th class="py-2">#</th><th>Name</th><th class="text-right">Action</th>
    </tr></thead>
  </table>
</div>
@endsection
@push("scripts")
<script>
$(function () {
  var table = $("#dt").DataTable({
    processing: true, serverSide: true, ajax: "{{ route('brands.data') }}",
    dom: 't<"flex items-center justify-between mt-4"ip>',
    columns: [
      { data: "DT_RowIndex", orderable: false, searchable: false },
      { data: "name" },
      { data: "action", orderable: false, searchable: false, className: "text-right" },
    ]
  });
  $("#dtSearch").on("keyup", function () { table.search(this.value).draw(); });
});
</script>
@endpush
