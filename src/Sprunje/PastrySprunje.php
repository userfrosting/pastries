<?php

namespace UserFrosting\Sprinkle\Pastries\Sprunje;

use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;
use UserFrosting\Sprinkle\Pastries\Database\Models\Pastries;

class PastrySprunje extends Sprunje
{
    protected $name = 'pastries';

    protected $sortable = [
    'name',
    'description',
    'origin'
    ];

    protected $filterable = [
    'name',
    'description',
    'origin'
    ];

    protected function baseQuery()
    {
        $instance = new Pastries();

        return $instance->newQuery();
    }
}
