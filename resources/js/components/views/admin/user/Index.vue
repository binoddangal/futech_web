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
                      Manage user
                  </h4>
                  <div class="breadcrumb-sub-header">
                      <router-link to="/dashboard">Dashboard </router-link>\ User
                  </div>

                  <!--end::Breadcrumb-->
              </div>
              <!--end::Page title-->
              <!--begin::Actions-->
              <div class="d-flex align-items-center gap-2 gap-lg-3">
                  <!--begin::Primary button-->

                  <v-menu offset-y v-if="status == 'volunteer'">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                            color="info"
                            class="mt-4"
                            v-bind="attrs"
                            v-on="on"
                            >
                            Export
                            </v-btn>
                        </template>
                        <v-list>

                            <v-list-item
                                @click="exportCSV()"
                            >
                                <v-icon class="mx-2" color="blue darken-2" small>fas fa-file-csv</v-icon>
                                <v-list-item-title>CSV</v-list-item-title>
                            </v-list-item>

                            <v-list-item
                                @click="exportExcel()"
                            >
                                <v-icon class="mx-2" color="blue darken-2" small>fas fa-file-excel</v-icon>
                                <v-list-item-title>Excel</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>

                    <v-btn @click="createUser()" dark  class="mt-4 btn-primary  mr-1">
                      <i class="fa fa-plus"></i>
                      Add user
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
            <div
              class="
                search-wrapper
                border-outline
                mb-5
                px-3
                pt-4
                d-sm-flex
                justify-content-start
              "
            >
              <div class="row">
                <div class="col-3">
                  <v-text-field
                    label="Search by name and email"
                    outlined
                    clearable
                    dense
                    v-on:keyup.enter="searchUser()"
                    v-model="search.info"
                  >
                  </v-text-field>
                </div>
                <div class="col-3" v-if="status != 'pending'">
                  <v-select
                    label="User Status"
                    :items="userStatus"
                    outlined
                    dense
                    item-text="title"
                    v-on:keyup.enter="searchUser()"
                    item-value="value"
                    v-model="search.status"
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
                    v-on:keyup.enter="searchUser()"
                    item-value="value"
                    v-model="search.is_active"
                  >
                  </v-select>
                </div>
                <div :class="status != 'pending' ? 'col-3' : 'col-6'">
                  <v-btn
                    @click.prevent="searchUser()"
                    class="btn btn-primary float-right"
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
                    <th>Mobile/phone</th>
                    <th>Account type</th>
                    <th>Status</th>
                    <th class="pr-3 text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) of users" :key="index">
                        <td>
                            <a @click="editUser(item)">
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
                            <span class="badge badge-info text-lg"
                            >{{ item.account_type_text }}</span>
                        </td>

                        <td>
                            <span class="badge badge-success text-lg"
                                v-bind:class="{ 'badge-success': item.is_active, 'badge-danger': !item.is_active }"
                            >{{ item.is_active ? 'Active' : 'Inactive' }}</span>
                        </td>

                        <td class="pr-0 text-left">
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
                                        @click="openDialog(item)"
                                    v-if="item.status == 'pending'"
                                    >
                                        <v-icon class="mx-2" color="blue darken-2" small>fas fa-eye</v-icon>
                                        <v-list-item-title>Approved/Rejected</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item
                                        @click="openQuickView(item)"
                                    >
                                        <v-icon class="mx-2" color="blue darken-2" small>fas fa-eye</v-icon>
                                        <v-list-item-title>Quick view</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item
                                        @click="openUserSetting(item)"
                                    >
                                        <v-icon class="mx-2" color="blue darken-2" small>fas fa-eye</v-icon>
                                        <v-list-item-title>Other detail</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item
                                        @click="editUser(item)"
                                    v-if="item.status != 'pending'"
                                    >
                                        <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                        <v-list-item-title>Edit</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item
                                        @click="deleteUser(item.id)"
                                    v-if="item.status != 'pending'"
                                    >
                                        <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                        <v-list-item-title>Delete</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </td>
                    </tr>
                </tbody>

                <tbody v-if="users.length == 0">
                    <tr>
                        <td class="py-3 text-center" colspan="10">
                            Items not found.
                        </td>
                    </tr>
                </tbody>

              </table>
            </div>
          </div>
          <create-and-update
            ref="create-and-update"
            @refresh="getAllUser"
          ></create-and-update>
        </div>
      </div>
    </div>

    <v-dialog v-model="dialog" max-width="700" persistent>
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class=""> Approved/Rejected user </v-card-title>

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
                {{ selectedUser.full_name }}
              </v-col>

              <v-col cols="12" md="6">
                <b>Email:</b>
                {{ selectedUser.email }}
              </v-col>

              <v-col cols="12" md="6">
                <b>Mobile/Phone:</b>
                {{ selectedUser.mobile || selectedUser.phone }}
              </v-col>

              <v-col cols="12" md="6" v-if="selectedUser.account_type == 'pharmaceutical_company'">
                <b>Organisation name:</b>
                {{ selectedUser.org_name  || 'N/A'}}
              </v-col>

              <v-col cols="12" md="6"  v-if="selectedUser.account_type == 'pharmaceutical_company'">
                <b>Organisation email:</b>
                {{ selectedUser.org_email  || 'N/A'}}
              </v-col>

              <v-col cols="12" md="6"  v-if="selectedUser.account_type == 'pharmaceutical_company'">
                <b>Organisation contact name:</b>
                {{ selectedUser.org_contact_name  || 'N/A'}}
              </v-col>

              <v-col
                cols="12"
                v-if="selectedUser.application_document_path && selectedUser.account_type == 'beneficiary'"
              >
                <b>Application document file: </b>
                <a
                  :href="selectedUser.application_document_path.thumb"
                  target="_blank"
                  >Open file</a
                >
              </v-col>
              <v-col
                cols="12"
                v-if="selectedUser.agreement_document_path"
              >
                <b>Agreement document file: </b>
                <a
                  :href="selectedUser.agreement_document_path.thumb"
                  target="_blank"
                  >Open file</a
                >
              </v-col>

              <v-col cols="12">
                <label>Description</label>
                <ckeditor :config="editorConfig" v-model="selectedUser.remarks"></ckeditor>
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
            >Cancel
          </v-btn>
          <v-btn
            class="text-white btn btn-danger"
            color="red"
            dark
            @click="rejectedUser"
            :loading="isBusy"
            >Rejected
          </v-btn>
          <v-btn
            class="text-white btn btn-primary"
            dark
            @click="approvedUser"
            :loading="isBusy"
            >Approved
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <user-setting ref="user-setting"></user-setting>
    <quick-user ref="quick-user"></quick-user>
  </v-app>
