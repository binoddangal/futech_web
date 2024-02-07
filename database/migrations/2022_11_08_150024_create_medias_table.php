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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('title')->nullable();
            $table->string('type')->default('other');
            $table->float('size')->nullable();
            $table->boolean('is_downloadable')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->bigInteger('uploaded_by')->unsigned()->index()->nullable();
            $table->foreign('uploaded_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('medias');
    }
};
