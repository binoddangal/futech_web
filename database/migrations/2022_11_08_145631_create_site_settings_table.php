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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('map_url')->nullable();
            $table->string('zoom_link')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('pininterest')->nullable();
            $table->string('viber')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('facebook_chat_widgets')->nullable();;
            $table->text('google_analytics')->nullable();
            $table->text('pixels')->nullable();
            $table->string('slogan')->nullable();
            $table->string('tagline')->nullable();
            $table->string('website')->nullable();
            $table->string('date_format')->default('d/m/Y');
            $table->string('address_type')->nullable();
            $table->boolean('enable_cookies')->nullable()->default(0);
            $table->text('cookie_content_text')->nullable();
            $table->string('copy_right_text')->nullable();
            $table->string('terms_condition')->nullable();
            $table->string('fav_icon')->nullable();
            $table->string('logo')->nullable();
            $table->string('login_bg_image')->nullable();
            $table->string('login_bg_color')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->text('colors_variables')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('email_logo_image')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_secret_key')->nullable();
            $table->string('mail_driver')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_user_name')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->string('mail_sender_name')->nullable();
            $table->string('mail_sender_address')->nullable();
            $table->string('storage_url')->nullable();
            $table->string('storage_type')->default('local');
            $table->string('storage_access_key')->nullable();
            $table->string('storage_secret_key')->nullable();
            $table->string('storage_region')->nullable();
            $table->string('storage_endpoint')->nullable();
            $table->string('storage_bucket_name')->nullable();
            $table->string('tax_percentage')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('vat_no')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
};
