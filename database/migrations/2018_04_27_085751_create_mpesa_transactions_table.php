<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->double('Amount',12);
            $table->double('coins',12)->default(0);
            $table->string('MpesaReceiptNumber');
            $table->double('Balance', 12)->nullable();
            $table->string('TransactionDate');
            $table->string('PhoneNumber');
            $table->integer('user_id');
            $table->integer('mpesa_request_id');
            $table->integer('transaction_id');
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
        Schema::dropIfExists('mpesa_transactions');
    }
}
