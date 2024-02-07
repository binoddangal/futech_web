<template>
  <v-app>
    <v-dialog v-model="dialog" max-width="800">
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="headline">
            {{ `${edit ? "Update" : "Add"} Partner` }}
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
                v-model="partner.title"
                outlined
                dense
                :error="$v.partner.title.$error"
              ></v-text-field>
              <span class="text-danger" v-if="$v.partner.title.$error"
                >This information is required</span
              >
            </v-col>

            <v-col cols="12">
              <v-text-field
                label="URL"
                v-model="partner.url"
                outlined
                dense
                :error="$v.partner.url.$error"
              ></v-text-field>
              <span class="text-danger" v-if="$v.partner.url.$error"
                >This information is required</span
              >
            </v-col>

            <v-col cols="12">
              <label for="description">Description</label>
              <ckeditor
                id="'Description"
                v-model="partner.description"
                :config="editorConfig"
              ></ckeditor>
              <span class="text-danger" v-if="$v.partner.description.$error"
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
                v-model="partner.file"
                label="Featured Photo"
                :error="$v.partner.file.$error"
              ></v-file-input>
              <span
                class="text-danger"
                v-if="$v.partner.file.$error"
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
                v-model="partner.is_active"
                :label="partner.is_active ? 'Active' : 'Inactive'"
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
import PartnerService from '@/services/admin/cms/partner/PartnerService';

const partnerService = new PartnerService();
export default {
  name: "CreateAndUpdate",
  data() {
    return {
      dialog: false,
      edit: false,
      sizeExceed: false,
      loading: false,
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
      partner: {
        title: null,
        description: null,
        url: null,
        file: null,
        is_active: true,
      },
    };
  },
  validations: {
    partner: {
      title: { required },
      url: { required },
      description: { required },
        file: { required: requiredIf(function() {
            return !this.edit;
        }) },
    },
  },
  methods: {
    addPartner() {
      this.dialog = true;
      this.edit = false;
    },

    editPartner(partner) {
      this.dialog = true;
      this.edit = true;
      this.partner = partner;
    },

    closeDialog() {
      this.dialog = false;
      this.resetForm();
    },

    generateFd() {
      let fd = new FormData();
      for (let key in this.partner) {
        if (
          key == "file" &&
          this.partner["file"] &&
          this.partner["file"] != null
        ) {
          fd.append("file", this.partner[key]);
        } else if (key == "is_active") {
          fd.append("is_active", this.partner["is_active"] == true ? 1 : 0);
        } else if (
          this.partner[key] != undefined &&
          this.partner[key] != null &&
          this.partner[key] != null
        ) {
          fd.append(key, this.partner[key]);
        }
      }
      return fd;
    },

    createOrUpdate() {
      this.$v.partner.$touch();
      if (this.$v.partner.$error) {
        setTimeout(() => {
          this.$v.partner.$reset();
        }, 3000);
      } else {
        let fd = this.generateFd();
        if (this.edit) {
          this.updatePartner(fd);
        } else {
          this.createPartner(fd);
        }
      }
    },

    updatePartner(fd) {
      this.loading = true;
      partnerService
        .update(this.partner.id, fd)
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
        console.log(featured_photo)
      let size = featured_photo.target.featured_photo[0].size / 1024 / 1024;
      let mbSize = size.toFixed(2);
      if (mbSize > 20) {
        this.sizeExceed = true;
      } else {
        this.sizeExceed = false;
      }
    },
    createPartner(fd) {
      this.loading = true;
      partnerService
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
      this.$v.partner.$reset();
      this.edit = false;
      this.partner = {
        title: null,
        is_active: true,
      };
    },
  },
};
</script>
