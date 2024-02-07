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
          <h4>Manage partner</h4>
          <div class="breadcrumb-sub-header">
            <a href="admin/dashboard">Dashboard </a>\ Partner
          </div>

          <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
          <!--begin::Primary button-->
          <v-btn @click="addPartner()" dark class="mt-4 btn-primary mr-1">
            <i class="fa fa-plus"></i>
            Add partner
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
                    v-on:keyup.enter="getPartners()"
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
                    v-on:keyup.enter="getPartners()"
                    item-value="value"
                    v-model="search.is_active"
                  >
                  </v-select>
                </v-col>

                <v-col cols="12" md="4" class="text-right">
                  <v-btn
                    @click.prevent="getPartners()"
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
                  <tr v-for="(partner, index) of partners" :key="index">
                    <td>
                      <a @click="editPartner(partner)" class="mr-2">
                        {{ partner.title }}</a
                      >
                      <i
                        class="fas fa-circle"
                        :class="
                          partner.is_active ? 'text-success' : 'text-danger'
                        "
                      ></i>
                    </td>

                    <td class="w-50">
                      <span v-if="partner.description && partner.description.length > 100" v-html="partner.description.slice(0, 100) +' .....'"></span>
                      <span v-if="partner.description && partner.description.length <= 100" v-html="partner.description"></span>
                    </td>

                    <td>
                        <span class="badge badge-success text-lg"
                            v-bind:class="{ 'badge-success': partner.is_active, 'badge-danger': !partner.is_active }">{{ partner.is_active ? 'Active' : 'Inactive' }}</span>
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
                          <v-list-item @click="editPartner(partner)">
                            <v-icon small class="mx-2" color="blue darken-2"
                              >fas fa-edit</v-icon
                            >
                            <v-list-item-title>Edit</v-list-item-title>
                          </v-list-item>

                          <v-list-item @click="deletePartner(partner.id)">
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

                <template v-if="partners.length == 0">
                  <tr>
                    <td class="text-center px-3" colspan="6">No items found</td>
                  </tr>
                </template>
              </table>
              <v-pagination
                v-show="partners.length > 0"
                @input="getPartners"
                class="pull-right mt-7"
                v-model="page"
                :total-rows="total"
                :length="lastPage"
              ></v-pagination>
            </div>
          </div>
          <create-and-update
            ref="partner"
            @refresh="getPartners"
          ></create-and-update>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import PartnerService from "@/services/admin/cms/partner/PartnerService";
import CreateAndUpdate from "./CreateAndUpdate.vue";

const partnerService = new PartnerService();
export default {
  name: "Partner",
  props: ["homeRoute"],
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      loading: false,
      page: null,
      lastPage: null,
      perPage: null,
      total: null,
      partners: [],
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
    this.getPartners();
  },
  methods: {
    getPartners() {
      this.loading = true;
      partnerService
        .paginate(this.search)
        .then((response) => {
          this.partners = response.data.data;
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

    addPartner() {
      this.$refs["partner"].addPartner();
    },

    editPartner(partner) {
      this.$refs["partner"].editPartner(partner);
    },

    deletePartner(id) {
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
            partnerService
              .delete(id)
              .then((response) => {
                this.getPartners();
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
