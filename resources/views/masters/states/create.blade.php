@extends('layouts.app')
@section('title', 'Add State')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('states.store') }}" class="ajax-form space-y-4" data-index-url="{{ route('states.index') }}">
    @csrf
    <div>
      <label class="form-label">Country *</label>
      <select name="country_id" class="form-select" required>
        <option value="">Select Country</option>
        @foreach($countries as $c)
          <option value="{{ $c->id }}" @selected(old('country_id') == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('country_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
      @error('name') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Save</button>
      <a href="{{ route('states.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
