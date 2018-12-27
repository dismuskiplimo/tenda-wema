<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('donated_item_id');
            $table->text('reason');

            $table->boolean('approved')->default(0);
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->boolean('dismissed')->default(0);
            $table->integer('dismissed_by')->nullable();
            $table->text('dismissed_reason')->nullable();
            $table->timestamp('dismissed_at')->nullable();

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
        Schema::dropIfExists('cancel_orders');
    }
}
