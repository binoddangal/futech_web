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
                    Manage admin users
                </h4>
                <div class="breadcrumb-sub-header">
                    <a href="admin/dashboard">Dashboard </a>\ Admin users
                </div>

                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <v-btn @click="createAdminUser" dark  class="btn-primary  mr-1">
                    <i class="fa fa-plus"></i>
                    Add admin user
                </v-btn
                >
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
            <div class="search-wrapper border-outline mb-5 px-3 pt-5 pb-6 d-sm-flex justify-content-start">
              <div class="row">
                <div class="col-3">
                  <v-text-field
                    label="Search by name, email"
                    outlined
                    clearable
                    dense
                    v-on:keyup.enter="searchAdminUser()"
                    v-model="search.info"
                  >
                  </v-text-field>
                </div>
                <div class="col-3">
                  <v-select
                    label="User type"
                    :items="userTypes"
                    outlined
                    dense
                    item-text="title"
                    v-on:keyup.enter="searchAdminUser()"
                    item-value="value"
                    :disabled="user_type == 'judge'"
                    v-model="search.user_type"
                  >
                  </v-select>
                </div>
                <div class="col-3">
                  <v-select
                    label="Status"
                    :items="statuses"
                    outlined
                    dense
                    item-text="title"
                    v-on:keyup.enter="searchAdminUser()"
                    item-value="value"
                    v-model="search.is_active"
                  >
                  </v-select>
                </div>
                <div class="col-3">
                  <v-btn
                    @click.prevent="searchAdminUser()"
                    class="btn btn-search float-right"
                    :loading="loading"
                    dark
                  >
                    <v-icon small elevation="2" outlined>mdi-magnify</v-icon
                    >&nbsp; Search
                  </v-btn>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <v-skeleton-loader v-if="loading" type="table-thead">
              </v-skeleton-loader>

              <v-skeleton-loader v-if="loading" type="table-row-divider@25">
              </v-skeleton-loader>
              <table class="table" v-if="!loading">
                <thead>
                  <tr class="px-3">
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th class="text-center">Status</th>
                    <th class="pr-3 text-center">Action</th>
                  </tr>
                </thead>
                <tbody v-if="adminusers.length > 0">
                    <tr v-for="(item, index) of adminusers" :key="index">
                        <td>
                            <a class="mr-2 cursor-pointer" @click="editAdminUser(item)">
                            {{ item.full_name }}</a
                            >&nbsp;
                            <i
                            class="fas fa-circle"
                            :class="item.is_active ? 'text-success' : 'text-danger'"
                            ></i>
                        </td>

                        <td>
                            {{ item.email }}
                        </td>

                        <td>
                            {{ item.mobile || item.phone }}
                        </td>

                        <td>
                            {{ item.address }}
                        </td>

                        <td class="text-center">
                            <span :class="item.is_active ? 'badge badge-success' : 'badge badge-danger'">{{ item.is_active ? 'Active' : 'Inactive' }}</span>
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
                                    <v-list-item @click="editAdminUser(item)">
                                        <v-list-item-title>
                                            Edit
                                        </v-list-item-title>
                                    </v-list-item>


                                    <v-list-item @click="deleteAdminUser(item.id)">
                                        <v-list-item-title>Delete</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>



                        </td>
                    </tr>
                </tbody>

                <tbody>
                    <tr v-if="adminusers.length == 0">
                        <td class="py-3 text-center" colspan="10">
                            No Data found.
                        </td>
                    </tr>
                </tbody>

              </table>

                <div class="text-center" v-if="adminusers.length > 0">
                    <v-pagination
                            class="mt-4"
                            v-model="page"
                            :length="lastPage"
                            :total-visible="perPage"
                            @click="getAllAdminUser"
                    ></v-pagination>
                </div>
            </div>
          </div>
          <create-and-update
            ref="create-and-update"
            :user_type="user_type"
            @refresh="getAllAdminUser"
          ></create-and-update>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import AdminUserService from '@/services/admin/admin-user/AdminUserService';

const adminUser = new AdminUserService();
export default {
  name: "AdminUser",
  props: ["user_type"],
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      adminusers: [],
      selectedAdminUser: {
        remarks: "",
      },
      page: null,
      perPage: null,
      lastPage: null,
      total: null,
      loading: false,
      isBusy: false,
      statuses: [
        { title: "Active", value: "1" },
        { title: "Inactive", value: "0" },
      ],
      userTypes: [
        { title: "Admin", value: "admin" },
        { title: "Judge", value: "judge" }
      ],
      search: {
        info: "",
        mobile: "",
        user_type: "",
        is_active: "",
      },
    };
  },
  mounted() {
    this.search.user_type = this.user_type;
    this.getAllAdminUser();
  },
  computed: {
    capitalizedStatus() {
        return this.user_type[0].toUpperCase() + this.user_type.slice(1);
    }
  },
  methods: {
    searchAdminUser() {
      this.page = 1;
      this.getAllAdminUser();
    },

    getAllAdminUser() {
      this.loading = true;
      adminUser
        .paginate(this.search, this.page)
        .then((response) => {
          this.adminusers = response.data.data;
          this.page = response.data.meta.current_page;
          this.total = response.data.meta.total;
          this.lastPage = response.data.meta.last_page;
          this.perPage = response.data.meta.per_page;
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
        });
    },

    createAdminUser() {
      this.$refs["create-and-update"].createAdminUser(this.user_type);
    },

    editAdminUser(id) {
      this.$refs["create-and-update"].editAdminUser(id);
    },

      deleteAdminUser(id) {

          this.$confirm({
              message: `Are you sure?`,
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
                      adminUser
                          .delete(id)
                          .then((response) => {
                              this.$snotify.success(`${this.capitalizedStatus} delete successfully`);
                              this.getAllAdminUser();
                          })
                          .catch((error) => {
                              this.$snotify.error('Problem occurred')
                          });
                  }
              }
          });

    },
  },
};
</script>
<style scoped>
.buttons {
  margin-top: 35px;
}
</style>
