<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonatedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donated_items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('condition')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('donor_id')->nullable();
            
            $table->integer('buyer_id')->nullable();
            $table->boolean('bought')->default(0);
            $table->timestamp('bought_at')->nullable();
            
            $table->integer('price')->default(0);

            $table->boolean('approved')->default(0);
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->boolean('disapproved')->default(0);
            $table->timestamp('disapproved_at')->nullable();
            $table->text('disapproved_reason')->nullable();
            $table->integer('disapproved_by')->nullable();

            $table->boolean('received')->default(0);
            $table->timestamp('received_at')->nullable();
            $table->text('received_message')->nullable();

            $table->integer('escrow_id')->nullable();

            $table->integer('views')->default(0);

            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
            $table->text('deleted_reason')->nullable();

            $table->boolean('disputed')->default(0);
            $table->timestamp('disputed_at')->nullable();
            $table->integer('disputed_by')->nullable();
            $table->text('disputed_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donated_items');
    }
}
