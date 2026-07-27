<div class="mb-6">

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">

                {{ $title }}

            </h1>

            <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">

                <span>

                    Dashboard

                </span>

                <span>/</span>

                <span>

                    {{ $parent }}

                </span>

                @isset($child)

                <span>/</span>

                <span class="text-red-700">

                    {{ $child }}

                </span>

                @endisset

            </div>

        </div>

        @isset($button)

            {!! $button !!}
        @endisset

    </div>

</div>