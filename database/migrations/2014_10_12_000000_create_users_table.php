<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('dob')->nullable();
            $table->string('password');
            
            $table->text('about_me')->nullable();
            
            $table->boolean('email_confirmed')->default(0);
            $table->string('email_token')->nullable();
            $table->timestamp('email_confirmed_at')->nullable();

            $table->integer('coins')->default(0);
            $table->integer('accumulated_coins')->default(0);
            $table->boolean('active')->default(1);

            $table->boolean('suspended')->default(0);
            $table->timestamp('suspended_from')->nullable();
            $table->timestamp('suspended_until')->nullable();
            $table->integer('suspended_days')->nullable();
            $table->text('suspended_reason')->nullable();
            
            $table->boolean('is_admin')->default(0);
            $table->boolean('moderator')->default(0);
            $table->string('usertype')->default('USER');
            $table->string('social_level')->default('MWANZO');
            $table->timestamp('social_level_attained_at')->nullable();

            $table->timestamp('last_seen')->nullable();
            
            $table->boolean('closed')->default(0);
            $table->timestamp('closed_at')->nullable();
            $table->integer('closed_by')->nullable();
            $table->text('closed_reason')->nullable();

            $table->integer('profile_id')->nullable();
            $table->integer('profile_completion')->default(0);

            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();

            $table->integer('rating')->default(0);
            $table->integer('reviews')->default(0);

            $table->boolean('verified')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->integer('verified_by')->nullable();

            $table->integer('views')->default(0);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
