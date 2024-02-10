//Vuetify Plugin Initiate
import "vuetify/dist/vuetify.min.css";
import "vue-snotify/styles/material.css";
import "verte/dist/verte.css";

import Vue from "vue";

// CKEditor
import CKEditor from "ckeditor4-vue";

//Jquery Initiate
import JQuery from "jquery";

//Verte
import Verte from "verte";

//Confirm Box
import VueConfirmDialog from "vue-confirm-dialog";

/*Vue Copy*/
import ClickCopy from "vue-directive-copy";
import VueNestable from "vue-nestable";

//Vue Router Initiate
import VueRouter from "vue-router";

//Toaster Notify Plugin Initiate
import Snotify from "vue-snotify";

//Validation Plugin Initiate
import Vuelidate from "vuelidate";
import Vuetify from "vuetify";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import ApiService from "./services/api/api.service";

window.Vue = require('vue').default;

ApiService.init();

window.$ = JQuery
window._ = require('lodash');

Vue.use(VueRouter)

Vue.use(Vuetify)

Vue.use(Vuelidate)

Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

Vue.use(Snotify)

Vue.component(Verte.name, Verte);
Vue.use(Verte);

Vue.use(CKEditor);

Vue.use(ClickCopy);

Vue.use(VueNestable)


//Admin Components
Vue.component('AdminLogin', require('./components/views/admin/auth/AdminLogin').default);
Vue.component('AdminMfa', require('./components/views/admin/auth/AdminMfaVerification').default);
Vue.component('AdminDashboard', require('./components/views/admin/dashboard/Dashboard').default);
Vue.component('AdminAccountSecurity', require('./components/views/admin/admin-user/profile/AccountSecurity').default);
Vue.component('AdminUser', require('./components/views/admin/admin-user/Index').default);

// User
Vue.component('User', require('./components/views/admin/user/Index').default);

// User
Vue.component('EmailTemplate', require('./components/views/admin/email-template/Index').default);
Vue.component('EmailTemplateRole', require('./components/views/admin/email-template/Roles').default);
Vue.component('EmailTemplateEdit', require('./components/views/admin/email-template/CreateAndUpdate').default);

// CMS
Vue.component('Download', require('./components/views/admin/cms/download/Index').default);
Vue.component('DownloadType', require('./components/views/admin/cms/download/type/Index').default);
Vue.component('Testimonial', require('./components/views/admin/cms/testimonial/Index').default);
Vue.component('TestimonialCreate', require('./components/views/admin/cms/testimonial/CreateAndUpdate').default);
Vue.component('TestimonialEdit', require('./components/views/admin/cms/testimonial/CreateAndUpdate').default);
Vue.component('Slider', require('./components/views/admin/cms/slider/Index').default);
Vue.component('SliderType', require('./components/views/admin/cms/slider/type/Index').default);
Vue.component('Page', require('./components/views/admin/cms/page/Index').default);
Vue.component('FaqCategory', require('./components/views/admin/cms/faq/category/Index').default);
Vue.component('Faq', require('./components/views/admin/cms/faq/Index').default);
Vue.component('BlogList', require('./components/views/admin/cms/blog/BlogList').default);
Vue.component('BlogCreateOrEdit', require('./components/views/admin/cms/blog/CreateAndUpdate').default);
Vue.component('NewsAndUpdates', require('./components/views/admin/cms/new-and-update/NewAndupdate').default);
Vue.component('NewsAndUpdatesCreateOrEdit', require('./components/views/admin/cms/new-and-update/CreateAndUpdate').default);
Vue.component('BlogCategory', require('./components/views/admin/cms/blog/category/Index').default);
Vue.component('Media', require('./components/views/admin/cms/media/Index').default);
Vue.component('Menus', require('./components/views/admin/cms/menu/Index').default);
Vue.component('MenuItem', require('./components/views/admin/cms/menu/item/Index').default);
Vue.component('Page', require('./components/views/admin/cms/page/Index').default);
Vue.component('OurProject', require('./components/views/admin/cms/our-project/Index').default);
Vue.component('Partner', require('./components/views/admin/cms/partner/Index').default);
Vue.component('Notice', require('./components/views/admin/cms/notice/Index').default);
Vue.component('Team', require('./components/views/admin/cms/team/Index').default);
Vue.component('Popup', require('./components/views/admin/cms/popup/Index').default);
Vue.component('SiteSetting', require('./components/views/admin/cms/setting/Index').default);
Vue.component('VideoGallery', require('./components/views/admin/cms/video-gallery/Index').default);
Vue.component('VideoGalleryCategory', require('./components/views/admin/cms/video-gallery/category/Index').default);
Vue.component('Contact', require('./components/views/admin/cms/contact/Index').default);
Vue.component('Album', require('./components/views/admin/cms/album/Index').default);
Vue.component('AlbumValue', require('./components/views/admin/cms/album/value/Index').default);
Vue.component('Career', require('./components/views/admin/cms/career/Index').default);
Vue.component('CareerCreateOrEdit', require('./components/views/admin/cms/career/CreateAndUpdate').default);
Vue.component('CareerApplication', require('./components/views/admin/cms/career/application/Index').default);

// Contact Us
Vue.component('ContactUs', require('./components/views/front/contact-us/ContactUs').default);

//Career
Vue.component('Careers',require('./components/views/front/career/career').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    vuetify : new Vuetify(),
    el: '#app',
});
