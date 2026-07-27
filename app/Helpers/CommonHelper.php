<?php

namespace App\Helpers;

class CommonHelper
{
    public static function statusBadge($status)
    {
        if($status){

            return '<span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">Active</span>';

        }

        return '<span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs">Inactive</span>';
    }

    public static function yesNo($value)
    {
        return $value ? 'Yes' : 'No';
    }
}