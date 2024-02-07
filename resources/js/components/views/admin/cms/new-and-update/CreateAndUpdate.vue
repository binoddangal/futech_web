<template>
  <v-app>
    <v-dialog v-model="dialog" max-width="800">
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="headline">
            {{ `${edit ? "Update" : "Add"} News and Updates` }}
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
            <v-col cols="12">
              <v-text-field
                label="Title"
                v-model="newsAndUpdate.title"
                outlined
                dense
                :error="$v.newsAndUpdate.title.$error"
              ></v-text-field>
              <span class="text-danger" v-if="$v.newsAndUpdate.title.$error"
                >This information is required</span
              >
            </v-col>

            <v-col cols="12">
              <v-text-field
                label="URL"
                v-model="newsAndUpdate.url"
                outlined
                dense
                :error="$v.newsAndUpdate.url.$error"
              ></v-text-field>
              <span class="text-danger" v-if="$v.newsAndUpdate.url.$error"
                >This information is required</span
              >
            </v-col>

            <v-col cols="12">
              <v-text-field
                label="Published By"
                v-model="newsAndUpdate.published_by"
                outlined
                dense
                :error="$v.newsAndUpdate.published_by.$error"
              ></v-text-field>
              <span class="text-danger" v-if="$v.newsAndUpdate.published_by.$error"
                >This information is required</span
              >
            </v-col>

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
                        v-model="newsAndUpdate.publish_date"
                        label="Publish date"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        dense
                        outlined
                        v-bind="attrs"
                        v-on="on"
                        :error="$v.newsAndUpdate.publish_date.$error"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                        no-title
                      v-model="newsAndUpdate.publish_date"
                      :min="today"
                      @input="menu2 = false"
                    ></v-date-picker>
                  </v-menu>
                  <span class="text-danger" v-if="$v.newsAndUpdate.publish_date.$error"
                    >This information is required</span
                  >
                </div>

            <div class="col-12" >
              <v-file-input
                accept="image/*"
                outlined
                dense
                prepend-inner-icon="fas fa-image"
                prepend-icon=""
                v-model="newsAndUpdate.file"
                label="Featured Photo"
                :error="$v.newsAndUpdate.file.$error"
              ></v-file-input>
              <span
                class="text-danger"
                v-if="$v.newsAndUpdate.file.$error"
                >This information is required</span
              >
              <div>
                <span class="text-danger" v-if="sizeExceed"
                  >Please upload a file upto 20MB</span
                >
              </div>
            </div>

            <v-col cols="12">
              <v-switch
                v-model="newsAndUpdate.is_active"
                :label="newsAndUpdate.is_active ? 'Active' : 'Inactive'"
              >
              </v-switch>
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
                  {{ edit ? "Update" : "Save" }}
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
import { required, requiredIf } from "vuelidate/lib/validators";
import NewsAndUpdatesService from '@/services/admin/cms/news-and-update/NewsAndUpdatesService';

const newsAndUpdatesService = new NewsAndUpdatesService();
export default {
  name: "CreateAndUpdate",
  data() {
    return {
      programs: [],
      dialog: false,
      edit: false,
      sizeExceed: false,
      loading: false,
      menu2: false,
      today: new Date().toISOString().substr(0,10),
      search: {
        is_active: "1",
      },
      newsAndUpdate: {
        title: null,
        url: null,
        file: null,
        is_active: true,
      },
    };
  },
  validations: {
    newsAndUpdate: {
      title: { required },
      url: { required },
      published_by: { required },
      publish_date: { required },
        file: { required: requiredIf(function() {
            return !this.edit;
        }) },
    },
  },
  methods: {
    addNewsAndUpdate() {
      this.dialog = true;
      this.edit = false;
    },

    editNewsAndUpdate(newsAndUpdate) {
      this.dialog = true;
      this.edit = true;
      this.newsAndUpdate = newsAndUpdate;
    },

    closeDialog() {
      this.dialog = false;
      this.resetForm();
    },

    generateFd() {
      let fd = new FormData();
      for (let key in this.newsAndUpdate) {
        if (
          key == "file" &&
          this.newsAndUpdate["file"] &&
          this.newsAndUpdate["file"] != null
        ) {
          fd.append("file", this.newsAndUpdate[key]);
        } else if (key == "is_active") {
          fd.append("is_active", this.newsAndUpdate["is_active"] == true ? 1 : 0);
        } else if (
          this.newsAndUpdate[key] != undefined &&
          this.newsAndUpdate[key] != null &&
          this.newsAndUpdate[key] != null
        ) {
          fd.append(key, this.newsAndUpdate[key]);
        }
      }
      return fd;
    },

    createOrUpdate() {
      this.$v.newsAndUpdate.$touch();
      if (this.$v.newsAndUpdate.$error) {
        setTimeout(() => {
          this.$v.newsAndUpdate.$reset();
        }, 3000);
      } else {
        let fd = this.generateFd();
        if (this.edit) {
          this.updateNewsAndUpdate(fd);
        } else {
          this.createNewsAndUpdate(fd);
        }
      }
    },

    updateNewsAndUpdate(fd) {
      this.loading = true;
      newsAndUpdatesService
        .update(this.newsAndUpdate.id, fd)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Updated successfully");
          this.closeDialog();
          this.$emit("refresh");
          this.resetForm();
        })
        .catch((error) => {
          this.loading = false;
          this.$snotify.error("Something Went Wrong");
        });
    },

    checkSize(social_share_image) {
      let size = social_share_image.target.social_share_image[0].size / 1024 / 1024;
      let mbSize = size.toFixed(2);
      if (mbSize > 20) {
        this.sizeExceed = true;
      } else {
        this.sizeExceed = false;
      }
    },
    createNewsAndUpdate(fd) {
      this.loading = true;
      newsAndUpdatesService
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
      this.$v.newsAndUpdate.$reset();
      this.edit = false;
      this.newsAndUpdate = {
        title: null,
        is_active: true,
      };
    },
  },
};
</script>
