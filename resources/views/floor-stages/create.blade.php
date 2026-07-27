@extends("layouts.app")
@section("title", "Add Floor Stage")
@section("content")
<div class="card max-w-lg">
  <form method="POST" action="{{ route('floor-stages.store') }}" class="ajax-form space-y-4" data-index-url="{{ route('floor-stages.index') }}">
    @csrf
    <div>
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
      @error("name") <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Save</button>
      <a href="{{ route('floor-stages.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
