<template>
  <v-dialog
      v-model="dialog"
      max-width="600px"
      scrollable
  >
    <v-card>
      <v-toolbar elevation="0">
        <v-card-title class="text-h5">
          <span>{{ title }} FAQ Category</span>
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
        <v-container>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                  v-model="faqCategory.name"
                  :error="$v.faqCategory.name.$error"
                  outlined
                  dense
              >
                <template v-slot:label>
                  Name <span class="text-danger">*</span>
                </template>
              </v-text-field>
              <span class="text-danger" v-if="$v.faqCategory.name.$error">Name is required.</span>
              <span class="text-danger" v-if="errors.name" >* {{ errors.name[0] }}</span>
            </v-col>

            <v-col cols="6" md="6">
              Is this a main category ?
              <v-switch
                  v-model="faqCategory.is_parent"
                  :label="faqCategory.is_parent?'Main':'Child'"
              ></v-switch>
            </v-col>

            <v-col cols="12" sm="12" md="12" v-if="!faqCategory.is_parent">
              <v-select
                  v-model="faqCategory.parent_id"
                  :error="$v.faqCategory.parent_id.$error"
                  :items="faqCategories"
                  item-text="name"
                  item-value="id"
                  outlined
                  dense
              >
                <template v-slot:label>
                  Choose Main Category <span class="text-danger">*</span>
                </template>
              </v-select>
              <span class="text-danger" v-if="$v.faqCategory.parent_id.$error">This Field is required</span>
            </v-col>

            <v-col cols="12" md="12">
              Description <span class="text-danger">*</span>
              <ckeditor
                  :config="editorConfig"
                  v-model="faqCategory.description" >
              </ckeditor>
              <span class="text-danger" v-if="$v.faqCategory.description.$error">Description Field is required</span>
              <span class="text-danger" v-if="errors.description" >* {{ errors.description[0] }}</span>
            </v-col>

            <v-col cols="6" md="6">
              Status
              <v-switch
                  v-model="faqCategory.is_active"
                  :label="faqCategory.is_active ? 'Active' : 'Inactive'"
              ></v-switch>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
            color="btn btn-standard"
            dark
            medium
            @click="dialog = false"
        >
          Cancel
        </v-btn>
        <v-btn
            color="btn btn-primary"
            dark
            medium
            @click="createOrUpdate()"
            :loading="loading"
        >
          {{ edit ? "Update" : "Save" }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import FaqCategoryService from '@/services/admin/cms/faq/category/FaqCategoryService';
import { required, requiredIf } from 'vuelidate/lib/validators';

const faqCategory = new FaqCategoryService();

export default {
    name: "CreateAndUpdate",
    data() {
        return {
        title: '',
        dialog: false,
        edit: false,
        loading: false,
        errors: [],
        faqCategories: [],
        faqCategory: {
            name:'',
            is_parent: true,
            parent_id:'',
            description:'',
            is_active: true,
        },
        editorConfig: {
            toolbar: [
            [
                'Font', 'FontSize', 'FontColor', 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Link', 'NumberedList', 'BulletedList', 'TextColor', 'BGColor'
            ]
            ],
            extraPlugins: ['font', 'colorbutton'],
            colorButton_enableMore: true,
        },
        }
    },
    validations: {
        faqCategory: {
        name: { required },
        parent_id: { required: requiredIf(function () {
            return !this.faqCategory.is_parent;
            }) },
        description: { required },
        is_active: { required }
        }
    },
    methods: {
        closeDialog() {
            this.dialog=false;
        },

        createFAQCategory() {
            this.title = 'Add';
            this.dialog = true;
            this.edit = false;
            this.resetForm();
        },

        editFAQCategory(faqCategory) {
            this.title = 'Update';
            this.dialog = true;
            this.edit = true;
            this.faqCategory = faqCategory;
        },

        getAllParent() {
            faqCategory
                .getParent()
                .then(response => {
                    this.faqCategories = response.data.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },

        createOrUpdate() {
            this.$v.$touch()
            if (this.$v.$error) {
                setTimeout(() => {
                this.$v.$reset()
                }, 3000);
            } else {
                if (!this.edit) this._create();
                else this.update();
            }
        },

        _create: function() {
            this.loading = true;
            faqCategory
                .create(this.faqCategory)
                .then(response => {
                    this.$snotify.success("FAQ category created successfully");
                    this.resetForm();
                    this.closeDialog();
                    this.$emit('refresh');
                    this.loading = false;
                })
                .catch((err) => {
                    this.loading = false;
                    this.errors = err.errors;
                    this.$snotify.error("Oops something went wrong");
                });
        },

        update() {
            this.loading = true;
            faqCategory
                .update(this.faqCategory.id,this.faqCategory)
                .then(response => {
                    this.$snotify.success("FAQ Category updated successfully");
                    this.resetForm();
                    this.closeDialog();
                    this.$emit('refresh');
                    this.getAllParent();
                    this.loading = false;
                })
                .catch((err) => {
                    this.loading = false;
                    this.errors = err.errors;
                    this.$snotify.error("Oops something went wrong");
                });
        },
        resetForm() {
            this.dialog = true;
            this.errors = [];
            this.$v.$reset();
            this.faqCategory = {
                name: '',
                is_parent: true,
                parent_id: '',
                description: '',
                is_active: true,
            }
        },

    },
    mounted() {
        this.getAllParent();
    }
}
</script>
