@if($row->latitude && $row->longitude)
  <a href="https://www.google.com/maps/search/?api=1&query={{ $row->latitude }},{{ $row->longitude }}"
     target="_blank" rel="noopener"
     class="inline-flex items-center justify-center w-8 h-8 rounded-full text-tertiary hover:bg-gray-100-container transition"
     title="View on Google Maps">
    <span class="material-symbols-outlined text-lg">location_on</span>
  </a>
@else
  <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-gray-500/30" title="No location saved for this dealer">
    <span class="material-symbols-outlined text-lg">location_off</span>
  </span>
@endif
