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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('sub_category_id')->index()->nullable();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('item_id')->index()->nullable();
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('priority', ['normal', 'urgent'])->default('normal')->nullable();
            $table->string('demanded_qty')->nullable();
            $table->string('fulfilled_qty')->nullable();
            $table->string('notifiable_users')->nullable();
            $table->string('rejected_users')->nullable();
            $table->date('requested_date')->nullable();
            $table->date('fulfilled_date')->nullable();
            $table->date('deadline')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_complete')->default(0)->nullable();
            $table->boolean('is_active')->default(1)->nullable();
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
        Schema::dropIfExists('requests');
    }
};
