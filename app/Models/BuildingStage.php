<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingStage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'building_stage';

    protected $fillable = [
        'name',
    ];
}