@extends('layouts.app')

@section('title','Edit SO Home Location')

@section('page_title','Edit SO Home Location')

@section('content')

<x-breadcrumb
    title="Edit SO Home Location"
    parent="Masters"
    child="SO Home Locations"
/>

<div class="max-w-5xl mx-auto">

<div class="bg-white rounded-xl shadow-sm p-6">

    <form action="{{ route('so-home-locations.update', $soHomeLocation->id) }}" method="POST" data-ajax-skip>

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <label class="font-medium">
                    SO Name
                </label>

                <input type="text"
                       name="so_id"
                       value="{{ old('so_id',$soHomeLocation->so_id) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1">

                @error('so_id')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror

            </div>

            <div>

                <label class="font-medium">
                    Home Latitude
                </label>

                <input type="text"
                       name="home_lat"
                       value="{{ old('home_lat',$soHomeLocation->home_lat) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1">

                @error('home_lat')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror

            </div>

            <div>

                <label class="font-medium">
                    Home Longitude
                </label>

                <input type="text"
                       name="home_long"
                       value="{{ old('home_long',$soHomeLocation->home_long) }}"
                       class="w-full border rounded-lg px-4 py-2 mt-1">

                @error('home_long')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror

            </div>

            <div class="md:col-span-2">

                <label class="font-medium">
                    Home Address
                </label>

                <textarea name="home_address"
                          rows="3"
                          class="w-full border rounded-lg px-4 py-2 mt-1">{{ old('home_address',$soHomeLocation->home_address) }}</textarea>

                @error('home_address')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror

            </div>

        </div>

        <div class="mt-8 flex gap-3">

            <button type="submit"
                    class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg">

                Update

            </button>

            <a href="{{ route('so-home-locations.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

                Cancel

            </a>

        </div>

    </form>

</div>

</div>

@endsection
