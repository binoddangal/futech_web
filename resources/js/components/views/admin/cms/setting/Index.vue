<template>
  <v-app>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div
                id="kt_app_toolbar_container"
                class="app-container container-fluid d-flex flex-stack"
            >
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h4>
                      Site setting
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="/dashboard">Dashboard </a>\Site setting
                    </div>

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <v-btn
                      :disabled="sizeExceed"
                      :loading="isBusy"
                      @click="saveSetting"
                      class="text-white float-right btn-primary"
                      dark
                    >Save Settings
                    </v-btn>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                    <div class="row">
                        <div class="col-12">
                            <v-tabs
                              class="justify-start"
                              v-model="tab"
                              vertical
                            >
                                <v-tabs-slider color="blue"></v-tabs-slider>

                                <v-tab class="justify-start">
                                    Global
                                </v-tab>

                                <v-tab class="justify-start">
                                    Social Medias
                                </v-tab>

                                <v-tab class="justify-start">
                                    Widget & API
                                </v-tab>

                                <v-tab class="justify-start">
                                  Email SMTP
                                </v-tab>

                                <v-tab class="justify-start">
                                  Storage
                                </v-tab>

                                <v-tab class="justify-start">
                                  Theme Style
                                </v-tab>

                                <v-tab class="justify-start">
                                  Payment Gateways
                                </v-tab>

                                <v-tab-item>
                                  <v-card>
                                      <v-card-text>
                                        <v-tabs class="justify-start" vertical>
                                            <v-tab class="justify-start">
                                                General
                                            </v-tab>
                                            <v-tab class="justify-start">
                                                Logo & Favicon
                                            </v-tab>
                                            <v-tab class="justify-start">
                                                Contact
                                            </v-tab>

                                            <v-tab class="justify-start">
                                                Action Button
                                            </v-tab>
                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text>
                                                      <v-row>
                                                        <v-col cols="12" md="6">
                                                            <v-text-field
                                                              dense
                                                              label="Slogon"
                                                              outlined
                                                              v-model="setting.slogan"
                                                            >
                                                            </v-text-field>
                                                        </v-col>

                                                        <v-col cols="12"  md="6">
                                                            <v-text-field
                                                              dense
                                                              label="Website Tagline"
                                                              outlined
                                                              v-model="setting.tagline"
                                                            >
                                                            </v-text-field>
                                                        </v-col>

                                                        <v-col cols="12"  md="6">
                                                            <v-text-field
                                                              dense
                                                              label="Website"
                                                              outlined
                                                              v-model="setting.website"
                                                            >
                                                            </v-text-field>
                                                        </v-col>

                                                        <v-col cols="12"  md="6">
                                                            <v-text-field
                                                              dense
                                                              label="Copyright Text" outlined
                                                              v-model="setting.copy_right_text"
                                                            >
                                                            </v-text-field>
                                                        </v-col>

                                                        <v-col cols="12" md="6">
                                                            <v-text-field
                                                                dense
                                                                label="Default Date Format"
                                                                outlined
                                                                v-model="setting.date_format"
                                                              >
                                                            </v-text-field>
                                                        </v-col>

                                                        <v-col cols="12" md="6">
                                                          <v-select
                                                              :items="['free-text', 'address-form']"
                                                              dense
                                                              label="User Address Type"
                                                              outlined
                                                              v-model="setting.address_type"
                                                            >
                                                            </v-select>
                                                        </v-col>

                                                        <v-col cols="12">
                                                            <v-switch
                                                              label="Enable Cookies"
                                                              v-model="setting.enable_cookies"
                                                            >
                                                            </v-switch>
                                                        </v-col>

                                                        <v-col cols="12">
                                                            Cookie Content Text
                                                            <ckeditor
                                                              :config="editorConfig"
                                                              v-model="setting.cookie_content_text"
                                                            >
                                                            </ckeditor>
                                                        </v-col>

                                                        <v-col cols="12">
                                                            Application Terms & Condition <span class="text-danger">*</span>
                                                            <ckeditor
                                                                    :config="editorConfig"
                                                                    v-model="setting.terms_condition"
                                                            >
                                                            </ckeditor>

                                                        </v-col>
                                                      </v-row>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>

                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text>
                                                        <v-row>
                                                          <v-col cols="12">
                                                              <v-file-input
                                                                @change="checkSize($event)" dense
                                                                label="Logo"
                                                                outlined
                                                                v-model="setting.logo_file"
                                                                prepend-icon=""
                                                                prepend-inner-icon="mdi-file"
                                                              >
                                                              </v-file-input>

                                                              <img
                                                                :src="setting.logo_path['real']"
                                                                alt
                                                                class="mt-5"
                                                                style="height:100px"
                                                                v-if="setting.logo_path && setting.logo_path['real']"
                                                              />
                                                          </v-col>

                                                          <v-col cols="12">
                                                              <v-file-input
                                                                @change="checkSize($event)" dense
                                                                label="Admin Logo"
                                                                outlined
                                                                v-model="setting.app_logo_file"
                                                                prepend-icon=""
                                                                prepend-inner-icon="mdi-file"
                                                              >
                                                              </v-file-input>

                                                              <img
                                                                :src="setting.app_logo_path['real']"
                                                                alt
                                                                class="mt-5"
                                                                style="height:100px"
                                                                v-if="setting.app_logo_path && setting.app_logo_path['real']"
                                                              />
                                                          </v-col>

                                                          <v-col cols="12">
                                                              <v-file-input
                                                                @change="checkSize($event)" dense
                                                                label="Footer Logo"
                                                                outlined
                                                                v-model="setting.footer_logo_file"
                                                                prepend-icon=""
                                                                prepend-inner-icon="mdi-file"
                                                              ></v-file-input>

                                                              <img
                                                                :src="setting.footer_logo_path['real']"
                                                                alt
                                                                class="mt-5"
                                                                style="height:100px"
                                                                v-if="setting.footer_logo_path && setting.footer_logo_path['real']"
                                                              />
                                                          </v-col>

                                                          <v-col cols="12">
                                                              <v-file-input
                                                                  @change="checkSize($event)" dense
                                                                  label="Favicon"
                                                                  outlined
                                                                  v-model="setting.fav_icon_file"
                                                                  prepend-icon=""
                                                                  prepend-inner-icon="mdi-file"
                                                                >
                                                                </v-file-input>
                                                                <img
                                                                        :src="setting.fav_icon_path['real']"

                                                                        alt
                                                                        class="mt-5"
                                                                        style="height:100px"
                                                                        v-if="setting.fav_icon_path && setting.fav_icon_path['real']"
                                                                />
                                                          </v-col>

                                                          <span class="text-danger" v-if="sizeExceed">File Size 20MB Max Allowed</span>
                                                        </v-row>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>

                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text>
                                                        <div class="row">
                                                            <div class="col-12 form-group">
                                                                <v-text-field dense label="Phone"
                                                                              outlined
                                                                              v-model="setting.phone"></v-text-field>
                                                                <span class="text-danger"
                                                                      v-if="$v.setting.phone.$error">Enter valid phone no</span>
                                                            </div>
                                                            <div class="col-12 form-group">
                                                                <v-text-field dense label="Email"
                                                                              outlined
                                                                              v-model="setting.email"></v-text-field>
                                                                <span class="text-danger"
                                                                      v-if="$v.setting.email.$error">Enter valid Email</span>
                                                            </div>
                                                            <div class="col-12 form-group">
                                                                <v-text-field dense label="Address"
                                                                              outlined
                                                                              v-model="setting.address"></v-text-field>
                                                            </div>
                                                            <div class="col-12 form-group">
                                                                <v-textarea dense label="Google Map Embed URL"
                                                                              outlined
                                                                              v-model="setting.map_url"></v-textarea>

                                                            </div>

                                                        </div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>

                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text>
                                                        <div class="row">
                                                            <div class="col-12 form-group">
                                                                <v-text-field
                                                                        dense
                                                                        label="Action Button Text" outlined
                                                                        v-model="setting.action_button_text"></v-text-field>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 form-group">
                                                                <v-text-field
                                                                        dense
                                                                        label="Action Button Link" outlined
                                                                        v-model="setting.action_button_link"></v-text-field>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 form-group">
                                                                <v-select
                                                                        :items="['yes','no']"
                                                                        dense
                                                                        label="Open in New Tab"
                                                                        outlined
                                                                        v-model="setting.action_button_link_action"
                                                                ></v-select>
                                                            </div>
                                                        </div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>

                                        </v-tabs>
                                      </v-card-text>
                                  </v-card>
                                </v-tab-item>

                                <v-tab-item>
                                    <v-card>
                                        <v-card-text>
                                          <v-row>
                                              <v-col cols="12">
                                                  <h3>Social Media</h3>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="Facebook"
                                                    outlined
                                                    v-model="setting.facebook"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.facebook.$error">Not a valid url</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="Twitter"
                                                    outlined
                                                    v-model="setting.twitter"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.twitter.$error">Not a valid url</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="Youtube"
                                                    outlined
                                                    v-model="setting.youtube"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.youtube.$error">Not a valid url</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="Instagram"
                                                    outlined
                                                    v-model="setting.instagram"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.instagram.$error">Not a valid url</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="LinkedIn"
                                                    outlined
                                                    v-model="setting.linkedin"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.linkedin.$error">Not a valid url</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="Tiktok"
                                                    outlined
                                                    v-model="setting.tiktok"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.tiktok.$error">Not a valid url</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="Pininterest"
                                                    outlined
                                                    v-model="setting.pininterest"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.pininterest.$error">Not a valid url</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                  dense
                                                  label="Viber"
                                                  outlined
                                                  v-model="setting.viber"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.viber.$error">Not a valid number</span>
                                              </v-col>

                                              <v-col cols="12" md="6">
                                                  <v-text-field
                                                    dense
                                                    label="Whatsapp"
                                                    outlined
                                                    v-model="setting.whatsapp"
                                                  >
                                                  </v-text-field>
                                                  <span class="text-danger" v-if="$v.setting.whatsapp.$error">Not a valid number</span>
                                              </v-col>
                                          </v-row>
                                        </v-card-text>
                                    </v-card>
                                </v-tab-item>

                                <v-tab-item>
                                  <widget :facebook_chat_widgets="facebook_chat_widgets"
                                          :setting="setting"
                                          @update_setting="updateSetting"></widget>
                                </v-tab-item>

                                <v-tab-item>
                                  <smtp-setting :setting="setting" @update_setting="updateSetting"></smtp-setting>
                                </v-tab-item>

                                <v-tab-item>
                                  <storage :setting="setting" :homeRoute="homeRoute" @update_setting="updateSetting"></storage>
                                </v-tab-item>

                                <v-tab-item>
                                  <theme-style :colors_variables="colors_variables"
                                        :setting="setting"
                                        @reset_theme="resetTheme"
                                  ></theme-style>
                                </v-tab-item>

                                <v-tab-item>
                                      <payment-gateway :setting="setting"></payment-gateway>
                                </v-tab-item>


                            </v-tabs>
                        </div>

                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>

  </v-app>
