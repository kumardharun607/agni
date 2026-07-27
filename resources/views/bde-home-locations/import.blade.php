@extends('layouts.app')

@section('title','Import BDE Home Location')

@section('content')

<div class="bg-white rounded-lg shadow-md p-6">

    <h2 class="text-3xl font-bold mb-6">
        Import BDE Home Location
    </h2>

    <form action="{{ route('bde-home-locations.import.store') }}"
          method="POST"
          enctype="multipart/form-data"
          data-ajax-skip>

        @csrf

        <div class="border border-gray-300 rounded p-3 mb-5">

            <input
                type="file"
                name="file"
                class="w-full">

            @error('file')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex gap-3">

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

                Import

            </button>

            <a href="{{ route('bde-home-locations.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

                Cancel

            </a>

        </div>

    </form>

</div>

@endsection