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
          <h4>Manage our projects</h4>
          <div class="breadcrumb-sub-header">
            <a href="admin/dashboard">Dashboard </a>\ Our project
          </div>

          <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
          <!--begin::Primary button-->
          <v-btn @click="addOurProject()" dark class="mt-4 btn-primary mr-1">
            <i class="fa fa-plus"></i>
            Add projects
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
            <div
              class="
                search-wrapper
                border-outline
                mb-5
                px-3
                py-5
                d-sm-flex
                justify-content-start
              "
            >
              <v-row>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Title"
                    type="text"
                    v-on:keyup.enter="getOurProjects()"
                    outlined
                    dense
                    v-model="search.title"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                  <v-select
                    label="Status"
                    outlined
                    dense
                    :items="status"
                    item-text="title"
                    v-on:keyup.enter="getOurProjects()"
                    item-value="value"
                    v-model="search.is_active"
                  >
                  </v-select>
                </v-col>

                <v-col cols="12" md="4" class="text-right">
                  <v-btn
                    @click.prevent="getOurProjects()"
                    class="btn btn-primary"
                    style="color: #fff"
                    :loading="loading"
                  >
                    <v-icon small>mdi-magnify</v-icon>&nbsp; Search
                  </v-btn>
                </v-col>
              </v-row>
            </div>
            <div class="table-responsive">
              <v-skeleton-loader v-if="loading" type="table-thead">
              </v-skeleton-loader>

              <v-skeleton-loader v-if="loading" type="table-row-divider@25">
              </v-skeleton-loader>
              <table class="table">
                <thead>
                  <tr class="px-3">
                    <th>Title</th>
                    <th>Description</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(ourProject, index) of ourProjects" :key="index">
                    <td>
                      <i class="cursor-drag fas fa-sort handle pr-2"></i>
                      <a @click="editOurProject(ourProject)" class="mr-2">
                        {{ ourProject.title }}</a
                      >
                      <i
                        class="fas fa-circle"
                        :class="
                          ourProject.is_active ? 'text-success' : 'text-danger'
                        "
                      ></i>
                    </td>

                    <td class="w-50">
                      <span v-if="ourProject.description && ourProject.description.length > 100" v-html="ourProject.description.slice(0, 100) +' .....'"></span>
                      <span v-if="ourProject.description && ourProject.description.length <= 100" v-html="ourProject.description"></span>
                    </td>

                    <td>
                        <span class="badge badge-success text-lg"
                            v-bind:class="{ 'badge-success': ourProject.is_active, 'badge-danger': !ourProject.is_active }">{{ ourProject.is_active ? 'Active' : 'Inactive' }}</span>
                    </td>

                    <td>
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
                          <v-list-item @click="editOurProject(ourProject)">
                            <v-icon small class="mx-2" color="blue darken-2"
                              >fas fa-edit</v-icon
                            >
                            <v-list-item-title>Edit</v-list-item-title>
                          </v-list-item>

                          <v-list-item @click="deleteOurProject(ourProject.id)">
                            <v-icon small class="mx-2" color="red darken-2"
                              >fas fa-trash</v-icon
                            >
                            <v-list-item-title>Delete</v-list-item-title>
                          </v-list-item>
                        </v-list>
                      </v-menu>
                    </td>
                  </tr>
                </tbody>

                <template v-if="ourProjects.length == 0">
                  <tr>
                    <td class="text-center px-3" colspan="6">No items found</td>
                  </tr>
                </template>
              </table>
              <v-pagination
                v-show="ourProjects.length > 0"
                @input="getOurProjects"
                class="pull-right mt-7"
                v-model="page"
                :total-rows="total"
                :length="lastPage"
              ></v-pagination>
            </div>
          </div>
          <create-and-update
            ref="ourProject"
            @refresh="getOurProjects"
          ></create-and-update>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import OurProjectService from "@/services/admin/cms/our-project/OurProjectService";

const ourProjectService = new OurProjectService();
export default {
  name: "OurProject",
  props: ["homeRoute"],
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      dragging: false,
      loading: false,
      page: null,
      lastPage: null,
      perPage: null,
      total: null,
      ourProjects: [],
      status: [
        { title: "Active", value: "1" },
        { title: "In Active", value: "0" },
      ],
      search: {
        title: "",
        is_active: "",
      },
    };
  },
  mounted() {
    this.getOurProjects();
  },
  methods: {
    getOurProjects() {
      this.loading = true;
      ourProjectService
        .paginate(this.search)
        .then((response) => {
          this.ourProjects = response.data.data;
          this.page = response.data.meta.current_page;
          this.total = response.data.meta.total;
          this.perPage = response.data.meta.per_page;
          this.lastPage = response.data.meta.last_page;
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
        });
    },

    addOurProject() {
      this.$refs["ourProject"].addOurProject();
    },

    editOurProject(ourProject) {
      this.$refs["ourProject"].editOurProject(ourProject);
    },

    deleteOurProject(id) {
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
            ourProjectService
              .delete(id)
              .then((response) => {
                this.getOurProjects();
              })
              .catch((error) => {
                //console.log(error);
              });
          }
        },
      });
    },
    detail(id) {
      window.location.href =
        window.location.origin + "/admin/our-project/" + id + "/projects";
    },
  },
};
</script>
<style scoped>
.buttons {
  margin-top: 35px;
}
.truncate {
  max-width: 500px;
  max-height: 50px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
