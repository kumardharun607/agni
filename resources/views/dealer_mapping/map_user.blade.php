@extends('layouts.app')
@section('title', 'Link User in Hierarchy')
@section('content')
<div class="card max-w-lg">
  <p class="text-sm text-on-surface/60 mb-4">Pick the higher-level user (parent) and the lower-level user (child) to connect them in the Telecaller &rarr; Manager &rarr; SO &rarr; BDE chain.</p>
  <form method="POST" action="{{ route('dealer-mapping.map-user.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="form-label">Parent (higher level) *</label>
      <select name="parent_id" class="form-select" required>
        <option value="">Select User</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}" @selected(old('parent_id') == $u->id)>{{ $u->name }} — {{ $u->role->name ?? '' }}</option>
        @endforeach
      </select>
      @error('parent_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Child (lower level) *</label>
      <select name="child_id" class="form-select" required>
        <option value="">Select User</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}" @selected(old('child_id') == $u->id)>{{ $u->name }} — {{ $u->role->name ?? '' }}</option>
        @endforeach
      </select>
      @error('child_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Link</button>
      <a href="{{ route('dealer-mapping.hierarchy') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
