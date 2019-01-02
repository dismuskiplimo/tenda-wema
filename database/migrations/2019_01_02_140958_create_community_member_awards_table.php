<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityMemberAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_member_awards', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->integer('user_id');
            $table->integer('award_year');
            $table->timestamp('valid_until')->nullable();
            
            $table->boolean('revoked')->default(0);
            $table->timestamp('revoked_at')->nullable();
            $table->integer('revoked_by')->nullable();
            $table->text('revoked_reason')->nullable();

            $table->integer('awarded_by')->nullable();

            
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
        Schema::dropIfExists('community_member_awards');
    }
}
