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
                        Manage testimonials
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ Testimonials
                    </div>

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <v-btn @click="createTestimonial()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add testimonial
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
              <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">
                <div class="row">
                  <div class="col-4">
                    <v-text-field label="Title"
                                  type="text"  v-on:keyup.enter="getTestimonial()"
                                  dense
                                  outlined
                                  v-model="search.title"></v-text-field>
                  </div>
                  <div class="col-4">
                    <v-select label="Status" outlined dense :items="status" item-text="title"
                              item-value="value"   v-on:keyup.enter="getTestimonial()"
                              v-model="search.active"></v-select>
                  </div>

                  <v-col cols="12" md="4" class="text-right">
                    <v-btn
                        @click="getTestimonial()"
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
                    <th class="px-3">Image</th>
                    <th class="px-3">Title</th>
                    <th class="px-3">Rating</th>
                    <th class="pr-3 text-center">Action</th>
                  </tr>
                  </thead>
                  <draggable v-show="testimonials.length>0" @change="sort" v-model="testimonials" class="text-left" tag="tbody">
                    <tr v-for="(testinomial, index) of testimonials" :key="index">
                      <td>
                        <i class="cursor-drag fas fa-sort handle pr-2"></i>
                        <img
                            v-if="testinomial.image_path.thumb"
                            :src="testinomial.image_path['thumb']"
                            alt
                            style="height:75px"
                            class="img-thumbnail"
                        />
                        <img
                            v-else
                            alt
                            style="height:75px"
                            class="img-thumbnail"
                        />
                      </td>
                      <td>
                        <a @click="editTestimonial(testinomial.id)" class="mr-2"> {{ testinomial.title }}</a>&nbsp;&nbsp;
                        <i class="fas fa-circle"
                           :class="testinomial.is_active?'text-success':'text-danger'"></i>
                      </td>

                      <td>
                        <v-rating
                            v-model="testinomial.rating"
                            color="yellow darken-3"
                            background-color="grey darken-1"
                            empty-icon="$ratingFull"
                            half-increments
                            readonly
                            hover
                            small
                        ></v-rating>

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
                          <!--begin::Navigation-->
                          <div class="navi navi-hover ">

                              <v-list>
                                  <v-list-item
                                      @click="editTestimonial(testinomial.id)"
                                  >
                                    <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                    <v-list-item-title>Edit</v-list-item-title>
                                  </v-list-item>

                                  <v-list-item
                                      @click="deleteTestimonial(testinomial.id)"
                                  >
                                    <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                    <v-list-item-title>Delete</v-list-item-title>
                                  </v-list-item>
                              </v-list>
                          </div>
                          </v-menu>
                          <!--end::Navigation-->
                      </td>
                    </tr>
                  </draggable>
                  <tr v-if="testimonials.length == 0">
                    <td colspan="4" class="text-center">
                      No items added
                    </td>
                  </tr>
                </table>
                <v-pagination  v-if="testimonials.length > 0"
                    @input="getTestimonial"
                    class="pull-right mt-7"
                    v-model="page"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>
              </div>

            </div>

        </div>
        </div>
      </div>
    </v-app>
</template>
<script>
import TestimonialService from "@/services/admin/cms/testimonial/TestimonialService"
import CreateAndUpdate from "./CreateAndUpdate.vue";

const testimonialService = new TestimonialService();
export default {
    name: "Testimonial",
    props: ["homeRoute"],
    components: {
        CreateAndUpdate
    },
    data() {
        return {
            testimonials: [],
            status: [
                {title: 'Active', value: "1"},
                {title: 'In Active', value: "0"}
            ],
            loading: false,
            page: null,
            total: null,
            perPage: null,
            lastPage: null,
            search: {
                title: "",
                is_active: "",
            }
        };
    },
    mounted() {
        this.getTestimonial();
    },
    methods: {
        getTestimonial() {
            this.loading = true;
            testimonialService.paginate(this.search).then(response => {
                this.testimonials = response.data.data;
                this.page = response.data.meta.current_page;
                this.total = response.data.meta.total;
                this.perPage = response.data.meta.per_page;
                this.lastPage = response.data.meta.last_page;
                this.loading = false;
            }).catch(() => {
                this.loading=false;
            });
        },

        createTestimonial(){
            window.location.href = `${this.homeRoute}/admin/testimonial/create`;
        },

        editTestimonial(id) {
            window.location.href = `${this.homeRoute}/admin/testimonial/${id}/edit`
        },

        sort() {
            testimonialService.sort(this.testimonials).then((res) => {
                this.$snotify.success("Sorted");
                this.getTestimonial()
            }).catch(err => {
                this.$snotify.success("Sorted Error");
            })
        },

        deleteTestimonial(id) {
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
                        testimonialService
                            .delete(id)
                            .then(response => {
                                this.$snotify.success("Deleted successfully");

                                this.getTestimonial();
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
