<template>
  <v-app>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="600"
    >
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="headline">
            {{ edit ? 'Update' : 'Add'}} video category
            <hr>
          </v-card-title>

          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-spacer></v-spacer>
            <v-btn icon  @click="resetForm">
              <i class="fas fa-times"></i>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <div class="row">
            <div class="col-12 form-group">
              <v-text-field outlined dense label="Title" v-model="category.title"></v-text-field>
              <span class="float-left text-danger" v-if="$v.category.title.$error">This information is required</span>
            </div>
            <!--            <div class="col-12 form-group" v-if="!category.is_parent">-->
            <!--              <v-select-->
            <!--                  outlined dense-->
            <!--                  :items="parent_categories"-->
            <!--                  item-text="title"-->
            <!--                  item-value="id"-->
            <!--                  v-model="category.parent_id"-->
            <!--              >-->
            <!--              </v-select>-->
            <!--            </div>-->
            <!--            <div class="col-6 form-group">-->
            <!--              <b-form-checkbox-->
            <!--                  @change="getParentCategories"-->
            <!--                  v-model="category.is_parent"-->
            <!--                  name="check-button"-->
            <!--                  switch-->
            <!--              >Is Parent-->
            <!--              </b-form-checkbox>-->
            <!--            </div>-->
            <div class="col-6 form-group">
              <v-switch v-model="category.is_active" name="check-button" label="Status">
              </v-switch>
            </div>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <div class="float-right">

            <v-btn
                class="btn  btn-standard text-gray cancel-btn"
                depressed
                @click="resetForm"
            >Cancel
            </v-btn>

            <v-btn v-if="checkIsAccessible('video-gallery','create')"
                class="text-white btn btn-primary btn   font-weight-bold px-9 py-4 my-3 font-size-3 mx-4"
                depressed
                @click="createOrUpdate"
                :loading="isBusy"
            >Save
            </v-btn>
          </div>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>

import {required} from "vuelidate/lib/validators";
import VideoGalleryCategoryService from "../../../../../../services/admin/cms/video-gallery/category/VideoGalleryCategoryService";

const categoryService = new VideoGalleryCategoryService();

export default {
  props: ['dialog'],
  validations: {
    category: {
      title: {required},
    }
  },

  data() {
    return {
      dialog: false,
      isBusy: false,
      edit: false,
      types: [
        {value: "event", title: "Event"},
        {value: "blog", title: "Blog"},
        {value: "news", title: "News"},
      ],
      parent_categories: [],
      category:{
        title:null,
        is_active:true,
      }
    };
  },
  mounted() {
  },
  methods: {
    getParentCategories() {
      categoryService
          .parentCategories()
          .then(response => {
            this.parent_categories = response.data.data;
          })
          .catch(error => {
            //console.log(error);
          });
    },
    editCategory(category) {
      this.edit = true;
      this.category = category;
      this.getParentCategories();

    },
    createOrUpdate() {
      this.edit = false
      if (this.category.id)
        this.edit = true
      this.$v.category.$touch();
      if (this.$v.category.$error) {
        setTimeout(() => {
          this.$v.category.$reset();
        }, 3000);
      } else {
        if (this.edit) {
          this.updateCategory();
        } else {
          this.saveCategory();
        }
      }
    },
    createCategory(){

      this.edit=false;
      this.category={
        title:null,
        is_active: true,
      };
    },

    saveCategory() {
      this.isBusy = true;
      categoryService
          .store(this.category)
          .then(response => {
            this.isBusy = false;
            this.$snotify.success("Created successfully");
            this.resetForm();
          })
          .catch(error => {
            console.log(error)
            this.isBusy = false;
            this.$snotify.error("Something Went Wrong");
            //console.log(error);
          });
    },
    updateCategory() {
      this.isBusy = true;
      categoryService
          .update(this.category.id, this.category)
          .then(response => {
            this.isBusy = false;
            this.$snotify.success("Updated successfully");
            this.resetForm();
          })
          .catch(error => {
            this.isBusy = false;
            this.$snotify.error("Something Went Wrong");
            //console.log(error);
          });
    },
    openDialog(category, type) {
      if (type && type != undefined && type != null) {
        this.category.type = type;
        this.getParentCategories();
      }
      if (category && category.id && category.id != undefined && category.id != null) {
        this.editCategory(category);
      }
    },
    resetForm() {
      this.edit = false;
      this.category = {
        title: null,
        parent_id: null,
        is_parent: true,
        is_active: true,
        type: null
      };
      this.$v.$reset();
      this.getParentCategories();
      this.$emit("refresh");
    },
    closeDialog() {
      this.dialog = false;
    }
  }
};
</script>
