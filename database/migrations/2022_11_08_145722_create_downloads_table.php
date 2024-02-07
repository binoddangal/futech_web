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
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('path');
            $table->string('preview_image');
            $table->bigInteger('download_type_id')->nullable()->index()->unsigned();
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_private')->default(0)->nullable();
            $table->boolean('public_hidden')->default(0)->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreign('download_type_id')->on('download_types')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('downloads');
    }
};
