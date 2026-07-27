@extends('layouts.app')
@section('title', 'Add Dealer')
@section('content')
<div class="card">
  <form method="POST" action="{{ route('dealers.store') }}" class="ajax-form" data-index-url="{{ route('dealers.index') }}">
    @csrf
    @include('dealers._form')
  </form>
</div>
@endsection
