<template>
  <v-card flat>
    <v-card-text>
      <v-card-text flat>
        <v-card-text>
          <v-tabs vertical class="justify-start">
            <v-tab class="justify-start">
              Facebook chat
            </v-tab >
            <v-tab class="justify-start">
              Facebook pixel
            </v-tab>
            <v-tab class="justify-start" >
              Google analytics
            </v-tab>
            <v-tab class="justify-start" >
              Google recaptcha
            </v-tab>

            <v-tab-item>
              <v-card flat>
                <v-card-text>
                  <div class="row">
                    <div class="col-12 form-group">
                      <v-card-text>
                        <v-row dense>
                          <v-col cols="12">
                            <v-text-field
                                label="Page ID"
                                outlined
                                v-model="facebook_chat_widgets.page_id"
                                dense
                            ></v-text-field>


                          </v-col>
                          <v-col cols="12">
                            <v-text-field
                                label="Theme color"
                                outlined
                                v-model="facebook_chat_widgets.theme_color"
                                dense
                            ></v-text-field>

                          </v-col>
                          <v-col cols="12">
                            <v-text-field
                                label="Logged in greeting message"
                                outlined
                                v-model="facebook_chat_widgets.login_greeting"
                                dense
                            ></v-text-field>

                          </v-col>
                          <v-col cols="12">
                            <v-text-field
                                label="Logged out greeting message"
                                outlined
                                v-model="facebook_chat_widgets.logout_greeting"
                                dense
                            ></v-text-field>

                          </v-col>

                        </v-row>
                      </v-card-text>
                      <!--                                                            <input-->
                      <!--                                                                    type="text"-->
                      <!--                                                                    class="form-control border border-dark"-->
                      <!--                                                                    placeholder="Facebook Chat"-->
                      <!--                                                                    v-model="setting.facebook_chat_widgets"-->
                      <!--                                                            />-->
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
                          label="Facebook pixel ID"
                          outlined
                          v-model="setting.pixels"
                          dense
                      ></v-text-field>
                    </div>

                  </div>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item>
              <v-card flat>
                <v-card-text>
                  <div class="row" v-if="!setting.display_google_analytics">
                    <div class="col-12 float-right">
                      <v-text-field
                          label="Google analytics"
                          outlined
                          v-model="setting.google_analytics"
                          dense
                      ></v-text-field>
                    </div>
                  </div>
                  <div class="row" v-else>
                    <div class="col-12 text-center">
                      <img src="media/misc/lock.png" alt="lock" height="200">
                      <br>
                      <a href="#" class="btn btn-primary" @click="removeSetting('google_analytics')">Remove</a>
                    </div>
                  </div>

                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item>
              <v-card flat>
                <v-card-text>
                  <div class="row" v-if="!setting.display_recaptcha  ">
                        <div class="col-12 float-right">
                          <v-text-field outlined dense v-model="setting.recaptcha_site_key"
                                        label="Recaptcha site key"></v-text-field>
                        </div>
                        <div class="col-12 float-right">
                          <v-text-field outlined dense v-model="setting.recaptcha_secret_key"
                                        label="Recaptcha secret key"></v-text-field>
                        </div>
                  </div>
                  <div class="row" v-else>
                    <div class="col-12 text-center">
                      <img src="media/misc/lock.png" alt="lock" height="200">
                      <br>
                      <a href="#" class="btn btn-primary" @click="removeSetting('recaptcha')">Remove</a>
                    </div>
                  </div>
                </v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs>
        </v-card-text>
      </v-card-text>

    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: ["setting", "facebook_chat_widgets"],
  name: "widget",
  methods:{
    removeSetting(type) {
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
            if(type == 'google_analytics'){
              this.setting.google_analytics =null
            }
            if (type == 'recaptcha'){
              this.setting.recaptcha_secret_key =null
              this.setting.recaptcha_site_key =null
            }
            this.$emit('update_setting')
          }s
        }
      });


    }
  }
}
</script>
