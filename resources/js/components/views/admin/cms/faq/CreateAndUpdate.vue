<template>
  <v-app>
    <v-dialog v-model="dialog" max-width="800">
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="headline">
            {{ `${edit ? "Update" : "Add"} Frequently asked questions (FAQs)` }}
            <hr />
          </v-card-title>

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
            <v-col cols="6">
              <v-text-field
                label="Title"
                v-model="faq.title"
                outlined
                dense
                :error="$v.faq.title.$error"
              ></v-text-field>
              <span class="text-danger" v-if="$v.faq.title.$error"
                >This information is required</span
              >
            </v-col>
            <v-col cols="6">
              <v-select
                outlined
                dense
                :items="faq_categories"
                v-model="faq.parent_id"
                item-text="name"
                item-value="id"
                label="Select category"
              ></v-select>
              <span class="text-danger" v-if="$v.faq.parent_id.$error"
                >This information is required</span
              >
            </v-col>

            <v-col cols="12">
              <label for="description">Description</label>
              <ckeditor
                id="'description"
                v-model="faq.description"
                :config="editorConfig"
              ></ckeditor>
              <span class="text-danger" v-if="$v.faq.description.$error"
                >This information is required</span
              >
            </v-col>

            <v-col cols="12">
              <v-switch v-model="faq.is_active" label="Status"></v-switch>
            </v-col>

            <v-col cols="12">
              <div class="text-right float-right">
                <v-btn
                  dark
                  @click="closeDialog"
                  class="text-gray btn btn-standard"
                >
                  Cancel
                </v-btn>
                <v-btn
                  dark
                  :loading="loading"
                  @click="createOrUpdate"
                  class="text-white ml-2 btn btn-primary"
                >
                  Save
                </v-btn>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-app>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import FaqService from "@/services/admin/cms/faq/FaqService";
import FaqCategoryService from "@/services/admin/cms/faq/category/FaqCategoryService";

const faqService = new FaqService();
const faqCategory = new FaqCategoryService();
export default {
  name: "CreateAndUpdate",
  data() {
    return {
      programs: [],
      dialog: false,
      edit: false,
      sizeExceed: false,
      loading: false,
      search: {
        is_active: "1",
        is_parent: 1,
      },
      editorConfig: {
        toolbar: [
          [
            "Bold",
            "Italic",
            "Underline",
            "Strike",
            "RemoveFormat",
            "Link",
            "NumberedList",
            "BulletedList",
          ],
        ],
      },
      faq: {
        title: null,
        description: null,
        parent_id: null,
        is_active: true,
      },
      faq_categories: [],
    };
  },
  validations: {
    faq: {
      title: { required },
      description: { required },
      parent_id: { required },
    },
  },
  methods: {
    addFaq() {
      this.dialog = true;
      this.edit = false;
      this.getFaqsCategories();
    },

    editFaq(faq) {
      this.dialog = true;
      this.edit = true;
      this.faq = faq;
      this.getFaqsCategories();
    },

    closeDialog() {
      this.dialog = false;
      this.resetForm();
    },

    getFaqsCategories() {
      faqCategory
        .getParent()
        .then((response) => {
          this.faq_categories = response.data.data;
        })
        .catch((error) => {});
    },

    generateFd() {
      let fd = new FormData();
      for (let key in this.faq) {
        if (key == "is_active" && this.faq["is_active"]) {
          fd.append("is_active", this.faq ? 1 : 0);
        } else {
          if (this.faq[key] != null) {
            fd.append(key, this.faq[key]);
          }
        }
      }
      return fd;
    },

    createOrUpdate() {
      this.$v.faq.$touch();
      if (this.$v.faq.$error) {
        setTimeout(() => {
          this.$v.faq.$reset();
        }, 3000);
      } else {
        let fd = this.faq;
        if (this.edit) {
          this.updateFaq(fd);
        } else {
          this.createFaq(fd);
        }
      }
    },

    updateFaq(fd) {
      this.loading = true;
      faqService
        .update(this.faq.id, fd)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Updated successfully");
          this.$emit("refresh");
          this.closeDialog();
            this.resetForm();

        })
        .catch((error) => {
          this.loading = false;
          this.$snotify.error("Something Went Wrong");
        });
    },

    checkSize(file) {
      let size = file.target.files[0].size / 1024 / 1024;
      let mbSize = size.toFixed(2);
      if (mbSize > 20) {
        this.sizeExceed = true;
      } else {
        this.sizeExceed = false;
      }
    },

    createFaq(fd) {
      this.loading = true;
      faqService
        .store(fd)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Created successfully");
          this.$emit("refresh");
          this.closeDialog();
        })
        .catch((error) => {
          this.loading = false;
          this.$snotify.error("Something Went Wrong");
        });
    },

    resetForm() {
      this.$v.faq.$reset();
      this.edit = false;
      this.faq = {
        title: null,
        is_active: true,
      };
    },
  },
};
</script>
