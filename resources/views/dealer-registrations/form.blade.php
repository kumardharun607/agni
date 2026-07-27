@extends('layouts.app')
@section('title', $dealer->exists ? 'Edit Dealer Registration' : 'Add Dealer Registration')
@section('content')
<div class="min-h-screen bg-slate-100 px-4 py-6 sm:px-6 lg:px-8">
<div class="mx-auto max-w-6xl">

<div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
<div class="flex items-center gap-3">
<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-700 text-white shadow-md">
<i class="bi bi-person-badge text-xl"></i>
</div>
<div>
<h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">{{ $dealer->exists ? 'Edit Dealer Registration' : 'Add Dealer Registration' }}</h1>
<p class="mt-1 text-sm text-slate-500">{{ $dealer->exists ? 'Update the existing dealer registration record.' : 'Fill in all sections below to register a new dealer.' }}</p>
</div>
</div>
<a href="{{ route('dealer-registrations.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100">
<i class="bi bi-arrow-left"></i>
Back to List
</a>
</div>

@if ($errors->any())
<div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">
<p class="mb-2 font-semibold">Please fix the following:</p>
<ul class="list-disc pl-5">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form action="{{ $dealer->exists ? route('dealer-registrations.update', $dealer->id) : route('dealer-registrations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="dealerForm" data-ajax-skip data-ajax-skip>
@csrf
@if ($dealer->exists)
@method('PUT')
@endif

{{-- SECTION: Basic Info --}}
<div class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-shop mr-2 text-orange-700"></i>New Dealership - Registration Form</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-3">

<x-dealer-select name="state_wise" label="State Name" required :value="old('state_wise', $dealer->state_wise)">
<option value="">-- Select --</option>
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::states() as $code => $label)
<option value="{{ $code }}" @selected(old('state_wise', $dealer->state_wise) === $code)>{{ $label }}</option>
@endforeach
</x-dealer-select>

<x-dealer-input name="n_of_firm" label="Shop Name" required :value="old('n_of_firm', $dealer->n_of_firm)" />
<x-dealer-input name="alias_id" label="Alias ID" required :value="old('alias_id', $dealer->alias_id)" />
<x-dealer-input name="n_of_propriter" label="Owner Name" required :value="old('n_of_propriter', $dealer->n_of_propriter)" />

<x-dealer-select name="dealers_type" label="Dealer Type" required :value="old('dealers_type', $dealer->dealers_type)">
<option value="">-- Select --</option>
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::dealerTypes() as $type)
<option value="{{ $type }}" @selected(old('dealers_type', $dealer->dealers_type) === $type)>{{ $type }}</option>
@endforeach
</x-dealer-select>

<div class="lg:col-span-3">
<x-dealer-textarea name="address" label="Address" required :value="old('address', $dealer->address)" />
</div>

<x-dealer-select name="shop_est_yr" label="Shop Established Year" required :value="old('shop_est_yr', $dealer->shop_est_yr)">
<option value="">-- Select --</option>
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::establishedYears() as $year)
<option value="{{ $year }}" @selected((string) old('shop_est_yr', $dealer->shop_est_yr) === (string) $year)>{{ $year }}</option>
@endforeach
</x-dealer-select>

<x-dealer-input name="age_of_bus" label="Age of Business" :value="old('age_of_bus', $dealer->age_of_bus)" placeholder="e.g. 5" />
<x-dealer-input name="mobile_no" label="Mobile No" required :value="old('mobile_no', $dealer->mobile_no)" />
<x-dealer-input name="alter_mobno1" label="Alternate Mobile 1" :value="old('alter_mobno1', $dealer->alter_mobno1)" />
<x-dealer-input name="alter_mobno2" label="Alternate Mobile 2" :value="old('alter_mobno2', $dealer->alter_mobno2)" />
<x-dealer-input type="email" name="email" label="Mail ID" required :value="old('email', $dealer->email)" />

</div>
</div>

{{-- SECTION: Bank & Firm Status --}}
<div class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-bank mr-2 text-orange-700"></i>Bank &amp; Firm Details</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-3">
<x-dealer-input name="name_add_bank" label="Name of the Bank" required :value="old('name_add_bank', $dealer->name_add_bank)" />

<div>
<label class="mb-2 block text-sm font-bold text-slate-700">Type of A/C <span class="text-red-600">*</span></label>
<div class="flex flex-wrap gap-4 pt-2">
@php $selectedAc = old('type_of_ac', $dealer->type_of_ac_array); @endphp
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::accountTypes() as $type)
<label class="inline-flex items-center gap-2 text-sm text-slate-700">
<input type="checkbox" name="type_of_ac[]" value="{{ $type }}" @checked(in_array($type, (array) $selectedAc)) class="h-4 w-4 rounded border-slate-300 text-orange-700 focus:ring-orange-500">
{{ $type }}
</label>
@endforeach
</div>
</div>

