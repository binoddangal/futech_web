<template>
    <div>
        <v-dialog v-model="dialog" max-width="600" persistent>
            <v-card>
              <v-toolbar elevation="0">
                <v-card-title class="headline">
                  {{`${category.id ? 'Update' : "Add"} category`}}
                  <hr>
                </v-card-title>

                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-spacer></v-spacer>
                  <v-btn icon  @click="closeDialog">
                    <i class="fas fa-times"></i>
                  </v-btn>
                </v-toolbar-items>
              </v-toolbar>
                <v-card-text>
                    <div class="row">
                        <div class="col-12 form-group">
                            <v-text-field outlined dense label="Title" v-model="category.title"></v-text-field>
                            <span class="float-left text-danger"
                                  v-if="$v.category.title.$error">This information is required</span>
                        </div>

                        <div class="col-12 form-group" v-if="!category.is_parent">
                            <v-select
                                    outlined dense
                                    :items="parent_categories"
                                    label="Category"
                                    item-text="title"
                                    item-value="id"
                                    v-model="category.parent_id"
                                    :error="$v.category.parent_id.$error"
                            >
                            </v-select>
                        </div>

                        <div class="col-12 form-group">
                            <label>Description</label>
                            <br />
                            <ckeditor
                                v-model="category.description"
                                :config="editorConfig"
                            ></ckeditor>

                            <span class="text-danger" v-if="$v.category.description.$error"
                                >This information is required</span
                            >
                        </div>

                        <div class="col-6 form-group">
                          <v-switch v-model="category.is_parent" label="Is Parent">
                          </v-switch>

                        </div>
                        <div class="col-6 form-group">
                          <v-switch v-model="category.is_active" label="Status">
                          </v-switch>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            <v-btn
                                    class="cancel-btn"
                                    depressed
                                    @click="closeDialog"
                            >Cancel
                            </v-btn>
                            <v-btn
                                    class="text-white ml-2 btn btn-primary"
                                    depressed
                                    @click="createOrUpdate"
                                    :loading="isBusy"
                            >{{ edit ? 'Update' : 'Save' }}
                            </v-btn>

                        </div>
                    </div>
                </v-card-text>
            </v-card>

        </v-dialog>

    </div>
</template>

<script>
import { required, requiredIf } from 'vuelidate/lib/validators';
import BlogCategoryService from "../../../../../../services/admin/cms/blog/category/BlogCategoryService";

const categoryService = new BlogCategoryService();

export default {
    name: "CreateAndUpdate",
    data() {
        return {
            dialog: false,
            isBusy: false,
            edit: false,
            parent_categories: [],
            category: {
                title: '',
                description: '',
                parent_id: '',
                is_parent: true,
                is_active: true
            },
            editorConfig: {
            toolbar: [ [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Link', 'NumberedList', 'BulletedList' ] ],
            autoGrow_onStartup:true
        },
        };
    },
    validations: {
        category: {
            title: {required},
            description: {required},
            parent_id: {required: requiredIf(function() {
                return !this.category.is_parent;
            })}
        }
    },
    methods: {
        createCategory() {
            this.dialog = true;
            this.edit = false;
            this.getParentCategories();
        },

        editCategory(category) {
            this.edit = true;
            this.dialog = true;
            this.getParentCategories();
            this.category = category;
        },

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

        createOrUpdate() {
            this.$v.category.$touch();
            if (this.$v.category.$error) {
                setTimeout(() => {
                    this.$v.category.$reset();
                }, 3000);
            } else {
                if (this.edit) {
                    this.update();
                } else {
                    this.create();
                }
            }
        },

        create() {
            this.isBusy = true;
            categoryService.store(this.category).then(response => {
                this.$snotify.success("Created successfully");
                this.closeDialog();
                this.$emit("refresh");
            }).catch(error => {
               this.$snotify.error("Something Went Wrong");
            }).finally(() => {
                this.isBusy = false;
            })

        },

        update() {
            this.isBusy = true;
            categoryService
                .update(this.category.id, this.category)
                .then(response => {
                    this.isBusy = false;
                    this.$snotify.success("Updated successfully");
                    this.closeDialog();
                    this.$emit("refresh");
                })
                .catch(error => {
                    this.isBusy = false;
                    this.$snotify.error("Something Went Wrong");
                    //console.log(error);
                });
        },

        resetForm() {
            this.$v.$reset();
            this.category = {
                title: '',
                parent_id: '',
                is_parent: true,
                is_active: true
            };
        },

        closeDialog() {
            this.dialog = false;
            this.edit = false;
            this.resetForm();
        }
    }
};
</script>
