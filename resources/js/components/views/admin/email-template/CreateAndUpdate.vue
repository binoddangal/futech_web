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
                      Update Email Template
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard</a> \<a class="cursor-pointer" @click="redirectedTo"> Email Template</a> \ Update Email Template
                    </div>

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12">
                  <h4>Email Template</h4>
                </div>

                <v-row>
                  <v-col cols="8">
                    <v-col cols="12">
                      <h6>{{ email_template.title }}</h6>
                    </v-col>

                    <v-col cols="12">
                      <v-text-field
                          outlined
                          dense
                          label="Email Subject"
                          v-model="email_template.subject"
                      >

                      </v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <strong>
                        Content
                      </strong>
                      <ckeditor v-model="email_template.description"></ckeditor>
                    </v-col>
                  </v-col>
                  <v-col cols="4">

                    <v-col cols="12">
                      <strong>Accepted Inputs</strong>
                    </v-col>

                    <v-col cols="12" v-if="accepted_inputs.length">
                      <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn v-for="(input,index) in accepted_inputs " :key="index"
                                class="ma-2 text-lowercase"
                                color="success"
                                outlined
                                label
                                dark
                                v-bind="attrs"
                                v-on="on"
                          >
                            {{ input }}
                          </v-btn>
                        </template>
                        <span>Copy</span>
                      </v-tooltip>

                    </v-col>
                    <v-col cols="12">
                      <v-switch label="Active" v-model="email_template.is_active">

                      </v-switch>
                    </v-col>
                    <v-col cols="12">
                      <v-btn @click.prevent="__update" :loading="is_loading" class="btn btn-primary text-white" dark>
                        Save
                      </v-btn>
                      <v-btn @click="redirectedTo" class="btn btn-secondary ml-2" text>
                        Cancel
                      </v-btn>
                    </v-col>

                  </v-col>
                </v-row>

              </div>
            </div>
        </div>
      </div>
    </div>
      <!-- <v-snackbar v-model="snackbar" :timeout="timeout">
        {{ text }}
        <v-btn color="blue" text @click="snackbar = false">Close</v-btn>
      </v-snackbar> -->
  </v-app>
</template>
<script>
import EmailTemplateService from '@/services/admin/email-template/EmailTemplateService';

const emailTemplate = new EmailTemplateService();
export default {
  name: "CreateAndUpdate",
  props: ['id','homeRoute'],
  components: {},
  data() {
    return {
      text: null,
      timeout: 2000,
      is_loading: false,
      snackbar: false,
      email_template: {},
      accepted_inputs: [],
    };
  },

  mounted() {
    this.getSingleEmailTemplate(this.id);
  },

  methods: {
    getSingleEmailTemplate(id) {
      emailTemplate
          .show(id)
          .then(response => {
        this.email_template = response.data.email_template;
        if (this.email_template.accepted_inputs) {
          this.accepted_inputs = this.email_template.accepted_inputs.split(',');
        }
      }).catch(error => {
      }).finally(() => {

      })
    },
    redirectedTo() {
      window.location.href = `${this.homeRoute}/admin/email-templates/${this.email_template.role}`
    },
    __update() {
        this.is_loading = true;
        this.email_template.accepted_inputs = this.accepted_inputs.join(',');
        emailTemplate.update(this.email_template.id, this.email_template).then(response => {
          this.$snotify.success('Updated Successfully')
          this.getSingleEmailTemplate(this.email_template_id);
          this.$tabs.close();
          this.$router.push({name: "email-template"});
        }).catch(error => {

        }).finally(() => {
          this.is_loading = false;

        })
      },

    //   onCopy: function (e) {
    //     this.text = "You just copied accepted input ";
    //     this.snackbar = true;
    //   },

    //   onError: function (e) {
    //     this.text = "Failed to copy accepted input";
    //     this.snackbar = true;
    //   },
  }
};
</script>
