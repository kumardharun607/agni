@extends('layouts.app')

@section('title','View Scrap Distributor')

@section('page_title','View Scrap Distributor')

@section('content')

<x-breadcrumb
    title="View Scrap Distributor"
    parent="Business"
    child="Scrap Distributors"
/>

<x-view-details
    :backRoute="route('scrap-distributors.index')"
    :fields="[
        'S.No' => $scrapDistributor->id,
        'Rep ID' => $scrapDistributor->rep_id,
        'Name' => $scrapDistributor->name,
        'Customer Name' => $scrapDistributor->customer_name,
        'Mobile' => $scrapDistributor->mobile,
        'Country' => $scrapDistributor->country->name ?? '-',
        'State' => $scrapDistributor->state->name ?? '-',
        'City' => $scrapDistributor->city->name ?? '-',
        'Pincode' => $scrapDistributor->pincode->pincode ?? '-',
        'Address' => $scrapDistributor->address,
        'GST No' => $scrapDistributor->gst_no,
        'PAN No' => $scrapDistributor->pan_no,
        'Email' => $scrapDistributor->email,
        'Latitude' => $scrapDistributor->latitude,
        'Longitude' => $scrapDistributor->longitude,
        'DOB' => optional($scrapDistributor->dob)->format('d-m-Y'),
        'Date' => optional($scrapDistributor->date)->format('d-m-Y'),
        'Created At' => optional($scrapDistributor->created_at)->format('d-m-Y h:i A'),
    ]"
/>

@endsection
