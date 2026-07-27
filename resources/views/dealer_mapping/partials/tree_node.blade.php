<div class="mb-1" style="margin-left: {{ $depth * 28 }}px;">
  <div class="flex items-center gap-2 py-1.5 px-3 rounded {{ $depth == 0 ? 'bg-on-surface text-white' : 'bg-surface border border-border text-on-surface' }} inline-flex">
    <span class="text-xs font-bold uppercase">{{ $node['user']->role->name ?? '' }}</span>
    <span class="text-sm">{{ $node['user']->name }}</span>
    <span class="text-xs opacity-60">({{ $node['user']->emp_code }})</span>
  </div>
  @if(!empty($node['children']))
    <div class="mt-1">
      @foreach($node['children'] as $child)
        @include('dealer_mapping.partials.tree_node', ['node' => $child, 'depth' => $depth + 1])
      @endforeach
    </div>
  @endif
</div>
