@extends('layouts.app')
@section('title', 'Edit State')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('states.update', $state->id) }}" class="ajax-form space-y-4" data-index-url="{{ route('states.index') }}">
    @csrf
    @method('PUT')
    <div>
      <label class="form-label">Country *</label>
      <select name="country_id" class="form-select" required>
        @foreach($countries as $c)
          <option value="{{ $c->id }}" @selected(old('country_id', $state->country_id) == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('country_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name', $state->name) }}" class="form-input" required>
      @error('name') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Update</button>
      <a href="{{ route('states.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
