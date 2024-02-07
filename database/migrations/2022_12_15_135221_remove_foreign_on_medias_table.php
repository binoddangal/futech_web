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
        Schema::table('medias', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['uploaded_by']);
        });
        Schema::table('medias', function (Blueprint $table) {
            $table->unsignedBigInteger('uploaded_by')->index()->nullable()->after('is_featured');
            $table->foreign('uploaded_by')->references('id')->on('admin_users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medias', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['uploaded_by']);
        });
        Schema::table('medias', function (Blueprint $table) {
            $table->unsignedBigInteger('uploaded_by')->index()->nullable()->after('is_featured');
            $table->foreign('uploaded_by')->references('id')->on('admin_users')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
