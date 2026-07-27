@extends('layouts.app')
@section('title', 'Add Role')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('roles.store') }}" class="ajax-form space-y-4" data-index-url="{{ route('roles.index') }}">
    @csrf
    <div>
      <label class="form-label">Role Name *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-input" required placeholder="Telecaller / Manager / SO / BDE">
      @error('name') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Hierarchy Level (1=Telecaller ... 4=BDE)</label>
      <input type="number" name="level" min="1" max="4" value="{{ old('level') }}" class="form-input">
      @error('level') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Save</button>
      <a href="{{ route('roles.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
