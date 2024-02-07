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
        Schema::table('user_settings', function (Blueprint $table) {
            $table->longText('offering_item_ids')->nullable()->after('org_address_id');
            $table->longText('offering_sub_category_ids')->nullable()->after('org_address_id');
            $table->longText('offering_category_ids')->nullable()->after('org_address_id');
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
            $table->dropColumn(['offering_category_ids', 'offering_sub_category_ids', 'offering_item_ids']);
        });
    }
};