<div>
<label class="mb-2 block text-sm font-bold text-slate-700">Status of Firm <span class="text-red-600">*</span></label>
<div class="flex flex-wrap gap-4 pt-2">
@php $selectedFirm = old('status_of_firm', $dealer->status_of_firm_array); @endphp
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::firmStatuses() as $status)
<label class="inline-flex items-center gap-2 text-sm text-slate-700">
<input type="checkbox" name="status_of_firm[]" value="{{ $status }}" @checked(in_array($status, (array) $selectedFirm)) class="h-4 w-4 rounded border-slate-300 text-orange-700 focus:ring-orange-500">
{{ $status }}
</label>
@endforeach
</div>
</div>

<x-dealer-select name="own_rent" label="Own (or) Rental Shop" required :value="old('own_rent', $dealer->own_rent)">
<option value="">-- Select --</option>
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::ownRentOptions() as $value => $label)
<option value="{{ $value }}" @selected(old('own_rent', $dealer->own_rent) === $value)>{{ $label }}</option>
@endforeach
</x-dealer-select>

<div>
<label class="mb-2 block text-sm font-bold text-slate-700">Shop Area <span class="text-red-600">*</span></label>
<div class="flex">
<input type="text" name="shop_areasq" value="{{ old('shop_areasq', $dealer->shop_areasq) }}" class="w-full rounded-l-lg border border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-orange-600">
<span class="inline-flex items-center rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 px-3 text-xs font-semibold text-slate-500">SQ.FT</span>
</div>
</div>

<div>
<label class="mb-2 block text-sm font-bold text-slate-700">Godown Area <span class="text-red-600">*</span></label>
<div class="flex">
<input type="text" name="godown_areasq" value="{{ old('godown_areasq', $dealer->godown_areasq) }}" class="w-full rounded-l-lg border border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-orange-600">
<span class="inline-flex items-center rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 px-3 text-xs font-semibold text-slate-500">SQ.FT</span>
</div>
</div>

</div>
</div>

{{-- SECTION: Brand Dealing --}}
<div class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-tags mr-2 text-orange-700"></i>Brand Dealing</h2>
</div>
<div class="p-5 sm:p-7">

<p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Steel Brands</p>
<div class="mb-6 grid gap-4 sm:grid-cols-2">
@for ($i = 1; $i <= 6; $i++)
<div class="flex items-end gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3">
<div class="flex-1">
<label class="mb-1 block text-xs font-semibold text-slate-600">Steel Brand {{ $i }}</label>
<select name="shop_brand{{ $i }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
<option value="">-- Select --</option>
@foreach ($brands as $brandName)
<option value="{{ $brandName }}" @selected(old('shop_brand'.$i, $dealer->{'shop_brand'.$i}) === $brandName)>{{ $brandName }}</option>
@endforeach
</select>
</div>
<div class="w-28">
<label class="mb-1 block text-xs font-semibold text-slate-600">Ton/Month</label>
<input type="text" name="shop_month_brand{{ $i }}" value="{{ old('shop_month_brand'.$i, $dealer->{'shop_month_brand'.$i}) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
</div>
</div>
@endfor
</div>

<p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Commercial</p>
<div class="mb-6 flex flex-wrap items-end gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3">
<div class="w-56">
<label class="mb-1 block text-xs font-semibold text-slate-600">Commercial Brand</label>
<select name="commercial_brand" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
<option value="">-- Select --</option>
@foreach ($brands as $brandName)
<option value="{{ $brandName }}" @selected(old('commercial_brand', $dealer->commercial_brand) === $brandName)>{{ $brandName }}</option>
@endforeach
</select>
</div>
<div class="w-28">
<label class="mb-1 block text-xs font-semibold text-slate-600">Ton/Month</label>
<input type="text" name="commercial_ton" value="{{ old('commercial_ton', $dealer->commercial_ton) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
</div>
</div>

<p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Cement Brands</p>
<div class="mb-6 grid gap-4 sm:grid-cols-2">
@for ($i = 1; $i <= 4; $i++)
<div class="flex items-end gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3">
<div class="flex-1">
<label class="mb-1 block text-xs font-semibold text-slate-600">Cement Brand {{ $i }}</label>
<input type="text" name="cement_brand{{ $i }}" value="{{ old('cement_brand'.$i, $dealer->{'cement_brand'.$i}) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
</div>
<div class="w-28">
<label class="mb-1 block text-xs font-semibold text-slate-600">Ton/Month</label>
<input type="text" name="cement_month_cement{{ $i }}" value="{{ old('cement_month_cement'.$i, $dealer->{'cement_month_cement'.$i}) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
</div>
</div>
@endfor
</div>

