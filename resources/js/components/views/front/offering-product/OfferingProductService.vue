<template>
    <v-app>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                    <!--begin::Toolbar container-->
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <!--begin::Title-->
                            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="/user/dashboard" class="text-muted text-hover-primary">Home</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">Offering Products</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->

                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!--begin::Offering product info-->
                        <div class="carda">
                            <!--begin::Card header-->
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                <v-row>
                                    <v-col cols="12" md="10" class="mt-5 col-md-10">
                                        <h3 class="fw-bold m-0">Search service item</h3>
                                    </v-col>

                                    <v-col cols="12" md="2"  class="mt-5 text-right">

                                        <v-btn
                                            v-if="!edit"
                                            class="btn-primary ml-3"
                                            @click="edit = true"
                                        >
                                            Add
                                        </v-btn>

                                        <v-btn v-if="edit"
                                            @click="cancelSetting"
                                        >
                                            Cancel
                                        </v-btn>

                                        <v-btn v-if="edit"
                                                class="text-white ml-2 btn-primary"
                                                dark
                                                @click="createOrUpdateSetting"
                                                :loading="loading"
                                        >
                                            Update
                                        </v-btn>

                                    </v-col>
                                </v-row>
                            </div>
                            <!--begin::Card header-->
                            <!--begin::Content-->
                            <div id="kt_account_settings_profile_details" class="collapse show" v-if="edit">
                                <!--begin::Form-->
                                <form id="kt_account_profile_details_form" class="form">
                                    <!--begin::Card body-->
                                    <div class="card-body border-top p-9">
                                        <!--begin::Input group-->
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">

                                            <!--begin::Col-->
                                            <div class="col-lg-12">

                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <v-autocomplete
                                                            v-model="selectedItems"
                                                            :items="items"
                                                            item-value="id"
                                                            item-text="title"
                                                            :error="$v.selectedItems.$error"
                                                            :search-input.sync="searchItems"
                                                            :loading="isLoading"
                                                            small-chips
                                                            deletable-chips
                                                            multiple
                                                            clearable
                                                            outlined
                                                            return-object
                                                            dense
                                                        >
                                                            <template v-slot:label>
                                                                Search a product <span class="text-danger"> *</span>
                                                            </template>
                                                        </v-autocomplete>
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>


                                    </div>
                                    <!--end::Card body-->

                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Offering product info-->

                        <!--begin::Table Offering product info-->
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
                                                        <th class="px-3"><strong>Title</strong></th>
                                                        <th class="px-3"><strong>Category</strong></th>
                                                        <th class="px-3"><strong>Sub category</strong></th>
                                                        <th class="px-3"><strong>Status</strong></th>
                                                        <th class="pr-3 text-center"><strong>Action</strong></th>
                                                    </tr>
                                                </thead>

                                                <tbody v-if="setting && setting.offering_items && setting.offering_items.length > 0">
                                                    <tr v-for="(item, index) in setting.offering_items" :key="index" >
                                                        <td class="px-3">
                                                            {{ item.title }}
                                                        </td>

                                                        <td class="px-3">
                                                            {{ item.category }}
                                                        </td>

                                                        <td class="px-3">
                                                            {{ item.sub_category }}
                                                        </td>

                                                        <td class="px-3">
                                                        <span class="badge badge-success text-lg"
                                                                v-bind:class="{ 'badge-success': item.is_active, 'badge-danger': !item.is_active }"
                                                            >
                                                            {{ item.is_active ? 'Active' : 'Inactive' }}
                                                        </span>
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
                                                                    @click="deleteItem(item.id)"
                                                                >
                                                                    <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                                                    <v-list-item-title>Delete</v-list-item-title>
                                                                </v-list-item>
                                                            </v-list>
                                                        </v-menu>

                                                        </td>
                                                    </tr>

                                                </tbody>

                                                <tbody  v-if="setting && setting.offering_items && setting.offering_items.length == 0">
                                                    <tr>
                                                        <td class="text-center font-weight-bold px-3" colspan="6">No Data Found</td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--end::Table Offering product info-->

                    </div>
                    <!--end::Content container-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <vue-confirm-dialog></vue-confirm-dialog>
    </v-app>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import UserSettingService from '@/services/front/user/setting/UserSettingService';
import ItemService from '@/services/front/category/sub-category/item/ItemService';

const item = new ItemService();
const userSetting = new UserSettingService();
export default {
    name: "OfferingProductService",
    props: ['userId'],
    data() {
        return {
            edit: false,
            loading: false,
            isLoading: false,
            searchItems: null,
            items: [],
            selectedItems: [],
            setting: {
                offering_category_ids: [],
                offering_sub_category_ids: [],
                offering_item_ids: [],
            }
        }
    },

    validations:{
        selectedItems: { required },
    },

    watch: {
        searchItems(val) {
            if(val) {
                this.isLoading = true;
                item.search({title: val})
                    .then((response) => {
                        this.items = response.data.items;
                        this.isLoading = false;
                    })
                    .catch(() => {
                        this.isLoading = false;
                    });
            }
        }
    },

    mounted() {
        this.getAllSetting();
    },

    methods: {

        changeItems() {
            if(this.selectedItems.length > 0) {
                this.selectedItems.forEach(item => {
                    this.setting.offering_item_ids.push(item.id);
                    this.setting.offering_sub_category_ids.push(item.sub_category_id);
                    this.setting.offering_category_ids.push(item.category_id);
                })
            }
        },

        getAllSetting() {
            userSetting.show(this.userId)
            .then((response) => {
                this.setting = response.data.userSetting;
            })
            .catch(() => {});
        },

        cancelSetting() {
            this.$v.selectedItems.$reset();
            this.edit = false;
            this.items = [];
            this.selectedItems = [];
            this.getAllSetting();
        },

        generateSettingFd() {
            let fd = new FormData();
            for (let key in this.setting) {
                if (this.setting[key]) {
                    fd.append(key, this.setting[key]);
                }
            }
            return fd;
        },

        createOrUpdateSetting() {
            this.changeItems();
            let fd = this.generateSettingFd();
            this.loading = true;
            userSetting
                .createOrUpdate(this.userId, fd)
                .then(() => {
                    this.loading = false;
                    this.$snotify.success("Updated successfully");
                    this.cancelSetting();
                    this.getAllSetting();
                })
                .catch(error => {
                    this.loading = false;
                    this.$snotify.error("Something Went Wrong");
                });
        },

        deleteItem(id){
            const itemId = id ? id.toString() : '';
            this.$confirm({
                    message: `Are you sure? `,
                    button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm) => {

                    if (confirm) {
                        if(itemId) {
                            let index = this.setting.offering_item_ids.indexOf(itemId)
                            this.setting.offering_item_ids.splice(index, 1);
                            this.setting.offering_sub_category_ids.splice(index, 1);
                            this.setting.offering_category_ids.splice(index, 1);
                            let fd = this.generateSettingFd();
                            this.loading = true;
                            userSetting
                            .createOrUpdate(this.userId, fd)
                            .then(() => {
                                this.loading = false;
                                this.$snotify.success("Updated successfully");
                                this.getAllSetting();
                            })
                            .catch(error => {
                                this.loading = false;
                                this.$snotify.error("Something Went Wrong");
                            });
                        }
                    }
                }
            });
        }
    },
}
</script>
