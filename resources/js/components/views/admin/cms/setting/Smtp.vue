<template>
  <v-card flat>
    <v-card-text>
      <div class="row">
        <div class="col-12 float-right">
          <h3>SMTP setting</h3>
          <div v-if="!setting.display_smtp_setting">
            <div class="col-12 float-right">
              <v-text-field outlined dense v-model="setting.mail_driver"
                            label="Driver"></v-text-field>
              <small>E.g.: SMTP</small>
            </div>
            <div class="col-12 float-right">
              <v-text-field outlined dense v-model="setting.mail_host"
                            label="Host"></v-text-field>
              <small>E.g.: smtp.gmail.com</small>
            </div>
            <div class="col-12 float-right">
              <v-text-field outlined dense v-model="setting.mail_port"
                            label="Port"></v-text-field>
              <small>Port: 587 for TLS</small>
            </div>
            <div class="col-12 float-right">
              <v-text-field outlined dense v-model="setting.mail_user_name"
                            label="Email address"></v-text-field>
            </div>
            <div class="col-12 float-right">
              <v-text-field outlined dense v-model="setting.mail_password"
                            label="Email password"></v-text-field>
            </div>
            <div class="col-12 float-right">
              <v-select :items="['tls', 'ssl']"
                        label="Encryption"
                        v-model="setting.mail_encryption" outlined dense></v-select>
              <small>Default: TLS</small>
            </div>
            <div class="col-12 float-right">
              <v-text-field outlined dense v-model="setting.mail_sender_name"
                            label="Sender name on system email"></v-text-field>
            </div>
            <div class="col-12 float-right">
              <v-text-field outlined dense v-model="setting.mail_from_address"
                            label="Mail from address"></v-text-field>
            </div>

          </div>
          <div class="row" v-else>
            <div class="col-8 text-center">
                <img :src="`${this.homeRoute}/ashwinifoundation/images/misc/lock.png`" alt="lock" height="200">
              <br>
              <v-btn class="btn btn-primary text-white" dark @click="removeSmtpSetting">Remove</v-btn>
            </div>
            <div class="col-4">
              <v-row>
                <v-col cols="12">
                  <v-text-field  v-model="email"  :error="$v.email.$error" outlined dense :label="$v.email.$error?'Not a valid email':'Email'" hint="Send test email to user"></v-text-field>
                  <span class="text-danger" v-if="$v.email.$error">Please enter a valid email to send test email.</span>
                </v-col>
                <v-col cols="12 text-center">
                  <v-btn :loading="loading" class="btn btn-primary text-white" depressed @click="sendTestEmail">Send test email</v-btn>
                </v-col>
              </v-row>

            </div>
          </div>
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>
<script>
import {required, email} from "vuelidate/lib/validators";
import SiteSettingService from "../../../../../services/admin/cms/site-setting/SiteSettingService";

const siteSetting = new SiteSettingService();
export default {
  name: "SmtpSetting",
  props: ["setting", "homeRoute"],
  validations:{
    email:{required, email}
  },
  data() {
    return {
      email: null,
      loading: false,
      test_file: null,
      test_path: null,
    }
  },
  methods: {
    removeSmtpSetting() {
      this.$confirm({
        message: `Are you sure you want to delete this item permanently?`,
        button: {
          no: "No",
          yes: "Yes"
        },
        /**
         * Callback Function
         * @param {Boolean} confirm
         */
        callback: confirm => {
          if (confirm) {
            this.setting.mail_driver = null
            this.setting.mail_host = null
            this.setting.mail_port = null
            this.setting.mail_user_name = null
            this.setting.mail_password = null
            this.setting.mail_encryption = null
            this.setting.mail_sender_name = null
            this.setting.mail_from_address = null
            this.$emit('update_setting')
          }
        }
      });


    },
    sendTestEmail(){
      this.$v.email.$touch()
      if (this.$v.email.$error){
          setTimeout(()=>{
            this.$v.email.$reset()
          }, 3000)
      } else{
        this.loading = true
        siteSetting.sendTestEmail(this.email).then(response=>{
          this.$snotify.success("Test email has been sent")
          this.loading = false
        }).catch(error=>{
          this.loading = false
          this.$snotify.error("Something went wrong");
        }).finally()
      }
    }
  }
}
</script>
