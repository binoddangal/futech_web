<template>
    <v-dialog v-model="dialog" max-width="700" persistent>
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="">User Setting</v-card-title>

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
              <v-col cols="12" md="6" v-if="user.account_type == 'volunteer'">
                <!-- <b>Blood group:</b>
                {{ user.blood_group }} -->
                <v-text-field
                    v-model="setting.blood_group"
                    :error="$v.setting.blood_group.$error"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Blood group <span class="text-danger">*</span>
                </template>
                </v-text-field>
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'volunteer'">
                <!-- <b>Education:</b>
                {{ user.education }} -->
                <v-text-field
                    v-model="setting.education"
                    :error="$v.setting.education.$error"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Education <span class="text-danger">*</span>
                </template>
                </v-text-field>
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'volunteer'">
                <!-- <b>Experience:</b> -->
                <!-- {{ user.experience }} -->
                <v-text-field
                    v-model="setting.experience"
                    :error="$v.setting.experience.$error"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Experience <span class="text-danger">*</span>
                </template>
                </v-text-field>
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'pharmaceutical_company'">
                <!-- <b>Organisation name:</b>
                {{ user.setting.org_name  || 'N/A'}} -->
                <v-text-field
                    v-model="setting.org_name"
                    :error="$v.setting.org_name.$error"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Organisation name <span class="text-danger">*</span>
                </template>
                </v-text-field>
              </v-col>

              <v-col cols="12" md="6"  v-if="user.account_type == 'pharmaceutical_company'">
                <!-- <b>Organisation email:</b>
                {{ user.setting.org_email  || 'N/A'}} -->
                <v-text-field
                    v-model="setting.org_email"
                    :error="$v.setting.org_email.$error"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Organisation email <span class="text-danger">*</span>
                </template>
                </v-text-field>
              </v-col>

              <v-col cols="12" md="6" v-if="user.account_type == 'pharmaceutical_company'">
                <!-- <b>Organisation contact name:</b>
                {{ user.setting.org_contact_name  || 'N/A'}} -->
                <v-text-field
                    v-model="setting.org_contact_name"
                    :error="$v.setting.org_contact_name.$error"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Organisation contact name <span class="text-danger">*</span>
                </template>
                </v-text-field>
              </v-col>

              <v-col
                cols="12"
                v-if="user.account_type == 'volunteer'"
              >
                <div class="my-3" v-if="setting && setting.cv_file_path">
                    <b>CV file: </b>
                    <a
                    :href="setting.cv_file_path.real"
                    target="_blank"
                    >Open file</a
                    >
                </div>
                <v-file-input
                    v-model="setting.cv_file"
                    :error="$v.setting.cv_file.$error"
                    prepend-icon=""
                    prepend-inner-icon="mdi-file"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    CV file <span class="text-danger">*</span>
                </template>
                </v-file-input>
              </v-col>

              <v-col
                cols="12"
                v-if="user.account_type == 'beneficiary' && user.account_type != 'volunteer'"
              >
                <div class="my-3" v-if="user && user.application_document_path">
                    <b>Application document file: </b>
                    <a
                    :href="user.application_document_path.real"
                    target="_blank"
                    >Open file</a
                    >
                </div>
              <v-file-input
                    placeholder="Application signed by Mayor/RM chairman"
                    v-model="setting.application_document_file"
                    :error="$v.setting.application_document_file.$error"
                    prepend-icon=""
                    prepend-inner-icon="mdi-file"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Application signed by Mayor/RM chairman <span class="text-danger">*</span>
                </template>
                </v-file-input>
              </v-col>

              <v-col
                cols="12"
                v-if="user.account_type != 'volunteer'"
              >
                <div class="my-3" v-if="user && user.agreement_document_path">
                    <b>Application document file: </b>
                    <a
                    :href="user.agreement_document_path.real"
                    target="_blank"
                    >Open file</a
                    >
                </div>
              <v-file-input
                    placeholder="Agreement signed by focal person of both Ashwini foundation and your organisation"
                    v-model="setting.agreement_document_file"
                    :error="$v.setting.agreement_document_file.$error"
                    prepend-icon=""
                    prepend-inner-icon="mdi-file"
                    clearable
                    outlined
                    dense
                >
                <template v-slot:label>
                    Agreement signed by focal person of both Ashwini foundation and your organisation <span class="text-danger">*</span>
                </template>
                </v-file-input>
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
import { requiredIf} from 'vuelidate/lib/validators';
import UserSettingService from '@/services/admin/user/setting/UserSettingService';

const userSetting = new UserSettingService();
export default {
    name: "UserSetting",
    data() {
        return {
            dialog: false,
            edit: false,
            loading: false,
            user: {},
            setting: {
                blood_group: '',
                education: '',
                experience: '',
                org_name: '',
                org_contact_name: '',
                org_email: '',
                cv_file: null,
                application_document_file: null,
                agreement_document_file: null,
            }
        }
    },

    validations:{
      setting: {
        blood_group: {
            required: requiredIf(function() {
                return this.user.account_type == 'volunteer';
            })
        },
        education: {
            required: requiredIf(function() {
                return this.user.account_type == 'volunteer';
            })
        },
        experience: {
            required: requiredIf(function() {
                return this.user.account_type == 'volunteer';
            })
        },
        org_name: {
            required: requiredIf(function() {
                return this.user.account_type == 'pharmaceutical_company';
            })
        },
        org_contact_name: {
            required: requiredIf(function() {
                return this.user.account_type == 'pharmaceutical_company';
            })
        },
        org_email: {
            required: requiredIf(function() {
                return this.user.account_type == 'pharmaceutical_company';
            })
        },
        cv_file: {
            required: requiredIf(function() {
                return this.user.account_type == 'volunteer';
            })
        },
        application_document_file: {
            required: requiredIf(function() {
                return this.user.account_type == 'beneficiary';
            })
        },
        agreement_document_file: {
            required: requiredIf(function() {
                return this.user.account_type != 'volunteer';
            })
        },
      }
    },

    methods: {

        cancelSetting() {
            this.dialog = false;
            this.resetForm();
        },

        openDialog(user) {
            this.dialog = true;
            this.user = user;
            if(user && user.setting) {
                this.setting = user.setting;
            }
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
        },

        resetForm() {
            this.$v.setting.$reset();
            this.setting = {
                blood_group: '',
                education: '',
                experience: '',
                org_name: '',
                org_contact_name: '',
                org_email: '',
                cv_file: null,
                application_document_file: null,
                agreement_document_file: null,
            }
        }
    }
}
</script>
