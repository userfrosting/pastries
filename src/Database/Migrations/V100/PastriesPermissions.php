<?php

namespace UserFrosting\Sprinkle\Pastries\Database\Migrations\v100;

use UserFrosting\Sprinkle\Core\Database\Migration;
use UserFrosting\Sprinkle\Account\Database\Models\Permission;

class PastriesPermissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public $dependencies = [
        '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\RolesTable',
        '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\PermissionsTable'
    ];

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        foreach ($this->pastryPermissions() as $permissionInfo) {
            $permission = new Permission($permissionInfo);
            $permission->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        foreach ($this->pastryPermissions() as $permissionInfo) {
            $permission = Permission::where($permissionInfo)->first();
            $permission->delete();
        }
    }

    protected function pastryPermissions()
    {
        return [
            [
                'slug'        => 'see_pastries',
                'name'        => 'See the pastries page',
                'conditions'  => 'always()',
                'description' => 'Enables the user to see the pastries page'
            ],
            [
                'slug'        => 'see_pastry_origin',
                'name'        => 'See pastry origin',
                'conditions'  => 'always()',
                'description' => 'Allows the user to see the origin of a pastry'
            ]
        ];
    }
}
