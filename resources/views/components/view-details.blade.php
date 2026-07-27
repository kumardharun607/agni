@props(['backRoute','fields' => []])

<div class="max-w-5xl mx-auto">

<div class="bg-white rounded-xl shadow-sm p-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @foreach($fields as $label => $value)

        <div>

            <label class="font-medium text-gray-600 text-sm">
                {{ $label }}
            </label>

            <p class="w-full border rounded-lg px-4 py-2 mt-1 bg-gray-50 text-gray-800">
                {{ $value !== null && $value !== '' ? $value : '-' }}
            </p>

        </div>

        @endforeach

    </div>

    <div class="mt-8 flex gap-3">

        <a href="{{ $backRoute }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

            Back

        </a>

    </div>

</div>

</div>
