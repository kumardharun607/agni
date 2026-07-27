@extends('layouts.app')

@section('title','View Country')

@section('page_title','View Country')

@section('content')

<x-breadcrumb
    title="View Country"
    parent="Masters"
    child="Countries"
/>

<x-view-details
    :backRoute="route('countries.index')"
    :fields="[
        'S.No' => $country->id,
        'Country Name' => $country->country_name,
        'Status' => $country->status ? 'Active' : 'Inactive',
        'Created At' => optional($country->created_at)->format('d-m-Y h:i A'),
    ]"
/>

@endsection
