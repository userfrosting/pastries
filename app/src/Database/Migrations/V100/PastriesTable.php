<?php

/*
 * UserFrosting Pastries Sprinkle
 *
 * @link      https://github.com/userfrosting/pastries
 * @copyright Copyright (c) 2023 Louis Charette
 * @license   https://github.com/userfrosting/pastries/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Pastries\Database\Migrations\v100;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class PastriesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $this->schema->create('pastries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('origin', 255);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
        });
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->drop('pastries');
    }
}
