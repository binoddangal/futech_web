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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('slug')->index();
            $table->dateTime('publish_date')->nullable();
            $table->string('custom_slug')->index()->nullable();
            $table->longText('content')->nullable();
            $table->text('main_css')->nullable();
            $table->text('section_css')->nullable();
            $table->string('seo_title')->index()->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('social_share_image')->index()->nullable();
            $table->text('social_share_description')->nullable();
            $table->string('category_id')->nullable();
//            $table->foreign('category_id')->references('id')->on('website_blog_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->boolean('is_active')->default(1)->index()->nullable();
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
        Schema::dropIfExists('blogs');
    }
};
