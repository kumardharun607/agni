@extends('layouts.app')
@section('title', 'Dealer Registration Details')
@section('content')
<div class="min-h-screen bg-slate-100 px-4 py-6 sm:px-6 lg:px-8">
<div class="mx-auto max-w-6xl">

<div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
<div class="flex items-center gap-3">
<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-700 text-white shadow-md">
<i class="bi bi-eye text-xl"></i>
</div>
<div>
<h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">Dealer Registration Details</h1>
<p class="mt-1 text-sm text-slate-500">Read-only view. Use Edit to change this registration.</p>
</div>
</div>
<div class="flex flex-wrap gap-3">
<a href="{{ route('dealer-registrations.pdf', $dealer->id) }}" target="_blank"
class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700">
<i class="bi bi-file-earmark-pdf"></i> Download PDF
</a>
@userCan('Dealer Registration','view')
<a href="{{ route('dealer-registrations.edit', $dealer->id) }}"
class="inline-flex items-center gap-2 rounded-lg bg-orange-700 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-orange-800">
<i class="bi bi-pencil-square"></i> Edit
</a>
@enduserCan
<a href="{{ route('dealer-registrations.index') }}"
class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100">
<i class="bi bi-arrow-left"></i> Back to List
</a>
</div>
</div>

@php
$directions = \App\Http\Controllers\DealerRegistration\DealerRegistrationController::nearbyDirections();
@endphp

