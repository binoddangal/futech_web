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
          <h4>Manage news and updates</h4>
          <div class="breadcrumb-sub-header">
            <a href="admin/dashboard">Dashboard </a>\ News and updates
          </div>

          <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
          <!--begin::Primary button-->
          <v-btn @click="addNewsAndUpdate()" dark class="mt-4 btn-primary mr-1">
            <i class="fa fa-plus"></i>
            Add news and update
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
                    v-on:keyup.enter="getNewsAndUpdates()"
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
                    v-on:keyup.enter="getNewsAndUpdates()"
                    item-value="value"
                    v-model="search.is_active"
                  >
                  </v-select>
                </v-col>

                <v-col cols="12" md="4" class="text-right">
                  <v-btn
                    @click.prevent="getNewsAndUpdates()"
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
                    <th>Published By</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(newsAndUpdate, index) of newsAndUpdates" :key="index">
                    <td>
                      <i class="cursor-drag fas fa-sort handle pr-2"></i>
                      <a @click="editNewsAndUpdate(newsAndUpdate)" class="mr-2">
                        {{ newsAndUpdate.title }}</a
                      >
                      <i
                        class="fas fa-circle"
                        :class="
                          newsAndUpdate.is_active ? 'text-success' : 'text-danger'
                        "
                      ></i>
                    </td>
                    <td>
                        {{ newsAndUpdate.published_by }}
                    </td>

                    <td>
                        <span class="badge badge-success text-lg"
                            v-bind:class="{ 'badge-success': newsAndUpdate.is_active, 'badge-danger': !newsAndUpdate.is_active }">{{ newsAndUpdate.is_active ? 'Active' : 'Inactive' }}</span>
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
                          <v-list-item @click="editNewsAndUpdate(newsAndUpdate)">
                            <v-icon small class="mx-2" color="blue darken-2"
                              >fas fa-edit</v-icon
                            >
                            <v-list-item-title>Edit</v-list-item-title>
                          </v-list-item>

                          <v-list-item @click="deleteNewsAndUpdate(newsAndUpdate.id)">
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

                <template v-if="newsAndUpdates.length == 0">
                  <tr>
                    <td class="text-center px-3" colspan="6">No items found</td>
                  </tr>
                </template>
              </table>
              <v-pagination
                v-show="newsAndUpdates.length > 0"
                @input="getNewsAndUpdates"
                class="pull-right mt-7"
                v-model="page"
                :total-rows="total"
                :length="lastPage"
              ></v-pagination>
            </div>
          </div>
          <create-and-update
            ref="newsAndUpdate"
            @refresh="getNewsAndUpdates"
          ></create-and-update>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import NewsAndUpdatesService from '@/services/admin/cms/news-and-update/NewsAndUpdatesService';

const newsAndUpdatesService = new NewsAndUpdatesService();
export default {
  name: "NewsAndUpdate",
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
      newsAndUpdates: [],
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
    this.getNewsAndUpdates();
  },
  methods: {
    getNewsAndUpdates() {
      this.loading = true;
      newsAndUpdatesService
        .paginate(this.search)
        .then((response) => {
          this.newsAndUpdates = response.data.data;
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

    addNewsAndUpdate() {
      this.$refs["newsAndUpdate"].addNewsAndUpdate();
    },

    editNewsAndUpdate(newsAndUpdate) {
      this.$refs["newsAndUpdate"].editNewsAndUpdate(newsAndUpdate);
    },

    deleteNewsAndUpdate(id) {
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
            newsAndUpdatesService
              .delete(id)
              .then((response) => {
                this.getNewsAndUpdates();
              })
              .catch((error) => {
                //console.log(error);
              });
          }
        },
      });
          },
    redirectTo() {
      window.location.href = `${this.homeRoute}/admin/news-and-updates`;

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
