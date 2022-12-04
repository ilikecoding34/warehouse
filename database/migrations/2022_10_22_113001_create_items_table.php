<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('uniquename')->unique();
            $table->string('serialnumber')->unique();
            $table->unsignedBigInteger('minimumlevel')->nullable();
            $table->string('company');
            $table->string('location');
            $table->float('price');
            $table->unsignedBigInteger('picture_id')->nullable();
            $table->string('description');
            $table->unsignedBigInteger('type_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
