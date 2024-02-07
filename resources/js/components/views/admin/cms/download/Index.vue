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
                        <a href="admin/faqs" class="text-dark"><i class="fas fa-arrow-left mr-3"></i></a>  Manage downloads
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\  Downloads
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">

                    <v-btn
                        @click="downloadCategory()"
                        class="btn-standard mt-4"
                    >
                        Categories
                    </v-btn>

                    <!--begin::Primary button-->
                    <v-btn @click="createDownload()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add download
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
                        <div class="search-wrapper border-outline mb-5 px-3 py-3 d-sm-flex justify-content-start">
                        <v-row>
                            <v-col cols="12" md="3">
                                <v-text-field
                                    label="Title"
                                    type="text"
                                    v-on:keyup.enter="searchDownoads()"
                                    outlined
                                    dense
                                    v-model="search.title"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-select
                                    v-model="search.type"
                                    label="Download type"
                                    outlined
                                    dense
                                    :items="types"
                                    item-text="title"
                                    item-value="id"
                                    v-on:keyup.enter="searchDownoads()"
                                >
                                </v-select>

                            </v-col>

                            <v-col cols="12" md="3">
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

                            <v-col cols="12" md="3" class="text-right">
                                <v-btn
                                    @click="searchDownoads()"
                                    class="btn btn-primary btn-search "
                                    :loading="loading"
                                >
                                    <v-icon small elevation="2" variant="outlined">mdi-magnify</v-icon>&nbsp;
                                    Search
                                </v-btn>
                            </v-col>

                        </v-row>
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
                            <table class="table">
                                <thead>
                                    <tr class="px-3">
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Is Private</th>
                                        <th>Is Public</th>
                                        <th class="pr-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                    <draggable @change="sort" v-model="downloads" v-if="downloads.length > 0" class="text-left" tag="tbody">
                                        <tr v-for="(download, index) of downloads" :key="index">
                                            <td>
                                                <i class="cursor-drag fas fa-sort handle pr-2"></i>&nbsp;&nbsp;
                                                <i :class="download.is_private?'fa fa-lock':'fa fa-lock-open'"></i>&nbsp;
                                                <a @click="editDownload(download)" class="mr-2"> {{
                                                    download.title }}</a>&nbsp;&nbsp;
                                                <i class="fas fa-circle"
                                                    :class="download.is_active?'text-success':'text-danger'"></i>

                                            </td>

                                            <td>
                                                {{download.type_name}}
                                            </td>

                                            <td>
                                                <span class="badge badge-success text-lg`"
                                                        v-bind:class="{ 'badge-success': download.is_private, 'badge-danger': !download.is_private }"
                                                >{{ download.is_private ? 'Yes' : 'No' }}</span>
                                            </td>

                                            <td>
                                                <span class="badge badge-success text-lg`"
                                                        v-bind:class="{ 'badge-success': download.public_hidden, 'badge-danger': !download.public_hidden }"
                                                >{{ download.public_hidden ? 'Yes' : 'No' }}</span>
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
                                                            @click="viewDownload(download)"
                                                        >
                                                            <v-icon class="mx-2" color="info darken-2" small>fas fa-file</v-icon>
                                                            <v-list-item-title>View</v-list-item-title>
                                                        </v-list-item>

                                                        <v-list-item
                                                            @click="editDownload(download)"
                                                        >
                                                            <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                                            <v-list-item-title>Edit</v-list-item-title>
                                                        </v-list-item>



                                                        <v-list-item
                                                            @click="deleteDownload(download.id)"
                                                        >
                                                            <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                                            <v-list-item-title>Delete</v-list-item-title>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </td>
                                        </tr>
                                    </draggable>
                                <tr v-show="downloads.length==0">
                                    <td  class="text-center" colspan="5">
                                        Please select a download type to fetch data.
                                    </td>
                                </tr>
                            </table>
                            <v-pagination
                                @input="getDownloads" v-if="downloads.length > 0"
                                v-model="page"  class="pull-right mt-7"
                                :total-rows="total"
                                :length="lastPage"
                                :disabled="loading"
                            ></v-pagination>
                        </div>
                    </div>
                </div>
            </div>
            <create-and-update ref="download" @refresh="getDownloads"></create-and-update>
        </div>
    </v-app>
</template>
<script>
import DownloadService from '@/services/admin/cms/download/DownloadService';
import CreateAndUpdate from "./CreateAndUpdate.vue";
import DownloadTypeService from '@/services/admin/cms/download/type/DownloadTypeService';

const downloadService = new DownloadService();
const typeService = new DownloadTypeService();

export default {
    name: "Downloads",
    props: ['homeRoute'],
    components: {
        CreateAndUpdate,
    },
    data() {
        return {
            loading:false,
            page: null,
            total: null,
            perPage: null,
            lastPage: null,
            downloads: [],
            types: [],
            search: {
                type: null,
                program_id: null,
                active: null
            },
            status: [
                { title: 'Active', value: 1 },
                { title: 'In Active', value: 0 }
            ],
        };
    },
    mounted() {
        this.getDownloads();
        this.getTypes();
    },
    methods: {
        searchDownoads() {
            this.page = 1;
            this.getDownloads();
        },

        getTypes() {
            typeService.allActive().then(response => {
                this.types = response.data;
            });
        },

        sort() {
            downloadService.sort(this.downloads).then((res) => {
                this.$snotify.success("Sorted");
                this.getDownloads()
            }).catch(err => {
                this.$snotify.success("Sorted Error");
            })
        },

        getDownloads() {
            this.loading = true;
            if (this.search.type != null) {

                downloadService.paginate(this.search).then(response => {
                    this.downloads = response.data.data;
                    this.page = response.data.meta.current_page;
                    this.total = response.data.meta.total;
                    this.perPage = response.data.meta.per_page;
                    this.lastPage = response.data.meta.last_page;
                    this.loading=false;
                }).catch((err) => {
                    // console.log(err)
                }).finally(() => {
                    this.loading=false;
                });
            }else{
                this.loading=false;
            }

        },

        createDownload() {
            this.$refs["download"].createDownload();
        },

        editDownload(download) {
            this.$refs["download"].editDownload(download);
        },

        downloadCategory(){
           window.location.href = `${this.homeRoute}/admin/download/type`;
        },

        viewDownload(download) {
            var domain = (function(){
                var i=0,domain=document.domain,p=domain.split('.'),s='_gd'+(new Date()).getTime();
                while(i<(p.length-1) && document.cookie.indexOf(s+'='+s)==-1){
                    domain = p.slice(-1-(++i)).join('.');
                }
                return domain;
                })();
            var webdomain = domain.replace(/^[^.]+\./g, "");
            webdomain = process.env.VUE_APP_PROTOCOL+webdomain+'/';
            if(download.is_private==1){
                window.open(webdomain+'download/'+download.id+'/file', '_blank')
            }
            else{
                window.open(webdomain+'download/'+download.path, '_blank')
            }
        },

        deleteDownload(id) {
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
                        downloadService.delete(id).then(response => {
                            this.$snotify.success("Deleted successfully");
                            this.getDownloads();
                        });
                    }
                }
            });
        }
    }
};
</script>
