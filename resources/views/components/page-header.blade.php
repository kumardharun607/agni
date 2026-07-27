@props(['title', 'parent' => null, 'parentRoute' => null])

<div class="flex items-start justify-between mb-6 flex-wrap gap-4">
  <div>
    <h1 class="font-heading text-2xl font-bold text-on-surface">{{ $title }}</h1>
    <p class="text-xs text-gray-500 mt-1">
      <a href="{{ route('dashboard') }}" class="hover:text-primary">Dashboard</a>
      @if($parent)
        / <a href="{{ $parentRoute ?? '#' }}" class="hover:text-primary">{{ $parent }}</a>
      @endif
      / <span class="text-primary font-semibold">{{ $title }}</span>
    </p>
  </div>

  <div class="flex items-center gap-2 flex-wrap">
    {{ $slot }}
  </div>
</div>
