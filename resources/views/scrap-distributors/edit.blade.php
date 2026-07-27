@extends('layouts.app')

@section('title','Edit Scrap Distributor')

@section('page_title','Edit Scrap Distributor')

@section('content')

<x-breadcrumb
    title="Edit Scrap Distributor"
    parent="Masters"
    child="Scrap Distributor"
/>

<div class="max-w-5xl mx-auto">

<form action="{{ route('scrap-distributors.update', $scrapDistributor->id) }}"
      method="POST"
      enctype="multipart/form-data"
      data-ajax-skip>

    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl shadow border">

        <div class="border-b px-6 py-4">
            <h2 class="text-xl font-bold">Edit Scrap Distributor</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 p-6">

            <div>
                <label class="font-medium">Rep ID</label>
                <input type="text" name="rep_id" value="{{ old('rep_id', $scrapDistributor->rep_id) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('rep_id') border-red-500 @enderror">
                @error('rep_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Distributor Name <span class="text-red-600">*</span></label>
                <input type="text" name="name" value="{{ old('name', $scrapDistributor->name) }}" required
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Customer Name <span class="text-red-600">*</span></label>
                <input type="text" name="customer_name" value="{{ old('customer_name', $scrapDistributor->customer_name) }}" required
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('customer_name') border-red-500 @enderror">
                @error('customer_name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Mobile <span class="text-red-600">*</span></label>
                <input type="text" name="mobile" value="{{ old('mobile', $scrapDistributor->mobile) }}" required
                       inputmode="numeric" pattern="[0-9]{10,15}"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('mobile') border-red-500 @enderror">
                @error('mobile')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Country <span class="text-red-600">*</span></label>
                <select name="country_id" required
                        class="w-full border rounded-lg px-4 py-2 mt-1 @error('country_id') border-red-500 @enderror">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" @selected(old('country_id', $scrapDistributor->country_id) == $country->id)>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">State <span class="text-red-600">*</span></label>
                <select name="state_id" required
                        class="w-full border rounded-lg px-4 py-2 mt-1 @error('state_id') border-red-500 @enderror">
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" @selected(old('state_id', $scrapDistributor->state_id) == $state->id)>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
                @error('state_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">City <span class="text-red-600">*</span></label>
                <select name="city_id" required
                        class="w-full border rounded-lg px-4 py-2 mt-1 @error('city_id') border-red-500 @enderror">
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" @selected(old('city_id', $scrapDistributor->city_id) == $city->id)>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Pincode <span class="text-red-600">*</span></label>
                <select name="pincode_id" required
                        class="w-full border rounded-lg px-4 py-2 mt-1 @error('pincode_id') border-red-500 @enderror">
                    <option value="">Select Pincode</option>
                    @foreach($pincodes as $pincode)
                        <option value="{{ $pincode->id }}" @selected(old('pincode_id', $scrapDistributor->pincode_id) == $pincode->id)>
                            {{ $pincode->pincode }}
                        </option>
                    @endforeach
                </select>
                @error('pincode_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="font-medium">Address <span class="text-red-600">*</span></label>
                <textarea name="address" rows="3" required
                          class="w-full border rounded-lg px-4 py-2 mt-1 @error('address') border-red-500 @enderror">{{ old('address', $scrapDistributor->address) }}</textarea>
                @error('address')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">GST No</label>
                <input type="text" name="gst_no" value="{{ old('gst_no', $scrapDistributor->gst_no) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('gst_no') border-red-500 @enderror">
                @error('gst_no')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">PAN No</label>
                <input type="text" name="pan_no" value="{{ old('pan_no', $scrapDistributor->pan_no) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('pan_no') border-red-500 @enderror">
                @error('pan_no')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $scrapDistributor->email) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('email') border-red-500 @enderror">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Image</label>
                @if($scrapDistributor->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$scrapDistributor->image) }}"
                             class="w-24 h-24 rounded-lg border object-cover" alt="">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('image') border-red-500 @enderror">
                @error('image')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Latitude</label>
                <input type="text" name="latitude" value="{{ old('latitude', $scrapDistributor->latitude) }}"
                       inputmode="decimal"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('latitude') border-red-500 @enderror">
                @error('latitude')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Longitude</label>
                <input type="text" name="longitude" value="{{ old('longitude', $scrapDistributor->longitude) }}"
                       inputmode="decimal"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('longitude') border-red-500 @enderror">
                @error('longitude')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">DOB</label>
                <input type="date" name="dob" value="{{ old('dob', optional($scrapDistributor->dob)->format('Y-m-d')) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('dob') border-red-500 @enderror">
                @error('dob')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="font-medium">Date</label>
                <input type="date" name="date" value="{{ old('date', optional($scrapDistributor->date)->format('Y-m-d')) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1 @error('date') border-red-500 @enderror">
                @error('date')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

        </div>

        <div class="border-t p-6 flex justify-end gap-3">
            <a href="{{ route('scrap-distributors.index') }}"
               class="px-6 py-2 rounded-lg border">Cancel</a>
            <button type="submit"
                    class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg">
                Update
            </button>
        </div>

    </div>

</form>

</div>

@endsection
