<template>
    <v-app>
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div
                id="kt_app_toolbar_container"
                class="app-container container-fluid d-flex flex-stack"
            >
                <!--begin::career title-->
                <div class="career-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h4>
                        Manage careers
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ Careers
                    </div>

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Career title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <v-btn @click="createJob()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add job
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
                                <div class="col-3">
                                    <v-text-field label="Title"
                                                  type="text"  v-on:keyup.enter="getCareers"
                                                  dense
                                                  outlined
                                                  v-model="search.title"></v-text-field>
                                </div>
                                <v-col cols="12" md="3">
                                    <v-select v-on:keyup.enter="getCareers"
                                              label="Status"
                                              outlined
                                              dense
                                              :items="active_statuses"
                                              item-text="title"
                                              item-value="value"
                                              v-model="search.active"
                                    ></v-select>
                                </v-col>

                                <v-col cols="12" md="3">
                                    <v-btn
                                        @click="getCareers()"
                                        class="btn btn-primary btn-search "
                                        :loading="loading"
                                    >
                                        <v-icon small elevation="2" outlined>fas fa-search</v-icon>&nbsp;
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
                                    <th class="">Title</th>
                                    <th>Closing date</th>
                                    <th>Total application</th>
                                    <th class="pr-3 text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(career, index) of careers" :key="index">
                                    <td>
                                        <a @click="getApplications(career.id)" class="mr-2"> {{ career.title }}</a>
                                        &nbsp;&nbsp; <i class="fas fa-circle"
                                                        :class="career.is_active ? 'text-success' : 'text-danger'"></i>
                                    </td>
                                    <td>
                                        <span class="font-weight-medium">
                                            {{ career.expiry_date_format }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{career.career_application_count}}</span>

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
                                                    @click="editCareer(career.id)"
                                                >
                                                    <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                                    <v-list-item-title>Edit</v-list-item-title>
                                                </v-list-item>

                                                <v-list-item
                                                    @click="deleteCareer(career.id)"
                                                >
                                                    <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                                    <v-list-item-title>Delete</v-list-item-title>
                                                </v-list-item>
                                                <v-list-item
                                                    @click="getApplications(career.id)"
                                                >
                                                    <v-icon class="mx-2" color="red darken-2" small>fa fa-cog</v-icon>
                                                    <v-list-item-title>Application</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </td>
                                </tr>
                                <tr v-if="careers && careers.length == 0">
                                    <td colspan="12" class="text-center">
                                        No items added
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <v-pagination
                                @input="getCareers" v-if="careers && careers.length > 0"
                                v-model="page"  class="pull-right mt-7"
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
import CareerService from "@/services/admin/cms/career/CareerService";

const career = new CareerService();
import CreateAndUpdate from "./CreateAndUpdate.vue";

export default {
    name: "Careers",
    props: ['homeRoute'],
    components: {
        CreateAndUpdate
    },
    data() {
        return {
            careers: [],
            loading:false,
            page: null,
            total: null,
            perPage: null,
            lastPage: null,
            active_statuses: [
                {title: 'Active', value: "active"},
                {title: 'In Active', value: "in_active"}
            ],
            search: {
                active:"active"
            }
        };
    },
    mounted() {
        this.getCareers();
    },
    methods: {
        getCareers() {
            this.loading = true;
            career.paginate(this.search).then(response => {
                this.careers = response.data.data;
                this.loading = false;
            });
        },
        createJob() {
            window.location.href = `${this.homeRoute}/admin/career/create`;
        },

        editCareer(id) {
            window.location.href = `${this.homeRoute}/admin/career/${id}/edit`;

        },

        getApplications(id) {
            window.location.href = `${this.homeRoute}/admin/career/${id}/application`;
        },


        deleteCareer(id) {
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
                        career
                            .delete(id)
                            .then(response => {
                                this.$snotify.success("Deleted successfully");

                                this.getCareers();
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
