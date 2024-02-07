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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id')->index()->nullable();
            $table->foreign('request_id')->references('id')->on('requests')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('responded_by')->index()->nullable();
            $table->foreign('responded_by')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('supplied_qty')->nullable();
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
        Schema::dropIfExists('responses');
    }
};
