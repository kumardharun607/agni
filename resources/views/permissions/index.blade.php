@extends('layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
<div class="card">
  <p class="text-sm text-on-surface/60 mb-4">Pick a role to configure which features it can View / Add / Edit / Delete.</p>
  <div class="grid grid-cols-3 gap-4">
    @foreach($roles as $role)
      <a href="{{ route('permissions.edit', $role->id) }}" class="border border-border rounded-lg p-4 hover:border-primary transition block">
        <p class="font-heading font-semibold text-on-surface">{{ $role->name }}</p>
        <p class="text-xs text-on-surface/50 mt-1">Level {{ $role->level ?? '-' }}</p>
      </a>
    @endforeach
  </div>
</div>
@endsection
