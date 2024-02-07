<template>
  <v-app>
    <div class="card card-custom">
      <div class="card-body p-0">
        <div
          class="wizard wizard-2"
          id="kt_wizard_v2"
          data-wizard-state="step-first"
          data-wizard-clickable="true"
        >
          <div class="wizard-body py-8 px-8 py-lg-10 px-lg-10">
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-6">
                    <h3>
                      {{ `${id ? "Update" : "Add"} blogs` }}
                    </h3>
                    <a href="admin/dashboard">Dashboard</a> \
                    <a href="admin/blogs">Blogs</a>
                  </div>
                  <div class="col-6 text-right">
                    <div class="row">
                      <div class="col-12 mt-5 text-right"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-8">
                <div class="col-12 form-group">
                  <v-text-field
                    outlined
                    dense
                    type="text"
                    v-model="blog.title"
                    label="Title"
                    :error="$v.blog.title.$error"
                  ></v-text-field>
                  <span class="text-danger" v-if="$v.blog.title.$error"
                    >This information is required</span
                  >
                </div>
                <div class="col-12 form-group">
                  <v-select
                    v-model="blog.category_id"
                    :items="categories"
                    item-text="title"
                    item-value="id"
                    label="Categories"
                    multiple
                    outlined
                    dense
                    chips
                    deletable-chips
                    :error="$v.blog.title.$error"
                  ></v-select>

                  <span class="text-danger" v-if="$v.blog.category_id.$error"
                    >This information is required</span
                  >
                </div>
                <div class="col-12 form-group">
                  <label for class>Content</label>
                  <br />
                  <ckeditor
                    v-model="blog.content"
                    :config="editorConfig"
                  ></ckeditor>

                  <span class="text-danger" v-if="$v.blog.content.$error"
                    >This information is required</span
                  >
                </div>

                <div class="col-12 form-group">
                  <v-text-field
                    outlined
                    dense
                    v-model="blog.seo_title"
                    label="SEO title"
                  ></v-text-field>
                </div>
                <div class="col-12">
                  <v-file-input
                    outlined
                    dense
                    v-model="blog.author_image_file"
                    @change="checkSize($event)"
                    label="Author image"
                    prepend-icon=""
                    prepend-inner-icon="mdi-link"
                  ></v-file-input>
                  <span class="text-danger" v-if="sizeExceed"
                    >Please upload a file upto 20MB</span
                  >
                </div>
                <div class="col-12 form-group"
                  v-if="
                    blog.author_image_path && blog.author_image_path['thumb']
                  "
                >
                  <img :src="blog.author_image_path['thumb']" alt />
                </div>
                <div class="col-12 form-group">
                  <v-text-field
                    outlined
                    dense
                    v-model="blog.author_name"
                    label="Author name"
                  ></v-text-field>
                </div>
                <div class="col-12 form-group">
                  <v-text-field
                    outlined
                    dense
                    v-model="blog.author_name"
                    label="Seo keywords"
                  ></v-text-field>
                </div>
                <div class="col-12 form-group">
                  <v-textarea
                    label="SEO content"
                    outlined
                    dense
                    v-model="blog.seo_description"
                  ></v-textarea>
                </div>
              </div>

              <div class="col-4">


                <div class="col-12 form-group">
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
                        v-model="blog.publish_date"
                        label="Publish date"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        dense
                        outlined
                        v-bind="attrs"
                        v-on="on"
                        :error="$v.blog.publish_date.$error"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                        no-title
                      v-model="blog.publish_date"
                      :min="today"
                      @input="menu2 = false"
                    ></v-date-picker>
                  </v-menu>
                  <span class="text-danger" v-if="$v.blog.publish_date.$error"
                    >This information is required</span
                  >
                </div>

                <div class="col-12">
                  <v-file-input
                    outlined
                    dense
                    v-model="blog.social_share_image"
                    @change="checkSize($event)"
                    label="Social share image"
                    prepend-inner-icon="mdi-file"
                    prepend-icon=""
                  ></v-file-input>
                  <span class="text-danger" v-if="sizeExceed"
                    >Please upload a file upto 20MB</span
                  >
                </div>
                <div
                  class="col-12 mt-4"
                  v-if="
                    blog.social_share_image_path &&
                    blog.social_share_image_path['thumb']
                  "
                >
                  <img :src="blog.social_share_image_path['thumb']" alt />
                </div>

                <div class="col-12">
                  <v-file-input
                    outlined
                    dense
                    v-model="blog.image_file"
                    @change="checkSize($event)"
                    label="Blog image"
                    prepend-inner-icon="mdi-file"
                    prepend-icon=""
                  ></v-file-input>
                  <span class="text-danger" v-if="sizeExceed"
                    >Please upload a file upto 20MB</span
                  >
                </div>
                <div
                  class="col-12 mt-4"
                  v-if="
                    blog.image_path &&
                    blog.image_path['thumb']
                  "
                >
                  <img :src="blog.image_path['thumb']" alt />
                </div>

                <div class="col-12 mt-4">
                  <v-switch
                    v-model="blog.is_active"
                    name="check-button"
                    label="Status"
                  >
                  </v-switch>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-12 mt-5 text-right">
                    <v-btn
                      class="text-white mr-2 btn btn-primary"
                      depressed
                      :disabled="sizeExceed"
                      @click="createOrUpdate"
                      :loading="isBusy"
                      >{{ blog.id ? "Update" : "Save" }}
                    </v-btn>
                    <v-btn
                      class="btn btn-standard"
                      depressed
                      @click="redirectTo"
                      >Back
                    </v-btn>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <pre>{{blog}}</pre> -->
    </div>
  </v-app>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import BlogService from "@/services/admin/cms/blog/BlogService";