<p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">If Any Other Business</p>
<div class="flex flex-wrap gap-5">
@php $selectedOther = old('other_business', $dealer->other_business_array); @endphp
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::otherBusinessOptions() as $option)
<label class="inline-flex items-center gap-2 text-sm text-slate-700">
<input type="checkbox" name="other_business[]" value="{{ $option }}" @checked(in_array($option, (array) $selectedOther)) class="h-4 w-4 rounded border-slate-300 text-orange-700 focus:ring-orange-500">
{{ $option }}
</label>
@endforeach
</div>

</div>
</div>

{{-- SECTION: Capacity --}}
<div class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-graph-up mr-2 text-orange-700"></i>Business Capacity</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-4">
<x-dealer-input name="agni_exp_ton" label="Agni Expected Tonnage" required :value="old('agni_exp_ton', $dealer->agni_exp_ton)" />
<x-dealer-input name="dealer_total_capacity" label="Dealer Total Capacity" required :value="old('dealer_total_capacity', $dealer->dealer_total_capacity)" />
<x-dealer-input name="total_turnover_month" label="Total Turnover / Month" :value="old('total_turnover_month', $dealer->total_turnover_month)" />
<x-dealer-input name="total_turnover_year" label="Total Turnover / Year" :value="old('total_turnover_year', $dealer->total_turnover_year)" />
</div>
</div>

{{-- SECTION: Nearby Agni Dealers (single card, 4 directions) --}}
<div class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-signpost-split mr-2 text-orange-700"></i>Nearby Agni Dealers</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-4">
@php
$directions = \App\Http\Controllers\DealerRegistration\DealerRegistrationController::nearbyDirections();
@endphp
@foreach ($directions as $dir)
<div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
<p class="mb-3 text-sm font-bold text-slate-700">{{ $dir['label'] }}</p>

<label class="mb-1 block text-xs font-semibold text-slate-600">Dealer Name</label>
<input type="text" name="{{ $dir['name'] }}" value="{{ old($dir['name'], $dealer->{$dir['name']}) }}" class="mb-3 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">

<label class="mb-1 block text-xs font-semibold text-slate-600">Dealer Type</label>
<select name="{{ $dir['sub'] }}" class="mb-3 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
<option value="">-- Select --</option>
@foreach (\App\Http\Controllers\DealerRegistration\DealerRegistrationController::dealerTypes() as $type)
<option value="{{ $type }}" @selected(old($dir['sub'], $dealer->{$dir['sub']}) === $type)>{{ $type }}</option>
@endforeach
</select>

<label class="mb-1 block text-xs font-semibold text-slate-600">KMS</label>
<input type="text" name="{{ $dir['dist'] }}" value="{{ old($dir['dist'], $dealer->{$dir['dist']}) }}" class="mb-3 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">

<label class="mb-1 block text-xs font-semibold text-slate-600">TON/MONTH</label>
<input type="text" name="{{ $dir['ton'] }}" value="{{ old($dir['ton'], $dealer->{$dir['ton']}) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-orange-600">
</div>
@endforeach
</div>
</div>

{{-- SECTION: Sales Officer --}}
<div class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-patch-check mr-2 text-orange-700"></i>Sales Officer</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-3">
<x-dealer-input name="so_approved_name" label="Sales Officer Name" required :value="old('so_approved_name', $dealer->so_approved_name)" />
<x-dealer-input name="manager_name" label="Sr. Marketing Manager Name" :value="old('manager_name', $dealer->manager_name)" />
</div>
<p class="px-5 pb-5 text-xs text-slate-400 sm:px-7">Manager Status and Admin Status are managed from the Dealer Registration list / admin workflow, not from this form.</p>
</div>

