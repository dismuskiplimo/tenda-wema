<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->default(0);
            $table->integer('good_deeds')->default(0);
            $table->integer('donated_items')->default(0);
            $table->integer('posts')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('item_reviews')->default(0);
            $table->integer('user_reviews')->default(0);
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('user_activities');
    }
}
