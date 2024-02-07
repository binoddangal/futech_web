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
                        Manage FAQs
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ FAQs
                    </div>

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">

                    <v-btn
                        @click="manageCategory()"
                        class="btn-standard mt-4"
                    >
                        Categories
                    </v-btn>

                    <!--begin::Primary button-->
                    <v-btn @click="addFaq()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add FAQ
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
                            <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field
                                    label="Title"
                                    type="text"
                                    v-on:keyup.enter="getFaqs"
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
                                    item-value="value"
                                    v-model="search.active"
                                >
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="4" class="text-right">
                                <v-btn
                                    @click.prevent="getFaqs"
                                    v-on:keyup.enter="getFaqs"
                                    class="btn btn-primary"
                                    style="color: #fff;"
                                    :loading="loading"
                                >
                                <v-icon small>mdi-magnify</v-icon>
                                    Search
                                </v-btn>
                            </v-col>
                            </v-row>
                        </div>
                        <div class="table-responsive">
                            <v-skeleton-loader
                                v-if="loading"
                                type="table-thead">
                            </v-skeleton-loader>

                            <v-skeleton-loader
                                v-if="loading"
                                type="table-row-divider@25">
                            </v-skeleton-loader>
                            <table class="table">
                            <thead>
                                <tr class="px-3">
                                <th>Title</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Action</th>
                                </tr>
                            </thead>

                                <draggable @change="sort" v-model="faqs" class="text-left" tag="tbody" handle=".handle">
                                <tr v-for="(faq, index) of faqs" :key="index">
                                    <td>
                                        <i class="cursor-drag fas fa-sort handle pr-2"></i>
                                        <a href="#" @click="editFaq(faq.id)" class="mr-2"> {{ faq.title }}</a>
                                        <i class="fas fa-circle"
                                            :class="faq.is_active ? 'text-success':'text-danger'"></i>
                                    </td>
                                    <td>
                                        {{ faq.parent ? faq.parent.title : 'N/A' }}
                                    </td>
                                    <td>
                                        <p v-html="faq.description"></p>
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
                                                    @click="editFaq(faq)"
                                                >
                                                    <v-icon small class="mx-2" color="blue darken-2">fas fa-edit</v-icon>
                                                    <v-list-item-title>Edit</v-list-item-title>
                                                </v-list-item>

                                                <v-list-item
                                                    @click="deleteFaq(faq.id)"
                                                >
                                                    <v-icon small class="mx-2" color="red darken-2">fas fa-trash</v-icon>
                                                    <v-list-item-title>Delete</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>

                                    </td>
                                </tr>
                                </draggable>

                            <template v-if="faqs.length==0">
                                <tr>
                                <td class="text-center  px-3" colspan="6">No items found</td>
                                </tr>
                            </template>
                            </table>
                            <v-pagination v-show="faqs.length > 0"
                                @input="getFaqs"
                                class="pull-right mt-7"
                                v-model="page"
                                :total-rows="total"
                                :length="lastPage"
                            ></v-pagination>
                        </div>

                    </div>
                    <create-and-update ref="faq" @refresh="getFaqs"></create-and-update>
            </div>
            </div>
        </div>
    </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import FaqService from "@/services/admin/cms/faq/FaqService";

const faqService = new FaqService();
export default {
    name: "Faq",
    props: ['homeRoute'],
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
            faqs: [],
            search: {
                active: "active",
                is_parent: "null"
            },
            status: [
                {title: 'Active', value: "active"},
                {title: 'In Active', value: "in_active"}
            ],
        };
    },
    mounted() {
        this.getFaqs();
    },
    methods: {
        sort() {
            faqService.sort(this.faqs).then((res) => {
                this.$snotify.success("Sorted");
                this.getFaqs()
            }).catch(err => {
                this.$snotify.success("Sorted Error");
            })
        },

        getFaqs() {
            this.loading=true;
            faqService
                .paginate(this.search)
                .then(response => {
                    this.faqs = response.data.data;
                    this.page = response.data.meta.current_page;
                    this.total = response.data.meta.total;
                    this.perPage = response.data.meta.per_page;
                    this.lastPage = response.data.meta.last_page;
                    this.loading=false;
                })
                .catch(error => {
                    this.loading=false;
                });
        },

        addFaq() {
            this.$refs["faq"].addFaq();
        },

        editFaq(faq) {
            this.$refs["faq"].editFaq(faq);
        },

        manageCategory() {
            window.location.href = `${this.homeRoute}/admin/faq/category`;
        },

        deleteFaq(id) {
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
                        faqService
                            .delete(id)
                            .then(response => {
                                this.getFaqs();
                            })
                            .catch(error => {
                                //console.log(error);
                            });
                    }
                }
            });
        },
    }
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
