<?php

namespace UserFrosting\Sprinkle\Pastries\Database\Migrations\v100;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\System\Bakery\Migration;

class PastriesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
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
    public function down()
    {
        $this->schema->drop('pastries');
    }
}
