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
                      <a href="admin/faqs" class="text-dark"><i class="fas fa-arrow-left mr-3"></i></a>  FAQs categories
                  </h4>
                  <div class="breadcrumb-sub-header">
                      <a href="admin/dashboard">Dashboard </a>\  <a href="admin/faqs">FAQs </a>\ categories
                  </div>
                  <!--end::Title-->
              </div>
              <!--end::Page title-->
              <!--begin::Actions-->
              <div class="d-flex align-items-center gap-2 gap-lg-3">
                  <!--begin::Primary button-->
                  <v-btn @click="createFaqCategory()" dark  class="mt-4 btn-primary  mr-1">
                      <i class="fa fa-plus"></i>
                      Add category
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
                    <div class="search-wrapper border-outline mb-5 px-3 pt-5 d-sm-flex justify-content-start">
                    <v-row>
                    <v-col cols="12" md="3">
                        <v-text-field
                            label="Name"
                            v-model="search.name"
                            v-on:keyup.enter="searchFaqCategory"
                            @input="search.name = $event !== null ? $event : ''"
                            clearable
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-select
                            :items="parents"
                            v-model="search.parent_id"
                            v-on:keyup.enter="searchFaqCategory"
                            @input="search.parent_id = $event !== null ? $event : ''"
                            label="Parent"
                            item-text="name"
                            item-value="id"
                            clearable
                            outlined
                            dense
                        ></v-select>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-select
                            label="Status"
                            outlined
                            dense
                            v-on:keyup.enter="searchFaqCategory"
                            @input="search.is_active = $event !== null ? $event : ''"
                            :items="status"
                            item-text="title"
                            item-value="value"
                            v-model="search.is_active"
                            >
                        </v-select>
                    </v-col>

                    <v-col cols="12" md="3" class="text-right">
                        <v-btn @click="searchFaqCategory()" class="btn btn-primary" style="color: #fff" :loading="loading">
                        <v-icon small elevation="2" outlined>mdi-magnify</v-icon>&nbsp;
                        Search
                        </v-btn>
                    </v-col>
                    </v-row>
                </div>

                    <!-- table -->
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
                        <th class="px-3"><strong>Name</strong></th>
                        <th class="px-3"><strong>Position</strong></th>
                        <th class="px-3"><strong>Parent</strong></th>
                        <th class="px-3"><strong>Is Parent</strong></th>
                        <th class="px-3"><strong>Status</strong></th>
                        <th class="pr-3 text-center"><strong>Action</strong></th>
                        </tr>
                        </thead>

                        <template v-if="faqCategories.length > 0">
                            <draggable class="w-100" v-model="faqCategories" @change="sort" @start="drag=true" tag="tbody" @end="drag=false">
                                <tr v-for="(faqCategory, index) in faqCategories" :key="index">
                                    <td class="px-3">
                                        <a @click="editFaqCategory(faqCategory)" class="text-primary font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                        <i class="fa fa-sort"></i> {{ faqCategory.name }}
                                        </a>
                                    </td>

                                    <td class="px-3">
                                        {{ faqCategory.position }}
                                    </td>

                                    <td class="px-3">
                                        {{ faqCategory.parent_name ?  faqCategory.parent_name : '--'}}
                                    </td>

                                    <td class="px-3">
                                        <span class="badge badge-success text-lg`"
                                            v-bind:class="{ 'badge-success': !faqCategory.is_parent, 'badge-danger': faqCategory.is_parent }"
                                        >{{ faqCategory.is_parent ? 'No' : 'Yes' }}</span>
                                    </td>

                                    <td class="px-3">
                                        <span class="badge badge-success text-lg`"
                                            v-bind:class="{ 'badge-success': faqCategory.is_active, 'badge-danger': !faqCategory.is_active }"
                                        >{{ faqCategory.is_active ? 'Active' : 'Inactive' }}</span>
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
                                                    @click="editFaqCategory(faqCategory)"
                                                >
                                                    <v-icon small class="mx-2" color="blue darken-2">fas fa-edit</v-icon>
                                                    <v-list-item-title>Edit</v-list-item-title>
                                                </v-list-item>

                                                <v-list-item
                                                    @click="deleteFaqCategory(faqCategory.id)"
                                                >
                                                    <v-icon small class="mx-2" color="red darken-2">fas fa-trash</v-icon>
                                                    <v-list-item-title>Delete</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </td>
                                </tr>

                            </draggable>
                        </template>
                        <tbody v-if="faqCategories.length == 0">
                            <tr>
                                <td class="text-center font-weight-bold px-3" colspan="7">No Data Found</td>
                            </tr>
                        </tbody>
                    </table>
                    <v-pagination
                        v-if="faqCategories.length > 0"
                        class="pull-right mt-7"
                        @input="getAllFaqCategories"
                        v-model="page"
                        :length="lastPage"
                        :disabled="loading"
                    ></v-pagination>
                    </div>
                    <!-- table ends -->

                    <v-overlay :value="isSorting">
                    <v-progress-circular
                        indeterminate
                        color="dark"
                    ></v-progress-circular>
                    </v-overlay>

                </div>
            </div>
            <create-and-update ref="create-and-update" @refresh="getAllFaqCategories"></create-and-update>
        </div>
    </div>
  </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import FaqCategoryService from '@/services/admin/cms/faq/category/FaqCategoryService';

