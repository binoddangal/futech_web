<template>
  <v-app>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
      <!--begin::Toolbar container-->
      <div
        id="kt_app_toolbar_container"
        class="app-container container-fluid d-flex flex-stack"
      >
        <!--begin::Page title-->
        <div
          class="
            page-title
            d-flex
            flex-column
            justify-content-center
            flex-wrap
            me-3
          "
        >
          <!--begin::Title-->
          <h4>Applications Received for {{ career.title }}</h4>
          <div class="breadcrumb-sub-header">
            <a href="admin/dashboard">Dashboard </a>\ Applications Received
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
            <div class="table-responsive">
              <v-skeleton-loader type="table-thead" v-if="loading">
              </v-skeleton-loader>

              <v-skeleton-loader v-if="loading" type="table-row-divider@25">
              </v-skeleton-loader>
              <table class="table">
                <thead>
                  <tr class="px-3">
                    <th class="px-3">Full name</th>
                    <th class="px-3">Email</th>
                    <th class="px-3">Phone</th>
                    <!--                  <th>Job Position</th>-->
                    <th class="pr-3 text-center">Resume download</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-show="applications.length > 0"
                    v-for="(application, index) of applications"
                    :key="index"
                  >
                    <td class="px-3">
                      <span class="font-weight-medium">
                        {{ application.full_name }}
                      </span>
                    </td>
                    <td class="px-3">
                      <a
                        class="text-info mb-1"
                        :href="'mailto:' + application.email"
                      >
                        {{ application.email ? application.email : "NA" }}
                      </a>
                    </td>
                    <td class="px-3">
                      <a
                        class="text-primary mb-1"
                        :href="'tel:' + application.phone"
                      >
                        {{ application.phone }}
                      </a>
                    </td>
                    <!--                    <td>{{application.career_title}}</td>-->
                    <td class="pr-0 text-center">
                      <a
                        class="cursor-pointer"
                        :href="application.file_path.real"
                        target="_blank"
                      >
                        <i class="fas fa-download"></i>
                    </a>
                    </td>
                  </tr>
                  <tr v-if="applications.length == 0">
                    <td colspan="4" class="text-center">No items added</td>
                  </tr>
                </tbody>
              </table>
              <v-pagination
                    @input="getApplications" v-if="applications && applications.length > 0"
                    v-model="page"  class="pull-right mt-7"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>

            </div>
          </div>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import CareerApplicationService from "@/services/admin/cms/career/application/CareerApplicationService";
import CareerService from "@/services/admin/cms/career/CareerService";

const career = new CareerService();
const applicationService = new CareerApplicationService();

export default {
  name: "Career",
  components: {},
  props: ["id"],
  data() {
    return {
      search: {
        career_id: "",
      },
      career: {},

      page: null,
      total: null,
      perPage: null,
      lastPage: null,
      applications: [],
      loading: false,
    };
  },
  mounted() {
    this.search.career_id = this.id;
    this.getApplications();
    this.getCareer();
  },
  methods: {
    getCareer() {
      career.show(this.search.career_id).then((response) => {
        this.career = response.data.career;
      });
    },
    getApplications() {
      applicationService.paginate(this.search).then((response) => {
        this.applications = response.data.data;
        this.page = response.data.meta.current_page;
        this.total = response.data.meta.total;
        this.perPage = response.data.meta.per_page;
        this.lastPage = response.data.meta.last_page;
      });
    },
    editCareer(id) {
      window.location.href = `admin/career/${id}/edit`;
    },
  },

  deleteCareer(id) {
    this.$confirm({
      message: `Are you sure?`,
      button: {
        no: "No",
        yes: "Yes",
      },
      /**
       * Callback Function
       * @param {Boolean} confirm
       */
      callback: (confirm) => {
        if (confirm) {
          applicationService
            .delete(id)
            .then((response) => {
              this.$snotify.success("Deleted successfully");

              this.getApplications();
            })
            .catch((error) => {});
        }
      },
    });
  },
  downloadCv(path) {
    window.open(path);
  },
};
</script>
