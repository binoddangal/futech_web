<template>
  <v-dialog v-model="dialog" max-width="800">
    <v-card>
      <v-toolbar elevation="0">
        <v-card-title> {{ edit ? "Edit" : "Add" }} request </v-card-title>

        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-spacer></v-spacer>
          <v-btn icon @click="closeDialog">
            <i class="fas fa-times"></i>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>

      <v-card-text>
        <v-row>
            <v-col cols="col-12" md="6">
                <v-select
                    v-model="request.category_id"
                    :error="$v.request.category_id.$error"
                    :items="categories"
                    item-text="title"
                    item-value="id"
                    @change="getAllSubCategory"
                    outlined
                    dense
                >
                    <template v-slot:label>
                        Category <span class="text-danger"> *</span>
                    </template>
                </v-select>
                <span class="text-danger" v-if="$v.request.category_id.$error"
                    >This information is required</span
                >
            </v-col>

            <v-col cols="col-12" md="6">
                <v-select
                    v-model="request.sub_category_id"
                    :error="$v.request.sub_category_id.$error"
                    :items="sub_categories"
                    item-text="title"
                    item-value="id"
                    @change="getAllItem"
                    outlined
                    dense
                >
                    <template v-slot:label>
                        Sub category <span class="text-danger"> *</span>
                    </template>
                </v-select>
                <span class="text-danger" v-if="$v.request.sub_category_id.$error"
                    >This information is required</span
                >
            </v-col>

            <v-col cols="col-12" md="6">
                <v-select
                    v-model="request.item_id"
                    :error="$v.request.item_id.$error"
                    :items="items"
                    item-text="title"
                    item-value="id"
                    outlined
                    dense
                >
                    <template v-slot:label>
                        Item <span class="text-danger"> *</span>
                    </template>
                </v-select>
                <span class="text-danger" v-if="$v.request.item_id.$error"
                    >This information is required</span
                >
            </v-col>

            <v-col cols="col-12" md="6">
                <v-select
                    v-model="request.priority"
                    :error="$v.request.priority.$error"
                    :items="priorities"
                    item-text="title"
                    item-value="value"
                    outlined
                    dense
                >
                    <template v-slot:label>
                        Priority <span class="text-danger"> *</span>
                    </template>
                </v-select>
                <span class="text-danger" v-if="$v.request.priority.$error"
                    >This information is required</span
                >
            </v-col>

            <v-col cols="col-12" md="6">
                <v-text-field
                    v-model="request.demanded_qty"
                    :error="$v.request.demanded_qty.$error"
                    outlined
                    dense
                >
                    <template v-slot:label>
                        Demanded quantity <span class="text-danger"> *</span>
                    </template>
                </v-text-field>
                <span class="text-danger" v-if="$v.request.demanded_qty.$error"
                    >This information is required</span
                >
            </v-col>

            <v-col cols="col-12" md="6">
                <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="request.deadline"
                        prepend-icon=""
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        outlined
                        dense
                        v-bind="attrs"
                        v-on="on"
                    >
                        <template v-slot:label>
                            Deadline <span class="text-danger"> *</span>
                        </template>
                    </v-text-field>
                    </template>
                    <v-date-picker
                        :min="currentDate"
                        v-model="request.deadline"
                        @input="menu = false"
                        no-title
                        scrollable
                    >
                    </v-date-picker>
                </v-menu>
                <span class="text-danger" v-if="$v.request.deadline.$error"
                    >This information is required</span
                >
            </v-col>

            <v-col cols="col-12" md="12">

                <ckeditor :config="editorConfig" v-model="request.remarks"></ckeditor>

                <span class="text-danger" v-if="$v.request.remarks.$error"
                    >This information is required</span
                >
            </v-col>

            <v-col cols="col-12">
                <v-switch
                    v-model="request.is_active"
                    name="check-button"
                    label="Status"
                >
                </v-switch>
            </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn class="btn btn-standard cancel-btn" dark @click="closeDialog"
          >Cancel
        </v-btn>
        <v-btn
          class="btn btn-primary"
          dark
          @click="createOrUpdate"
          :loading="loading"
          >{{ edit ? "Update" : "Save" }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import RequestService from '@/services/front/request/RequestService';
import CategoryService from '@/services/front/category/CategoryService';
import SubCategoryService from '@/services/front/category/sub-category/SubCategoryService';
import ItemService from '@/services/front/category/sub-category/item/ItemService';

const request = new RequestService();
const category = new CategoryService();
const subCategory = new SubCategoryService();
const item = new ItemService();

export default {
  data() {
    return {
        edit: false,
        dialog: false,
        menu: false,
        loading: false,
        categories: [],
        sub_categories: [],
        items: [],
        currentDate: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        request: {
            category_id: '',
            sub_category_id: '',
            item_id: '',
            priority: '',
            demanded_qty: '',
            deadline: '',
            remarks: '',
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
        priorities: [
            { title: "Normal", value: "normal" },
            { title: "Urgent", value: "urgent" },
        ]
    };
  },
  validations: {
    request: {
        category_id: { required },
        sub_category_id: { required },
        item_id: { required },
        priority: { required },
        demanded_qty: { required },
        deadline: { required },
        remarks: { required },
    },
  },

  methods: {
    createRequest() {
      this.dialog = true;
      this.edit = false;
      this.resetForm();
      this.getAllCategory();
    },

    editRequest(request) {
      this.edit = true;
      this.dialog = true;
      this.resetForm();
      this.request = request;
      this.getAllCategory();
      this.getAllSubCategory();
      this.getAllItem();
    },

    closeDialog() {
      this.dialog = false;
      this.resetForm();
    },

    getAllCategory() {
        category.all()
        .then((response) => {
            this.categories = response.data.categories;
        })
        .catch(() => {});
    },

    getAllSubCategory() {
        subCategory.getAllSubCategory(this.request.category_id)
        .then((response) => {
            this.sub_categories = response.data.subCategories;
        })
        .catch(() => {});
    },

    getAllItem() {
        item.getAllItem({category_id: this.request.category_id, sub_category_id: this.request.sub_category_id})
        .then((response) => {
            this.items = response.data.items;
        })
        .catch(() => {});
    },

    createOrUpdate() {
      this.$v.request.$touch();
      if (this.$v.request.$error) {
        setTimeout(() => {
          this.$v.request.$reset();
        }, 3000);
      } else {
        if (this.edit) {
          this.update();
        } else {
          this.create();
        }
      }
    },

    update() {
      this.loading = true;
      request
        .update(this.request.id, this.request)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Updated successfully");
          this.$emit("refresh");
          this.closeDialog();
        })
        .catch((error) => {
          this.loading = false;
          this.$snotify.error("Something Went Wrong");
          this.loading = false;
        });
    },

    create() {
      this.loading = true;
      request
        .store(this.request)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Created successfully");
          this.closeDialog();
          this.$emit("refresh");
        })
        .catch((error) => {
          this.$snotify.error("Something Went Wrong");
          this.loading = false;
        });
    },

    resetForm() {
      this.$v.request.$reset();
      this.request = {
        category_id: '',
        sub_category_id: '',
        item_id: '',
        priority: '',
        demanded_qty: '',
        deadline: '',
        remarks: '',
        is_active: true,
      };
    },
  },
};
</script>
