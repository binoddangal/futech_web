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
                      {{ role_name }} Email template
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ Email template
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
            <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">
              <div class="row">
                <v-col cols="12" sm="6" md="4">
                  <v-text-field  v-on:keyup.enter="searchEmailTemplate"
                                 @input="search.info = $event !== null ? $event : ''"
                                 label="Lookup by Title"
                                 v-model="search.info" outlined dense clearable>

                  </v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="3">
                  <v-select v-model="search.role" :items="roles"
                            label="Roles"
                            item-text="text"  v-on:keyup.enter="searchEmailTemplate"
                            item-value="value"
                            outlined
                            dense
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" sm="6" md="3">
                  <v-select
                      :items="status"
                      v-model="search.is_active"
                      label="Status"
                      item-text="name"
                      item-value="value"
                      outlined
                      v-on:keyup.enter="searchEmailTemplate"
                      dense clearable
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="2">
                  <v-btn :loading="isLoading"
                      @click="searchEmailTemplate"
                      class="mt-1 btn btn-block btn-primary"
                      style="color: #fff;"
                  >
                    <v-icon small elevation="2" outlined>fas fa-search</v-icon>&nbsp;
                    Search
                  </v-btn>
                </v-col>
              </div>
            </div>
            <div class="table-responsive" style="table-layout: fixed">
              <v-skeleton-loader
                  type="table-thead"
                  v-if="isLoading">
              </v-skeleton-loader>

              <v-skeleton-loader
                  v-if="isLoading"
                  type="table-row-divider@25">
              </v-skeleton-loader>
              <table class="table">
                <thead>
                <th class="px-3">Title</th>
                <th class="px-3">Subject</th>

                <th class="px-3">Status</th>
                <th class="px-3 text-center">Action</th>
                </thead>
                <tbody v-if="email_templates.length>0">
                <tr v-for="(email_template, index) of email_templates" :key="index">
                  <td  class="px-2">
                    <a  class="text-dark-75 text-hover-primary mb-1"  @click="__edit(email_template.id)">{{ email_template.title }}
                    </a>
                    <div>
                      <span class="badge badge-primary"> {{ email_template.score_id ? 'Customize For '+email_template.score_name : 'DEFAULT' }}</span>
                    </div>
                  </td>
                  <td class="px-2">
                    <span class="font-weight-bolder text-dark-75 text-hover-primary mb-1 font-size-lg">
                      {{ email_template.subject ? email_template.subject : 'N/A' }}
                    </span>
                  </td>
                  <td class="px-2">
                     <span class="badge badge-success" v-bind:class="{ 'badge-success': email_template.is_active, 'badge-danger': !email_template.is_active }">
                       {{ email_template.status_text }}
                     </span>
                  </td>
                  <td class="pr-0 text-center">
                    <v-menu offset-y>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          color="primary"
                          text
                          icon
                          v-bind="attrs"
                          v-on="on"
                        >
                          <v-icon>mdi-dots-horizontal</v-icon>
                        </v-btn>
                      </template>
                      <v-list>
                        <v-list-item
                        @click="__edit(email_template.id)"
                        >
                          <v-icon class="mx-2" color="blue darken-2">fas fa-edit</v-icon>
                          <v-list-item-title>Edit</v-list-item-title>
                        </v-list-item>

                        <v-list-item
                          @click="openCloneForm(email_template)"
                        >
                          <v-icon class="mx-2" color="orange darken-2">fas fa-clone</v-icon>
                          <v-list-item-title>Customize</v-list-item-title>
                        </v-list-item>

                      </v-list>
                    </v-menu>

                  </td>
                </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="50" class="text-center">No data found</td>
                  </tr>
                </tbody>
              </table>
              <v-pagination v-if="email_templates.length > 0"
                  @input="getTemplates"
                  class="pull-right mt-7"
                  v-model="page"
                  :total-rows="total"
                  :length="lastPage"
              ></v-pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
    <v-dialog v-model="cloneDialog" max-width="500">
      <v-card>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="btn btn-primary"
                dark :loading="cloneLoading"
                medium @click="clone">
             Clone Email Template
            </v-btn>
            <v-btn
                color="btn btn-standard"
                dark
                medium
                @click="closeCloneForm">
              Cancel
            </v-btn>

          </v-card-actions>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>
<script>
import EmailTemplateService from '@/services/admin/email-template/EmailTemplateService';

const emailTemplate = new EmailTemplateService();

export default {
  name: "EmailTemplate",
  props: ['role', 'homeRoute'],
  data() {
    return {
        cloneDialog: false,
        isLoading: false,
        page: null,
        total: null,
        perPage: null,
        lastPage: null,
        cloneLoading: false,
        email_templates: [],
        search: {
          title:'',
          role: '',
          identifier: "",
          is_active: "",
        },
        roles: [],
        email_template:{
          id:'',
          title:'',
          role:'',
          type:'',
          subject:'',
          description:'',
          accepted_inputs:'',
          is_active: true,
        },
        status: [
          { name: 'Active', value: 1 },
          { name: 'Inactive', value: 0 },
        ]
    };
  },
  computed: {
    rules() {
      return {
        email_template: {
        }
      }
    },

    role_name() {
      let role = this.role.charAt(0).toUpperCase() + this.role.slice(1);
      return role.replace("_", " ");
    }
  },
  mounted() {
    this.search.role = this.role;
    this.getEmailTemplateRoles();
    this.getTemplates();
  },

  validations(){
    return this.rules;
  },

  methods: {
    getEmailTemplateRoles() {
      emailTemplate.emailTemplateRoles().then(response => {
        let roles = [];
        if(response.data.length > 0) {
          roles = response.data;
          roles.forEach(role => {
            this.roles.push({
              "text": role[0],
              "value": role[1],
            })
          })
          roles.forEach(role => {

          });
        }
      });
    },


    openCloneForm(item){
      this.email_template=item;
      this.clone();
    },

    closeCloneForm(){
      this.cloneDialog = false;
      this.email_template={
            id:'',
            title:'',
            role:'',
            type:'',
            subject:'',
            description:'',
            accepted_inputs:'',
            is_active:true,
      };
    },
    getTemplates() {
      this.isLoading = true;
        emailTemplate
          .paginate(this.search, this.page)
            .then(response => {
            this.email_templates = response.data.data;
            this.page = response.data.meta.current_page;
            this.total = response.data.meta.total;
            this.perPage = response.data.meta.per_page;
            this.lastPage = response.data.meta.last_page;
            this.isLoading = false;
          })
          .catch((err) => {
            console.log(err);
            this.isLoading = false;
          });
    },
    __edit(id) {
      window.location.href = `${this.homeRoute}/admin/email-templates/${id}/edit`
    },
    searchEmailTemplate() {
      this.getTemplates();
    },
    clone(){
      this.$v.$touch()
      if (this.$v.$error) {
        setTimeout(() => {
          this.$v.$reset()
        }, 3000);
      }
      else {
        this.cloneLoading = true;
        this.email_template.role = this.role;
        emailTemplate
            .clone(this.email_template)
            .then(response => {
              this.$snotify.success("Email Template Customize Successfully");
              this.cloneLoading = false;
              this.getTemplates();
              this.closeCloneForm();

            })
      }
    },
  },

};
</script>
