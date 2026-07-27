@extends('layouts.app')
@section('title', ($readonly ?? false) ? 'View Dealer' : 'Edit Dealer')
@section('content')
<div class="card">
  <form method="POST" action="{{ route('dealers.update', $dealer->id) }}" class="ajax-form" data-index-url="{{ route('dealers.index') }}">
    @csrf
    @method('PUT')
    <fieldset @disabled($readonly ?? false)>
      @include('dealers._form')
    </fieldset>
  </form>
</div>
@endsection
