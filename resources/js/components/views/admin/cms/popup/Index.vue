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
                      Manage popups
                  </h4>
                  <div class="breadcrumb-sub-header">
                      <a href="admin/dashboard">Dashboard </a>\ popups
                  </div>

                  <!--end::Breadcrumb-->
              </div>
              <!--end::Page title-->
              <!--begin::Actions-->
              <div class="d-flex align-items-center gap-2 gap-lg-3">
                  <!--begin::Primary button-->
                  <v-btn @click="createPopup()" dark  class="mt-4 btn-primary  mr-1">
                      <i class="fa fa-plus"></i>
                      Add popup
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
              <div class="search-wrapper border-outline mb-5 px-3 pt-3 d-sm-flex justify-content-start">
                <v-row>
                  <v-col cols="12" md="4">
                    <v-text-field label="Title"
                                  type="text"
                                  dense  v-on:keyup.enter="getPopups()"

                                  outlined
                                  v-model="search.title"></v-text-field>
                  </v-col>

                  <v-col cols="12" md="4">
                    <v-select label="Status" outlined dense :items="active_statuses" item-text="title"
                      item-value="value" v-on:keyup.enter="getPopups()"  @input="search.active = $event !== null ? $event : ''"
                      v-on:change="getPopups"
                      v-model="search.active"></v-select>
                  </v-col>

                  <v-col cols="12" md="4" class="text-right">
                      <v-btn
                          @click="getPopups()"
                          class="btn btn-primary btn-search "
                          :loading="loading"
                      >
                        <v-icon small elevation="2" outlined>mdi-magnify</v-icon>&nbsp;
                        Search
                      </v-btn>
                  </v-col>
                </v-row>
              </div>
              <div class="table-responsive">
                <v-skeleton-loader
                    type="table-thead"
                    v-if="loading"
                >
                </v-skeleton-loader>

                <v-skeleton-loader
                    v-if="loading"
                    type="table-row-divider@25"
                >
                </v-skeleton-loader>
                <table class="table ">
                  <thead>
                  <tr class="px-3">
                    <th>Title</th>
                    <th>Type</th>
                    <th class="px-3">Active</th>
                    <th class="pr-3 text-center">Action</th>
                  </tr>
                  </thead>
                  <tbody>

                        <tr v-for="(popup, index) of popups" :key="index">
                        <td>
                            <i v-if="search.active=='active'" class="cursor-drag fas fa-sort handle pr-2"></i>
                            <a href="#" @click="editPopup(popup.id)" class="mr-2"> {{ popup.title }}</a>&nbsp;&nbsp;
                            <i class="fas fa-circle"
                            :class="popup.is_active?'text-success':'text-danger'"></i>
                        </td>
                        <td>{{ popup.type_text }}</td>
                        <td>
                            <span class="badge badge-success text-lg"
                                v-bind:class="{ 'badge-success': popup.is_active, 'badge-danger': !popup.is_active }">{{ popup.is_active ? 'Active' : 'Inactive' }}</span>
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
                                        @click="editPopup(popup)"
                                    >
                                        <v-icon small class="mx-2" color="blue darken-2">fas fa-edit</v-icon>
                                        <v-list-item-title>Edit</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item
                                        @click="deletePopup(popup.id)"
                                    >
                                        <v-icon small class="mx-2" color="red darken-2">fas fa-trash</v-icon>
                                        <v-list-item-title>Delete</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>

                        </td>
                        </tr>
                        <tr v-if="popups.length == 0">
                        <td colspan="10" class="text-center">
                            No items added
                        </td>
                        </tr>
                   </tbody>
                </table>
                <v-pagination
                    v-if="popups.length > 0"
                    class="pull-right mt-7"
                    @input="getPopups"
                    v-model="page"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>
              </div>

           </div>
        </div>
      </div>
    </div>
    <create-and-update ref="create-and-update" @refresh="getPopups"></create-and-update>
  </v-app>
</template>
<script>
import CreateAndUpdate from './CreateAndUpdate.vue'
import PopupService from '@/services/admin/cms/pop-up/PopupService';

const popup = new PopupService();

export default {
  name: "Popups",
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      popups: [],
      dialog: false,
      loading: false,
      popups_id: null,
      page: null,
      total: null,
      perPage: null,
      lastPage: null,
      search: {
        title: "",
        is_active: ""
      },
      active_statuses: [
        {title: 'Active', value: 1},
        {title: 'In Active', value: 0}
      ],
    };
  },
  mounted() {
    this.getPopups();
  },
  methods: {
    getPopups() {
      this.loading=true;
      popup.paginate(this.search).then(response => {
        this.popups = response.data.data;
        this.page = response.data.meta.current_page;
        this.total = response.data.meta.total;
        this.perPage = response.data.meta.per_page;
        this.lastPage = response.data.meta.last_page;
        this.loading = false;
      }).catch(() => {
        this.loading = false;
      });
    },

    createPopup() {
        this.$refs['create-and-update'].createPopup();
    },

    editPopup(popup) {
        this.$refs['create-and-update'].editPopup(popup);
    },

    deletePopup(id) {
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
            popup
                .delete(id)
                .then(response => {
                  this.$snotify.success("Deleted successfully");
                  this.getPopups();
                })
                .catch(error => {
                });
          }
        }
      });
    },

    sort() {
      popup.sort(this.popups).then(response => {
        this.$snotify.success("Popups sorted successfully")
      }).catch(er => {
        this.$snotify.error("Something went wrong please try again later");
        this.getPopups()
      })
    }
  }
};
</script>
