<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->integer('amount')->nullable();
            $table->string('country')->nullable();
            $table->string('organization')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('donating_as')->nullable();
            $table->string('method')->nullable();

            $table->boolean('received')->default(0);
            $table->timestamp('received_at')->nullable();
            $table->integer('received_by')->nullable();

            $table->boolean('dismissed')->default(0);
            $table->timestamp('dismissed_at')->nullable();
            $table->integer('dismissed_by')->nullable();
            $table->text('dismissed_reason')->nullable();

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
        Schema::dropIfExists('donations');
    }
}