</template>

<script>
import SiteSettingService from '@/services/admin/cms/site-setting/SiteSettingService';
import { email, minLength, numeric, url } from "vuelidate/lib/validators";
import Widget from './Widget.vue';
import SmtpSetting from './Smtp.vue';
import Storage from './Storage.vue';
import ThemeStyle from './ThemeStyle.vue';
import PaymentGateway from './PaymentGateway.vue';

const siteSettingService = new SiteSettingService();
export default {
  name: "SiteSetting",
  props: ['homeRoute'],
  components: {
    Widget,
    SmtpSetting,
    Storage,
    ThemeStyle,
    PaymentGateway,
  },
  data() {
    return {
      tab: null,
      file1: null,
      button: null,
      file2: null,
      edit: false,
      isReload: false,
      isBusy: false,
      sizeExceed: false,
      facebook_chat_widgets: {},
      editorConfig: {
          toolbar: [ [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Link', 'NumberedList', 'BulletedList' ] ]
      },
      colors_variables: {
          login: {
              primary_color: '#00458f',
              primary_text_color: '#000000',
              secondary_color: '#f2883a',
              secondary_text_color: '#000000',
          },
          header: {
              primary_color: "#5d5d5d",
              primary_text_color: "#000000",
              secondary_color: "#f2883a",
              secondary_text_color: "#000000",
          },
          side_bar: {
              bg_color: "#000000",
              primary_color: "#000000",
              primary_text_color: "#000000",
              secondary_color: "#000000",
              secondary_text_color: "#000000"

          },
          button: {
              primary_color: "#00458f",
              primary_text_color: "#000000",
              secondary_color: "#16b",
              secondary_text_color: "#000000"

          },
          email: {
            header_background_color: "#00458f",
            header_text_color: "#00458f",
            footer_background_color: "#00458f",
            footer_text_color: "#00458f",
          }
      },
      setting: {
          phone: null,
          email: null,
          website: null,
          address: null,
          whatsapp: null,
          viber: null,
          pininterest: null,
          tiktok: null,
          linkedin: null,
          instagram: null,
          youtube: null,
          twitter: null,
          facebook: null,
          copy_right_text: null,
          cookie_content_text: `This website uses cookies to ensure you get the best experience on our website`,
          zoom_link: null,
          map_url: null,
          storage_type: 'local',
          storage_access_key: null,
          storage_secret_key: null,
          storage_region: null,
          storage_bucket_name: null,
          storage_url: null,
          slogan: null,
          tagline: null,
          date_format: 'Y-m-d',
          logo_file: null,
          app_logo_file: null,
          footer_logo_file: null,
          email_logo_image_file: null,
          fav_icon_file: null,
          action_button_text: null,
          action_button_link: null,
          action_button_link_action: null
      }
    }
  },

  validations: {
    setting: {
      phone: {minLength: minLength(10)},
      email: {email},
      whatsapp: {numeric, minLength: minLength(10)},
      viber: {numeric, minLength: minLength(10)},
      pininterest: {url},
      tiktok: {url},
      linkedin: {url},
      instagram: {url},
      youtube: {url},
      twitter: {url},
      facebook: {url},
      zoom_link: {url}
    }
  },

  mounted() {
    this.getSetting();
    this.colorSetting();
  },

  methods: {
    getSetting() {
        siteSettingService.show().then(response => {
            if(response.data.siteSetting == null) {
              this.resetForm();
            }
            if(response.data.siteSetting) {
              this.setting = response.data.siteSetting;
              if(this.setting.mail_driver == null) {
                this.setting.mail_driver = 'smtp';
              }
            }
            if (this.setting && this.setting.id) {
                this.edit = true;
                if (this.setting.facebook_chat_widgets)
                    this.facebook_chat_widgets = JSON.parse(this.setting.facebook_chat_widgets);
                if (this.setting.colors_variables) {
                    this.colors_variables = JSON.parse(this.setting.colors_variables);
                    if(this.colors_variables.email == "undefined" || this.colors_variables.email == undefined) {
                      this.colors_variables.email = {
                        header_background_color: "#00458f",
                        header_text_color: "#00458f",
                        footer_background_color: "#00458f",
                        footer_text_color: "#00458f",
                      }
                    }
                    this.setStyleVariable();
                }
                if (this.setting.login_bg_image)
                    delete this.setting.login_bg_image
                if (this.setting.logo)
                    delete this.setting.logo
                if (this.setting.fav_icon)
                    delete this.setting.fav_icon
                if (this.setting.app_logo)
                    delete this.setting.app_logo

            }
        });
    },

    colorSetting() {
      siteSettingService.getColorsVariables().then(() => {});
    },

    saveSetting() {
        this.$v.setting.$touch();
        if (this.$v.setting.$error) {
            setTimeout(() => {
                this.$v.setting.$reset();
            }, 3000);
        } else {
            if (this.edit) {
                this.setting.facebook_chat_widgets = JSON.stringify(this.facebook_chat_widgets);
                this.setting.colors_variables = this.colors_variables ? JSON.stringify(this.colors_variables) : null;
                this.updateSetting();
            } else {
                this.createSetting();
            }
        }
    },

    setStyleVariable() {
        document.documentElement.style.setProperty('--sidebar-secondary-color', this.colors_variables.side_bar.secondary_color);
        document.documentElement.style.setProperty('--sidebar-primary-text-color', this.colors_variables.side_bar.primary_text_color);
        document.documentElement.style.setProperty('--sidebar-secondary-text-color', this.colors_variables.side_bar.secondary_text_color);

        document.documentElement.style.setProperty('--header-primary-color', this.colors_variables.header.primary_color);
        document.documentElement.style.setProperty('--header-secondary-color', this.colors_variables.header.secondary_color);
        document.documentElement.style.setProperty('--header-primary-text-color', this.colors_variables.header.primary_text_color);
        document.documentElement.style.setProperty('--header-secondary-text-color', this.colors_variables.header.secondary_text_color);


        document.documentElement.style.setProperty('--button-primary-color', this.colors_variables.button.primary_color);
        document.documentElement.style.setProperty('--button-secondary-color', this.colors_variables.button.secondary_color);
        document.documentElement.style.setProperty('--button-primary-text-color', this.colors_variables.button.primary_text_color);
        document.documentElement.style.setProperty('--button-secondary-text-color', this.colors_variables.button.secondary_text_color);

    },
    resetTheme() {
        this.colors_variables = null;
        this.isReload = true;
        this.saveSetting();
    },

    checkSize(file) {
        let size = file.size / 1024 / 1024;
        let mbSize = size.toFixed(2);
        if (mbSize > 20) {
            this.sizeExceed = true;
        } else {
            this.sizeExceed = false;
        }
      },
    createSetting() {
        this.isBusy = true;
        let fd = this.generateFd();
        siteSettingService.store(fd).then(response => {
            setTimeout(() => {
              this.isBusy = false;
              this.$snotify.success("Updated successfully");
              this.getSetting();
            }, 2000);
        }).catch(() => {
          this.isBusy = false
        });
    },

    updateSetting() {
        this.isBusy = true;
        let fd = this.generateFd();
        siteSettingService.update(this.setting.id, fd).then(response => {
            setTimeout(() => {
              this.isBusy = false;
              this.$snotify.success("Updated successfully");
              this.getSetting();
            }, 1000);
        }).catch(() => {
          this.isBusy = false
        });
    },

    resetForm() {
        this.setting = {
            phone: null,
            email: null,
            website: null,
            address: null,
            whatsapp: null,
            viber: null,
            pininterest: null,
            tiktok: null,
            linkedin: null,
            instagram: null,
            youtube: null,
            twitter: null,
            facebook: null,
            copy_right_text: null,
            cookie_content_text: `This website uses cookies to ensure you get the best experience on our website`,
            zoom_link: null,
            map_url: null,
            tagline: null,
            logo_file: null,
            app_logo_file: null,
            footer_logo_file: null,
            email_logo_image_file: null,
            fav_icon_file: null,
            date_format: 'Y-m-d',
        };

    },

    generateFd() {
        let fd = new FormData();
        for (let key in this.setting) {
            if (
                key == "logo" &&
                this.setting["logo"] &&
                this.setting["logo"] != null
            ) {
                fd.append("logo", this.setting[key]);
            } else if (
                key == "fav_icon" &&
                this.setting["fav_icon"] &&
                this.setting["fav_icon"] != null
            ) {
                fd.append("fav_icon", this.setting[key]);
            } else if (
                key == "footer_logo" &&
                this.setting["footer_logo"] &&
                this.setting["footer_logo"] != null
            ) {
                fd.append("footer_logo", this.setting[key]);
            } else if (key == "enable_level" && this.setting["enable_level"]) {
                fd.append("enable_level", this.setting['enable_level'] ? 1 : 0);
            } else if (key == "enable_buildings" && this.setting["enable_buildings"]) {
                fd.append("enable_buildings", this.setting['enable_buildings'] ? 1 : 0);
            } else {
                fd.append(key, this.setting[key] ? this.setting[key] : "");
            }
        }
        return fd;
    },
  }
}
</script>