{{-- SECTION: Images --}}
<div class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
    <div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
        <h2 class="text-lg font-bold text-slate-800">
            <i class="bi bi-images mr-2 text-orange-700"></i>
            Shop &amp; Godown Images
        </h2>
    </div>

    <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-7">

        {{-- SHOP IMAGE --}}
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700">
                Shop Image {{ $dealer->exists ? '' : '(required)' }}
            </label>

            <input
                type="file"
                name="photo_upload1"
                id="photo_upload1"
                accept="image/jpeg,image/jpg,image/png,image/webp"
                class="mb-3 w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-orange-600"
            >

            <div class="flex flex-wrap items-start gap-4">

                {{-- EXISTING SHOP IMAGE --}}
                @if($dealer->exists && $dealer->shop_image)
                    @php
                        $shopImagePath = $dealer->shop_image;

                        if (
                            \Illuminate\Support\Str::startsWith($shopImagePath, ['http://', 'https://'])
                        ) {
                            $shopImageUrl = $shopImagePath;
                        } elseif (
                            \Illuminate\Support\Str::startsWith($shopImagePath, ['/storage/', 'storage/'])
                        ) {
                            $shopImageUrl = asset(ltrim($shopImagePath, '/'));
                        } else {
                            $shopImageUrl = asset('storage/' . ltrim($shopImagePath, '/'));
                        }
                    @endphp

                    <div>
                        <p class="mb-1 text-xs font-semibold text-slate-500">
                            Existing Image
                        </p>

                        <img
                            src="{{ $shopImageUrl }}"
                            alt="Existing Shop Image"
                            class="img-preview-fixed"
                            onerror="this.style.display='none'; document.getElementById('shop-image-error').classList.remove('hidden');"
                        >

                        <p id="shop-image-error" class="hidden mt-2 text-xs font-semibold text-red-500">
                            Shop image could not be loaded.
                        </p>
                    </div>
                @endif

                {{-- NEW SHOP IMAGE PREVIEW --}}
                <div id="shop_image_preview_wrap" class="hidden">
                    <p class="mb-1 text-xs font-semibold text-slate-500">
                        New Image
                    </p>

                    <img
                        id="shop_image_preview"
                        class="img-preview-fixed"
                        src=""
                        alt="New Shop Image Preview"
                    >
                </div>

            </div>

            <p class="mt-2 text-xs text-slate-400">
                JPG, JPEG, PNG or WEBP. Maximum size 5 MB.
            </p>
        </div>


        {{-- GODOWN IMAGE --}}
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700">
                Godown Image {{ $dealer->exists ? '' : '(required)' }}
            </label>

            <input
                type="file"
                name="photo_upload2"
                id="photo_upload2"
                accept="image/jpeg,image/jpg,image/png,image/webp"
                class="mb-3 w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-orange-600"
            >

            <div class="flex flex-wrap items-start gap-4">

                {{-- EXISTING GODOWN IMAGE --}}
                @if($dealer->exists && $dealer->godown_image)
                    @php
                        $godownImagePath = $dealer->godown_image;

                        if (
                            \Illuminate\Support\Str::startsWith($godownImagePath, ['http://', 'https://'])
                        ) {
                            $godownImageUrl = $godownImagePath;
                        } elseif (
                            \Illuminate\Support\Str::startsWith($godownImagePath, ['/storage/', 'storage/'])
                        ) {
                            $godownImageUrl = asset(ltrim($godownImagePath, '/'));
                        } else {
                            $godownImageUrl = asset('storage/' . ltrim($godownImagePath, '/'));
                        }
                    @endphp

                    <div>
                        <p class="mb-1 text-xs font-semibold text-slate-500">
                            Existing Image
                        </p>

                        <img
                            src="{{ $godownImageUrl }}"
                            alt="Existing Godown Image"
                            class="img-preview-fixed"
                            onerror="this.style.display='none'; document.getElementById('godown-image-error').classList.remove('hidden');"
                        >

                        <p id="godown-image-error" class="hidden mt-2 text-xs font-semibold text-red-500">
                            Godown image could not be loaded.
                        </p>
                    </div>
                @endif

                {{-- NEW GODOWN IMAGE PREVIEW --}}
                <div id="godown_image_preview_wrap" class="hidden">
                    <p class="mb-1 text-xs font-semibold text-slate-500">
                        New Image
                    </p>

                    <img
                        id="godown_image_preview"
                        class="img-preview-fixed"
                        src=""
                        alt="New Godown Image Preview"
                    >
                </div>

            </div>

            <p class="mt-2 text-xs text-slate-400">
                JPG, JPEG, PNG or WEBP. Maximum size 5 MB.
            </p>
        </div>

    </div>
</div>

<div class="flex flex-wrap justify-end gap-3 pb-10">
<a href="{{ route('dealer-registrations.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100">
Cancel
</a>
<button type="reset" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100">
Reset
</button>
<button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-700 px-8 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-orange-800">
<i class="bi bi-check-lg"></i>
{{ $dealer->exists ? 'Update Dealer Registration' : 'Save Dealer Registration' }}
</button>
</div>

</form>
</div>
</div>
@endsection
@push('styles')
<style>
.img-preview-fixed {
    width: 160px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
}
</style>
@endpush
@push('scripts')
<script>
$(document).ready(function () {
    function bindPreview(inputId, imgId, wrapId) {
        document.getElementById(inputId).addEventListener('change', function (e) {
            const file = e.target.files && e.target.files[0];
            const img = document.getElementById(imgId);
            const wrap = document.getElementById(wrapId);
            if (!file) { wrap.classList.add('hidden'); return; }
            const reader = new FileReader();
            reader.onload = function (ev) {
                img.src = ev.target.result;
                wrap.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    }
    bindPreview('photo_upload1', 'shop_image_preview', 'shop_image_preview_wrap');
    bindPreview('photo_upload2', 'godown_image_preview', 'godown_image_preview_wrap');
});
</script>
@endpush
