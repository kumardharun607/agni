@extends('layouts.app')
@section('title', 'Permissions — ' . $role->name)
@section('content')
<div class="card max-w-xl mx-auto text-center p-10">
  <div class="text-red-600 text-5xl mb-4">
    <i class="fa-solid fa-lock"></i>
  </div>
  <h2 class="text-xl font-bold text-gray-900 mb-2">Admin permissions are locked</h2>
  <p class="text-gray-600 mb-6">
    The <strong>Admin</strong> role always has full access to every feature.
    Its permissions cannot be viewed or changed by anyone.
  </p>
  <a href="{{ route('permissions.index') }}"
     class="inline-block bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg">
    Back to Roles
  </a>
</div>
@endsection
