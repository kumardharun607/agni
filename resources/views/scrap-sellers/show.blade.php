@extends('layouts.app')

@section('title','View Scrap Seller')

@section('page_title','View Scrap Seller')

@section('content')

<x-breadcrumb
    title="View Scrap Seller"
    parent="Business"
    child="Scrap Sellers"
/>

<x-view-details
    :backRoute="route('scrap-sellers.index')"
    :fields="[
        'S.No' => $scrapSeller->id,
        'Alies ID' => $scrapSeller->alies_id,
        'Company Name' => $scrapSeller->company_name,
        'Business Age' => $scrapSeller->business_age,
        'Owner Name' => $scrapSeller->owner_name,
        'Mobile' => $scrapSeller->mobile,
        'Owner Type' => $scrapSeller->owner_type,
        'Address' => $scrapSeller->address,
        'GST No' => $scrapSeller->gst_no,
        'PAN No' => $scrapSeller->pan_no,
        'Email' => $scrapSeller->email,
        'Owner Rent' => $scrapSeller->owner_rent,
        'Godown Space' => $scrapSeller->godownspace,
        'Company Seller 1' => $scrapSeller->company_seller1,
        'Company Seller 2' => $scrapSeller->company_seller2,
        'Company Seller 3' => $scrapSeller->company_seller3,
        'Company Seller 4' => $scrapSeller->company_seller4,
        'Company Seller 5' => $scrapSeller->company_seller5,
        'Ton Month 1' => $scrapSeller->tonmonth1,
        'Ton Month 2' => $scrapSeller->tonmonth2,
        'Ton Month 3' => $scrapSeller->tonmonth3,
        'Ton Month 4' => $scrapSeller->tonmonth4,
        'Ton Month 5' => $scrapSeller->tonmonth5,
        'Total Ton' => $scrapSeller->total_ton,
        'Other Business' => $scrapSeller->other_business,
        'Agni Business Value' => $scrapSeller->agni_business_value,
        'Question 1' => $scrapSeller->question1,
        'Question 2' => $scrapSeller->question2,
        'Question 3' => $scrapSeller->question3,
        'Question 4' => $scrapSeller->question4,
        'Question 5' => $scrapSeller->question5,
        'Question 6' => $scrapSeller->question6,
        'Question 7' => $scrapSeller->question7,
        'Question 8' => $scrapSeller->question8,
        'Rep ID' => $scrapSeller->rep_id,
        'Approval' => $scrapSeller->approval,
        'Date' => optional($scrapSeller->cdate)->format('d-m-Y'),
        'Created At' => optional($scrapSeller->created_at)->format('d-m-Y h:i A'),
    ]"
/>

<div class="max-w-5xl mx-auto mt-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Uploaded Images</h3>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @php
                $images = [
                    'Shop Image'      => $scrapSeller->shop_image,
                    'Godown Image'    => $scrapSeller->godown_image,
                    'Pancard Image'   => $scrapSeller->pancard_image,
                    'Aadhar Front'    => $scrapSeller->aadhar_front_image,
                    'Aadhar Back'     => $scrapSeller->aadhar_back_image,
                    'Reg Certificate' => $scrapSeller->reg_certificate_image,
                ];
            @endphp

            @foreach($images as $label => $path)
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ $label }}</p>

                    @if($path)
                        @php
                            $clean = ltrim(str_replace('\\', '/', $path), '/');

                            // Your files live under public/uploads/...
                            // DB path example: uploads/scrap-sellers/shop-images/xxx.jpg
                            $imageUrl = null;
                            $fileExists = false;

                            // 1) Path relative to public/ (uploads/...)
                            if (file_exists(public_path($clean))) {
                                $fileExists = true;
                                $imageUrl = asset($clean);
                            }
                            // 2) Laravel public disk (storage/app/public/...)
                            elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($clean)) {
                                $fileExists = true;
                                $imageUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($clean);
                            }
                            // 3) Path already includes storage/
                            elseif (str_starts_with($clean, 'storage/') && file_exists(public_path($clean))) {
                                $fileExists = true;
                                $imageUrl = asset($clean);
                            }
                            // 4) Fallback URL (may 404 if file really missing)
                            else {
                                if (str_starts_with($clean, 'uploads/')) {
                                    $imageUrl = asset($clean);
                                } else {
                                    $imageUrl = asset('storage/' . $clean);
                                }
                            }
                        @endphp

                        @if($fileExists)
                            <a href="{{ $imageUrl }}" target="_blank" rel="noopener">
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $label }}"
                                     class="w-full h-32 object-cover rounded-lg border hover:opacity-90 transition">
                            </a>
                        @else
                            <div class="w-full h-32 flex flex-col items-center justify-center bg-yellow-50 rounded-lg border border-yellow-200 text-yellow-700 text-xs p-2 text-center">
                                <span>File missing on disk</span>
                                <span class="mt-1 break-all opacity-70">{{ $clean }}</span>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-32 flex items-center justify-center bg-gray-50 rounded-lg border text-gray-400 text-sm">
                            No Image
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
