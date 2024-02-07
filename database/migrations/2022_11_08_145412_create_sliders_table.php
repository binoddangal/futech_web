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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('link')->nullable();
            $table->integer('position')->nullable();
            $table->boolean('new_tab')->nullable();
            $table->longText('description')->nullable();
            $table->string('heading_text')->nullable();
            $table->string('sub_heading_text')->nullable();
            $table->string('button_text')->nullable();
            $table->boolean('show_button')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->nullable();
            $table->bigInteger('slider_type_id')->nullable()->index()->unsigned();
            $table->foreign('slider_type_id')->references('id')->on('slider_types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sliders');
    }
};
