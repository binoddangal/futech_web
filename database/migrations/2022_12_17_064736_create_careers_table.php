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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('slug')->nullable();
            $table->integer('no_of_vacancies')->nullable();
            $table->integer('salary_offer')->nullable();
            $table->date('opened_at')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('min_qualification')->nullable();
            $table->string('position')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('careers');
    }
};
