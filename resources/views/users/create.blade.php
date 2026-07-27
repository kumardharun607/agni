@extends('layouts.app')
@section('title', 'Add User')
@section('content')
<div class="card">
  <form method="POST" action="{{ route('users.store') }}" class="ajax-form" data-index-url="{{ route('users.index') }}">
    @csrf
    @include('users._form')
  </form>
</div>
@endsection
