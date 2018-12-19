<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');

            $table->boolean('about_me')->default(0);
            $table->boolean('memberships')->default(0);
            $table->boolean('education')->default(0);
            $table->boolean('work_experience')->default(0);
            $table->boolean('skills')->default(0);
            $table->boolean('awards')->default(0);
            $table->boolean('hobbies')->default(0);
            $table->boolean('achievements')->default(0);
            $table->boolean('redeemed')->default(0);
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
        Schema::dropIfExists('profiles');
    }
}
