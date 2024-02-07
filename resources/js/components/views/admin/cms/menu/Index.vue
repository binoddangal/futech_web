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
          <h4>Menu manager</h4>
          <div class="breadcrumb-sub-header">
            <a href="admin/dashboard">Dashboard </a>\ Menu manager
          </div>

          <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
          <!--begin::Primary button-->
          <v-btn @click="createMenu()" dark class="mt-4 btn-primary mr-1">
            <i class="fa fa-plus"></i>
            Add menu category
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
            <div class="table-responsive">
              <v-skeleton-loader type="table-thead" v-if="loading">
              </v-skeleton-loader>

              <v-skeleton-loader v-if="loading" type="table-row-divider@25">
              </v-skeleton-loader>
              <table class="table">
                <thead>
                  <th>Title</th>
                  <th>Menu type</th>
                  <th>Action</th>
                </thead>
                <tbody v-if="menus.length > 0">
                  <tr v-for="(menu, index) of menus" :key="index">
                    <td scope="row">
                      <a :href="`${homeRoute}/admin/menu/item/${menu.id}`" class="navi-link">{{ menu.title }} </a>
                      <i
                        class="fas fa-circle"
                        :class="menu.is_active ? 'text-success' : 'text-danger'"
                      ></i>
                    </td>

                    <td>
                      <span
                        :class="
                          menu.header
                            ? 'badge badge-success'
                            : 'badge badge-danger'
                        "
                        >{{ menu.header ? "Header" : "Footer" }}</span
                      >
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
                            <v-list-item
                                @click="editMenu(menu)"
                            >
                                <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                <v-list-item-title>Edit</v-list-item-title>
                            </v-list-item>



                            <v-list-item
                                @click="deleteMenu(menu.id)"
                            >
                                <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                <v-list-item-title>Delete</v-list-item-title>
                            </v-list-item>
                        </v-list>
                      </v-menu>
                    </td>
                  </tr>
                </tbody>
              </table>

              <v-pagination
                @input="getMenu"
                v-if="menus.length > 0"
                v-model="page"
                class="pull-right mt-7"
                :total-rows="total"
                :length="lastPage"
                :disabled="loading"
              ></v-pagination>

            </div>
            <create-and-update ref="create-and-update" @refresh="getMenu"></create-and-update>

          </div>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import MenuService from "@/services/admin/cms/menu/MenuService";
import CreateAndUpdate from './CreateAndUpdate.vue';

const menu = new MenuService();

export default {
  components: { CreateAndUpdate },
  name: "Menu",
  props: ['homeRoute'],
  data() {
    return {
      menus: [],
      addMenudialog: false,
      loading: false,
      page: null,
      total: null,
      perPage: null,
      lastPage: null,
    };
  },
  mounted() {
    this.getMenu();
  },
  methods: {
    getMenu() {
      this.loading = true;
      menu
        .paginate(this.search)
        .then((response) => {
          this.menus = response.data.data;
          this.page = response.data.meta.current_page;
          this.lastPage = response.data.meta.last_page;
          this.total = response.data.meta.total;
          this.perPage = response.data.meta.per_page;
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
        });
    },


    createMenu() {
      this.$refs["create-and-update"].createMenu();
    },

    editMenu(menu) {
      this.$refs["create-and-update"].editMenu(menu);
    },

    changeType(type) {
      this.newMenu.menu_type = type;
      this.newMenu.title = "";
    },
    addMenuForm() {
      this.selectedMenu = null;
    },
    opoenDialog() {
      this.addMenudialog = true;
    },
    closeDialog() {
      this.addMenudialog = false;
    },

    deleteMenu(id) {
      this.$confirm({
        message: `Are you sure you want to delete this item permanently?`,
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
            menu
              .delete(id)
              .then((response) => {
                this.getMenu();
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
