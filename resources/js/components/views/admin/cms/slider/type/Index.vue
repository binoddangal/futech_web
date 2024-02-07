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
                        Manage slider types
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\  <a href="admin/sliders">Slider </a> \ Types
                    </div>

                    <!--end::Breadcrumb-->
                </div>

                <div class="d-flex align-items-center gap-2 gap-lg-3">

                    <!--begin::Primary button-->
                    <v-btn @click="addType()" dark  class="mt-4 btn-primary  mr-1">
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
                                v-if="loading"
                                type="table-thead"
                            >
                            </v-skeleton-loader>

                            <v-skeleton-loader
                                v-if="loading"
                                type="table-row-divider@25"
                            >
                            </v-skeleton-loader>
                            <table class="table" v-if="!loading">
                                <thead>
                                <tr class="px-3">
                                    <th>Title</th>
                                    <th class="px-3">Status</th>
                                    <th class="pr-3 text-center">Action</th>
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
                                                    @click="editSliderType(type)"
                                                >
                                                    <v-icon small class="mx-2" color="blue darken-2">fas fa-edit</v-icon>
                                                    <v-list-item-title>Edit</v-list-item-title>
                                                </v-list-item>

                                                <v-list-item
                                                    @click="deleteSliderType(type.id)"
                                                >
                                                    <v-icon small class="mx-2" color="blue darken-2">fas fa-trash</v-icon>
                                                    <v-list-item-title>Delete</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr v-if="types.length == 0" >
                                    <td  colspan="3" class="text-center">No items found</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <v-pagination
                        @input="getTypes"   v-if="types.length > 0"
                        v-model="page"  class="pull-right mt-7"
                        :total-rows="total"
                        :length="lastPage"
                    ></v-pagination>
                </div>
            </div>
            <create-and-update
                ref="slider-type"
                :dialog="dialog"
                @refresh_list="getTypes"
            ></create-and-update>
        </div>
    </v-app>

</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate";
import SliderTypeService from "@/services/admin/cms/slider/type/SliderTypeService";

const typeService = new SliderTypeService();

export default {
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      types: [],
      dialog: false,
      loading: false,
      type: {

      }
    };
  },
  mounted() {
    this.getTypes();
  },
  methods: {
    getTypes() {
      this.dialog = false
      this.loading = true
      typeService.paginate().then((response) => {
        this.types = response.data;
        this.loading=false;
      });
    },
    addType() {
      this.$refs['slider-type'].createType();
    },
    editSliderType(type) {

      this.$refs['slider-type'].setType(type)
    },
    deleteSliderType(id) {
      this.$confirm({
        message: `Are you sure you want to delete this item permanently?`,
        button: {
          no: "No",
          yes: "Yes"
        },
        callback: confirm => {
          if (confirm) {
            typeService.delete(id).then((response) => {
              this.getTypes()
            });
          }
        }
      });
    },
  },
};
</script>
