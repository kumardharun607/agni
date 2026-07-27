@extends('layouts.app')
@section('title', 'Add City')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('cities.store') }}" class="ajax-form space-y-4" data-index-url="{{ route('cities.index') }}">
    @csrf
    <div>
      <label class="form-label">State *</label>
      <select name="state_id" class="form-select" required>
        <option value="">Select State</option>
        @foreach($states as $s)
          <option value="{{ $s->id }}" @selected(old('state_id') == $s->id)>{{ $s->name }}</option>
        @endforeach
      </select>
      @error('state_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
      @error('name') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Save</button>
      <a href="{{ route('cities.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
