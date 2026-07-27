@extends('layouts.app')
@section('title', 'Edit Role')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('roles.update', $role->id) }}" class="ajax-form space-y-4" data-index-url="{{ route('roles.index') }}">
    @csrf
    @method('PUT')
    <div>
      <label class="form-label">Role Name *</label>
      <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-input" required>
      @error('name') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Hierarchy Level (1=Telecaller ... 4=BDE)</label>
      <input type="number" name="level" min="1" max="4" value="{{ old('level', $role->level) }}" class="form-input">
      @error('level') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Update</button>
      <a href="{{ route('roles.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
