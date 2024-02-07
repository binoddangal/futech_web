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
                        Manage sliders
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ Sliders
                    </div>

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">

                    <v-btn
                        @click="createSliderType()"
                        class="btn-standard mt-4"
                    >
                        Slider type
                    </v-btn>

                    <!--begin::Primary button-->
                    <v-btn @click="createSlider()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add slider
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
        <div class="card ">
            <div class="card-body ">
              <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">
                <v-row>
                  <div class="col-6">
                    <v-text-field label="Title"
                                  type="text"
                                  dense  v-on:keyup.enter="getSlider"
                                  outlined
                                  v-model="search.title"></v-text-field>
                  </div>
                  <div class="col-4">
                    <v-select label="Status" outlined dense :items="active_statuses" item-text="title"
                              item-value="value" v-on:keyup.enter="getSlider"
                              v-model="search.is_active"></v-select>
                  </div>
                  <div class="col-2 text-right">
                    <button  @click="getSlider()"
                            class="btn btn-primary btn-search "
                            :loading="loading"
                    >Search</button>
                  </div>
                </v-row>
              </div>
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
                    <th class="px-3" style="max-width: 270px !important; white-space: pre-wrap;">Image</th>
                    <th class="px-3">Title</th>
                    <th class="px-3">Type</th>
                    <th class="pr-3 text-left">Action</th>
                  </tr>
                  </thead>
                  <draggable v-show="sliders.length>0" @change="sort" v-model="sliders" class="text-left" tag="tbody">
                    <tr v-for="(slider, index) of sliders" :key="index">
                        <td>
                            <i class="cursor-drag fas fa-sort handle pr-2"></i>

                            <img
                                v-if="slider.image_path.thumb"
                                :src="slider.image_path['thumb']"
                                alt
                                style="height:75px"
                                class="img-thumbnail"
                            />
                        </td>

                        <td>
                            <a href="#" @click="editSlider(slider.id)" class="mr-2">
                            {{ slider.title }}</a>&nbsp;&nbsp;
                            <i class="fas fa-circle" :class="slider.is_active?'text-success':'text-danger'"></i>
                        </td>

                        <td>
                            {{ slider.type || 'N/A' }}
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
                                        @click="editSlider(slider)"
                                    >
                                        <v-icon small class="mx-2" color="blue darken-2">fas fa-edit</v-icon>
                                        <v-list-item-title>Edit</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item
                                        @click="deleteSlider(slider.id)"
                                    >
                                        <v-icon small class="mx-2" color="red darken-2">fas fa-trash</v-icon>
                                        <v-list-item-title>Delete</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>

                        </td>
                    </tr>
                  </draggable>
                  <tr v-if="sliders.length == 0">
                    <td colspan="5" class="text-center">
                      No items added
                    </td>
                  </tr>
                </table>
                <v-pagination
                    v-if="sliders.length > 0"
                    class="pull-right mt-7"
                    @input="getSlider"
                    v-model="page"
                    :total-rows="total"
                    :per-page="perPage"
                    first-number
                    last-number
                    :length="lastPage"

                ></v-pagination>
              </div>

            </div>
            <create-and-update ref="create-and-update" @refresh="getSlider"></create-and-update>

        </div>
        </div>
      </div>
    </v-app>
</template>
<script>

import SliderService from "../../../../../services/admin/cms/slider/SliderService";
import CreateAndUpdate from "./CreateAndUpdate.vue";
import draggable from "vuedraggable";

const slider = new SliderService();
export default {
    name: "Slider",
    props: ['homeRoute'],
    components: {
        CreateAndUpdate

    },
    data() {
        return {
            sliders: [], active_statuses: [
                {title: 'Active', value: "1"},
                {title: 'In Active', value: "0"}
            ],
            page: null,
            total: null,
            perPage: null,
            lastPage: null,
            search: {
                title: "",
                is_active: "",
            },
            loading:false,
        };
    },
    mounted() {
        this.getSlider();
    },
    methods: {
        createSlider() {
            this.$refs['create-and-update'].createSlider();
        },

        editSlider(slider) {
            this.$refs['create-and-update'].editSlider(slider);
        },

        createSliderType(){
           window.location.href=`${this.homeRoute}/admin/sliders/type`;
        },

        getSlider() {
            this.loading=true;
            slider.paginate(this.search).then(response => {
                this.sliders = response.data.data;
                this.page = response.data.meta.current_page;
                this.total = response.data.meta.total;
                this.perPage = response.data.meta.per_page;
                this.lastPage = response.data.meta.last_page;
                this.loading=false;
            })
                .catch(() => {
                    this.loading=false;
                });
        },
        // editSlider(sliderId) {
        //     this.$router.push({name: "slider-update", params: {id: sliderId}});
        // },
        sort() {
            slider.sort(this.sliders).then((res) => {
                this.$snotify.success("Sorted");
                this.getSlider()
            }).catch(err => {
                this.$snotify.success("Sorted Error");
            })
        },
        deleteSlider(id) {
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
                        slider
                            .delete(id)
                            .then(response => {
                                this.$snotify.success("Deleted successfully");

                                this.getSlider();
                            })
                            .catch(error => {
                            });
                    }
                }
            });
        }
    }
};
</script>
