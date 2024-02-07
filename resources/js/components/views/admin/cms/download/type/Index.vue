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
                        Manage download types
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\  <a href="admin/download">Download </a> \ Categories
                    </div>

                    <!--end::Breadcrumb-->
                </div>

                <div class="d-flex align-items-center gap-2 gap-lg-3">

                    <!--begin::Primary button-->
                    <v-btn @click="addDownloadType()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add new
                    </v-btn
                    >
                    <!--end::Primary button-->
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <v-skeleton-loader
                                type="table-thead"
                                v-if="loading"
                            >
                            </v-skeleton-loader>

                            <v-skeleton-loader
                                v-if="loading"
                                type="table-row-divider@25"
                            ></v-skeleton-loader>
                            <table class="table">

                            <thead>
                            <tr class="px-3">
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody v-if="types.length > 0">
                              <tr v-for="(type, index) of types" :key="index">
                              <td>{{ type.title }}</td>
                              <td>
                                      <span class="badge badge-success text-lg`"
                                              v-bind:class="{ 'badge-success': type.is_active, 'badge-danger': !type.is_active }"
                                      >{{ type.is_active ? 'Active' : 'Inactive' }}</span>
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
                                            @click="editDownloadType(type)"
                                        >
                                            <v-icon small class="mx-2" color="blue darken-2">fas fa-edit</v-icon>
                                            <v-list-item-title>Edit</v-list-item-title>
                                        </v-list-item>



                                        <v-list-item
                                            @click="deleteDownloadType(type.id)"
                                        >
                                            <v-icon small class="mx-2" color="red darken-2">fas fa-trash</v-icon>
                                            <v-list-item-title>Delete</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                              </td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                            <td colspan="5" class="text-center">No items found</td>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <create-and-update
            ref="download-type"
            @refresh="getTypes"
            ></create-and-update>
        </div>
    </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import DownloadTypeService from '@/services/admin/cms/download/type/DownloadTypeService';

const downloadType = new DownloadTypeService();

export default {
  name: "DownloadType",
  props: ['homeRoute'],
  components: {
    CreateAndUpdate,
  },

  data() {
    return {
      types: [],
      loading:false
    };
  },

  mounted() {
    this.getTypes();
  },

  methods: {

    getTypes() {
      this.loading = true;
      downloadType.paginate().then((response) => {
        this.types = response.data;
        this.loading=false;
      });
    },

    addDownloadType() {
      this.$refs["download-type"].createType();
    },

    editDownloadType(type) {
      this.$refs["download-type"].editType(type);
    },

    deleteDownloadType(id) {
            this.$confirm({
                message: `Are you sure you want to delete this item permanently?`,
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
                      downloadType.delete(id).then(response => {
                            this.$snotify.success("Deleted successfully");
                            this.getTypes();
                        });
                    }
                }
            });
        }
  },
};
</script>
