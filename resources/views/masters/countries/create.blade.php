@extends('layouts.app')
@section('title', 'Add Country')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('countries.store') }}" class="ajax-form space-y-4" data-index-url="{{ route('countries.index') }}">
    @csrf
    <div>
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
      @error('name') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Code</label>
      <input type="text" name="code" value="{{ old('code') }}" class="form-input" maxlength="10">
      @error('code') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Save</button>
      <a href="{{ route('countries.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
