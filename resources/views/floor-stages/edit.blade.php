@extends("layouts.app")
@section("title", isset($readonly) && $readonly ? "View Floor Stage" : "Edit Floor Stage")
@section("content")
<div class="card max-w-lg">
  <form method="POST" action="{{ route('floor-stages.update', $item->id) }}" class="ajax-form space-y-4" data-index-url="{{ route('floor-stages.index') }}">
    @csrf
    @method('PUT')
    <div>
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-input" required @if(isset($readonly) && $readonly) readonly @endif>
      @error("name") <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      @if(!isset($readonly) || !$readonly)
        <button class="btn-primary">Update</button>
      @endif
      <a href="{{ route('floor-stages.index') }}" class="btn-secondary">{{ isset($readonly) && $readonly ? 'Back' : 'Cancel' }}</a>
    </div>
  </form>
</div>
@endsection
