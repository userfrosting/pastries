<?php

/*
 * UserFrosting Pastries Sprinkle
 *
 * @link      https://github.com/userfrosting/pastries
 * @copyright Copyright (c) 2023 Louis Charette
 * @license   https://github.com/userfrosting/pastries/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Pastries\Database\Migrations\v100;

use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PermissionsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\RolesTable;
use UserFrosting\Sprinkle\Account\Database\Models\Permission;
use UserFrosting\Sprinkle\Core\Database\Migration;

class PastriesPermissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        RolesTable::class,
        PermissionsTable::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        foreach ($this->pastryPermissions() as $permissionInfo) {
            $permission = new Permission($permissionInfo);
            $permission->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        foreach ($this->pastryPermissions() as $permissionInfo) {
            /** @var Permission */
            $permission = Permission::where($permissionInfo)->first();
            $permission->delete();
        }
    }

    protected function pastryPermissions(): array
    {
        return [
            [
                'slug'        => 'see_pastries',
                'name'        => 'See the pastries page',
                'conditions'  => 'always()',
                'description' => 'Enables the user to see the pastries page',
            ],
            [
                'slug'        => 'see_pastry_origin',
                'name'        => 'See pastry origin',
                'conditions'  => 'always()',
                'description' => 'Allows the user to see the origin of a pastry',
            ],
        ];
    }
}
