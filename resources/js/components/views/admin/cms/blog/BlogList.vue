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
                        Manage blogs
                    </h4>
                    <div class="breadcrumb-sub-header">
                        <a href="admin/dashboard">Dashboard </a>\ Blogs
                    </div>

                    <!--end::Breadcrumb-->
                </div>

                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <v-btn
                        @click="blogCategory()"
                        class="btn btn-standard mt-4"
                    >
                        Blog categories
                    </v-btn>
                    <!--begin::Primary button-->
                    <v-btn @click="createBlog()" dark  class="mt-4 btn-primary  mr-1">
                        <i class="fa fa-plus"></i>
                        Add blog
                    </v-btn
                    >
                    <!--end::Primary button-->
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">
                <div class="row">
                    <div class="col-3">
                        <v-text-field
                            label="Title"
                            type="text"
                            dense
                            outlined
                            v-model="search.title"
                        ></v-text-field>
                    </div>
                    <div class="col-md-3">
                        <v-select
                            outlined
                            dense v-on:keyup.enter="getBlogs()"
                            v-model="search.category_id"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            label="Category"
                        >
                        </v-select>
                    </div>
                    <div class="col-md-3">
                        <v-menu
                            v-model="menu2"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="search.publish_date_from"
                                    label="From"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on" v-on:keyup.enter="getBlogs()"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="search.publish_date_from"
                                @input="menu2 = false"
                            ></v-date-picker>
                        </v-menu>
                    </div>
                    <div class="col-md-3">
                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="search.publish_date_to"
                                    label="To"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on" v-on:keyup.enter="getBlogs()"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="search.publish_date_to"
                                @input="menu = false"
                            ></v-date-picker>
                        </v-menu>
                    </div>
                    <div class="col-md-3 text-right">
                        <v-select
                            label="Status"
                            :items="active_statuses"
                            item-text="name"
                            item-value="value"
                            outlined v-on:keyup.enter="getBlogs()"
                            dense v-model="search.active">
                        </v-select>
                    </div>

                    <v-col cols="12" sm="12" md="9" class="text-right">
                        <v-btn
                            @click.prevent="getBlogs"
                            class="btn  btn-primary"
                            style="color: #fff;"
                            :loading="loading"
                        >
                            <v-icon small  elevation="2" outlined>mdi-magnify</v-icon>&nbsp;
                            Search
                        </v-btn>
                    </v-col>
                </div>
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
                    <thead >
                    <tr class="px-3">
                        <th>Title</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th class="pr-0 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody >
                        <tr v-show="blogs.length > 0" v-for="(blog, index) of blogs" :key="index">
                            <td>
                                <a @click.prevent="editblog(blog.id)" class="mr-2"> {{ blog.title }}  <i class="fas fa-circle"
                                    :class="blog.is_active ? 'text-success' : 'text-danger'"></i></a>
                            </td>
                            <td>
                                {{ blog.formatted_publish_date }}
                            </td>
                            <td>
                                <ul class v-if="blog && blog.categories && blog.categories.length > 0">
                                    <li
                                        v-for="(category, i) of blog.categories"
                                        :key=i
                                    >{{ category.title }}</li
                                    >
                                </ul>
                                <div class v-else>
                                    <span>--</span>
                                </div>
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
                                            @click="editblog(blog.id)"
                                        >
                                            <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                            <v-list-item-title>Edit</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item
                                            @click="deleteblog(blog.id)"
                                        >
                                            <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                            <v-list-item-title>Delete</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </td>
                        </tr>
                        <tr v-if="blogs.length == 0">
                            <td colspan="12" class="text-center">
                                No items added
                            </td>
                        </tr>
                    </tbody>
                </table>
                <v-pagination
                    @input="getBlogs"   v-if="blogs.length > 0"
                    v-model="page"  class="pull-right mt-7"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>

        <create-and-update ref="category" @refresh="getBlogs"></create-and-update>
    </div>
        </div>
    </v-app>
</template>
<script>
import BlogCategoryService from "@/services/admin/cms/blog/category/BlogCategoryService";
import BlogService from "@/services/admin/cms/blog/BlogService";

const categoryService = new BlogCategoryService();
const blogService = new BlogService();
export default {
    name:"BlogList",
    props: ['homeRoute'],
    data() {
        return {
            categories: [],
            menu2: false,
            menu: false,
            blogs: [],
            page: null,
            total: null,
            perPage: null,
            lastPage: null,
            loading:false,
            search: {
                title: '',
                category_id: '',
                type: 'blog',
                is_active: ''
            },
            active_statuses: [
                {value: "1", name: "Active"},
                {value: "0", name: "In active"},
            ]
        };
    },

    mounted() {
        this.getBlogs();
        this.getCategories();
    },

    methods: {
        getBlogs() {
            this.loading=true;
            blogService
                .paginate(this.search, this.page)
                .then(response => {

                    this.blogs = response.data.data;
                    this.page = response.data.meta.current_page;
                    this.total = response.data.meta.total;
                    this.perPage = response.data.meta.per_page;
                    this.lastPage = response.data.meta.last_page;
                    this.loading=false;
                })
                .catch(error => {
                    // console.log(error);
                    this.loading=false;
                });
        },

        getCategories() {
            categoryService
                .paginate(this.type)
                .then(response => {
                    this.categories = response.data.data;
                })
                .catch(error => {
                    // console.log(error);
                });
        },

        createBlog(){
            window.location.href = `${this.homeRoute}/admin/blog/create` ;
        },

        editblog(id) {
             window.location.href = `${this.homeRoute}/admin/blog/${id}/edit` ;
        },

        deleteblog(id) {
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
                        blogService
                            .delete(id)
                            .then(response => {
                                this.$snotify.success("Deleted successfully");

                                this.getBlogs();
                            })
                            .catch(error => {
                                //console.log(error);
                            });
                    }
                }
            });
        },


        blogCategory(){
           window.location.href = `${this.homeRoute}/admin/blog-categories`;
        },


    }
};
</script>