import BlogCategoryService from "@/services/admin/cms/blog/category/BlogCategoryService";

const blogService = new BlogService();
const category = new BlogCategoryService();
export default {
  name: "CreateAndUpdate",
  props: ["id", "homeRoute"],
  data() {
    return {
      categories: [],
      isBusy: false,
      sizeExceed: false,
      edit: false,
      menu2: false,
      menu3: false,
      today: new Date().toISOString().substr(0,10),
      editorData: "<p>Content of the editor.</p>",
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
        autoGrow_onStartup: true,
      },
      blog: {
        title: null,
        publish_date: "",
        content: null,
        seo_title: null,
        seo_keyword: null,
        image_file: null,
        author_image_file: null,
        seo_description: null,
        social_share_description: null,
        category_id: [],
        type: "blog",
        is_active: true,
        event_start: "",
        event_end: "",
      },
    };
  },

  validations: {
    blog: {
      title: { required },
      publish_date: { required },
      content: { required },
      category_id: { required },
    },
  },

  mounted() {
    if (this.id) {
        this.edit = true;
        this.getBlog();
    }
    this.getCategories();
  },
  methods: {

    checkSize(file) {
      let size = file.size / 1024 / 1024;
      let mbSize = size.toFixed(2);
      if (mbSize > 20) {
        this.sizeExceed = true;
      } else {
        this.sizeExceed = false;
      }
    },
    getCategories() {
      category
        .parentCategories()
        .then((response) => {
          this.categories = response.data.data;
        })
        .catch((error) => {
          // console.log(error);
        });
    },

    getBlog() {
      blogService
        .show(this.id)
        .then((response) => {
            this.blog = response.data.blog;
            if(this.blog.type == null) {
                this.blog.type = 'blog';
            }
            this.getCategories();
            delete this.blog["social_share_image"];
        })
        .catch(() => {
        });
    },
    generateFd() {

      let fd = new FormData();
      for (let key in this.blog) {
        if (
          key == "social_share_image" &&
          this.blog["social_share_image"] &&
          this.blog["social_share_image"] != null
        ) {
          fd.append("social_share_image", this.blog[key]);
        } else if (
          key == "image_file" &&
          this.blog["image_file"] &&
          this.blog["image_file"] != null
        ) {
          fd.append("image_file", this.blog[key]);
        } else if (
          key == "author_image_file" &&
          this.blog["author_image_file"] &&
          this.blog["author_image_file"] != null
        ) {
          fd.append("author_image_file", this.blog[key]);
        } else if (key == "is_active") {
          fd.append("is_active", this.blog.is_active ? 1 : 0);
        } else {
          fd.append(key, this.blog[key]);
        }
      }
      return fd;
    },
    createOrUpdate() {
      this.$v.blog.$touch();
      if (this.$v.blog.$error) {
        setTimeout(() => {
          this.$v.blog.$reset();
        }, 3000);
      } else {
        let fd = this.generateFd();
        if (this.edit) {
          this.updateBlog(fd);
        } else {
          this.createBlog(fd);
        }
      }
    },
    updateBlog(fd) {
      this.isBusy = true;

      blogService
        .update(this.blog.id, fd)
        .then((response) => {
          this.isBusy = false;
          this.$snotify.success("Updated successfully");
          setTimeout(() => {
            this.redirectTo();
          }, 1000);
        })
        .catch((error) => {
          this.isBusy = false;
          this.$snotify.error("Something Went Wrong");
        });
    },
    createBlog(fd) {
      this.isBusy = true;
      blogService
        .store(fd)
        .then((response) => {
          this.isBusy = false;
          this.$snotify.success("Created successfully");
          setTimeout(() => {
            this.redirectTo();
          }, 1000);
        })
        .catch((error) => {
          this.isBusy = false;
          this.$snotify.error("Something Went Wrong");

        });
    },

    redirectTo() {
      window.location.href = `${this.homeRoute}/admin/blogs`;
    },
  },
};
</script>

<style scoped>
.v-text-field__details {
  display: inline-block !important;
}
</style>
