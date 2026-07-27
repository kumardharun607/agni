<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use SoftDeletes;

    const TYPE_EXISTING = 1;
    const TYPE_NEW = 2;
    const TYPE_SUB = 3;

    const TYPE_LABELS = [
        self::TYPE_EXISTING => 'Existing Dealer',
        self::TYPE_NEW => 'New Dealer',
        self::TYPE_SUB => 'Sub Dealer',
    ];

    const TYPE_PREFIX = [
        self::TYPE_EXISTING => 'ED',
        self::TYPE_NEW => 'ND',
        self::TYPE_SUB => 'SD',
    ];

    protected $fillable = [
        'alias_id', 'name', 'client_type', 'parent_dealer_id', 'designation',
        'contact_person', 'mobile', 'alternate_mobile', 'whatsapp_number', 'email',
        'gst_no', 'pan_no', 'credit_limit', 'payment_terms', 'country_id', 'state_id',
        'city_id', 'pincode_id', 'address', 'latitude', 'longitude',
    ];

    // Generates the next alias id per client_type, e.g. ED-001, ND-001, SD-001
    public static function generateAliasId(int $clientType): string
    {
        $prefix = self::TYPE_PREFIX[$clientType] ?? 'DL';

        $last = self::withTrashed()
            ->where('client_type', $clientType)
            ->where('alias_id', 'like', $prefix . '-%')
            ->orderByRaw('CAST(SUBSTRING(alias_id, 4) AS UNSIGNED) DESC')
            ->first();

        $next = 1;
        if ($last) {
            $lastNumber = (int) substr($last->alias_id, strlen($prefix) + 1);
            $next = $lastNumber + 1;
        }

        return $prefix . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    public function parentDealer() { return $this->belongsTo(Dealer::class, 'parent_dealer_id'); }
    public function subDealers() { return $this->hasMany(Dealer::class, 'parent_dealer_id'); }
    public function country() { return $this->belongsTo(Country::class); }
    public function state() { return $this->belongsTo(State::class); }
    public function city() { return $this->belongsTo(City::class); }
    public function pincode() { return $this->belongsTo(Pincode::class); }
    public function typeLabel(): string { return self::TYPE_LABELS[$this->client_type] ?? '-'; }
}
