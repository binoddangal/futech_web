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
            <div class="row mb-3">
              <div class="col-6">
                <h4>
                  <a href="/admin/testimonials">
                    <i class="fas fa-arrow-left"></i>
                  </a>
                  {{ `${id ? "Update" : "Add"} testimonial` }}
                </h4>
                <a href="/admin/dashboard"> Dashboard </a>
                \ Testimonials
                </div>
              <div class="col-6 text-right"></div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <v-text-field
                  outlined
                  dense
                  label="Title"
                  v-model="testimonial.title"
                  :error="$v.testimonial.title.$error"
                ></v-text-field>
                <span class="text-danger" v-if="$v.testimonial.title.$error"
                  >This information is required</span
                >
              </div>
              <div class="col-md-6">
                <v-text-field
                  outlined
                  dense
                  label="Position"
                  v-model="testimonial.position"
                ></v-text-field>
              </div>
              <div class="col-12">
                <v-textarea
                  outlined
                  dense
                  label="Description"
                  v-model="testimonial.description"
                ></v-textarea>
              </div>
              <div class="col-md-12">
                <v-file-input
                  accept="image/*"
                  outlined
                  dense
                  prepend-icon=""
                  prepend-inner-icon="mdi-file"
                  @change="checkSize($event)"
                  v-model="testimonial.image"
                  label="Image"
                  :error="$v.testimonial.image.$error"
                ></v-file-input>
                <span class="text-danger" v-if="$v.testimonial.image.$error"
                  >This information is required</span
                >
                <span class="text-danger" v-if="sizeExceed"
                  >Please upload a file upto 20MB</span
                >
              </div>
              <div class="col-md-6">
                <v-text-field
                  outlined
                  dense
                  label="Type"
                  v-model="testimonial.type"
                ></v-text-field>
              </div>
              <div class="col-md-6">
                <v-text-field
                  outlined
                  dense
                  label="Name"
                  v-model="testimonial.name"
                ></v-text-field>
              </div>
              <div class="col-md-6">
                <v-text-field
                  outlined
                  dense
                  label="Job Title"
                  v-model="testimonial.job_title"
                ></v-text-field>
              </div>

              <div class="col-md-6">
                <v-rating
                  v-model="testimonial.rating"
                  background-color="orange lighten-3"
                  color="orange"
                  large
                ></v-rating>
                <!--                <b-form-rating v-model="testimonial.rating" show-value precision="2"></b-form-rating>-->
              </div>

              <div class="col-md-12">
                Status
                <v-switch
                  v-model="testimonial.is_active"
                  :label="testimonial.is_active ? 'Active' : 'Inactive'"
                >
                </v-switch>
                <!-- <span class="text-danger" v-if="$v.testimonial.is_active.$error">Title is required</span> -->
              </div>
              <div class="col-12">
                <img
                  v-if="testimonial.image_path"
                  :src="testimonial.image_path['thumb']"
                  alt
                  style="height: 75px"
                  class="img-thumbnail"
                />
              </div>

              <div class="col-12 mt-5">
                <div class="float-right">
                  <v-btn
                    class="mr-2 cancel-btn"
                    text
                    x-large
                    @click="redirectTo"
                    >Cancel
                  </v-btn>
                  <v-btn
                    class="btn btn-primary"
                    depressed
                    x-large
                    :disabled="sizeExceed"
                    @click="createOrUpdate"
                    :loading="isBusy"
                    >{{ edit ? 'Update' : 'Save' }}
                  </v-btn>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import TestimonialService from "../../../../../services/admin/cms/testimonial/TestimonialService";

const testimonial = new TestimonialService();

export default {
  name: "CreateAndUpdate",
  props: ["id", "homeRoute"],
  validations: {
    testimonial: {
      title: { required },
      image: { required },
    },
  },

  data() {
    return {
      isBusy: false,
      sizeExceed: false,
      value: 3.5,
      testimonial: {
        id: null,
        title: null,
        link: null,
        image: null,
        position: null,
        new_tab: 0,
        rating: 0,
        description: null,
        type: null,
        is_active: true,
      },
    };
  },
  mounted() {
    this.id ? this.getTestimonial(this.id) : "";
  },

  methods: {
    getTestimonial(id) {
      testimonial.show(id).then((response) => {
        this.testimonial = response.data.testimonial;
        this.testimonial.is_active
          ? (this.testimonial.is_active = true)
          : false;
        this.testimonial.new_tab ? (this.testimonial.new_tab = true) : false;
        this.testimonial.show_to_program
          ? (this.testimonial.show_to_program = true)
          : false;
        this.edit = true;
      });
    },

    redirectTo() {
      window.location.href = `${this.homeRoute}/admin/testimonials`;
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
    saveTestimonial(fd) {
      this.isBusy = true;
      testimonial
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

    createOrUpdate() {
      this.$v.testimonial.$touch();
      if (this.$v.testimonial.$error) {
        setTimeout(() => {
          this.$v.testimonial.$reset();
        }, 3000);
      } else {
        let fd = this.generateFd();
        // console.log(fd);
        if (this.edit) {
          this.updateTestimonial(fd);
        } else {
          this.saveTestimonial(fd);
        }
      }
    },
    updateTestimonial(fd) {
      this.isBusy = true;
      testimonial
        .update(this.testimonial.id, fd)
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
    generateFd() {
      let fd = new FormData();
      for (let key in this.testimonial) {
        if (
          key == "image" &&
          this.testimonial["image"] &&
          this.testimonial["image"] != null
        ) {
          if (typeof this.testimonial["image"] == "object") {
            fd.append("image", this.testimonial[key]);
          }
        } else if (key == "new_tab" && this.testimonial["new_tab"]) {
          fd.append("new_tab", this.testimonial.new_tab ? 1 : 0);
        } else if (key == "is_active") {
          fd.append("is_active", this.testimonial.is_active ? 1 : 0);
        } else if (key == "show_to_program") {
          fd.append(
            "show_to_program",
            this.testimonial.show_to_program ? 1 : 0
          );
        } else {
          if (key != "id" && this.testimonial[key]) {
            fd.append(key, this.testimonial[key]);
          }
        }
      }
      return fd;
    },
  },
};
</script>