const faqCategory = new FaqCategoryService();

export default {
  components: {
    CreateAndUpdate,
  },
  name: "Index",
  data() {
    return{
      loading: false,
      isSorting: false,
      total: null,
      perPage: null,
      lastPage: null,
      page: '',
      faqCategories: [],
      currentUser: {},
      parents: [],
      status: [
        { title: 'Active', value: 1 },
        { title: 'Inactive', value: 0 },
      ],
      search:{
        name: '',
        parent_id: '',
        is_active: '',
      }
    }
  },
  mounted() {
    this.getAllFaqCategories();
    this.getAllParent();
  },
  methods: {
    createFaqCategory(){
      this.$refs['create-and-update'].createFAQCategory();
    },

    editFaqCategory(faqCategory){
      this.$refs['create-and-update'].editFAQCategory(faqCategory);
    },

    getAllFaqCategories(){
      this.loading = true;
      faqCategory
          .paginate(this.search,this.page)
          .then(response => {
            this.faqCategories = response.data.data;
            this.page = response.data.meta.current_page;
            this.total = response.data.meta.total;
            this.perPage = response.data.meta.per_page;
            this.lastPage = response.data.meta.last_page;
            this.loading = false;
          })
          .catch((err) => {
            this.loading = false;
            this.$snotify.error("Oops something went wrong");
          });
    },

    getAllParent(){
      faqCategory
          .getParent()
          .then(response => {
            this.parents = response.data.data;
          })
          .catch((err) => {
            this.$snotify.error("Oops something went wrong");
          });
    },

    sort(){
      this.isSorting = true;
      faqCategory
          .sort(this.faqCategories)
          .then(response => {
            this.$snotify.success('Faq category Sorted !!');
            this.getAllFaqCategories();
            this.isSorting = false;
          })
          .catch(err => {
            this.isSorting = false;
            this.$snotify.error("Oops something went wrong");
          });
    },

    searchFaqCategory(){
        this.page = 1;
        this.getAllFaqCategories();
    },

    deleteFaqCategory(id) {
      this.$confirm({
        message: `Are you sure? `,
        button: {
          no: "No",
          yes: "Yes",
        },
        callback: (confirm) => {
          if (confirm) {
            faqCategory
                .delete(id)
                .then((response) => {
                  this.getAllFaqCategories();
                  this.$snotify.success("FAQ category deleted successfully");
                })
                .catch((err) => {
                  this.$snotify.error("Oops something went wrong");
                });
          }
        },
      });
    },
  },

}
</script>
