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
            {{ edit ? 'Update' : 'Add'}} video gallery
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
              <v-text-field outlined dense label="Title" v-model="video.title"></v-text-field>
              <span class="text-danger" v-if="$v.video.title.$error">This information is required</span>
            </div>
            <div class="col-12 form-group">
              <v-select item-value="id" item-text="title" :items="categories" outlined dense label="Category"
                        v-model="video.category_id"></v-select>
              <span class="text-danger" v-if="$v.video.category_id.$error">This information is required</span>
            </div>

            <div class="col-12 form-group">
<!--              <b-form-tags input-id="tags-basic" class="border border-dark" v-model="video.tags"></b-form-tags>-->
              <v-combobox
                  v-model="video.tags"
                  hide-selected outlined dense deletable-chips
                  placeholder="Add tag" label="Add tag"
                  multiple  small-chips>
                <template v-slot:no-data>
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-title>
                        Type an tag  and press <kbd>enter</kbd> to add to this album
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </v-combobox>
            </div>
            <div class="col-12 form-group">
              <v-text-field outlined dense label="Video Url" v-model="video.video_url"></v-text-field>
              <span class="text-danger" v-if="$v.video.video_url.$error">This information is required</span>
            </div>
            <div class="col-12 form-group">
              <v-textarea outlined dense label="Description" v-model="video.description"></v-textarea>
              <!-- <span class="text-danger" v-if="$v.page.content.$error">Content is required</span> -->
            </div>
            <div class="col-6 form-group mt-5">
              Featured
              <v-switch
                  v-model="video.is_featured"
                  :label="video.is_featured?'Yes':'No'"
                  color="primary">
              </v-switch>
            </div>
            <div class="col-6">
              Status
              <v-switch
                  :label="video.is_active?'Active':'Inactive'"
                  v-model="video.is_active"
                  color="primary">
              </v-switch>
            </div>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <div class="float-right">
            <v-btn
                class="btn btn-standard text-gray cancel-btn"
                depressed
                @click="hideModal"
            >Cancel
            </v-btn>

            <v-btn v-if="checkIsAccessible('video-gallery','create')"
                   class="text-white btn btn-primary btn px-9 py-4 my-3 font-size-3 mx-4"
                   depressed
                   :disabled="sizeExceed"
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

import { required } from 'vuelidate/lib/validators'
import VideoGalleryService from "../../../../../services/admin/cms/video-gallery/VideoGalleryService";
import VideoGalleryCategoryService from "../../../../../services/admin/cms/video-gallery/category/VideoGalleryCategoryService";

const videoGallery = new VideoGalleryService();
const categoryService = new VideoGalleryCategoryService();

export default {
  validations: {
    video: {
      title: {required},
      category_id: {required},
      video_url: {required}
    }
  },

  data() {
    return {
      dialog: false,
      edit: false,
      sizeExceed: false,
      isBusy: false,
      categories: [],
      video: {
        title: null,
        category_id: null,
        video_url: null,
        description: null,
        is_active: true
      }
    };
  },mounted() {
    this.getCategories()
  },
  methods: {
    getCategories() {
      categoryService.activeAll().then(response => {
        this.categories = response.data
      })
    },
    showModal(id = null) {
      if (id) {
        this.edit = true
        this.getVideo(id)
      }
      this.dialog =true;
    },
    hideModal() {
      this.dialog = false;
    },
    toggleModal() {
      this.dialog = ! this.dialog;
    },
    getVideo(id) {
      videoGallery.show(id).then(response => {
        this.video = response.data.videoGallery
        if (this.video.tags) {
          this.video.tags = this.video.tags.split(',');
        }
      })
    },
    generateFd() {
      let fd = new FormData();
      for (let key in this.video) {
        if (key == "is_active" && this.video["is_active"]) {
          fd.append("is_active", this.video ? 1 : 0);
        } else {
          if (this.video[key] != null) {
            fd.append(key, this.video[key]);
          }
        }
      }
      return fd;
    },
    createOrUpdate() {
      this.$v.video.$touch();
      if (this.$v.video.$error) {
        setTimeout(() => {
          this.$v.video.$reset();
        }, 3000);
      } else {
        this.video.tags = (this.video.tags && this.video.tags.length > 0) ? this.video.tags.join(",") : null
        let fd = this.video;
        if (this.edit) {
          this.updateAlbum(fd);
        } else {
          this.createAlbum(fd);
        }
      }
    },
    updateAlbum(fd) {
      this.isBusy = true;
      videoGallery
          .update(this.video.id, fd)
          .then(response => {
            this.isBusy = false;
            this.$snotify.success("Updated successfully");

            this.resetForm();
          })
          .catch(error => {
            this.isBusy = false;
            this.$snotify.error("Something Went Wrong");
            // console.log(error);
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
    createAlbum(fd) {
      this.isBusy = true;
      videoGallery
          .store(fd)
          .then(response => {
            this.isBusy = false;
            this.resetForm();
            this.$snotify.success("Created successfully");

          })
          .catch(error => {
            this.isBusy = false;
            this.$snotify.error("Something Went Wrong");
            // console.log(error);
          });
    },
    resetForm() {
      this.$v.video.$reset();
      this.edit = false;
      this.video = {
        title: null,
        is_active: true
      };
      this.hideModal();
      this.$emit("refresh");
    }
  }
};
</script>
