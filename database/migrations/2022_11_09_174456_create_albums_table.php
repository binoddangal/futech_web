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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('tags')->nullable();
            $table->string('position')->nullable();
            $table->string('event_date')->nullable();
            $table->boolean('is_active')->default(1);
            $table->bigInteger('album_id')->unsigned()->index()->nullable();
            $table->foreign('album_id')->on('albums')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('albums');
    }
};
