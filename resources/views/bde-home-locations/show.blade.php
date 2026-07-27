@extends('layouts.app')

@section('title','View BDE Home Location')

@section('page_title','View BDE Home Location')

@section('content')

<x-breadcrumb
    title="View BDE Home Location"
    parent="Masters"
    child="BDE Home Locations"
/>

<x-view-details
    :backRoute="route('bde-home-locations.index')"
    :fields="[
        'S.No' => $bdeHomeLocation->id,
        'BDE Name' => $bdeHomeLocation->bde_id,
        'Home Latitude' => $bdeHomeLocation->home_lat,
        'Home Longitude' => $bdeHomeLocation->home_long,
        'Home Address' => $bdeHomeLocation->home_address,
        'Created At' => optional($bdeHomeLocation->created_at)->format('d-m-Y h:i A'),
    ]"
/>

@endsection
