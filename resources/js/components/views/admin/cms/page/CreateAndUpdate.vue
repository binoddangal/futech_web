<template>
  <v-dialog v-model="dialog" max-width="800">
    <v-card>
      <v-toolbar elevation="0">
        <v-card-title> {{ edit ? "Edit" : "Add" }} page </v-card-title>

        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-spacer></v-spacer>
          <v-btn icon @click="closeDialog">
            <i class="fas fa-times"></i>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>

      <v-card-text>
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 form-group">
                <v-text-field
                  outlined
                  dense
                  label="Title"
                  v-model="page.title"
                  :error="$v.page.title.$error"
                ></v-text-field>
                <span class="text-danger" v-if="$v.page.title.$error"
                  >This information is required</span
                >
                <ckeditor v-model="page.content"></ckeditor>

                <span class="text-danger" v-if="$v.page.content.$error"
                  >This information is required</span
                >
              </div>
              <!-- <div class="col-12 form-group">
                <v-expansion-panels>
                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      Manage SEO
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <div class="col-12 form-group">
                        <v-text-field
                          outlined
                          dense
                          label="Seo title"
                          v-model="page.seo_title"
                        ></v-text-field>
                        <v-combobox
                          outlined
                          small-chips
                          dense
                          v-model="page.seo_keyword"
                          label="Seo keywords"
                          multiple
                        ></v-combobox>
                        <v-textarea
                          outlined
                          dense
                          name
                          label="Seo content"
                          cols="30"
                          rows="10"
                          v-model="page.seo_description"
                        ></v-textarea>
                      </div>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </div> -->

              <div class="col-12 mt-4">
                <v-switch
                  v-model="page.is_active"
                  name="check-button"
                  label="Status"
                >
                </v-switch>
              </div>
            </div>
          </div>
        </div>
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
          >Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import PageService from "@/services/admin/cms/page/PageService";
import { required } from "vuelidate/lib/validators";

const pageService = new PageService();

export default {
  data() {
    return {
      edit: false,
      dialog: false,
      sizeExceed: false,
      loading: false,
      page: {
        title: null,
        slug: null,
        custom_slug: null,
        content: null,
        position: null,
        seo_title: null,
        seo_keyword: null,
        seo_description: null,
        social_share_image: null,
        social_share_description: null,
        views: null,
        is_active: true,
      },
    };
  },
  validations: {
    page: {
      title: { required },
      content: { required },
    },
  },

  methods: {
    createPage() {
      this.dialog = true;
    },

    editPage(page) {
      this.edit = true;
      this.dialog = true;
      this.page = page;
    },

    closeDialog() {
      this.dialog = false;
      this.resetForm();
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

    createOrUpdate() {
      this.$v.page.$touch();
      if (this.$v.page.$error) {
        setTimeout(() => {
          this.$v.page.$reset();
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
      pageService
        .update(this.page.id, this.page)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Updated successfully");
          this.$emit("refresh");
          this.resetForm();
        })
        .catch((error) => {
          this.loading = false;
          this.$snotify.error("Something Went Wrong");
          this.loading = false;
          // console.log(error);
        });
    },

    create() {
      this.loading = true;
      pageService
        .store(this.page)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Created successfully");
          this.resetForm();
          this.$emit("refresh");
        })
        .catch((error) => {
          this.$snotify.error("Something Went Wrong");
          this.loading = false;
          // console.log(error);
        });
    },

    resetForm() {
      this.dialog = false;
      this.edit = false;
      this.$v.page.$reset();
      this.page = {
        title: null,
        slug: null,
        custom_slug: null,
        content: null,
        position: null,
        seo_title: null,
        seo_keyword: [],
        seo_description: null,
        social_share_image: null,
        social_share_description: null,
        views: null,
        is_active: true,
      };
    },
  },
};
</script>
