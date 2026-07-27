@extends('layouts.app')
@section('title', 'Add Dealer Mapping')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('dealer-mapping.store') }}" class="ajax-form space-y-4" data-index-url="{{ route('dealer-mapping.index') }}">
    @csrf
    <div>
      <label class="form-label">Dealer *</label>
      <select name="dealer_id" class="form-select" required>
        <option value="">Select Dealer</option>
        @foreach($dealers as $d)
          <option value="{{ $d->id }}" @selected(old('dealer_id') == $d->id)>{{ $d->name }} ({{ $d->alias_id }})</option>
        @endforeach
      </select>
      @error('dealer_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">BDE *</label>
      <select name="bde_id" class="form-select" required>
        <option value="">Select BDE</option>
        @foreach($bdes as $b)
          <option value="{{ $b->id }}" @selected(old('bde_id') == $b->id)>{{ $b->name }}</option>
        @endforeach
      </select>
      @error('bde_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Save</button>
      <a href="{{ route('dealer-mapping.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
