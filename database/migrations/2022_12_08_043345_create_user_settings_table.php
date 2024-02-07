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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('blood_group')->nullable();
            $table->string('education')->nullable();
            $table->bigInteger('default_address_id')->unsigned()->index()->nullable();
            $table->foreign('default_address_id')->references('id')->on('user_addresses')->onDelete('SET NULL');
            $table->string('org_name')->nullable();
            $table->string('org_contact_name')->nullable();
            $table->string('org_email')->nullable();
            $table->bigInteger('org_address_id')->unsigned()->index()->nullable();
            $table->foreign('org_address_id')->references('id')->on('user_addresses')->onDelete('SET NULL');
            $table->string('application_document')->nullable();
            $table->string('agreement_document')->nullable();
            $table->boolean('agreement_signed')->nullable();
            $table->dateTime('agreement_signed_date')->nullable();
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
        Schema::table('user_settings', function (Blueprint $table) {
            //
            Schema::dropIfExists('user_settings');
        });
    }
};
