<template>
    <v-dialog v-model="dialog" max-width="800">
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title> {{ edit ? "Edit" : "Add" }} response </v-card-title>

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

            <v-col cols="col-12" md="12">
                  <v-text-field
                      v-model="response.supplied_qty"
                      :error="$v.response.supplied_qty.$error"
                      outlined
                      dense
                  >
                      <template v-slot:label>
                          Supplied quantity <span class="text-danger"> *</span>
                      </template>
                  </v-text-field>
                  <span class="text-danger" v-if="$v.response.supplied_qty.$error"
                      >This information is required</span
                  >
            </v-col>

            <v-col cols="col-12" md="12">
                Remarks
                <ckeditor :config="editorConfig" v-model="response.remarks"></ckeditor>

                <span class="text-danger" v-if="$v.response.remarks.$error"
                    >This information is required</span
                >
            </v-col>
          </v-row>
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
            >{{ edit ? "Update" : "Save" }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>

  <script>
  import { required } from "vuelidate/lib/validators";
  import ResponseService from '@/services/front/response/ResponseService';

  const response = new ResponseService();

  export default {
    data() {
      return {
          edit: false,
          dialog: false,
          loading: false,
          demanded_qty: null,
          requestId: null,
          response: {
            request_id: '',
            supplied_qty: '',
            remarks: '',
          },
          editorConfig: {
            toolbar: [
              [
                'Font', 'FontSize', 'FontColor', 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Link', 'NumberedList', 'BulletedList', 'TextColor', 'BGColor'
              ]
            ],
          extraPlugins: ['font', 'colorbutton'],
          colorButton_enableMore: true,
        },
      };
    },

    validations: {
        response: {
            request_id: { required },
            supplied_qty: { required },
            remarks: { required },
        },
    },

    computed: {
        isGreaterThanDemandedQty() {
            if(this.demanded_qty >= this.response.supplied_qty) {
                return true;
            }
            return false;
        }
    },

    methods: {
      createOrEditResponse(requestId, demanded_qty) {
        this.dialog = true;
        this.requestId = requestId;
        this.demanded_qty = demanded_qty;
        this.getResponse();
      },

      closeDialog() {
        this.dialog = false;
        this.resetForm();
      },

      getResponse() {
        response.show(this.requestId)
        .then((response) => {
            this.response = response.data.response;

            if(this.response && this.response.id) {
                this.edit = true;
            } else {
                this.resetForm();
                this.response.request_id = this.requestId;
            }
        })
        .catch(() => {});
      },

      createOrUpdate() {
        this.$v.response.$touch();
        if (this.$v.response.$error) {
          setTimeout(() => {
            this.$v.response.$reset();
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
        response
          .update(this.response.id, this.response)
          .then((response) => {
            this.loading = false;
            this.$snotify.success("Updated successfully");
            this.$emit("refresh");
            this.closeDialog();
          })
          .catch((error) => {
            this.loading = false;
            this.$snotify.error("Something Went Wrong");
            this.loading = false;
          });
      },

      create() {
        this.loading = true;
        response
          .store(this.response)
          .then((response) => {
            this.loading = false;
            this.$snotify.success("Created successfully");
            this.$emit("refresh");
            this.closeDialog();
          })
          .catch((error) => {
            this.$snotify.error("Something Went Wrong");
            this.loading = false;
          });
      },

      resetForm() {
        this.$v.response.$reset();
        this.response = {
            request_id: '',
            supplied_qty: '',
            remarks: '',
        };
      },
    },
  };
  </script>
