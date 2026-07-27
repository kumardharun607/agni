@extends('layouts.app')
@section('title', ($readonly ?? false) ? 'View Dealer Mapping' : 'Edit Dealer Mapping')
@section('content')
<div class="card max-w-lg">
  <form method="POST" action="{{ route('dealer-mapping.update', $item->id) }}" class="ajax-form space-y-4" data-index-url="{{ route('dealer-mapping.index') }}">
    @csrf
    @method('PUT')
    <fieldset @disabled($readonly ?? false) class="space-y-4">
      <div>
        <label class="form-label">Dealer *</label>
        <select name="dealer_id" class="form-select" required>
          @foreach($dealers as $d)
            <option value="{{ $d->id }}" @selected(old('dealer_id', $item->dealer_id) == $d->id)>{{ $d->name }} ({{ $d->alias_id }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="form-label">BDE *</label>
        <select name="bde_id" class="form-select" required>
          @foreach($bdes as $b)
            <option value="{{ $b->id }}" @selected(old('bde_id', $item->bde_id) == $b->id)>{{ $b->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex gap-3 pt-2">
        @unless($readonly ?? false)
          <button class="btn-primary">Update</button>
        @endunless
        <a href="{{ route('dealer-mapping.index') }}" class="btn-secondary">{{ ($readonly ?? false) ? 'Back' : 'Cancel' }}</a>
      </div>
    </fieldset>
  </form>
</div>
@endsection
