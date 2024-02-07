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
        Schema::create('video_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('video_url');
            $table->string('short_description')->nullable();
            $table->text('tags')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('category_id')->nullable()->unsigned()->index();
            $table->foreign('category_id')->on('video_gallery_categories')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('position')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
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
        Schema::dropIfExists('video_galleries');
    }
};
