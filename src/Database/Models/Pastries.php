<?php

namespace UserFrosting\Sprinkle\Pastries\Database\Models;

use UserFrosting\Sprinkle\Core\Database\Models\Model;

class Pastries extends Model
{
    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'pastries';

    protected $fillable = [
        'name',
        'description',
        'origin',
    ];

    /**
     * @var bool Enable timestamps for this class.
     */
    public $timestamps = true;
}
