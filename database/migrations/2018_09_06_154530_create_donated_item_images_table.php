<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonatedItemImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donated_item_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('slide')->nullable();
            $table->integer('donated_item_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('donated_item_images');
    }
}
