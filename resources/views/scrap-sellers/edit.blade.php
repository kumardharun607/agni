@extends('layouts.app')

@section('title','Edit Scrap Seller')

@section('page_title','Edit Scrap Seller')

@section('content')

<x-breadcrumb
    title="Edit Scrap Seller"
    parent="Masters"
    child="Scrap Sellers"
/>

<div class="max-w-5xl mx-auto">

<form action="{{ route('scrap-sellers.update', $scrapSeller->id) }}" method="POST" enctype="multipart/form-data" data-ajax-skip>

    @csrf
    @method('PUT')

<div class="bg-white rounded-xl shadow">

    <div class="border-b px-6 py-4 flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-bold">
                Edit Scrap Seller
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Update Scrap Seller Details
            </p>

        </div>

        <a href="{{ route('scrap-sellers.index') }}"
           class="bg-gray-600 text-white px-5 py-2 rounded-lg">

            Back

        </a>

    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Alias ID --}}

        <div>

            <label class="font-semibold">Alias ID</label>

            <input type="text"
                   name="alies_id"
                   value="{{ old('alies_id',$scrapSeller->alies_id) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Company Name --}}

        <div>

            <label class="font-semibold">Company Name</label>

            <input type="text"
                   name="company_name"
                   value="{{ old('company_name',$scrapSeller->company_name) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Business Age --}}

        <div>

            <label class="font-semibold">Business Age</label>

            <input type="text"
                   name="business_age"
                   value="{{ old('business_age',$scrapSeller->business_age) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Owner Name --}}

        <div>

            <label class="font-semibold">Owner Name</label>

            <input type="text"
                   name="owner_name"
                   value="{{ old('owner_name',$scrapSeller->owner_name) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Mobile --}}

        <div>

            <label class="font-semibold">Mobile</label>

            <input type="text"
                   name="mobile"
                   value="{{ old('mobile',$scrapSeller->mobile) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Owner Type --}}

        <div>

            <label class="font-semibold">Owner Type</label>

            <select name="owner_type"
                    class="w-full border rounded-lg px-4 py-2 mt-1">

                <option value="">Select</option>

                <option value="Owner"
                    {{ old('owner_type',$scrapSeller->owner_type)=='Owner' ? 'selected' : '' }}>
                    Owner
                </option>

                <option value="Partner"
                    {{ old('owner_type',$scrapSeller->owner_type)=='Partner' ? 'selected' : '' }}>
                    Partner
                </option>

                <option value="Manager"
                    {{ old('owner_type',$scrapSeller->owner_type)=='Manager' ? 'selected' : '' }}>
                    Manager
                </option>

            </select>

        </div>

        {{-- Address --}}

        <div class="md:col-span-2 lg:col-span-3">

            <label class="font-semibold">Address</label>

            <textarea
                name="address"
                rows="3"
                class="w-full border rounded-lg px-4 py-2 mt-1">{{ old('address',$scrapSeller->address) }}</textarea>

        </div>

        {{-- GST --}}

        <div>

            <label class="font-semibold">GST No</label>

            <input type="text"
                   name="gst_no"
                   value="{{ old('gst_no',$scrapSeller->gst_no) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- PAN --}}

        <div>

            <label class="font-semibold">PAN No</label>

            <input type="text"
                   name="pan_no"
                   value="{{ old('pan_no',$scrapSeller->pan_no) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Email --}}

        <div>

            <label class="font-semibold">Email</label>

            <input type="email"
                   name="email"
                   value="{{ old('email',$scrapSeller->email) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Owner Rent --}}

        <div>

            <label class="font-semibold">Owner Rent</label>

            <input type="text"
                   name="owner_rent"
                   value="{{ old('owner_rent',$scrapSeller->owner_rent) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Godown Space --}}

        <div>

            <label class="font-semibold">Godown Space</label>

            <input type="text"
                   name="godownspace"
                   value="{{ old('godownspace',$scrapSeller->godownspace) }}"
                   class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

                {{-- Company Seller 1 --}}

        <div>

            <label class="font-semibold">
                Company Seller 1
            </label>

            <input
                type="text"
                name="company_seller1"
                value="{{ old('company_seller1',$scrapSeller->company_seller1) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Company Seller 2 --}}

        <div>

            <label class="font-semibold">
                Company Seller 2
            </label>

            <input
                type="text"
                name="company_seller2"
                value="{{ old('company_seller2',$scrapSeller->company_seller2) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Company Seller 3 --}}

        <div>

            <label class="font-semibold">
                Company Seller 3
            </label>

            <input
                type="text"
                name="company_seller3"
                value="{{ old('company_seller3',$scrapSeller->company_seller3) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Company Seller 4 --}}

        <div>

            <label class="font-semibold">
                Company Seller 4
            </label>

            <input
                type="text"
                name="company_seller4"
                value="{{ old('company_seller4',$scrapSeller->company_seller4) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Company Seller 5 --}}

        <div>

            <label class="font-semibold">
                Company Seller 5
            </label>

            <input
                type="text"
                name="company_seller5"
                value="{{ old('company_seller5',$scrapSeller->company_seller5) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Ton Month 1 --}}

        <div>

            <label class="font-semibold">
                Ton Month 1
            </label>

            <input
                type="number"
                name="tonmonth1"
                value="{{ old('tonmonth1',$scrapSeller->tonmonth1) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Ton Month 2 --}}

        <div>

            <label class="font-semibold">
                Ton Month 2
            </label>

            <input
                type="number"
                name="tonmonth2"
                value="{{ old('tonmonth2',$scrapSeller->tonmonth2) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Ton Month 3 --}}

        <div>

            <label class="font-semibold">
                Ton Month 3
            </label>

            <input
                type="number"
                name="tonmonth3"
                value="{{ old('tonmonth3',$scrapSeller->tonmonth3) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Ton Month 4 --}}

        <div>

            <label class="font-semibold">
                Ton Month 4
            </label>

            <input
                type="number"
                name="tonmonth4"
                value="{{ old('tonmonth4',$scrapSeller->tonmonth4) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Ton Month 5 --}}

        <div>

            <label class="font-semibold">
                Ton Month 5
            </label>

            <input
                type="number"
                name="tonmonth5"
                value="{{ old('tonmonth5',$scrapSeller->tonmonth5) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Total Ton --}}

        <div>

            <label class="font-semibold">
                Total Ton
            </label>

            <input
                type="number"
                name="total_ton"
                value="{{ old('total_ton',$scrapSeller->total_ton) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- Other Business --}}

        <div>

            <label class="font-semibold">
                Other Business
            </label>

            <input
                type="text"
                name="other_business"
                value="{{ old('other_business',$scrapSeller->other_business) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

        {{-- AGNI Business Value --}}

        <div>

            <label class="font-semibold">
                AGNI Business Value
            </label>

            <input
                type="text"
                name="agni_business_value"
                value="{{ old('agni_business_value',$scrapSeller->agni_business_value) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">

        </div>

                {{-- Question 1 --}}

        <div>
            <label class="font-semibold">Question 1</label>
            <input
                type="text"
                name="question1"
                value="{{ old('question1',$scrapSeller->question1) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Question 2 --}}

        <div>
            <label class="font-semibold">Question 2</label>
            <input
                type="text"
                name="question2"
                value="{{ old('question2',$scrapSeller->question2) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Question 3 --}}

        <div>
            <label class="font-semibold">Question 3</label>
            <input
                type="text"
                name="question3"
                value="{{ old('question3',$scrapSeller->question3) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Question 4 --}}

        <div>
            <label class="font-semibold">Question 4</label>
            <input
                type="text"
                name="question4"
                value="{{ old('question4',$scrapSeller->question4) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Question 5 --}}

        <div>
            <label class="font-semibold">Question 5</label>
            <input
                type="text"
                name="question5"
                value="{{ old('question5',$scrapSeller->question5) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Question 6 --}}

        <div>
            <label class="font-semibold">Question 6</label>
            <input
                type="text"
                name="question6"
                value="{{ old('question6',$scrapSeller->question6) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Question 7 --}}

        <div>
            <label class="font-semibold">Question 7</label>
            <input
                type="text"
                name="question7"
                value="{{ old('question7',$scrapSeller->question7) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Question 8 --}}

        <div>
            <label class="font-semibold">Question 8</label>
            <input
                type="text"
                name="question8"
                value="{{ old('question8',$scrapSeller->question8) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Shop Image --}}

        <div>
            <label class="font-semibold">Shop Image</label>

            @if($scrapSeller->shop_image_url)
                <img src="{{ $scrapSeller->shop_image_url }}"
                     class="w-40 h-32 object-cover rounded mb-2 border">
            @endif

            <input type="file"
                   name="shop_image"
                   class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Godown Image --}}

        <div>
            <label class="font-semibold">Godown Image</label>

            @if($scrapSeller->godown_image_url)
                <img src="{{ $scrapSeller->godown_image_url }}"
                     class="w-40 h-32 object-cover rounded mb-2 border">
            @endif

            <input type="file"
                   name="godown_image"
                   class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- PAN Card --}}

        <div>
            <label class="font-semibold">PAN Card Image</label>

            @if($scrapSeller->pancard_image_url)
                <img src="{{ $scrapSeller->pancard_image_url }}"
                     class="w-40 h-32 object-cover rounded mb-2 border">
            @endif

            <input type="file"
                   name="pancard_image"
                   class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Aadhaar Front --}}

        <div>
            <label class="font-semibold">Aadhaar Front Image</label>

            @if($scrapSeller->aadhar_front_image_url)
                <img src="{{ $scrapSeller->aadhar_front_image_url }}"
                     class="w-40 h-32 object-cover rounded mb-2 border">
            @endif

            <input type="file"
                   name="aadhar_front_image"
                   class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Aadhaar Back --}}

        <div>
            <label class="font-semibold">Aadhaar Back Image</label>

            @if($scrapSeller->aadhar_back_image_url)
                <img src="{{ $scrapSeller->aadhar_back_image_url }}"
                     class="w-40 h-32 object-cover rounded mb-2 border">
            @endif

            <input type="file"
                   name="aadhar_back_image"
                   class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Registration Certificate --}}

        <div>
            <label class="font-semibold">Registration Certificate</label>

            @if($scrapSeller->reg_certificate_image_url)
                <img src="{{ $scrapSeller->reg_certificate_image_url }}"
                     class="w-40 h-32 object-cover rounded mb-2 border">
            @endif

            <input type="file"
                   name="reg_certificate_image"
                   class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Approval --}}

        <div>
            <label class="font-semibold">Approval</label>

            <select name="approval"
                    class="w-full border rounded-lg px-4 py-2 mt-1">

                <option value="Pending"
                    {{ old('approval',$scrapSeller->approval)=='Pending' ? 'selected':'' }}>
                    Pending
                </option>

                <option value="Approved"
                    {{ old('approval',$scrapSeller->approval)=='Approved' ? 'selected':'' }}>
                    Approved
                </option>

                <option value="Rejected"
                    {{ old('approval',$scrapSeller->approval)=='Rejected' ? 'selected':'' }}>
                    Rejected
                </option>

            </select>
        </div>

        {{-- Action --}}

        <div>
            <label class="font-semibold">Action</label>

            <input
                type="text"
                name="action"
                value="{{ old('action',$scrapSeller->action) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Rep ID --}}

        <div>
            <label class="font-semibold">Rep ID</label>

            <input
                type="text"
                name="rep_id"
                value="{{ old('rep_id',$scrapSeller->rep_id) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

        {{-- Date --}}

        <div>
            <label class="font-semibold">Date</label>

            <input
                type="date"
                name="cdate"
                value="{{ old('cdate',$scrapSeller->cdate) }}"
                class="w-full border rounded-lg px-4 py-2 mt-1">
        </div>

    </div>

    <div class="border-t px-6 py-4 flex justify-end gap-3">

        <a href="{{ route('scrap-sellers.index') }}"
           class="bg-gray-600 text-white px-6 py-2 rounded-lg">

            Cancel

        </a>

        <button
            type="submit"
            class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg">

            Update Scrap Seller

        </button>

    </div>

</div>

</form>

</div>

@endsection