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
                        Manage pages
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ Pages
                    </div>

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <v-btn @click="createPage()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add page
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
                <div class="search-wrapper border-outline mb-5 px-3 pt-5 d-sm-flex justify-content-start">
                  <div class="row">
                    <div class="col-4">
                      <v-text-field label="Title"
                                    type="text"
                                    dense
                                    v-on:keyup.enter="getPages()"
                                    outlined
                                    clearable
                                    v-model="search.title"></v-text-field>
                    </div>
                    <div class="col-4">
                      <v-select label="Status" outlined dense :items="active_statuses" item-text="title"   v-on:keyup.enter="getPages()"
                                item-value="value"
                                v-model="search.active"></v-select>
                    </div>
                    <v-col cols="12" md="4" class="text-right">
                      <v-btn
                          @click="getPages()"
                          class="btn btn-primary btn-search "
                          :loading="loading"
                      >
                        <v-icon small elevation="2" outlined>mdi-magnify</v-icon>&nbsp;
                        Search
                      </v-btn>
                    </v-col>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                    <tr class="px-3">
                      <th>Title</th>
                      <th class="pr-3 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-left" >
                      <tr v-show="pages.length > 0" v-for="(page, index) of pages" :key="index" >
                      <td>
                        <router-link :to="{ name: 'page-update' , params: {id: page.id}}"  class="navi-link" >{{page.title}}</router-link>&nbsp;&nbsp;
                        <i class="fas fa-circle" :class="page.is_active?'text-success':'text-danger'"></i></td>
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
                                      @click="editPage(page)"
                                  >
                                      <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                      <v-list-item-title>Edit</v-list-item-title>
                                  </v-list-item>

                                  <v-list-item
                                      @click="deletePage(page.id)"
                                  >
                                      <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                      <v-list-item-title>Delete</v-list-item-title>
                                  </v-list-item>
                              </v-list>
                          </v-menu>
                      </td>
                    </tr>
                      <tr v-if="pages.length == 0">
                        <td colspan="2" class="text-center">
                          No items added
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <v-pagination
                      @input="getPages"   v-if="pages.length > 0"
                      v-model="page"  class="pull-right mt-7"
                      :total-rows="total"
                      :length="lastPage"
                  ></v-pagination>
                </div>
            </div>
            <create-and-update ref="create-and-update" @refresh="getPages"></create-and-update>
          </div>
        </div>
      </div>
    </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import PageService from "@/services/admin/cms/page/PageService";

const pageService = new PageService();


export default {
    components: {
        CreateAndUpdate
    },
    data() {
        return {
            pages: [],
            page_id: null,
            page: null,
            total: null,
            lastPage: null,
            perPage: null, search: {
                active: "active"
            },
            active_statuses: [
                {title: 'Active', value: "active"},
                {title: 'In Active', value: "in_active"}
            ],
            loading:false,
        };
    },

    mounted() {
        this.getPages();
    },

    methods: {
        getPages() {
            this.loading = true;
            pageService
                .paginate(this.search)
                .then(response => {
                    this.pages = response.data.data;
                    this.page = response.data.meta.current_page;
                    this.lastPage = response.data.meta.last_page;
                    this.total = response.data.meta.total;
                    this.perPage = response.data.meta.per_page;
                    this.loading=false;
                })
                .catch(() => {
                    this.loading=false;
                });
        },

        capitalize(string) {
            if (string) {
                string = string.charAt(0).toUpperCase() + string.slice(1);
                return string;
            }
        },

        createPage() {
            this.$refs['create-and-update'].createPage();
        },

        editPage(page) {
            this.$refs['create-and-update'].editPage(page);
        },

        deletePage(id) {
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
                        pageService
                            .delete(id)
                            .then(response => {
                                this.$snotify.success("Deleted successfully");

                                this.getPages();
                            })
                            .catch(error => {
                                //console.log(error);
                            });
                    }
                }
            });
        }
    }
};
</script>
