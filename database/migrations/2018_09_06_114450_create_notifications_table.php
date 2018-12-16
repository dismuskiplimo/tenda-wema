<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id')->nullable();
            $table->integer('to_id')->nullable();
            $table->text('message')->nullable();
            $table->boolean('system_message')->default(0);
            $table->boolean('from_admin')->default(0);
            $table->boolean('read')->default(0);
            $table->timestamp('read_at')->nullable();
            $table->string('notification_type')->nullable();
            $table->integer('model_id')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
