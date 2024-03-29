<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->nullable();
            $table->string('campaign_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('total_target')->nullable();
            $table->integer('total_sent')->nullable();
            $table->integer('total_received')->nullable();
            $table->integer('total_read')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
};
