<?php

/*
 * UserFrosting Pastries Sprinkle
 *
 * @link      https://github.com/userfrosting/pastries
 * @copyright Copyright (c) 2023 Louis Charette
 * @license   https://github.com/userfrosting/pastries/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Pastries;

use UserFrosting\Sprinkle\Account\Account;
use UserFrosting\Sprinkle\Admin\Admin;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\MigrationRecipe;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\SeedRecipe;
use UserFrosting\Sprinkle\Pastries\Database\Migrations\V100\PastriesPermissions;
use UserFrosting\Sprinkle\Pastries\Database\Migrations\V100\PastriesTable;
use UserFrosting\Sprinkle\Pastries\Database\Seeds\DefaultPastries;
use UserFrosting\Sprinkle\SprinkleRecipe;
use UserFrosting\Theme\AdminLTE\AdminLTE;

class MyApp implements SprinkleRecipe, MigrationRecipe, SeedRecipe
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Pastries';
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return __DIR__ . '/../';
    }

    /**
     * {@inheritdoc}
     */
    public function getSprinkles(): array
    {
        return [
            Core::class,
            Account::class,
            Admin::class,
            AdminLTE::class,
        ];
    }

    /**
     * Returns a list of routes definition in PHP files.
     *
     * @return string[]
     */
    public function getRoutes(): array
    {
        return [
            MyRoutes::class,
        ];
    }

    /**
     * Returns a list of all PHP-DI services/container definitions files.
     *
     * @return string[]
     */
    public function getServices(): array
    {
        return [];
    }

    /**
     * Return an array of all registered Migrations.
     *
     * @return string[]
     */
    public function getMigrations(): array
    {
        return [
            PastriesTable::class,
            PastriesPermissions::class,
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function getSeeds(): array
    {
        return [
            DefaultPastries::class,
        ];
    }
}
