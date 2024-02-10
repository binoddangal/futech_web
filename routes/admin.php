<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');


Route::group(['prefix' => 'admin'], function ($router) {
    $router->post('check/verification-enabled', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'checkVerificationEnabled']);
    $router->post('reset/password', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'resetPassword']);
    //    $router->post('check/reset/password', [App\Http\Controllers\User\Auth\ForgotPasswordController::class, 'checkResetPassword']);
    $router->post('do-reset/password', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'doResetPassword']);
    $router->post('request/verification-code', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'requestEmailVerificationCode']);
    $router->post('verify/mfa-verification-code', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'verifyMfaVerificationCode']);
    $router->post('verify/email-verification-code', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'verifyEmailVerificationCode']);
    $router->post('activate/email-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'activateEmailAuthenticator']);
    $router->post('activate/mfa-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'activateMfaAuthenticator']);
    $router->post('deactivate/mfa-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'deactivateMfaAuthenticator']);
    $router->post('deactivate/email-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'deactivateEmailAuthenticator']);
    $router->get('mfa-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'getMfaAuthenticatorCode']);
    $router->post('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    $router->get('logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
});


Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function ($router) {
    $router->get('dashboard', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index'])->name('admin.dashboard');
    $router->get('account/security', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'accountSecurity'])->name('admin.account-security');
    $router->post('dashboard/stats', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'getStats']);

    // Admin User
    $router->get('admin-users/{user_type}/user', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, 'indexView'])->name('admin-user.indexView');
    $router->get('view-profile', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, 'viewProfile'])->name('admin-user.viewProfile');
    $router->resource('admin-user', \App\Http\Controllers\Admin\AdminUser\AdminUserController::class);
    $router->get('admin-user/get/all/{userType}', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, 'getByUserType'])->name('admin-user.user-type');
    $router->post('admin-user/{id}/change-password', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, 'changePassword']);
    $router->post('admin-user/get/mfa-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'getMfaAuthenticatorCode']);
    $router->post('admin-user/verify/mfa-verification-code', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'verifyMfaVerificationCode']);
    $router->post('admin-user/activate/email-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'activateEmailAuthenticator']);
    $router->post('admin-user/activate/mfa-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'activateMfaAuthenticator']);
    $router->post('admin-user/deactivate/mfa-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'deactivateMfaAuthenticator']);
    $router->post('admin-user/deactivate/email-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'deactivateEmailAuthenticator']);

    // User
    // $router->get('user/{status}', [\App\Http\Controllers\Admin\User\UserController::class, 'indexView'])->name('admin.user.indexView');
    // $router->resource('user', \App\Http\Controllers\Admin\User\UserController::class);
    // $router->post('user/{id}/approved-or-rejected', [ \App\Http\Controllers\Admin\User\UserController::class, 'approvedOrRejectedUser']);
    // $router->get('user/export/volunteer', [ \App\Http\Controllers\Admin\User\UserController::class, 'exportVolunteer']);

    // User Setting
    // $router->post('user-setting/{userId}', [\App\Http\Controllers\Admin\User\Setting\UserSettingController::class, 'createOrUpdate']);
    // $router->get('user-setting/{userId}', [\App\Http\Controllers\Admin\User\Setting\UserSettingController::class, 'show']);

    //Email template
    $router->get('email-templates-roles', [\App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class, 'roleView'])->name('admin.email-template-role.indexView');
    $router->get('email-templates/{role}', [\App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class, 'indexView'])->name('admin.email-template.indexView');
    $router->get('email-templates/{id}/edit', [\App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class, 'edit'])->name('admin.email-template.edit');
    $router->resource('email-template', \App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class);
    $router->post('email-template/clone', [\App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class, 'cloneEmailTemplate']);
    $router->get('email-template-roles', [\App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class, 'emailTemplateRoles']);

    // Album
    $router->get('albums', [\App\Http\Controllers\Admin\Cms\Album\AlbumController::class, 'indexView'])->name('admin.albums.indexView');
    $router->resource('album', \App\Http\Controllers\Admin\Cms\Album\AlbumController::class);
    $router->get('album/{id}/{index}/sort', [\App\Http\Controllers\Admin\Cms\Album\AlbumController::class, 'sort']);
    $router->post('album/{id}/update', [\App\Http\Controllers\Admin\Cms\Album\AlbumController::class, 'update']);
    $router->get('album/active/all', [\App\Http\Controllers\Admin\Cms\Album\AlbumController::class, 'activeAll']);

    // Album Tag
    $router->get('album/{id}/photos', [\App\Http\Controllers\Admin\Cms\Album\Value\AlbumValueController::class, 'indexView'])->name('admin.album-value.indexView');
    $router->resource('album.value', \App\Http\Controllers\Admin\Cms\Album\Value\AlbumValueController::class);
    $router->post('album/{album_id}/value/{value_id}/update', [\App\Http\Controllers\Admin\Cms\Album\Value\AlbumValueController::class, 'update']);
    $router->post('album/{album_id}/value/sort', [\App\Http\Controllers\Admin\Cms\Album\Value\AlbumValueController::class, 'sort']);

    // Our Project
    $router->get('our-projects', [\App\Http\Controllers\Admin\Cms\OurProject\OurProjectController::class, 'indexView'])->name('admin.our-project.index');
    $router->resource('our-project', \App\Http\Controllers\Admin\Cms\OurProject\OurProjectController::class);
    $router->post('our-project/{id}', [\App\Http\Controllers\Admin\Cms\OurProject\OurProjectController::class, 'update']);

    // Partner
    $router->get('partners', [\App\Http\Controllers\Admin\Cms\Partner\PartnerController::class, 'indexView'])->name('admin.partner.indexView');
    $router->resource('partner', \App\Http\Controllers\Admin\Cms\Partner\PartnerController::class);
    $router->post('partner/{id}', [\App\Http\Controllers\Admin\Cms\Partner\PartnerController::class, 'update']);

    /*Contact-us*/
    $router->get('contact-us', [\App\Http\Controllers\Admin\Cms\ContactUs\ContactUsController::class, 'indexView'])->name('admin.contact.indexView');
    $router->resource('contact', \App\Http\Controllers\Admin\Cms\ContactUs\ContactUsController::class);

    /*Page*/
    $router->get('pages', [\App\Http\Controllers\Admin\Cms\Page\PageController::class, 'indexView'])->name('admin.cms.page.indexView');
    $router->resource('page', \App\Http\Controllers\Admin\Cms\Page\PageController::class);

    /*Faq Category */
    $router->get('faq/category', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'indexView'])->name('admin.faq-category.indexView');
    $router->resource('faq-category', \App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class);
    $router->get('faq-category/parent/all', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'getParent']);
    $router->post('faq-category/sort', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'sort']);

    /*Faq */
    $router->get('faqs', [\App\Http\Controllers\Admin\Cms\Faq\FaqController::class, 'indexView'])->name('admin.faq.indexView');
    $router->resource('faq', \App\Http\Controllers\Admin\Cms\Faq\FaqController::class);
    $router->post('faq/sort', [\App\Http\Controllers\Admin\Cms\Faq\FaqController::class, 'sort']);

    //blog
    $router->get('blogs', [\App\Http\Controllers\Admin\Cms\Blog\BlogController::class,'indexView'])->name('admin.blog.indexView');
    $router->resource('blog', \App\Http\Controllers\Admin\Cms\Blog\BlogController::class);
    $router->post('blog/{id}/update', [\App\Http\Controllers\Admin\Cms\Blog\BlogController::class, 'update']);

    //news and updatws
    $router->get('news-and-updates', [\App\Http\Controllers\Admin\Cms\NewsAndUpdates\NewsAndUpdatesController::class,'indexView'])->name('admin.indexNewAndUpdate');
    $router->resource('news-and-update', \App\Http\Controllers\Admin\Cms\NewsAndUpdates\NewsAndUpdatesController::class);
    $router->post('news-and-update/{id}/update', [\App\Http\Controllers\Admin\Cms\NewsAndUpdates\NewsAndUpdatesController::class, 'update']);

    //blog-category
    $router->get('blog-categories', [\App\Http\Controllers\Admin\Cms\Blog\Category\BlogCategoryController::class, 'indexView'])->name('admin.blog.category.indexView');
    $router->resource('blog-category', \App\Http\Controllers\Admin\Cms\Blog\Category\BlogCategoryController::class);
    $router->get('blog-category/get/parent', [\App\Http\Controllers\Admin\Cms\Blog\Category\BlogCategoryController::class, 'parent']);

    //Slider
    $router->get('sliders', [\App\Http\Controllers\Admin\Cms\Slider\SliderController::class,'indexView'])->name('admin.slider.indexView');
    $router->resource('slider', \App\Http\Controllers\Admin\Cms\Slider\SliderController::class);
    $router->post('slider/{id}/update', [\App\Http\Controllers\Admin\Cms\Slider\SliderController::class, 'update']);
    $router->post('slider/sort', [\App\Http\Controllers\Admin\Cms\Slider\SliderController::class, 'sort']);

    //slider-type
    $router->get('sliders/type', [\App\Http\Controllers\Admin\Cms\Slider\Type\SliderTypeController::class,'indexView'])->name('admin.slider.type.indexView');
    $router->resource('slider-type', \App\Http\Controllers\Admin\Cms\Slider\Type\SliderTypeController::class);
    $router->get('slider-type-active', [\App\Http\Controllers\Admin\Cms\Slider\Type\SliderTypeController::class,'getActive']);

    //Testimonial
    $router->get('testimonials', [\App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class,'indexView'])->name('admin.cms.testimonials.indexView');
    $router->resource('testimonial', \App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class);
    $router->post('testimonial/{id}/update', [\App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class, 'update']);
    $router->post('testimonial/sort', [\App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class, 'sort']);

    /*Popup */
    $router->resource('popup', \App\Http\Controllers\Admin\Cms\Popup\PopupController::class);
    $router->post('popup/{id}', [\App\Http\Controllers\Admin\Cms\Popup\PopupController::class, 'update']);

    /*Notice */
    $router->get('notices', [\App\Http\Controllers\Admin\Cms\Notice\NoticeController::class,'indexView'])->name('admin.cms.notices.indexView');
    $router->resource('notice', \App\Http\Controllers\Admin\Cms\Notice\NoticeController::class);
    $router->post('notice/sort', [\App\Http\Controllers\Admin\Cms\Notice\NoticeController::class, 'sort']);

    /*Team */
    $router->get('teams', [\App\Http\Controllers\Admin\Cms\Team\TeamController::class,'indexView'])->name('admin.cms.teams.indexView');
    $router->resource('team', \App\Http\Controllers\Admin\Cms\Team\TeamController::class);
    $router->post('team/{id}', [\App\Http\Controllers\Admin\Cms\Team\TeamController::class, 'update']);
    $router->post('team/get/sort', [\App\Http\Controllers\Admin\Cms\Team\TeamController::class, 'sort']);

    /*Category */
    $router->get('categories', [\App\Http\Controllers\Admin\Category\CategoryController::class,'indexView'])->name('admin.categories.indexView');
    $router->resource('category', \App\Http\Controllers\Admin\Category\CategoryController::class);
    $router->get('category/get/all', [\App\Http\Controllers\Admin\Category\CategoryController::class, 'all']);

    /*Sub Category */
    $router->get('sub-categories', [\App\Http\Controllers\Admin\Category\SubCategory\SubCategoryController::class,'indexView'])->name('admin.sub-categories.indexView');
    $router->resource('sub-category', \App\Http\Controllers\Admin\Category\SubCategory\SubCategoryController::class);
    $router->get('sub-category/get/all', [\App\Http\Controllers\Admin\Category\SubCategory\SubCategoryController::class, 'all']);

    /*Item */
    $router->get('items', [\App\Http\Controllers\Admin\Category\SubCategory\Item\ItemController::class,'indexView'])->name('admin.items.indexView');
    $router->resource('item', \App\Http\Controllers\Admin\Category\SubCategory\Item\ItemController::class);

    /*Download Category */
    $router->get('download/type', [\App\Http\Controllers\Admin\Cms\Download\Type\DownloadTypeController::class, 'indexView'])->name('admin.download-type.indexView');
    $router->resource('download-type', \App\Http\Controllers\Admin\Cms\Download\Type\DownloadTypeController::class);
    $router->get('download-type/get/all', [\App\Http\Controllers\Admin\Cms\Download\Type\DownloadTypeController::class, 'all']);
    $router->post('download-type/sort', [\App\Http\Controllers\Admin\Cms\Download\Type\DownloadTypeController::class, 'sort']);
    $router->get('download-type-active', [\App\Http\Controllers\Admin\Cms\Download\Type\DownloadTypeController::class, 'getActive']);

    /*Download */
    $router->get('downloads', [\App\Http\Controllers\Admin\Cms\Download\DownloadController::class, 'indexView'])->name('admin.download.indexView');
    $router->resource('download', \App\Http\Controllers\Admin\Cms\Download\DownloadController::class);
    $router->post('download/{id}', [\App\Http\Controllers\Admin\Cms\Download\DownloadController::class, 'update']);
    $router->post('download/sort/position', [\App\Http\Controllers\Admin\Cms\Download\DownloadController::class, 'sort']);

    /*Faq Category */
    $router->get('faq/category', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'indexView'])->name('admin.faq.category.indexView');
    $router->resource('faq-category', \App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class);
    $router->get('faq-category/parent/all', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'getParent']);
    $router->post('faq-category/sort', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'sort']);

    /*Faq */
    $router->get('faqs', [\App\Http\Controllers\Admin\Cms\Faq\FaqController::class, 'indexView'])->name('admin.faq.indexView');
    $router->resource('faq', \App\Http\Controllers\Admin\Cms\Faq\FaqController::class);
    $router->post('faq/sort', [\App\Http\Controllers\Admin\Cms\Faq\FaqController::class, 'sort']);

    // Media
    $router->get('medias', [\App\Http\Controllers\Admin\Cms\Media\MediaController::class, 'indexView'])->name('admin.media.indexView');
    $router->resource('media', \App\Http\Controllers\Admin\Cms\Media\MediaController::class);

    // Menu
    $router->get('menus',  [\App\Http\Controllers\Admin\Cms\Menu\MenuController::class, 'indexView'])->name('admin.menu.indexView');
    $router->resource('menu',  \App\Http\Controllers\Admin\Cms\Menu\MenuController::class);

    // Menu Item
    $router->get('menu/item/{menu_id}', [\App\Http\Controllers\Admin\Cms\Menu\Item\MenuItemController::class, 'indexView'])->name('admin.menu-item.indexView');
    $router->resource('menu-item', \App\Http\Controllers\Admin\Cms\Menu\Item\MenuItemController::class);
    $router->get('menu-item/{id}/menu', [\App\Http\Controllers\Admin\Cms\Menu\Item\MenuItemController::class, 'getMenuItemsByMenuId']);

    /*Site setting*/
    $router->get('site/setting', [\App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class, 'indexView'])->name('admin.site-setting.indexView');
    $router->get('site-setting/get/all', [\App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class, 'all']);
    $router->resource('site-setting', \App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class);
    $router->post('site-setting/{id}/update', [\App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class, 'update']);
    $router->post('site-setting/s3/test', [\App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class, 'testAwsUpload']);
    $router->get('site-setting/test/s3', [\App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class, 'testS3']);
    $router->post('site-setting/test-email', [\App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class, 'sendTestEmail']);
    $router->get('site-setting/get/colors', [\App\Http\Controllers\Admin\Cms\SiteSetting\SiteSettingController::class, 'getSettingColors']);

    //career
    $router->get('careers', [\App\Http\Controllers\Admin\Cms\Career\CareerController::class, 'indexView'])->name('admin.career.indexView');
    $router->resource('career', \App\Http\Controllers\Admin\Cms\Career\CareerController::class);
    $router->get('career/{id}/edit', [\App\Http\Controllers\Admin\Cms\Career\CareerController::class, 'edit']);
    $router->post('career/sort', [\App\Http\Controllers\Admin\Cms\Career\CareerController::class,'sort']);

    //career-application
    $router->get('career/{id}/application', [\App\Http\Controllers\Admin\Cms\Career\Application\CareerApplicationController::class, 'indexView'])->name('admin.application.indexView');
    $router->resource('career-application', \App\Http\Controllers\Admin\Cms\Career\Application\CareerApplicationController::class);
    $router->get('career-application/get/all', [\App\Http\Controllers\Admin\Cms\Career\Application\CareerApplicationController::class],'all');


    // Payment Gateway Setting
    $router->resource('setting/payment-gateway', \App\Http\Controllers\Admin\Cms\SiteSetting\PaymentGateway\PaymentGatewaySettingController::class);

    $router->get('option/{key}', [\App\Http\Controllers\Admin\Option\OptionController::class, 'getOptionByKey']);

    /*Popup */
    $router->get('popups', [\App\Http\Controllers\Admin\Cms\Popup\PopupController::class, 'indexView'])->name('admin.popup.indexView');
    $router->resource('popup', \App\Http\Controllers\Admin\Cms\Popup\PopupController::class);
    $router->post('popup/{id}', [\App\Http\Controllers\Admin\Cms\Popup\PopupController::class, 'update']);


    // Testimonial
    $router->get('testimonial', [\App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class, 'indexView'])->name('admin.testimonial.indexView');
    $router->get('testimonial/{id}/edit', [\App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class, 'edit']);
    $router->resource('testimonial', \App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class);
    $router->post('testimonial/{id}/update', [\App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class, 'update']);
    $router->post('testimonial/sort', [\App\Http\Controllers\Admin\Cms\Testimonial\TestimonialController::class, 'sort']);

});
