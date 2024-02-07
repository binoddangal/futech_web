<template>
  <div>
    <v-dialog v-model="dialog" max-width="700" scrollable>
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="">
            {{ `${edit ? "Update" : "Add"} album` }}
          </v-card-title>

          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-spacer></v-spacer>
            <v-btn icon @click="closDialog">
              <i class="fas fa-times"></i>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <div class="row">
              <div class="col-12">
                <v-text-field
                  outlined
                  dense
                  label="Album name"
                  v-model="album.title"
                  :error="$v.album.title.$error"
                ></v-text-field>

                <span class="text-danger" v-if="$v.album.title.$error"
                  >This information is required</span
                >
              </div>
              <div class="col-12">
                <v-file-input
                  outlined
                  dense
                  prepend-inner-icon="fas fa-image"
                  prepend-icon=""
                  v-model="album.file"
                  @change="checkSize($event)"
                  label="Cover image"
                ></v-file-input>
                <span class="text-danger" v-if="sizeExceed"
                  >Please upload a file size upto 20MB</span
                >
              </div>
              <div class="col-12 mt-4" v-if="album.file_path">
                <img :src="album.file_path['thumb']" alt />
              </div>

              <div class="col-12">
                <!--          <b-form-tags class="border border-dark" input-id="tags-basic" v-model="album.tags"></b-form-tags>-->
                <v-combobox
                  v-model="album.tags"
                  hide-selected
                  outlined
                  dense
                  deletable-chips
                  placeholder="Add tag"
                  label="Add tag"
                  multiple
                  small-chips
                >
                  <template v-slot:no-data>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title>
                          Type an tag and press <kbd>enter</kbd> to add to this
                          album
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </template>
                </v-combobox>
              </div>
              <div class="col-12">
                <label for="">Description</label>
                <ckeditor v-model="album.description"></ckeditor>
                <!-- <span class="text-danger" v-if="$v.page.content.$error">Content is required</span> -->
              </div>
              <div class="col-12 mt-5">
                <v-col cols="6" md="4">
                  Status
                  <v-switch
                    v-model="album.is_active"
                    :label="album.is_active ? 'Active' : 'Inactive'"
                    color="primary"
                  ></v-switch>
                </v-col>
              </div>
            </div>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="btn btn-standard cancel-btn" dark @click="closDialog"
            >Cancel
          </v-btn>
          <v-btn
            class="text-white btn btn-primary"
            dark
            :disabled="sizeExceed"
            @click="createOrUpdate"
            :loading="isBusy"
            >Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import AlbumService from '@/services/admin/cms/album/AlbumService';

import { required } from 'vuelidate/lib/validators'

const album = new AlbumService();
export default {
    data() {
        return {
            edit: false,
            dialog: false,
            sizeExceed: false,
            isBusy: false,
            album: {
                title: null,
                is_active: true
            }
        };
    },
    validations: {
        album: {
            title: {required}
        }
    },
    methods: {

        openDialog(){
            this.dialog=true;
        },

        showModal(album = null) {
            this.openDialog();
            if (album) {
                this.edit = true
                this.album = album;
            }
        },

        closDialog() {
          this.dialog = false;
        },

        generateFd() {
            let fd = new FormData();
            for (let key in this.album) {
                if (key == "file" && this.album["file"] && this.album["file"] != null) {
                    fd.append("file", this.album[key]);
                } else {
                    if (this.album[key] != null) {
                        fd.append(key, this.album[key]);
                    }
                }
            }
            return fd;
        },

        createOrUpdate() {
            this.$v.album.$touch();
            if (this.$v.album.$error) {
                setTimeout(() => {
                    this.$v.album.$reset();
                }, 3000);
            } else {
                let fd = this.generateFd();
                if (this.edit) {
                    this.updateAlbum(fd);
                } else {
                    this.createAlbum(fd);
                }
            }
        },

        updateAlbum(fd) {
            this.isBusy = true;
            album
                .update(this.album.id, fd)
                .then((response) => {
                    this.isBusy = false;
                    this.$snotify.success("Updated successfully");
                    this.$emit("refresh");
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
            album
                .store(fd)
                .then(response => {
                    this.isBusy = false;
                    this.resetForm();
                    this.$snotify.success("Created successfully");

                })
                .catch(error => {
                    this.isBusy = false;
                    this.$snotify.error("Something Went Wrong");
            });
        },

        resetForm() {
            this.$v.album.$reset();
            this.edit = false;
            this.album = {
                title: null,
                is_active: true
            };
            this.closDialog();
            this.$emit("refresh_album");
        }
    }
};
</script>