</template>
<script>
import QuickUser from './QuickUser.vue';
import CreateAndUpdate from "./CreateAndUpdate.vue";
import UserService from '@/services/admin/user/UserService';
import UserSetting from './setting/UserSetting.vue';

const user = new UserService();
export default {
  name: "User",
  props: ["status"],
  components: {
    CreateAndUpdate,
    QuickUser,
    UserSetting,
  },
  data() {
    return {
      users: [],
      selectedUser: {
        remarks: "",
      },
      page: null,
      perPage: null,
      lastPage: null,
      total: null,
      dialog: false,
      loading: false,
      isBusy: false,
      statuses: [
        { title: "Active", value: "1" },
        { title: "In Active", value: "0" },
      ],
      userStatus: [
        { title: "Pending", value: "pending" },
        { title: "Approved", value: "approved" },
        { title: "Rejected", value: "rejected" },
      ],
      search: {
        info: "",
        mobile: "",
        account_type: "",
        status: "",
        type: "",
        is_active: "",
      },
      editorConfig: {
            toolbar: [
              [
                'Font', 'FontSize', 'FontColor', 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Link', 'NumberedList', 'BulletedList', 'TextColor', 'BGColor'
              ]
            ],
          extraPlugins: ['font', 'colorbutton'],
          colorButton_enableMore: true,
        }
    };
  },
  mounted() {
    if(this.status  == 'pending' || this.status == 'approved' || this.status == 'rejected') {
        this.search.status = this.status;
    } else {
        this.search.account_type = this.status;
        this.search.status = 'approved';
    }
    this.getAllUser();
  },
  methods: {
    openDialog(item) {
      this.dialog = true;
      this.selectedUser = item;
    },

    openQuickView(item) {
        this.$refs['quick-user'].openView(item);
    },

    openUserSetting(item) {
        this.$refs['user-setting'].openDialog(item);
    },

    searchUser() {
      this.page = 1;
      this.getAllUser();
    },

    exportCSV() {
        this.search.type = 'csv';
        user.exportVolunteer(this.search);
    },

    exportExcel() {
        this.search.type = 'excel';
        user.exportVolunteer(this.search);
    },

    getAllUser() {
      this.loading = true;
      user
        .paginate(this.search, this.page)
        .then((response) => {
          this.users = response.data.data;
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

    createUser() {
      this.$refs["create-and-update"].createUser(this.status);
    },

    editUser(id) {
      this.$refs["create-and-update"].editUser(id);
    },

    approvedUser() {
      this.selectedUser.status = "approved";
      this.isBusy = true;
      user
        .approvedOrRejectedUser(
          this.selectedUser.id,
          this.selectedUser
        )
        .then((response) => {
          this.$snotify.success("This is user is approved ");
          this.isBusy = false;
          this.dialog = false;
          this.selectedUser = {};
          this.getAllUser();
        })
        .catch((error) => {
          this.isBusy = false;
        });
    },

    rejectedUser() {
      this.selectedUser.status = "rejected";
      this.isBusy = true;
      user
        .approvedOrRejectedUser(
          this.selectedUser.id,
          this.selectedUser
        )
        .then((response) => {
          this.isBusy = false;
          this.dialog = false;
          this.selectedUser = {};
          this.$snotify.success("This is user is rejected");
          this.getAllUser();
        })
        .catch((error) => {
          this.isBusy = false;
        });
    },

    deleteUser(id) {
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
            user
              .delete(id)
              .then((response) => {
                this.$snotify.success("User delete successfully !!");
                this.getAllUser();
              })
              .catch((error) => {
                //console.log(error);
              });
          }
        },
      });
    },
  },
};
</script>
