@extends('layouts.app')
@section('title', 'Reporting Hierarchy')
@section('content')

<div class="card mb-5">
  <div class="flex justify-between items-center">
    <p class="text-sm text-on-surface/70">Hierarchy order: <strong>BDE</strong> &rarr; <strong>SO</strong> &rarr; <strong>Manager</strong> &rarr; <strong>Telecaller</strong></p>
    <a href="{{ route('dealer-mapping.map-user') }}" class="btn-primary">+ Link User in Hierarchy</a>
  </div>
</div>

<div class="card">
  @forelse($tree as $node)
    @include('dealer_mapping.partials.tree_node', ['node' => $node, 'depth' => 0])
  @empty
    <p class="text-sm text-on-surface/50">No BDE users found. Add users with the BDE role first.</p>
  @endforelse
</div>
@endsection
