<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dealer Registration - {{ $dealer->application_no }}</title>
<style>
    @page { margin: 22px 32px 34px 32px; }
    body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10.5px; color: #1e293b; }
    .header { text-align: center; margin-bottom: 4px; }
    .header img { height: 42px; }
    .title { text-align: center; font-size: 15px; font-weight: bold; color: #9a3412; margin: 4px 0 1px; text-transform: uppercase; }
    .subtitle { text-align: center; font-size: 11px; font-weight: bold; color: #334155; margin-bottom: 10px; }
    table.info { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
    table.info td { border: 1px solid #94a3b8; padding: 4px 7px; font-size: 10px; vertical-align: top; }
    table.info td.label { width: 26%; font-weight: bold; background: #f8fafc; color: #475569; }
    .section-title { background: #9a3412; color: #ffffff; font-size: 10.5px; font-weight: bold; padding: 5px 9px; margin: 9px 0 5px; text-transform: uppercase; }
    table.grid { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
    table.grid th, table.grid td { border: 1px solid #94a3b8; padding: 4px 7px; font-size: 9.5px; text-align: left; }
    table.grid th { background: #f1f5f9; font-weight: bold; color: #334155; }
    .images-row { width: 100%; margin-top: 4px; }
    .images-row td { text-align: center; border: 1px solid #94a3b8; padding: 10px; width: 50%; vertical-align: middle; height: 200px; }
    .images-row img { width: 240px; height: 170px; object-fit: contain; border: 1px solid #cbd5e1; }
    .no-image { font-size: 9.5px; color: #94a3b8; }
    .footer-note { position: fixed; bottom: -18px; left: 0; right: 0; text-align: center; font-size: 8.5px; color: #94a3b8; }
</style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('images/agni-logo.png') }}" alt="Agni Steels">
</div>
<div class="title">New Dealership</div>
<div class="subtitle">Registration Form</div>

<table class="info">
    <tr>
        <td class="label">State Name</td><td>{{ $dealer->state_label }}</td>
        <td class="label">Application No</td><td>{{ $dealer->application_no }}</td>
    </tr>
    <tr>
        <td class="label">Shop Name</td><td>{{ $dealer->n_of_firm ?: '-' }}</td>
        <td class="label">Alias ID</td><td>{{ $dealer->alias_id ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">Owner Name</td><td>{{ $dealer->n_of_propriter ?: '-' }}</td>
        <td class="label">Dealer Type</td><td>{{ $dealer->dealers_type ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">Address</td><td colspan="3">{{ $dealer->address ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">Shop Established Year</td><td>{{ $dealer->shop_est_yr ?: '-' }}</td>
        <td class="label">Age of Business</td><td>{{ $dealer->age_of_bus ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">Mobile No</td><td>{{ $dealer->mobile_no ?: '-' }}</td>
        <td class="label">Mail ID</td><td>{{ $dealer->email ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">Name of the Bank</td><td>{{ $dealer->name_add_bank ?: '-' }}</td>
        <td class="label">Type of A/C</td><td>{{ $dealer->type_of_ac ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">Status of Firm</td><td>{{ $dealer->status_of_firm ?: '-' }}</td>
        <td class="label">Own (or) Rental Shop</td><td>{{ \App\Http\Controllers\DealerRegistration\DealerRegistrationController::ownRentOptions()[$dealer->own_rent] ?? ($dealer->own_rent ?: '-') }}</td>
    </tr>
    <tr>
        <td class="label">Shop Area (SQ.FT.)</td><td>{{ $dealer->shop_areasq ?: '-' }}</td>
        <td class="label">Godown Area (SQ.FT.)</td><td>{{ $dealer->godown_areasq ?: '-' }}</td>
    </tr>
</table>

<div class="section-title">Brand Dealing</div>
<table class="grid">
    <thead>
        <tr><th>Steel Brand</th><th>Ton/Month</th><th>Cement Brand</th><th>Ton/Month</th></tr>
    </thead>
    <tbody>
        @for ($i = 1; $i <= 6; $i++)
        <tr>
            <td>{{ $dealer->{'shop_brand'.$i} ?: '-' }}</td>
            <td>{{ $dealer->{'shop_month_brand'.$i} ?: '-' }}</td>
            @if ($i <= 4)
                <td>{{ $dealer->{'cement_brand'.$i} ?: '-' }}</td>
                <td>{{ $dealer->{'cement_month_cement'.$i} ?: '-' }}</td>
            @else
                <td>-</td><td>-</td>
            @endif
        </tr>
        @endfor
        <tr>
            <td><strong>Commercial: {{ $dealer->commercial_brand ?: '-' }}</strong></td>
            <td>{{ $dealer->commercial_ton ?: '-' }}</td>
            <td>-</td><td>-</td>
        </tr>
    </tbody>
</table>

<table class="info">
    <tr>
        <td class="label">If Any Other Business</td><td colspan="3">{{ $dealer->other_business ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">Agni-Expected Tonnage</td><td>{{ $dealer->agni_exp_ton ?: '-' }}</td>
        <td class="label">Dealer Total Capacity</td><td>{{ $dealer->dealer_total_capacity ?: '-' }}</td>
    </tr>
</table>

<div class="section-title">Nearby Agni Dealers</div>
<table class="grid">
    <thead>
        <tr>
            <th>&nbsp;</th>
            @foreach ($directions as $dir)
                <th>{{ $dir['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Dealer Name</strong></td>
            @foreach ($directions as $dir)<td>{{ $dealer->{$dir['name']} ?: '-' }}</td>@endforeach
        </tr>
        <tr>
            <td><strong>Type</strong></td>
            @foreach ($directions as $dir)<td>{{ $dealer->{$dir['sub']} ?: '-' }}</td>@endforeach
        </tr>
        <tr>
            <td><strong>Tonnage/Month</strong></td>
            @foreach ($directions as $dir)<td>{{ $dealer->{$dir['ton']} ?: '-' }}</td>@endforeach
        </tr>
        <tr>
            <td><strong>KMS</strong></td>
            @foreach ($directions as $dir)<td>{{ $dealer->{$dir['dist']} ?: '-' }}</td>@endforeach
        </tr>
    </tbody>
</table>

<div class="section-title">Sales Officer / Sr. Marketing Manager</div>
<table class="grid">
    <thead>
        <tr><th>Sales Officer</th><th>Sr. Marketing Manager</th></tr>
    </thead>
    <tbody>
        <tr>
            <td>Name: {{ $dealer->so_approved_name ?: '-' }}</td>
            <td>Name: {{ $dealer->manager_name ?: '-' }}</td>
        </tr>
    </tbody>
</table>

<div class="section-title">Shop / Godown Images</div>
<table class="images-row">
    <tr>
        <td>
            <div style="font-weight:bold;font-size:9.5px;margin-bottom:4px;">SHOP IMAGE</div>
            @if ($dealer->photo_upload1 && \Illuminate\Support\Facades\Storage::disk('public')->exists($dealer->photo_upload1))
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->path($dealer->photo_upload1) }}">
            @else
                <div class="no-image">No image uploaded</div>
            @endif
        </td>
        <td>
            <div style="font-weight:bold;font-size:9.5px;margin-bottom:4px;">GODOWN IMAGE</div>
            @if ($dealer->photo_upload2 && \Illuminate\Support\Facades\Storage::disk('public')->exists($dealer->photo_upload2))
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->path($dealer->photo_upload2) }}">
            @else
                <div class="no-image">No image uploaded</div>
            @endif
        </td>
    </tr>
</table>

<div class="footer-note">Agni Steels &bull; Dealer Registration &bull; {{ $dealer->application_no }}</div>

</body>
</html>
