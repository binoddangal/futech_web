<template>
  <v-dialog v-model="dialog" persistent max-width="800">
    <v-card>
      <v-toolbar elevation="0">
        <v-card-title class="headline">
          {{ `${edit ? "Update" : "Add"} slider` }}
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
          <div class="col-md-8 col-sm-12 form-group">
            <v-text-field
              outlined
              dense
              label="Title"
              v-model="slider.title"
              :error="$v.slider.title.$error"
            ></v-text-field>
            <span class="text-danger" v-if="$v.slider.title.$error"
              >This information is required</span
            >
          </div>
          <div class="col-md-4 col-sm-12 form-group">
            <v-select
              :items="slider_types"
              outlined
              dense
              label="Type"
              v-model="slider.slider_type_id"
              item-text="title"
              item-value="id"
            ></v-select>
            <!--                <span class="text-danger" v-if="$v.slider.slider_type_id.$error">Type is required</span>-->
          </div>
          <div class="col-md-12 col-sm-12 form-group">
            <v-text-field
              outlined
              dense
              label="Heading text"
              v-model="slider.heading_text"
            ></v-text-field>
          </div>
          <div class="col-md-12 col-sm-12 form-group">
            <v-text-field
              outlined
              dense
              label="Sub heading text"
              v-model="slider.sub_heading_text"
            ></v-text-field>
          </div>
          <div class="col-12 form-group">
            <v-textarea
              outlined
              dense
              label="Description"
              v-model="slider.description"
            ></v-textarea>
          </div>
          <div class="col-md-12 col-sm-12 form-group">
            <v-file-input
              outlined
              dense
              label="Banner image"
              accept="image/*"
              prepend-inner-icon="mdi-attachment"
              prepend-icon=""
              @change="checkSize($event)"
              v-model="slider.image_file"
              :error="$v.slider.image_file.$error"
            ></v-file-input>
            <span class="text-danger" v-if="$v.slider.image_file.$error"
              >This information is required</span
            >
            <span class="text-danger" v-if="sizeExceed"
              >Please upload a file upto 20MB</span
            >
          </div>
          <div class="col-md-6 col-lg-6 col-sm-12 form-group" v-if="slider.show_button">
            <v-text-field
              outlined
              dense
              label="Button text"
              v-model="slider.button_text"
            ></v-text-field>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-12 form-group" v-if="slider.show_button">
            <v-text-field
              outlined
              dense
              label="Link"
              v-model="slider.link"
              :error="$v.slider.link.$error"
              placeholder="https://example.com"
            ></v-text-field>
          </div>
          <div class="col-md-3 col-sm-12 form-group">
            <v-switch
                @change="resetButton"
              label="Show button"
              v-model="slider.show_button"
            ></v-switch>
          </div>
          <div class="col-md-3 col-sm-12 form-group">
            <v-switch
              label="Open in new tab"
              v-model="slider.new_tab"
            ></v-switch>

            <!-- <span class="text-danger" v-if="$v.slider.is_active.$error">Title is required</span> -->
          </div>
          <div class="col-md-3 col-sm-6 form-group">
            <v-switch label="Status" v-model="slider.is_active"></v-switch>

            <!-- <span class="text-danger" v-if="$v.slider.is_active.$error">Title is required</span> -->
          </div>
          <div class="col-12" v-if="slider.image_path">
            <img

              :src="slider.image_path['thumb']"
              alt
              style="height: 75px"
              class="img-thumbnail"
            />
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
          :disabled="sizeExceed"
          @click="createOrUpdate"
          :loading="loading"
          >{{ edit ? 'Update' : 'Save' }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import { required, url, requiredIf } from "vuelidate/lib/validators";
import SliderService from "../../../../../services/admin/cms/slider/SliderService";
import SliderTypeService from "../../../../../services/admin/cms/slider/type/SliderTypeService";

const slider = new SliderService();
const sliderTypeService = new SliderTypeService();
export default {
  name: "CreateAndUpdate",
  validations: {
    slider: {
      title: { required },
      link: { url },
      image_file: { required :requiredIf(function() {
        return !this.edit;
      })},
    },
  },
  data() {
    return {
      loading: false,
      dialog: false,
      edit: false,
      sizeExceed: false,
      slider_types: [],
      slider: {
        id: null,
        slider_type_id: null,
        title: null,
        heading_text: null,
        sub_heading_text: null,
        button_text: "Read More",
        show_button: true,
        link: null,
        image_file: null,
        position: null,
        new_tab: 0,
        description: null,
        type: null,
        is_active: true,
      },
    };
  },

  methods: {
    closeDialog() {
      this.edit = false;
      this.dialog = false;
      this.resetForm();
    },

    createSlider() {
      this.edit = false;
      this.dialog = true;
      this.resetForm();
      this.getSliderTypes();
    },

    editSlider(slider) {
      this.edit = true;
      this.dialog = true;
      this.resetForm();
      this.getSliderTypes();
      this.slider = slider;
    },

    getSliderTypes() {
      sliderTypeService.allActive().then((response) => {
        this.slider_types = response.data.types;
      });
    },

    resetButton() {
        if(!this.slider.show_button) {
            this.slider.button_text = "Read More";
            this.slider.link = null;
        }
    },

    checkSize(file) {
      let size = file.size / 1024 / 1024;
      let mbSize = size.toFixed(2);
      if (mbSize > 20) {
        this.sizeExceed = true;
      } else {
        this.sizeExceed = false;
      }
    },

    createOrUpdate() {
      this.$v.slider.$touch();
      if (this.$v.slider.$error) {
        setTimeout(() => {
          this.$v.slider.$reset();
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

    create(fd) {
      this.loading = true;
      slider
        .store(fd)
        .then((response) => {
            this.loading = false;
            this.$snotify.success("Created successfully");
            this.closeDialog();
            this.$emit("refresh")
        })
        .catch((error) => {
          this.loading = false;
          this.$snotify.error("Something Went Wrong");
        });
    },

    update(fd) {
      this.loading = true;
      slider
        .update(this.slider.id, fd)
        .then((response) => {
          this.loading = false;
          this.$snotify.success("Updated successfully");
          this.closeDialog();
          this.$emit("refresh")
        })
        .catch((error) => {

          this.$snotify.error("Something Went Wrong");
            this.loading = false;
        });
    },
    generateFd() {
      let fd = new FormData();
      for (let key in this.slider) {
        if (
          key == "image_file" &&
          this.slider["image_file"] &&
          this.slider["image_file"] != null
        ) {
          if (typeof this.slider["image_file"] == "object") {
            fd.append("image_file", this.slider[key]);
          }
        } else if (key == "new_tab" && this.slider["new_tab"]) {
          fd.append("new_tab", this.slider.new_tab ? 1 : 0);
        } else if (key == "is_active") {
          fd.append("is_active", this.slider.is_active ? 1 : 0);
        } else {
          if (this.slider[key]) {
            fd.append(key, this.slider[key] ? this.slider[key] : "");
          }
        }
      }
      return fd;
    },
    resetForm() {
      this.$v.slider.$reset();
      this.slider = {
        id: null,
        slider_type_id: null,
        title: null,
        heading_text: null,
        sub_heading_text: null,
        button_text: "Read More",
        show_button: true,
        link: null,
        image_file: null,
        position: null,
        new_tab: 0,
        description: null,
        type: null,
        is_active: true,
      };
    },
  },
};
</script>
