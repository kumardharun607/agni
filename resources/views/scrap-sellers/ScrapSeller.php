<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScrapSeller extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'alies_id',
        'company_name',
        'business_age',
        'owner_name',
        'mobile',
        'owner_type',
        'address',
        'gst_no',
        'pan_no',
        'email',
        'owner_rent',
        'godownspace',
        'company_seller1',
        'company_seller2',
        'company_seller3',
        'company_seller4',
        'company_seller5',
        'tonmonth1',
        'tonmonth2',
        'tonmonth3',
        'tonmonth4',
        'tonmonth5',
        'total_ton',
        'other_business',
        'agni_business_value',
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
        'question6',
        'question7',
        'question8',
        'shop_image',
        'godown_image',
        'pancard_image',
        'aadhar_front_image',
        'aadhar_back_image',
        'reg_certificate_image',
        'action',
        'cdate',
        'rep_id',
        'approval',
    ];

    protected $casts = [
        'cdate' => 'date',
    ];

    public function imageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    public function getShopImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->shop_image);
    }

    public function getGodownImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->godown_image);
    }

    public function getPancardImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->pancard_image);
    }

    public function getAadharFrontImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->aadhar_front_image);
    }

    public function getAadharBackImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->aadhar_back_image);
    }

    public function getRegCertificateImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->reg_certificate_image);
    }
}
