<?php

/*
 * UserFrosting Pastries Sprinkle
 *
 * @link      https://github.com/userfrosting/pastries
 * @copyright Copyright (c) 2023 Louis Charette
 * @license   https://github.com/userfrosting/pastries/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Pastries\Database\Models;

use UserFrosting\Sprinkle\Core\Database\Models\Model;

class Pastries extends Model
{
    protected $fillable = [
        'name',
        'description',
        'origin',
    ];
}
