@extends('layouts.app')

@section('title','View Pincode')

@section('page_title','View Pincode')

@section('content')

<x-breadcrumb
    title="View Pincode"
    parent="Masters"
    child="Pincodes"
/>

<x-view-details
    :backRoute="route('pincodes.index')"
    :fields="[
        'S.No' => $pincode->id,
        'Pincode' => $pincode->pincode,
        'City' => $pincode->city->city_name ?? '-',
        'State' => $pincode->city->state->state_name ?? '-',
        'Country' => $pincode->city->state->country->country_name ?? '-',
        'Status' => $pincode->status ? 'Active' : 'Inactive',
        'Created At' => optional($pincode->created_at)->format('d-m-Y h:i A'),
    ]"
/>

@endsection
