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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_parent')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->string('short_description')->nullable();
            $table->text('tags')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('faq_category_id')->unsigned()->index()->nullable();
            $table->foreign('faq_category_id')->on('faq_categories')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('faqs');
    }
};
