<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeratorRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderator_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            
            $table->boolean('approved')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->integer('approved_by')->nullable();

            $table->boolean('dismissed')->default(0);
            $table->timestamp('dismissed_at')->nullable();
            $table->integer('dismissed_by')->nullable();
            $table->text('dismissed_reason')->nullable();
            
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
        Schema::dropIfExists('moderator_requests');
    }
}
