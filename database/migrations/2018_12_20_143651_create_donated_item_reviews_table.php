<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonatedItemReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donated_item_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('donated_item_id');
            $table->integer('user_id');
            $table->integer('rating')->default(1);
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donated_item_reviews');
    }
}
