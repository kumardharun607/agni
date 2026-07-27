<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerRegistration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dealer_registrations';

    protected $fillable = [
        'alias_id',
        'apply_id',
        'state_wise',
        'serial_no',
        'apply_no',
        'shop_est_yr',
        'age_of_bus',
        'own_rent',
        'agni_exp_ton',
        'dealer_total_capacity',
        'near_d',
        'so_approved_name',
        'manager_name',
        'manager_status',
        'admin_status',
        'photo_upload1',
        'photo_upload2',
        'n_of_propriter',
        'n_of_firm',
        'address',
        'email',
        'mobile_no',
        'alter_mobno1',
        'alter_mobno2',
        'name_add_bank',
        'type_of_ac',
        'status_of_firm',
        'other_business',
        'total_turnover_month',
        'total_turnover_year',
        'east',
        'e_dist',
        'west',
        'w_dist',
        'south',
        's_dist',
        'north',
        'n_dist',
        'shop_brand1',
        'shop_month_brand1',
        'shop_brand2',
        'shop_month_brand2',
        'shop_brand3',
        'shop_month_brand3',
        'shop_brand4',
        'shop_month_brand4',
        'shop_brand5',
        'shop_month_brand5',
        'shop_brand6',
        'shop_month_brand6',
        'commercial_brand',
        'commercial_ton',
        'cement_brand1',
        'cement_month_cement1',
        'cement_brand2',
        'cement_month_cement2',
        'cement_brand3',
        'cement_month_cement3',
        'cement_brand4',
        'cement_month_cement4',
        'other1',
        'other2',
        'other3',
        'other4',
        'dealers_type',
        'sub_1',
        'sub_2',
        'sub_3',
        'sub_4',
        'shop_areasq',
        'godown_areasq',
        'action',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Full public URL for the shop image, or null if none was uploaded.
     */
    public function getShopImageUrlAttribute(): ?string
    {
        if (!$this->photo_upload1) {
            return null;
        }
        $path = ltrim($this->photo_upload1, '/');
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset('storage/' . $path);
    }

    /**
     * Full public URL for the godown image, or null if none was uploaded.
     */
    public function getGodownImageUrlAttribute(): ?string
    {
        if (!$this->photo_upload2) {
            return null;
        }
        $path = ltrim($this->photo_upload2, '/');
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset('storage/' . $path);
    }

    /**
     * other_business / type_of_ac / status_of_firm are checkbox groups
     * stored as comma-separated strings. These accessors turn them back
     * into arrays for the Show page, PDF and Edit form pre-checking.
     */
    public function getOtherBusinessArrayAttribute(): array
    {
        return $this->splitCsv($this->other_business);
    }

    public function getTypeOfAcArrayAttribute(): array
    {
        return $this->splitCsv($this->type_of_ac);
    }

    public function getStatusOfFirmArrayAttribute(): array
    {
        return $this->splitCsv($this->status_of_firm);
    }

    private function splitCsv(?string $value): array
    {
        if (!$value) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value)), fn ($v) => $v !== ''));
    }

    /**
     * Human friendly application number, e.g. "ASPL / TN-0001".
     */
    public function getApplicationNoAttribute(): string
    {
        return trim(($this->apply_id ? $this->apply_id . ' / ' : '') . ($this->apply_no ?: '-'));
    }

    /**
     * Full state label (falls back to the raw stored code).
     */
    public function getStateLabelAttribute(): string
    {
        $states = \App\Http\Controllers\DealerRegistration\DealerRegistrationController::states();

        return $states[$this->state_wise] ?? ($this->state_wise ?: '-');
    }
}
