@extends('layouts.app')
@section('title', 'Add Pincode')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('pincodes.store') }}" class="ajax-form space-y-4" data-index-url="{{ route('pincodes.index') }}">
    @csrf
    <div>
      <label class="form-label">City *</label>
      <select name="city_id" class="form-select" required>
        <option value="">Select City</option>
        @foreach($cities as $c)
          <option value="{{ $c->id }}" @selected(old('city_id') == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('city_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="form-label">Pincode *</label>
      <input type="text" name="pincode" value="{{ old('pincode') }}" class="form-input" required maxlength="10">
      @error('pincode') <p class="error-text">{{ $message }}</p> @enderror
    </div>
    <div class="flex gap-3 pt-2">
      <button class="btn-primary">Save</button>
      <a href="{{ route('pincodes.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
