@extends("layouts.app")
@section("title", ($readonly ?? false) ? "View Sales Stage" : "Edit Sales Stage")
@section("content")
<div class="card max-w-lg">
  <form method="POST" action="{{ route('sales-stage.update', $item->id) }}" class="ajax-form space-y-4" data-index-url="{{ route('sales-stage.index') }}">
    @csrf
    @method("PUT")
    <fieldset @disabled($readonly ?? false) class="space-y-4">
      <div>
        <label class="form-label">Name *</label>
        <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-input" required>
        @error("name") <p class="error-text">{{ $message }}</p> @enderror
      </div>
      <div class="flex gap-3 pt-2">
        @unless($readonly ?? false)
          <button class="btn-primary">Update</button>
        @endunless
        <a href="{{ route('sales-stage.index') }}" class="btn-secondary">{{ ($readonly ?? false) ? 'Back' : 'Cancel' }}</a>
      </div>
    </fieldset>
  </form>
</div>
@endsection
