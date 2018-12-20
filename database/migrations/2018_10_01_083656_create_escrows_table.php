<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escrows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('donated_item_id');
            $table->float('amount', 12);
            $table->boolean('released')->default(0);
            $table->integer('released_by')->nullable();
            $table->timestamp('released_at')->nullable();
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
        Schema::dropIfExists('escrows');
    }
}
