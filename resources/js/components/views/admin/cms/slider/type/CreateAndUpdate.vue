<template>
  <v-app>
    <v-dialog v-model="dialog" max-width="600">
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="headline">
            {{ edit ? 'Update' : 'Add'}} slider type
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
            <div class="col-12">
              <v-text-field outlined dense label="Title" v-model="type.title"></v-text-field>
              <span class="text-danger" v-if="$v.type.title.$error">This information is required</span>
            </div>


            <div class="col-12">
              Status
              <v-switch v-model="type.is_active" name="check-button"   :label="type.is_active ? 'Active' : 'Inactive'"></v-switch>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-right">
              <v-btn
                  class="btn btn-standard cancel-btn"
                  depressed
                  @click="closeDialog"
              >Cancel
              </v-btn>
              <v-btn
                     class="text-white ml-2 btn btn-primary"
                  depressed
                  @click="createOrUpdate"
                  :loading="loading"
              >Save
              </v-btn>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-app>

</template>
<script>

import {required} from 'vuelidate/lib/validators';
import SliderTypeService from "../../../../../../services/admin/cms/slider/type/SliderTypeService";

const typeService = new SliderTypeService();

export default {
    name: "CreateAndUpdate",
    data() {
        return {
        dialog:false,
        edit: false,
        loading: false,
        type: {
            title: null,
            is_active: true,
        }
        };
    },

    validations: {
        type: {
            title: {required},
        }
    },
    methods: {
        showModal(typeId = null) {
        if (typeId) {
            this.edit = true;
            this.getType(typeId);
        }else{
            this.edit=false;
        }
        this.dialog=true;

        },
        closeDialog() {
        this.dialog=false;
        this.resetForm();
        },

        getType(id) {
        typeService.show(id).then(response => {
            this.type = response.data.type;
        });
        },
        createOrUpdate() {
        this.$v.type.$touch();
        if (this.$v.type.$error) {
            setTimeout(() => {
            this.$v.type.$reset();
            }, 3000);
        } else {
            if (this.type.id) {
            this.updateType();
            } else {
            this.create();
            }
        }
        },
        create() {
        typeService.store(this.type).then(response => {
            this.closeDialog();
            this.$emit("refresh_list");
        });
        },
        updateType() {
        typeService.update(this.type.id, this.type).then(response => {
            this.closeDialog();
            this.$emit("refresh_list");
        });
        },
        resetForm() {
        this.type = {
            title: null,
            is_active: true,
        };
        this.$v.type.$reset();


        },
        setType(type) {
        this.type = type;
        this.dialog=true;
        this.edit=true;
        },
        createType(){
        this.dialog=true;
        this.edit=false;
        this.resetForm();
        },
    }
};
</script>
