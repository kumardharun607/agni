@extends('layouts.app')

@section('title','Import SO Home Location')

@section('content')

<div class="bg-white rounded-lg shadow-md p-6">

    <h2 class="text-3xl font-bold mb-6">
        Import SO Home Location
    </h2>

    
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('so-home-locations.import.store') }}"
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

            <a href="{{ route('so-home-locations.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

                Cancel

            </a>

        </div>

    </form>

</div>

@endsection