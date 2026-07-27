@extends('layouts.app')

@section('title','View City')

@section('page_title','View City')

@section('content')

<x-breadcrumb
    title="View City"
    parent="Masters"
    child="Cities"
/>

<x-view-details
    :backRoute="route('cities.index')"
    :fields="[
        'S.No' => $city->id,
        'City Name' => $city->city_name,
        'State' => $city->state->state_name ?? '-',
        'Country' => $city->state->country->country_name ?? '-',
        'Status' => $city->status ? 'Active' : 'Inactive',
        'Created At' => optional($city->created_at)->format('d-m-Y h:i A'),
    ]"
/>

@endsection
