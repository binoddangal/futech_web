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
          <h4>Manage request</h4>
          <div class="breadcrumb-sub-header">
            <a href="user/dashboard">Dashboard </a>\ Request
          </div>

          <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

      </div>
      <!--end::Toolbar container-->
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="search-wrapper border-outline mb-5 px-3 pt-5 d-sm-flex justify-content-start">
              <div class="row">
                <v-col cols="col-3">
                    <v-select
                        label="Priority"
                        v-model="search.priority"
                        :items="priorities"
                        item-text="title"
                        item-value="value"
                        clearable
                        outlined
                        dense
                    >
                    </v-select>
                </v-col>

                <v-col cols="col-3">
                    <v-select
                        label="Complete"
                        v-model="search.is_complete"
                        :items="completes"
                        item-text="title"
                        item-value="value"
                        clearable
                        outlined
                        dense
                    >
                    </v-select>
                </v-col>

                <v-col cols="col-3">
                  <v-select
                    label="Status"
                    outlined
                    dense
                    :items="status"
                    item-text="title"
                    v-on:keyup.enter="getAllRequestForPharmaceuticalCompany()"
                    item-value="value"
                    v-model="search.active"
                  ></v-select>
                </v-col>

                <v-col cols="12" md="2" class="text-right">
                  <v-btn
                    @click="getAllRequestForPharmaceuticalCompany()"
                    class="btn btn-primary btn-search"
                    :loading="loading"
                  >
                    <v-icon small elevation="2" outlined>mdi-magnify</v-icon
                    >&nbsp; Search
                  </v-btn>
                </v-col>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">

                <thead>
                  <tr class="px-3">
                    <th class="px-3"><strong>Category</strong></th>
                    <th class="px-3"><strong>Sub category</strong></th>
                    <th class="px-3"><strong>Item</strong></th>
                    <th class="px-3"><strong>Priority</strong></th>
                    <th class="px-3"><strong>Demand qty</strong></th>
                    <th class="px-3"><strong>Fullfilled qty</strong></th>
                    <th class="px-3"><strong>Remaining qty</strong></th>
                    <th class="pr-3">Status</th>
                    <th class="pr-3 text-center">Action</th>
                  </tr>
                </thead>

                <tbody v-if="requests.length > 0">
                  <tr
                    v-for="(item, index) of requests"
                    :key="index"
                  >
                    <td>
                      <a
                        @click="sentResponse(item)"
                        class="mr-2 cursor-pointer"
                      >
                        {{ item.category }}</a
                      >
                      <i
                        class="fas fa-circle"
                        :class="item.is_active ? 'text-success' : 'text-danger'"
                      ></i>
                    </td>

                    <td class="px-3">
                        {{ item.sub_category }}
                    </td>

                    <td class="px-3">
                        {{ item.item }}
                    </td>

                    <td class="px-3">
                        {{ item.priority_text }}
                    </td>

                    <td class="px-3">
                        {{ item.demanded_qty }}
                    </td>

                    <td class="px-3">
                        {{ item.fulfilled_qty }}
                    </td>

                    <td class="px-3">
                        {{ item.remaining_qty }}
                    </td>

                    <td class="px-3">
                        <span class="badge badge-success text-lg"
                                v-bind:class="{ 'badge-success': item.is_active, 'badge-danger': !item.is_active }"
                        >{{ item.is_active ? 'Active' : 'Inactive' }}</span>
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
                          <v-list-item @click="createOrEditResponse(item.id, item.demanded_qty)" v-if="item.fulfilled_qty >= 0 && item.remaining_qty != 0 || item.fulfilled_qty == 0 && item.remaining_qty == 0">
                            <v-icon class="mx-2" color="blue darken-2" small
                              >fas fa-eye</v-icon
                            >
                            <v-list-item-title>Response</v-list-item-title>
                          </v-list-item>

                          <v-list-item @click="removeProduct(item)">
                            <v-icon class="mx-2" color="blue darken-2" small
                              >fas fa-close</v-icon
                            >
                            <v-list-item-title>Reject</v-list-item-title>
                          </v-list-item>

                        </v-list>
                      </v-menu>
                    </td>
                  </tr>
                </tbody>

                <tbody>
                    <tr v-if="requests.length == 0">
                        <td colspan="10" class="text-center">No items added</td>
                    </tr>
                </tbody>
              </table>

              <v-pagination
                    @input="getAllRequestForPharmaceuticalCompany"
                    v-if="requests.length > 0"
                    v-model="page"
                    class="pull-right mt-7"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>
            </div>
          </div>
        </div>

        <response ref="response" @refresh="getAllRequestForPharmaceuticalCompany"></response>
        <vue-confirm-dialog></vue-confirm-dialog>
      </div>
    </div>
  </v-app>
</template>
<script>
import RequestService from "@/services/front/request/RequestService";
import Response from './Response.vue';

const request = new RequestService();
export default {
  components: { Response },
    name: 'RequestForPharmaceuticalCompany',
    props: ['userId'],
    data() {
        return {
            loading: false,
            requests: [],
            page: null,
            total: null,
            lastPage: null,
            perPage: null,
            search: {
                is_active: "",
            },
            status: [
                { title: "Active", value: "1" },
                { title: "In Active", value: "0" },
            ],
            priorities: [
                { title: "Normal", value: "normal" },
                { title: "Urgent", value: "urgent" },
            ],
            completes: [
                { title: "Complete", value: "1" },
                { title: "Not complete", value: "0" },
            ]
        };
    },

    mounted() {
        this.getAllRequestForPharmaceuticalCompany();
    },

    methods: {
        getAllRequestForPharmaceuticalCompany() {
            this.loading = true;
            request
                .getRequestForPharmaceuticalCompany(this.search, this.page)
                .then((response) => {
                    this.requests = response.data.data;
                    this.page = response.data.meta.current_page;
                    this.lastPage = response.data.meta.last_page;
                    this.total = response.data.meta.total;
                    this.perPage = response.data.meta.per_page;
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                });
        },

        createOrEditResponse(requestId, demanded_qty) {
            this.$refs['response'].createOrEditResponse(requestId, demanded_qty)
        },

        removeProduct(item) {

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
                        let req = item;
                        let index = req.notifiable_users.indexOf(this.userId)
                        req.notifiable_users.splice(index, 1);
                        if(req.rejected_users == null) {
                            req.rejected_users = [];
                            req.rejected_users.push(this.userId);
                        } else {
                            req.rejected_users.push(this.userId);
                        }
                        request
                            .update(req.id, req)
                            .then((response) => {
                                this.loading = false;
                                this.$snotify.success("Remove successfully");
                                this.getAllRequestForPharmaceuticalCompany();
                            })
                            .catch((error) => {
                                this.$snotify.error("Something Went Wrong");
                                this.loading = false;
                            });
                    }
                }
            });
        }
    },
};
</script>
