<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinPurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_purchase_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('coins');
            $table->integer('amount_paid');
            $table->string('transaction_code');
            $table->boolean('approved')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->integer('approved_by')->nullable();
            
            $table->boolean('disapproved')->default(0);
            $table->integer('disapproved_by')->nullable();
            $table->timestamp('disapproved_at')->nullable();
            $table->text('disapproved_reason')->nullable();

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
        Schema::dropIfExists('coin_purchase_histories');
    }
}
