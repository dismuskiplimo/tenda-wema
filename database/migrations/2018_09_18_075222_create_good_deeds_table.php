<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodDeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_deeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            
            $table->boolean('approved')->default(0);
            $table->integer('approver_id')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->boolean('disapproved')->default(0);
            $table->text('disapproved_reason')->nullable();
            $table->integer('disapprover_id')->nullable();
            $table->timestamp('disapproved_at')->nullable();
            
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->date('performed_at')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->text('contacts')->nullable();
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
        Schema::dropIfExists('good_deeds');
    }
}
