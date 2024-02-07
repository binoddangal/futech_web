<template>
  <v-app>
    <div class="row">
      <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title pt-3 px-3 d-flex justify-content-between">
                <div class="breadcrumb-left">

                  <div class="breadcrumb-sub-header">
                    <router-link to="/dashboard">Dashboard </router-link>\ Video category
                  </div>
                </div>
                <div class="breadcrumb-right">
                  <v-btn  v-if="checkIsAccessible('video-gallery','create')"
                         @click="openDialog()"
                         class="mt-4 btn btn-primary  mr-1"
                         dark>
                    <i class="fa fa-plus"></i>
                    Add category
                  </v-btn>

                </div>
              </div>
            </div>
           <div class="card-body">
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
                   <th>Parent</th>
                   <th class="pr-3 text-center">Action</th>
                 </tr>
                 </thead>
                 <tbody v-if="categories.length>0">
                 <tr v-for="(category, index) of categories" :key="index">
                   <td>
                     <a href="#" @click="editCategory(category)" class="mr-2"> {{ category.title }}</a> &nbsp;&nbsp;
                     <i class="fas fa-circle"
                        :class="category.is_active?'text-success':'text-danger'"></i>
                   </td>
                   <td>
                                      <span class="badge badge-primary">
                                        {{ category.type ? category.type : '-' }}
                                      </span>
                   </td>
                   <td>{{ category.parent_title ? category.parent_title : 'N/A' }}</td>
                   <!--                                    <td>-->
                   <!--                                    <span>-->
                   <!--                                      <i v-if="category.is_parent" class="fas fa-check text-success"></i>-->
                   <!--                                      <i v-else class="fas fa-ban text-danger"></i>-->
                   <!--                                    </span>-->
                   <!--                                    </td>-->



                   <td class="pr-0 text-center">
                     <template>
                       <b-dropdown
                           size="sm"
                           variant="link"
                           toggle-class="custom-v-dropdown btn btn-clean btn-hover-light-primary btn-sm btn-icon"
                           no-caret
                           right
                           no-flip
                       >
                         <template v-slot:button-content>
                           <i class="ki ki-bold-more-hor"></i>
                         </template>
                         <div class="navi navi-hover min-w-md-250px">
                           <b-dropdown-text tag="div" class="navi-item" >
                             <a @click="editCategory(category)" class="navi-link">
                                <span class="navi-icon">
                                  <i class="fas fa-edit"></i>
                                </span>
                               <span class="navi-text">Edit</span>
                             </a>
                           </b-dropdown-text>
                           <b-dropdown-text tag="div" class="navi-item">
                             <a @click.prevent="deleteCategory(category.id)" class="navi-link">
                                <span class="navi-icon">
                                    <i class="fas fa-eye"></i>
                                </span>
                               <span class="navi-text">Quick view</span>

                             </a>
                           </b-dropdown-text>

                         </div>
                       </b-dropdown>
                     </template>
                   </td>
                 </tr>
                 </tbody>
                 <tbody v-else>
                 <tr>

                   <td colspan="4" class="text-center">No items found</td>
                 </tr>
                 </tbody>
               </table>
             </div>
           </div>
          <!-- create and update -->
          <create-and-update ref="category" :dialog="dialog"  @refresh="refreshList()"></create-and-update>
      <!-- <pre>{{category}}</pre> -->
    </div>
      </div>
    </div>
  </v-app>
</template>
<script>

import {required} from "vuelidate//lib/validators";
import CreateAndUpdate from "./CreateAndUpdate.vue";
import VideoGalleryCategoryService from "../../../../../../services/admin/cms/video-gallery/category/VideoGalleryCategoryService";

const categoryService = new VideoGalleryCategoryService();
export default {
  name: 'VideoGalleryCategory',

  components: {
    CreateAndUpdate
  },
  validations: {
    category: {
      title: {required},
      type: {required},
    }
  },

  data() {
    return {
      categories: [],
      dialog: false,
      loading: false,
      category: {
        title: null,
        type: null,
        parent_id: null,
        is_parent: true,
        is_active: true
      },

      parent_categories: []
    };
  },
  computed: {
    categoryName() {
      return this.$route.params.category;
    }
  },
  mounted() {
    this.getCatgories();
    this.getParentCategories();
  },
  methods: {
    getParentCategories() {

      categoryService
          .parentCategories(this.category.type)
          .then(response => {
            this.parent_categories = response.data.data;
            this.loading=false;
          })
          .catch(error => {
            //console.log(error);
          });
    },
    getCatgories() {
      this.loading = true;
      categoryService
          .paginate(this.categoryName)
          .then(response => {
            this.categories = response.data.data;
            this.loading=false;
          })
          .catch(error => {
            //console.log(error);
          });
    },

    createOrUpdate() {
      this.$v.category.$touch();
      if (this.$v.category.$error) {
        setTimeout(() => {
          this.$v.category.$reset();
        }, 3000);
      } else {
        if (this.edit) {
          this.udpateCategory();
        } else {
          this.createCategory();
        }
      }
    },
    createCategory() {
      categoryService
          .store(this.category)
          .then(response => {
            this.$snotify.success("Created successfully");

            this.resetForm();
          })
          .catch(error => {
            //console.log(error);
          });
    },
    udpateCategory() {
      categoryService
          .update(this.category.id, this.category)
          .then(response => {
            this.$snotify.success("Updated successfully");
            this.resetForm();
          })
          .catch(error => {
            //console.log(error);
          });
    },
    deleteCategory(id) {

      this.$confirm(
          {
            message: `Are you sure you want to delete this item permanently?`,
            button: {
              no: 'No',
              yes: 'Yes'
            },
            /**
             * Callback Function
             * @param {Boolean} confirm
             */
            callback: confirm => {
              if (confirm) {
                categoryService
                    .delete(id)
                    .then(response => {
                      this.$snotify.success("Deleted successfully");
                      this.getCatgories();
                    })
                    .catch(error => {
                      //console.log(error);
                    });


              }
            }
          }
      )
    },
    openDialog(category) {
      this.dialog = true;
      this.$refs['category'].createCategory();
    },
    editCategory(category) {
      this.dialog = true;
      this.$refs['category'].editCategory(category);
    },

    resetForm() {
      this.edit = false;
      this.category = {
        title: null,
        parent_id: null,
        is_parent: true,
        is_active: true,
        type: null,
      };
      this.$v.$reset();
      this.hideModal();
      this.getCatgories();
      this.getParentCategories();
    },
    closeDialog() {
      this.dialog = false;
    }, refreshList() {
      this.dialog = false
      this.getCatgories();
    }
  }
};
</script>
