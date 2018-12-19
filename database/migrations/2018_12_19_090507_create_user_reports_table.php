<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');

            $table->integer('report_type_id');
            $table->string('section')->nullable();
            $table->integer('model_id')->nullable();
            $table->text('description')->nullable();

            $table->integer('reported_by');
            
            $table->boolean('approved')->default(0);
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->boolean('dismissed')->default(0);
            $table->integer('dismissed_by')->nullable();
            $table->timestamp('dismissed_at')->nullable();
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
        Schema::dropIfExists('user_reports');
    }
}
