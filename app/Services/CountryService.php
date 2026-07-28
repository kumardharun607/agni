<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryService extends BaseService
{
    public function __construct(CountryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create a country. If a soft-deleted country with the same name exists,
     * restore it (clear deleted_at) and update its data instead of failing unique.
     */
    public function create(array $data)
    {
        $trashed = Country::onlyTrashed()
            ->where('name', $data['name'] ?? null)
            ->first();

        if ($trashed) {
            $trashed->restore();
            $trashed->update($data);

            return $trashed->fresh();
        }

        return parent::create($data);
    }
}
