<template>
  <v-app>
    <v-dialog v-model="dialog" max-width="800">
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="headline">
            {{ `${edit ? "Update" : "Add"} Projects` }}
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
                v-model="ourProject.title"
                outlined
                dense
                :error="$v.ourProject.title.$error"
              ></v-text-field>
              <span class="text-danger" v-if="$v.ourProject.title.$error"
                >This information is required</span
              >
            </v-col>

            <v-col cols="12">
              <label for="description">Description</label>
              <ckeditor
                id="'Description"
                v-model="ourProject.description"
                :config="editorConfig"
              ></ckeditor>
              <span class="text-danger" v-if="$v.ourProject.description.$error"
                >This information is required</span
              >
            </v-col>

            <div class="col-12" >
              <v-file-input
                accept="image/*"
                outlined
                dense
                prepend-inner-icon="fas fa-image"
                prepend-icon=""
                v-model="ourProject.file"
                label="Featured Photo"
                :error="$v.ourProject.file.$error"
              ></v-file-input>
              <span
                class="text-danger"
                v-if="$v.ourProject.file.$error"
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
                v-model="ourProject.is_active"
                :label="ourProject.is_active ? 'Active' : 'Inactive'"
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
import OurProjectService from "@/services/admin/cms/our-project/OurProjectService";

const ourProjectService = new OurProjectService();
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
      ourProject: {
        title: null,
        description: null,
        file: null,
        is_active: true,
      },
    };
  },
  validations: {
    ourProject: {
      title: { required },
      description: { required },
        file: { required: requiredIf(function() {
            return !this.edit;
        }) },
    },
  },
  methods: {
    addOurProject() {
      this.dialog = true;
      this.edit = false;
    },

    editOurProject(ourProject) {
      this.dialog = true;
      this.edit = true;
      this.ourProject = ourProject;
    },

    closeDialog() {
      this.dialog = false;
      this.resetForm();
    },

    generateFd() {
      let fd = new FormData();
      for (let key in this.ourProject) {
        if (
          key == "file" &&
          this.ourProject["file"] &&
          this.ourProject["file"] != null
        ) {
          fd.append("file", this.ourProject[key]);
        } else if (key == "is_active") {
          fd.append("is_active", this.ourProject["is_active"] == true ? 1 : 0);
        } else if (
          this.ourProject[key] != undefined &&
          this.ourProject[key] != null &&
          this.ourProject[key] != null
        ) {
          fd.append(key, this.ourProject[key]);
        }
      }
      return fd;
    },

    createOrUpdate() {
      this.$v.ourProject.$touch();
      if (this.$v.ourProject.$error) {
        setTimeout(() => {
          this.$v.ourProject.$reset();
        }, 3000);
      } else {
        let fd = this.generateFd();
        if (this.edit) {
          this.updateOurProject(fd);
        } else {
          this.createOurProject(fd);
        }
      }
    },

    updateOurProject(fd) {
      this.loading = true;
      ourProjectService
        .update(this.ourProject.id, fd)
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

    checkSize(featured_photo) {
      let size = featured_photo.target.featured_photo[0].size / 1024 / 1024;
      let mbSize = size.toFixed(2);
      if (mbSize > 20) {
        this.sizeExceed = true;
      } else {
        this.sizeExceed = false;
      }
    },
    createOurProject(fd) {
      this.loading = true;
      ourProjectService
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
      this.$v.ourProject.$reset();
      this.edit = false;
      this.ourProject = {
        title: null,
        is_active: true,
      };
    },
  },
};
</script>
