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
        Schema::create('campaign_targets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_campaign')->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('status')->nullable(); // panding, sent, received, read, sending
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
        Schema::dropIfExists('campaign_targets');
    }
};
