<template>
  <div>
    <v-dialog v-model="dialog" max-width="800">
      <v-card>

        <v-toolbar elevation="0">
          <v-card-title class="headline">
            {{`${edit?'Update':"Add"} download type`}}
            <hr>
          </v-card-title>

          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-spacer></v-spacer>
            <v-btn icon  @click="closeDialog">
              <i class="fas fa-times"></i>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <div class="row">
            <div class="col-12 form-group">
              <v-text-field outlined dense label="Title" v-model="type.title"     :error="$v.type.title.$error"></v-text-field>
              <span class="text-danger" v-if="$v.type.title.$error">This information is required</span>
            </div>
            <div class="col-12 form-group">
              <v-switch v-model="type.is_active" name="check-button" label="Status"></v-switch>
            </div>
          </div>


          <div class="row">
            <div class="col-12 text-right">
                <v-btn
                    class="btn text-gray btn-standard"
                    depressed
                    @click="closeDialog"
                >Cancel
                </v-btn>
              <v-btn
                  class="text-primary btn btn-primary btn px-9 py-4 my-3 font-size-3 mx-4"
                  dark
                  @click="createOrUpdate"
                  :loading="loading"
              >{{ edit ? 'Update' : 'Save' }}
              </v-btn>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import DownloadTypeService from '@/services/admin/cms/download/type/DownloadTypeService';
import { required } from 'vuelidate/lib/validators';

const downloadType = new DownloadTypeService();

export default {
  validations: {
    type: {
      title: { required },
    }
  },
  data() {
    return {
      dialog: false,
      edit: false,
      loading: false,
      type: {
        title: '',
        is_active: true,
      }
    };
  },

  methods: {

    closeDialog() {
      this.dialog = false;
      this.resetForm();
    },

    createType(){
      this.dialog=true;
      this.edit = false;
      this.resetForm();
    },

    editType(type) {
      this.dialog = true;
      this.edit = true;
      this.resetForm();
      this.type = type;
    },

    createOrUpdate() {
      this.$v.type.$touch();
      if (this.$v.type.$error) {
        setTimeout(() => {
          this.$v.type.$reset();
        }, 3000);
      } else {
        if (this.edit) {
          this.update();
        } else {
          this.create();
        }
      }
    },

    create() {
      this.loading = true;
      downloadType.store(this.type).then(response => {
        this.$snotify.success("Created successfully");
        this.$emit("refresh");
        this.closeDialog();
        this.loading = false;
      }).catch(() => {
        this.loading = false;
      });
    },

    update() {
      this.loading = true;
      downloadType
          .update(this.type.id, this.type)
          .then(response => {
            this.$snotify.success("Update successfully");
            this.$emit("refresh");
            this.closeDialog();
            this.loading = false;
          }).catch(() => {
            this.loading = false;
          });
    },

    resetForm() {
      this.$v.$reset();
      this.type = {
        title: '',
        is_active: true,
      };
    }
  }
};
</script>
