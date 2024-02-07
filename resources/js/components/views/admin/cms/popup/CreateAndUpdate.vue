<template>
  <v-dialog v-model="dialog" persistent max-width="600">
    <v-card>
      <v-toolbar elevation="0">
        <v-card-title class="headline">
          {{ `${edit ? "Update" : "Add"} popup` }}
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
        <div class="row">
          <div class="col-12 form-group">
            <v-text-field
              outlined
              dense
              label="Title"
              v-model="popup.title"
              :error="$v.popup.title.$error"
            ></v-text-field>

            <span class="text-danger" v-if="$v.popup.title.$error"
              >This information is required</span
            >
          </div>
          <div class="col-12 form-group" v-if="popup.type == 'text'">
            <v-text-field
              outlined
              dense
              label="Link"
              v-model="popup.link"
            ></v-text-field>
          </div>
          <div class="col-12 form-group"  v-if="popup.type == 'text'">
            <v-textarea
              outlined
              dense
              label="Description"
              v-model="popup.description"
            ></v-textarea>
          </div>
          <div class="col-12 form-group" v-if="popup.type == 'image'">
            <v-file-input
              outlined
              dense
              v-model="popup.image"
              prepend-inner-icon="mdi-file"
              prepend-icon=""
              @change="checkSize($event)"
              label="Image"
            ></v-file-input>
            <span class="text-danger" v-if="sizeExceed"
              >Please upload a file upto 20MB</span
            >
          </div>

          <div class="col-12 form-group">
            <label class="h6">Type</label>

            <v-radio-group v-model="popup.type" row>
              <v-radio label="Image only" value="image" dense></v-radio>
              <v-radio label="Text only" value="text" dense></v-radio>
            </v-radio-group>
            <span class="text-danger" v-if="$v.popup.type.$error"
              >This information is required</span
            >
          </div>

          <div class="col-2 form-group">
            <label class="h6">Status</label>
            <v-switch
              v-model="popup.is_active"
              :label="popup.is_active ? 'Active' : 'Inactive'"
            >
            </v-switch>
          </div>
          <div class="col-6 form-group">
            <img
              v-if="popup.image"
              :src="popup.image_path['thumb']"
              alt
              class="mt-5"
            />
          </div>
        </div>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <div class="float-right">
          <v-btn
            class="btn btn-standard text-gray cancel-btn"
            dark
            @click="closeDialog"
            >Cancel
          </v-btn>

          <v-btn
            class="
              text-white
              btn btn-primary btn
              px-9
              py-4
              my-3
              font-size-3
              mx-4
            "
            dark
            :disabled="sizeExceed"
            @click="createOrUpdate"
            :loading="isBusy"
            >Save
          </v-btn>
        </div>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import PopupService from "@/services/admin/cms/pop-up/PopupService";
import { required } from "vuelidate/lib/validators";

const popupService = new PopupService();

export default {
  name: "CreateAndUpdate",
  props: ["id"],
  validations: {
    popup: {
      title: { required },
      type: { required },
    },
  },
  data() {
    return {
      isBusy: false,
      sizeExceed: false,
      dialog: false,
      edit: false,
      popup: {
        title: null,
        link: null,
        image: null,
        description: null,
        type: "image",
        is_active: true,
      },
    };
  },

  methods: {
    closeDialog() {
      this.dialog = false;
      this.edit = false;
      this.resetForm();
    },

    createPopup() {
      this.dialog = true;
      this.edit = false;
      this.resetForm();
    },

    editPopup(popup) {
      this.dialog = true;
      this.resetForm();
      this.edit = true;
      this.popup = popup;
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

    create(fd) {
      this.isBusy = true;
      popupService
        .store(fd)
        .then((response) => {
          this.isBusy = false;
          this.$snotify.success("Created successfully");
          this.closeDialog();
          this.$emit("refresh");
        })
        .catch((error) => {
          this.isBusy = false;
          this.$snotify.error("Something Went Wrong");
        });
    },

    createOrUpdate() {
      this.$v.popup.$touch();
      if (this.$v.popup.$error) {
        setTimeout(() => {
          this.$v.popup.$reset();
        }, 3000);
      } else {
        let fd = this.generateFd();
        if (this.edit) {
          this.update(fd);
        } else {
          this.create(fd);
        }
      }
    },
    update(fd) {
      this.isBusy = true;
      popupService
        .update(this.popup.id, fd)
        .then((response) => {
          this.isBusy = false;
          this.$snotify.success("Updated successfully");
          this.closeDialog();
          this.$emit("refresh");
        })
        .catch((error) => {
          this.isBusy = false;
          this.$snotify.error("Something Went Wrong");
        });
    },
    generateFd() {
      let fd = new FormData();
      for (let key in this.popup) {
        if (
          key == "image" &&
          this.popup["image"] &&
          this.popup["image"] != null
        ) {
          fd.append("image", this.popup[key]);
        } else if (key == "is_active") {
          fd.append("is_active", this.popup["is_active"] == true ? 1 : 0);
        } else if (
          this.popup[key] != undefined &&
          this.popup[key] != null &&
          this.popup[key] != null
        ) {
          fd.append(key, this.popup[key]);
        }
      }
      return fd;
    },
    resetForm() {
      this.$v.popup.$reset();
      this.popup = {
        id: null,
        title: null,
        link: null,
        image: null,
        description: null,
        type: "image",
        is_active: true,
      };
    },
  },
};
</script>

<style>
.v-application--wrap {
  min-height: 0 !important;
}
</style>
