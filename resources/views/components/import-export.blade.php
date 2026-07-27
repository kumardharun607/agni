{{--
    Generic "Import Excel" / "Export Excel" button pair.
    Import navigates to a dedicated import page (no modal popup).
    Export downloads Excel/CSV and must skip the SPA ajax interceptor.
--}}
@props(['export', 'import', 'table' => '#dt', 'sample' => null, 'feature' => null])

@if(!$feature || userCan($feature, 'import'))
<a href="{{ $import }}"
   class="btn-import"
   data-load="ajax">
  <span class="material-symbols-outlined text-base">upload_file</span> Import Excel
</a>
@endif

@if(!$feature || userCan($feature, 'export'))
<a href="{{ $export }}"
   class="btn-export"
   data-ajax-skip
   download>
  <span class="material-symbols-outlined text-base">download</span> Export Excel
</a>
@endif
