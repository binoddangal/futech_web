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
                      Email template role
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ Email template role
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

            <div class="table-responsive" style="table-layout: fixed">
              <table class="table">
                <thead>
                <th>Title</th>
                <th class="pr-3 text-center">Action</th>
                </thead>
                <tbody>
                <tr v-for="(role, index) of roles" :key="index">
                  <td>
                    <a class="cursor-pointer" @click="openEmailTemplateList(role[1])">{{ role[0] }}
                      <i class="fas fa-circle text-success">
                      </i>
                    </a>
                  </td>


                  <td class="pr-0 text-center">
                    <a @click="openEmailTemplateList(role[1])" class="navi-link">
                        <span class="navi-icon">
                            <i class="fas fa-eye"></i>
                        </span>
                      <span class="navi-text">View</span>
                    </a>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import EmailTemplateService from '@/services/admin/email-template/EmailTemplateService';

const emailTemplate = new EmailTemplateService();

export default {
  name: "EmailTemplateRole",
  props: ['homeRoute'],
  data() {
    return {
      roles: [],
    };
  },

  mounted() {
    this.getEmailTemplateRoles();
  },

  methods: {

    getEmailTemplateRoles() {
      emailTemplate.emailTemplateRoles().then(response => {
        this.roles = response.data;
      });
    },

    openEmailTemplateList(role) {
      window.location.href = `${this.homeRoute}/admin/email-templates/${role}`
    },

  }
};
</script>
