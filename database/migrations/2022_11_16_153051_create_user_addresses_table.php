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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->unsigned()->index();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->enum('type', ["temporary", "permanent"])->nullable();
            $table->bigInteger('province_id')->unsigned()->index()->nullable();
            $table->foreign('province_id')->on('provinces')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('district_id')->unsigned()->index()->nullable();
            $table->foreign('district_id')->on('districts')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('municipality_id')->unsigned()->index()->nullable();
            $table->foreign('municipality_id')->on('municipalities')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('post_code')->nullable();
            $table->string('ward_no')->nullable();
            $table->foreign('user_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('user_addresses');
    }
};
