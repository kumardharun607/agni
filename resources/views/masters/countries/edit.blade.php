@extends('layouts.app')
@section('title', 'Edit Country')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('countries.update', $country->id) }}" class="ajax-form space-y-4" data-index-url="{{ route('countries.index') }}">
    @csrf
    @method('PUT')
    <div>
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name', $country->name) }}" class="form-input" required>
      @error('name') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Code</label>
      <input type="text" name="code" value="{{ old('code', $country->code) }}" class="form-input" maxlength="10">
      @error('code') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Update</button>
      <a href="{{ route('countries.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
