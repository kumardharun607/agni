@extends('layouts.app')
@section('title', ($readonly ?? false) ? 'View User' : 'Edit User')
@section('content')
<div class="card">
  <form method="POST" action="{{ route('users.update', $user->id) }}" class="ajax-form" data-index-url="{{ route('users.index') }}">
    @csrf
    @method('PUT')
    <fieldset @disabled($readonly ?? false)>
      @include('users._form')
    </fieldset>
  </form>
</div>
@endsection
