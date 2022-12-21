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
            $table->unsignedBigInteger('quantity')->nullable();
            $table->unsignedBigInteger('minimumlevel')->nullable();
            $table->float('price');
            $table->string('location');
            $table->string('type');
            $table->string('company');
            $table->string('description');
            $table->string('created_by_user');
            $table->string('updated_by_user');
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
