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
          <h4>Manage categories</h4>
          <div class="breadcrumb-sub-header">
            <a href="admin/dashboard">Dashboard </a>\
            \ Categories
          </div>

          <!--end::Breadcrumb-->
        </div>

        <div class="d-flex align-items-center gap-2 gap-lg-3">
          <!--begin::Primary button-->
          <v-btn @click="createCategory()" dark class="mt-4 btn-primary mr-1">
            <i class="fa fa-plus"></i>
            Add new
          </v-btn>
          <!--end::Primary button-->
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="search-wrapper border-outline mb-5 px-3 py-3 d-sm-flex justify-content-start">
                <div class="row">
                    <div class="col-3">
                        <v-text-field
                            label="Title"
                            v-model="search.name"
                            v-on:keyup.enter="getCatgories()"
                            outlined
                            clearable
                            dense
                        >
                        </v-text-field>
                    </div>

                    <div class="col-md-3">
                        <v-select
                            outlined
                            dense
                            v-on:keyup.enter="getCatgories()"
                            v-model="search.parent_id"
                            :items="parent_categories"
                            item-text="name"
                            item-value="id"
                            label="Category"
                            clearable
                        >
                        </v-select>
                    </div>

                    <div class="col-md-3">
                        <v-select
                            label="Status"
                            :items="status"
                            item-text="name"
                            item-value="value"
                            outlined v-on:keyup.enter="getCatgories()"
                            dense v-model="search.is_active"
                            clearable
                        >
                        </v-select>
                    </div>

                    <v-col cols="12"  md="3" class="text-right">
                        <v-btn
                            @click.prevent="getCatgories"
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
                <table class="table"  v-if="!loading">
                    <thead>
                    <tr class="px-3">
                        <th>Title</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th class="pr-3 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-show="categories.length > 0"
                        v-for="(category, index) of categories"
                        :key="index"
                    >
                        <td>{{ category.title }}</td>

                        <td>
                        {{ category.parent_title ? category.parent_title : "-" }}
                        </td>
                        <td>
                        <span>
                            <span
                            v-if="category.is_active"
                            class="badge badge-success"
                            >Active</span
                            >
                            <span v-else class="badge badge-danger">Inactive</span>
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
                            <v-list-item @click="editCategory(category)">
                                <v-icon class="mx-2" color="blue darken-2" small
                                >fas fa-edit</v-icon
                                >
                                <v-list-item-title>Edit</v-list-item-title>
                            </v-list-item>

                            <v-list-item @click="deleteCategory(category.id)">
                                <v-icon class="mx-2" color="red darken-2" small
                                >fas fa-trash</v-icon
                                >
                                <v-list-item-title>Delete</v-list-item-title>
                            </v-list-item>
                            </v-list>
                        </v-menu>
                        </td>
                    </tr>
                    <tr v-if="categories.length == 0">
                        <td colspan="10" class="text-center">No items added</td>
                    </tr>
                    </tbody>
                </table>
                <v-pagination
                    @input="getCatgories"
                    v-if="categories.length > 0"
                    v-model="page"
                    class="pull-right mt-7"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>
            </div>
          </div>
          <!-- create and update -->
          <create-and-update
            ref="category"
            @refresh="getCatgories"
          ></create-and-update>
          <!-- <pre>{{category}}</pre> -->
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import BlogCategoryService from "../../../../../../services/admin/cms/blog/category/BlogCategoryService";
import CreateAndUpdate from "./CreateAndUpdate.vue";

const blogCategory = new BlogCategoryService();
export default {
  name: "BlogCategory",
  components: {
    CreateAndUpdate,
  },
  validations: {
    category: {
      title: { required },
      type: { required },
    },
  },
  data() {
    return {
        categories: [],
        parent_categories: [],
        page: null,
        total: null,
        perPage: null,
        lastPage: null,
        loading: false,
        search: {
            name: '',
            parent_id: '',
            is_active: '',
        },
        status: [
            {value: "1", name: "Active"},
            {value: "0", name: "In active"},
        ],
    };
  },
  mounted() {
    this.getCatgories();
    this.getParentCategories();
  },
  methods: {
    getParentCategories() {
      blogCategory
        .parentCategories()
        .then((response) => {
          this.parent_categories = response.data.data;
        })
        .catch((error) => {

        });
    },
    getCatgories() {
        this.loading = true;
        blogCategory
            .paginate(this.search, this.page)
            .then((response) => {
            this.categories = response.data.data;
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
    createCategory(category) {
      this.$refs["category"].createCategory(category, null);
    },

    editCategory(category) {
      this.$refs["category"].editCategory(category);
    },

    deleteCategory(id) {
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
            blogCategory
              .delete(id)
              .then((response) => {
                this.$snotify.success("Deleted successfully");
                this.getCatgories();
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
