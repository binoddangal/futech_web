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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable()->unsigned()->index();
            $table->bigInteger('menu_id')->nullable()->unsigned()->index();
            $table->bigInteger('page_id')->nullable()->unsigned()->index();
            $table->bigInteger('blog_id')->nullable()->unsigned()->index();
            $table->string('title');
            $table->string('menu_type')->nullable();
            $table->string('menu_location_type')->nullable();
            $table->string('link')->nullable();
            $table->integer('position')->nullable();
            $table->integer('depth')->nullable();
            $table->boolean('new_tab')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->foreign('page_id')->on('pages')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('blog_id')->on('blogs')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('menu_items');
    }
};