{{-- SECTION: Application --}}
<div class="mb-6 overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-card-checklist mr-2 text-orange-700"></i>Application</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-4">
<div class="detail-item"><p class="detail-label">Application No</p><p class="detail-value">{{ $dealer->application_no }}</p></div>
<div class="detail-item"><p class="detail-label">Alias ID</p><p class="detail-value">{{ $dealer->alias_id ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">State</p><p class="detail-value">{{ $dealer->state_label }}</p></div>
<div class="detail-item"><p class="detail-label">Dealer Type</p><p class="detail-value">{{ $dealer->dealers_type ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Manager Status</p><p class="detail-value">{{ $dealer->manager_status ?: 'Pending' }}</p></div>
<div class="detail-item"><p class="detail-label">Admin Status</p><p class="detail-value">{{ $dealer->admin_status ?: 'Pending' }}</p></div>
<div class="detail-item"><p class="detail-label">Manager Name</p><p class="detail-value">{{ $dealer->manager_name ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Created</p><p class="detail-value">{{ $dealer->created_at?->format('d-m-Y h:i A') ?? '-' }}</p></div>
</div>
</div>

{{-- SECTION: Basic / Contact --}}
<div class="mb-6 overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-shop mr-2 text-orange-700"></i>Dealer &amp; Contact Information</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-3">
<div class="detail-item"><p class="detail-label">Shop Name</p><p class="detail-value">{{ $dealer->n_of_firm ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Owner Name</p><p class="detail-value">{{ $dealer->n_of_propriter ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Shop Established Year</p><p class="detail-value">{{ $dealer->shop_est_yr ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Age of Business</p><p class="detail-value">{{ $dealer->age_of_bus ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Mobile No</p><p class="detail-value">{{ $dealer->mobile_no ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Alternate Mobile 1</p><p class="detail-value">{{ $dealer->alter_mobno1 ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Alternate Mobile 2</p><p class="detail-value">{{ $dealer->alter_mobno2 ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Email</p><p class="detail-value">{{ $dealer->email ?: '-' }}</p></div>
<div class="detail-item sm:col-span-2 lg:col-span-3"><p class="detail-label">Address</p><p class="detail-value">{{ $dealer->address ?: '-' }}</p></div>
</div>
</div>

{{-- SECTION: Bank / Firm --}}
<div class="mb-6 overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-bank mr-2 text-orange-700"></i>Bank &amp; Firm Details</h2>
</div>
<div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-3">
<div class="detail-item"><p class="detail-label">Name of the Bank</p><p class="detail-value">{{ $dealer->name_add_bank ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Type of A/C</p><p class="detail-value">{{ $dealer->type_of_ac ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Status of Firm</p><p class="detail-value">{{ $dealer->status_of_firm ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Own / Rental Shop</p><p class="detail-value">{{ \App\Http\Controllers\DealerRegistration\DealerRegistrationController::ownRentOptions()[$dealer->own_rent] ?? ($dealer->own_rent ?: '-') }}</p></div>
<div class="detail-item"><p class="detail-label">Shop Area (SQ.FT)</p><p class="detail-value">{{ $dealer->shop_areasq ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Godown Area (SQ.FT)</p><p class="detail-value">{{ $dealer->godown_areasq ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Other Business</p><p class="detail-value">{{ $dealer->other_business ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Agni Expected Tonnage</p><p class="detail-value">{{ $dealer->agni_exp_ton ?: '-' }}</p></div>
<div class="detail-item"><p class="detail-label">Dealer Total Capacity</p><p class="detail-value">{{ $dealer->dealer_total_capacity ?: '-' }}</p></div>
</div>
</div>

{{-- SECTION: Brand Dealing --}}
<div class="mb-6 overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-tags mr-2 text-orange-700"></i>Brand Dealing</h2>
</div>
<div class="p-5 sm:p-7">
<p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Steel</p>
<div class="mb-6 overflow-x-auto rounded-xl border border-slate-300">
<table class="w-full min-w-[420px] border-collapse text-left text-sm">
<thead class="bg-slate-100"><tr>
<th class="border border-slate-300 px-4 py-2 font-bold">S.No</th>
<th class="border border-slate-300 px-4 py-2 font-bold">Steel Brand</th>
<th class="border border-slate-300 px-4 py-2 font-bold">Ton/Month</th>
</tr></thead>
<tbody>
@for ($i = 1; $i <= 6; $i++)
<tr><td class="border border-slate-300 px-4 py-2">{{ $i }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{'shop_brand'.$i} ?: '-' }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{'shop_month_brand'.$i} ?: '-' }}</td></tr>
@endfor
<tr class="bg-slate-50 font-semibold">
<td class="border border-slate-300 px-4 py-2">-</td>
<td class="border border-slate-300 px-4 py-2">Commercial: {{ $dealer->commercial_brand ?: '-' }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->commercial_ton ?: '-' }}</td>
</tr>
</tbody>
</table>
</div>

<p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Cement</p>
<div class="overflow-x-auto rounded-xl border border-slate-300">
<table class="w-full min-w-[420px] border-collapse text-left text-sm">
<thead class="bg-slate-100"><tr>
<th class="border border-slate-300 px-4 py-2 font-bold">S.No</th>
<th class="border border-slate-300 px-4 py-2 font-bold">Cement Brand</th>
<th class="border border-slate-300 px-4 py-2 font-bold">Ton/Month</th>
</tr></thead>
<tbody>
@for ($i = 1; $i <= 4; $i++)
<tr><td class="border border-slate-300 px-4 py-2">{{ $i }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{'cement_brand'.$i} ?: '-' }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{'cement_month_cement'.$i} ?: '-' }}</td></tr>
@endfor
</tbody>
</table>
</div>
</div>
</div>

{{-- SECTION: Nearby Agni Dealers --}}
<div class="mb-6 overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
<div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
<h2 class="text-lg font-bold text-slate-800"><i class="bi bi-signpost-split mr-2 text-orange-700"></i>Nearby Agni Dealers</h2>
</div>
<div class="overflow-x-auto p-5 sm:p-7">
<table class="w-full min-w-[640px] border-collapse text-left text-sm">
<thead class="bg-slate-100"><tr>
<th class="border border-slate-300 px-4 py-2 font-bold">Direction</th>
<th class="border border-slate-300 px-4 py-2 font-bold">Dealer Name</th>
<th class="border border-slate-300 px-4 py-2 font-bold">Dealer Type</th>
<th class="border border-slate-300 px-4 py-2 font-bold">KMS</th>
<th class="border border-slate-300 px-4 py-2 font-bold">TON/MONTH</th>
</tr></thead>
<tbody>
@foreach ($directions as $dir)
<tr>
<td class="border border-slate-300 px-4 py-2 font-semibold">{{ $dir['label'] }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{$dir['name']} ?: '-' }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{$dir['sub']} ?: '-' }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{$dir['dist']} ?: '-' }}</td>
<td class="border border-slate-300 px-4 py-2">{{ $dealer->{$dir['ton']} ?: '-' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

{{-- SECTION: Sales / Images --}}
<div class="mb-10 overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg">
    <div class="border-b border-orange-200 bg-orange-50 px-5 py-4 sm:px-7">
        <h2 class="text-lg font-bold text-slate-800">
            <i class="bi bi-patch-check mr-2 text-orange-700"></i>
            Sales Officer & Images
        </h2>
    </div>

    {{-- Sales Officer --}}
    <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7">
        <div class="detail-item">
            <p class="detail-label">Sales Officer Name</p>
            <p class="detail-value">
                {{ $dealer->so_approved_name ?: '-' }}
            </p>
        </div>

        <div class="detail-item">
            <p class="detail-label">Sr. Marketing Manager (Manager Name)</p>
            <p class="detail-value">
                {{ $dealer->manager_name ?: '-' }}
            </p>
        </div>
    </div>

    {{-- Images --}}
    <div class="grid gap-6 border-t border-slate-200 p-5 sm:grid-cols-2 sm:p-7">

        {{-- SHOP IMAGE --}}
        <div class="rounded-xl border border-slate-300 bg-slate-50 p-5 text-center">

            <p class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                Shop Image
            </p>

            @if(!empty($dealer->shop_image))
                <a href="{{ asset('storage/' . $dealer->shop_image) }}"
                   target="_blank"
                   class="inline-block">

                    <img
                        src="{{ asset('storage/' . $dealer->shop_image) }}"
                        alt="Shop Image"
                        class="mx-auto rounded-lg border border-slate-300 object-cover shadow-sm"
                        style="width: 260px; height: 200px;"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                    >
                </a>

                <p class="mt-3 hidden text-sm font-medium text-red-500">
                    Unable to load shop image.
                </p>
            @else
                <div class="flex h-[200px] items-center justify-center">
                    <p class="text-sm text-slate-400">
                        No shop image uploaded
                    </p>
                </div>
            @endif

        </div>


        {{-- GODOWN IMAGE --}}
        <div class="rounded-xl border border-slate-300 bg-slate-50 p-5 text-center">

            <p class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                Godown Image
            </p>

            @if(!empty($dealer->godown_image))
                <a href="{{ asset('storage/' . $dealer->godown_image) }}"
                   target="_blank"
                   class="inline-block">

                    <img
                        src="{{ asset('storage/' . $dealer->godown_image) }}"
                        alt="Godown Image"
                        class="mx-auto rounded-lg border border-slate-300 object-cover shadow-sm"
                        style="width: 260px; height: 200px;"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                    >
                </a>

                <p class="mt-3 hidden text-sm font-medium text-red-500">
                    Unable to load godown image.
                </p>
            @else
                <div class="flex h-[200px] items-center justify-center">
                    <p class="text-sm text-slate-400">
                        No godown image uploaded
                    </p>
                </div>
            @endif

        </div>

    </div>
</div>
</div>
</div>
@endsection
@push('styles')
<style>
.detail-item { border-left: 2px solid #fed7aa; padding-left: 12px }
.detail-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; margin-bottom: 2px }
.detail-value { font-size: 14px; font-weight: 600; color: #334155; word-break: break-word; }
</style>
@endpush
