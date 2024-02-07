<template>
  <v-dialog
      v-model="dialog"
      max-width="800"
      scrollable
  >
    <v-card>
      <v-toolbar elevation="0">
        <v-card-title class="text-h5">
          <span>{{ title }} team</span>
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
        <v-container>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                  v-model="team.title"
                  :error="$v.team.title.$error"
                  outlined
                  dense
              >
                <template v-slot:label>
                  Title <span class="text-danger">*</span>
                </template>
              </v-text-field>
              <span class="text-danger" v-if="$v.team.title.$error">Name is required</span>
              <span class="text-danger" v-if="errors.title" >* {{ errors.title[0] }}</span>
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field
                  v-model="team.job_title"
                  outlined
                  dense
              >
                <template v-slot:label>
                 Job Title
                </template>
              </v-text-field>
            </v-col>

            <div class="col-md-12 col-sm-12">
                <v-file-input
                outlined
                dense
                label="Image"
                accept="image/*"
                prepend-inner-icon="mdi-attachment"
                prepend-icon=""
                @change="checkSize($event)"
                v-model="team.image_file"
                :error="$v.team.image_file.$error"
                ></v-file-input>
                <span class="text-danger" v-if="$v.team.image_file.$error"
                >This information is required</span
                >
                <span class="text-danger" v-if="sizeExceed"
                >Please upload a file upto 20MB</span
                >
            </div>

            <div class="col-md-12" v-if="team && team.image_path">
                <v-img
                :src="team.image_path.real"
                :lazy-src="team.image_path.real"
                width="100px"
                height="100px"
                ></v-img>
            </div>

            <v-col cols="12" md="12">
              <v-text-field
                  v-model="team.fb_url"
                  :error="$v.team.fb_url.$error"
                  type="url"
                  outlined
                  dense
              >
                <template v-slot:label>
                 Facebook URL
                </template>
              </v-text-field>
              <span class="text-danger" v-if="$v.team.fb_url.$error">Url should be valid</span>
            </v-col>

            <v-col cols="12" md="12">
              <v-text-field
                  v-model="team.linked_url"
                  type="url"
                  :error="$v.team.linked_url.$error"
                  outlined
                  dense
              >
                <template v-slot:label>
                 Linkedin URL
                </template>
              </v-text-field>
              <span class="text-danger" v-if="$v.team.linked_url.$error">Url should be valid</span>
            </v-col>

            <v-col cols="12">
              Description <span class="text-danger">*</span>
              <ckeditor
                  :config="editorConfig"
                  v-model="team.description" >
              </ckeditor>
              <span class="text-danger" v-if="$v.team.description.$error">Description Field is required</span>
              <span class="text-danger" v-if="errors.description" >* {{ errors.description[0] }}</span>
            </v-col>

            <v-col cols="12">
              Status
              <v-switch
                  v-model="team.is_active"
                  :label="team.is_active ? 'Active' : 'Inactive'"
                  color="indigo darken-3"
              ></v-switch>
            </v-col>

          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
            color="btn btn-standard"
            text
            @click="closeDialog">
          Cancel
        </v-btn>
        <v-btn
            color="btn btn-primary"
            @click="createOrUpdate()"
            :loading="loading"
        >
          {{ edit ? 'Update' : 'Save' }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { required, url } from "vuelidate/lib/validators";
import TeamService from "@/services/admin/cms/team/TeamService";

const noticeService = new TeamService();

export default {
  validations: {
    team: {
        title: { required },
        fb_url: { url },
        linked_url: { url },
        description: { required },
        image_file: {  },
        is_active: { required },
    }
  },
  data() {
    return{
        title: '',
        menu: false,
        loading: false,
        dialog: false,
        edit: false,
        errors: [],
        sizeExceed: false,
        team: {
            title: '',
            job_title: '',
            fb_url: '',
            linked_url: '',
            description: '',
            image_file: null,
            is_active: true
        },

        editorConfig: {
            toolbar: [
              [
                'Font', 'FontSize', 'FontColor', 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Link', 'NumberedList', 'BulletedList', 'TextColor', 'BGColor'
              ]
            ],
          extraPlugins: ['font', 'colorbutton'],
          colorButton_enableMore: true,
        }
    }
  },

  methods: {

    checkSize(file) {
        console.log(file)
        let size = file.size / 1024 / 1024;
        let mbSize = size.toFixed(2);
        if (mbSize > 20) {
            this.sizeExceed = true;
        } else {
            this.sizeExceed = false;
        }
    },

    closeDialog() {
      this.dialog = false;
      this.errors = [];
      this.resetForm();
    },

    createTeam() {
      this.title = 'Add';
      this.dialog = true;
      this.edit = false;
      this.resetForm();
    },

    editTeam(team) {
      this.title = 'Edit';
      this.dialog = true;
      this.edit = true;
      this.team = team;
    },

    generateFd() {
      let fd = new FormData();
      for (let key in this.team) {
        if (
          key == "image_file" &&
          this.team["image_file"] &&
          this.team["image_file"] != null
        ) {
          if (typeof this.team["image_file"] == "object") {
            fd.append("image_file", this.team[key]);
          }
        } else if (key == "is_active") {
          fd.append("is_active", this.team.is_active ? 1 : 0);
        } else {
          if (this.team[key]) {
            fd.append(key, this.team[key] ? this.team[key] : "");
          }
        }
      }
      return fd;
    },

    createOrUpdate(){
      this.$v.$touch()
      if (this.$v.$error) {
        setTimeout(() => {
          this.$v.$reset()
        }, 3000);
      }
      else {
        this.loading = true;
        let formData = this.generateFd();
        if (!this.edit) this._create(formData);
        else this.update(formData);
      }
    },

    _create: function (formData) {

      noticeService
          .create(formData)
          .then(response => {
            this.$snotify.success("Team created successfully");
            this.closeDialog();
            this.loading = false;
            this.$emit('refresh');
          })
          .catch((error) => {
            this.loading = false;
            this.errors = error.errors;
            this.$snotify.error("Oops something went wrong");
          });

    },

    update: function (formData) {
      noticeService
          .update(this.team.id, formData)
          .then((response) => {
            this.$snotify.success("Team Updated successfully");
            this.team = {};
            this.closeDialog();
            this.loading = false;
            this.$emit('refresh');
          })
          .catch((error) => {
            this.loading = false;
            this.errors = error.errors;
            this.$snotify.error("Oops something went wrong");
          });
    },

    resetForm() {
      this.errors = [];
      this.$v.$reset();
      this.team = {
        title: '',
        job_title: '',
        fb_url: '',
        linked_url: '',
        description: '',
        image_file: null,
        is_active: true
        };
    },
  }
}
</script>
