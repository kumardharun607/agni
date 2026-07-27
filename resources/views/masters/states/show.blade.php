@extends('layouts.app')

@section('title','View State')

@section('page_title','View State')

@section('content')

<x-breadcrumb
    title="View State"
    parent="Masters"
    child="States"
/>

<x-view-details
    :backRoute="route('states.index')"
    :fields="[
        'S.No' => $state->id,
        'State Name' => $state->state_name,
        'Country' => $state->country->country_name ?? '-',
        'Status' => $state->status ? 'Active' : 'Inactive',
        'Created At' => optional($state->created_at)->format('d-m-Y h:i A'),
    ]"
/>

@endsection
