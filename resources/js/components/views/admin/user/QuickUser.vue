<template>
    <v-dialog v-model="dialog" max-width="700" persistent>
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="">Quick view user </v-card-title>

          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-spacer></v-spacer>
            <v-btn icon @click="dialog = false">
              <i class="fas fa-times"></i>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" md="6">
                <b>Full name:</b>
                {{ user.full_name }}
              </v-col>

              <v-col cols="12" md="6">
                <b>Email:</b>
                {{ user.email }}
              </v-col>

              <v-col cols="12" md="6">
                <b>Mobile/Phone:</b>
                {{ user.mobile || user.phone }}
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'pharmaceutical_company'">
                <b>Blood group:</b>
                {{ user.blood_group }}
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'pharmaceutical_company'">
                <b>Education:</b>
                {{ user.education }}
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'pharmaceutical_company'">
                <b>Experience:</b>
                {{ user.experience }}
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'pharmaceutical_company'">
                <b>Organisation name:</b>
                {{ user.setting.org_name  || 'N/A'}}
              </v-col>

              <v-col cols="12" md="6"  v-if="user.account_type == 'pharmaceutical_company'">
                <b>Organisation email:</b>
                {{ user.setting.org_email  || 'N/A'}}
              </v-col>

              <v-col cols="12" md="6"  v-if="user.account_type == 'pharmaceutical_company'">
                <b>Organisation contact name:</b>
                {{ user.setting.org_contact_name  || 'N/A'}}
              </v-col>

              <v-col
                cols="12"
                v-if="user.setting && user.setting.cv_file_path && user.account_type == 'volunteer'"
              >
                <b>CV file: </b>
                <a
                  :href="user.setting.cv_file_path.real"
                  target="_blank"
                  >Open file</a
                >
              </v-col>

              <v-col
                cols="12"
                v-if="user.application_document_path && user.account_type == 'beneficiary' && user.account_type != 'volunteer'"
              >
                <b>Application document file: </b>
                <a
                  :href="user.application_document_path.real"
                  target="_blank"
                  >Open file</a
                >
              </v-col>

              <v-col
                cols="12"
                v-if="user.agreement_document_path"
              >
                <b>Agreement document file: </b>
                <a
                  :href="user.agreement_document_path.real"
                  target="_blank"
                  >Open file</a
                >
              </v-col>

            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            class="btn btn-standard cancel-btn"
            dark
            @click="dialog = false"
            >Close
          </v-btn>

          <v-btn
            v-if="user.application_document_path == null || user.agreement_document_path == null"
            class="text-white btn btn-primary"
            dark
            @click="updateSetting"
            :loading="loading"
            >Update
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<script>
import { required, requiredIf} from 'vuelidate/lib/validators';
import UserSettingService from '@/services/admin/user/setting/UserSettingService';

const userSetting = new UserSettingService();
export default {
    name: "QuickUser",
    data() {
        return {
            dialog: false,
            edit: false,
            loading: false,
            user: {},
            setting: {
                application_document_file: null,
                agreement_document_file: null,
            }
        }
    },

    validations:{
      setting: {
        application_document_file: {required: requiredIf(function() {
            return this.user.account_type == 'beneficiary';
        })
        },
        agreement_document_file: {required},
      }
    },

    methods: {

        cancelSetting() {
            this.$v.setting.$reset();
            this.dialog = false;
            this.setting = {
                application_document_file: null,
                agreement_document_file: null,
            }
        },

        openView(user) {
            this.dialog = true;
            this.user = user;
        },

        generateSettingFd() {
            let fd = new FormData();
            for (let key in this.setting) {
                if (key == "application_document_file" && this.setting["application_document_file"] && this.setting["application_document_file"] != null) {
                    fd.append("application_document_file", this.setting[key]);
                } else if(key == "agreement_document_file" && this.setting["agreement_document_file"] && this.setting["agreement_document_file"] != null) {
                    if (this.setting[key] != null) {
                        fd.append("agreement_document_file", this.setting[key]);
                    }
                } else {
                    if (this.setting[key] != null) {
                        fd.append(key, this.setting[key]);
                    }
                }
            }
            return fd;
        },

        updateSetting() {
            let fd = this.generateSettingFd();
            this.loading = true;
            userSetting
                .createOrUpdate(this.user.id, fd)
                .then(() => {
                    this.loading = false;
                    this.$snotify.success("Updated successfully");
                    this.setting.application_document_file = null;
                    this.setting.agreement_document_file = null;
                    this.cancelSetting();
                })
                .catch(error => {
                    this.loading = false;
                    this.$snotify.error("Something Went Wrong");
                });
        }
    }
}
</script>
