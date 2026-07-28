@extends('layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
<div class="card">
  <p class="text-sm text-on-surface/60 mb-4">Pick a role to configure which features it can View / Add / Edit / Delete.</p>
  <div class="grid grid-cols-3 gap-4">
    @foreach($roles as $role)
      @if(strcasecmp($role->name, 'Admin') === 0)
        {{-- Admin permissions are locked — not editable by anyone --}}
        <div class="border border-border rounded-lg p-4 bg-gray-50 opacity-90 cursor-not-allowed" title="Admin always has full access. Permissions cannot be changed.">
          <p class="font-heading font-semibold text-on-surface flex items-center gap-2">
            {{ $role->name }}
            <span class="text-[10px] uppercase tracking-wide bg-red-100 text-red-700 px-2 py-0.5 rounded">Locked</span>
          </p>
          <p class="text-xs text-on-surface/50 mt-1">Level {{ $role->level ?? '-' }}</p>
          <p class="text-xs text-red-600 mt-2">Admin always has full access. Permissions cannot be modified.</p>
        </div>
      @else
        <a href="{{ route('permissions.edit', $role->id) }}" class="border border-border rounded-lg p-4 hover:border-primary transition block">
          <p class="font-heading font-semibold text-on-surface">{{ $role->name }}</p>
          <p class="text-xs text-on-surface/50 mt-1">Level {{ $role->level ?? '-' }}</p>
        </a>
      @endif
    @endforeach
  </div>
</div>
@endsection
