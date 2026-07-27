@extends('layouts.app')

@section('title','View SO Home Location')

@section('page_title','View SO Home Location')

@section('content')

<x-breadcrumb
    title="View SO Home Location"
    parent="Masters"
    child="SO Home Locations"
/>

<x-view-details
    :backRoute="route('so-home-locations.index')"
    :fields="[
        'S.No' => $soHomeLocation->id,
        'SO Name' => $soHomeLocation->so_id,
        'Home Latitude' => $soHomeLocation->home_lat,
        'Home Longitude' => $soHomeLocation->home_long,
        'Home Address' => $soHomeLocation->home_address,
        'Created At' => optional($soHomeLocation->created_at)->format('d-m-Y h:i A'),
    ]"
/>

@endsection
