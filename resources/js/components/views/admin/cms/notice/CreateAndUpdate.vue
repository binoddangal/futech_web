<template>
  <v-dialog
      v-model="dialog"
      max-width="800"
      scrollable
  >
    <v-card>
      <v-toolbar elevation="0">
        <v-card-title class="text-h5">
          <span>{{ title }} notice</span>
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
            <v-col cols="12" md="12">
              <v-text-field
                  v-model="notice.name"
                  :error="$v.notice.name.$error"
                  outlined
                  dense
              >
                <template v-slot:label>
                  Name <span class="text-danger">*</span>
                </template>
              </v-text-field>
              <span class="text-danger" v-if="$v.notice.name.$error">Name is required</span>
              <span class="text-danger" v-if="errors.name" >* {{ errors.name[0] }}</span>
            </v-col>

            <v-col cols="12">
              <v-select
                  item-text="name"
                  item-value="value"
                  :items="user_types"
                  v-model="notice.user_type"
                  :error="$v.notice.user_type.$error"
                  @input="notice.user_type = $event !== null ? $event : ''"
                  multiple
                  small-chips
                  deletable-chips
                  outlined
                  dense
              >
                <template v-slot:label>
                  User Type <span class="text-danger">*</span>
                </template>
                <template v-slot:prepend-item>
                  <v-list-item
                      ripple
                      @click="allSelect"
                  >
                    <v-list-item-action>
                      <v-icon :color="notice.user_type.length > 0 ? 'indigo darken-4' : ''">
                        {{ icon }}
                      </v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                      <v-list-item-title>
                        Select All
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-divider class="mt-1"></v-divider>
                </template>
              </v-select>
              <span class="text-danger" v-if="$v.notice.user_type.$error">User Type is required</span>
              <span class="text-danger" v-if="errors.user_type" >* {{ errors.user_type[0] }}</span>
            </v-col>

            <v-col cols="12">
              <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                      v-model="notice.visible_from_date"
                      chips
                      clearable
                      small-chips
                      label="Visible From Date"
                      readonly
                      outlined
                      dense
                      v-bind="attrs"
                      v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                    v-model="notice.visible_from_date"
                    outlined
                    dense
                    no-title
                    @input="menu = false"
                >
                </v-date-picker>
              </v-menu>
            </v-col>

            <v-col cols="12">
              Description <span class="text-danger">*</span>
              <ckeditor
                  :config="editorConfig"
                  v-model="notice.description" >
              </ckeditor>
              <span class="text-danger" v-if="$v.notice.description.$error">Description Field is required</span>
              <span class="text-danger" v-if="errors.description" >* {{ errors.description[0] }}</span>
            </v-col>

            <v-col cols="12">
              Status
              <v-switch
                  v-model="notice.is_active"
                  :label="notice.is_active ? 'Active' : 'Inactive'"
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
            @click="createOrUpdate"
            :loading="loading"
        >
         save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import NoticeService from '@/services/admin/cms/notice/NoticeService';

const noticeService = new NoticeService();

export default {
  validations: {
    notice: {
        name: { required },
        description: { required },
        user_type: { required },
        // is_active: { required },
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
        select: false,
        notice:{
            name: '',
            description: '',
            position: '',
            user_type: [],
            visible_from_date: '',
            is_active: true
        },
        user_types: [
          { name: "Home Page", value: "homepage" },
          { name: "Beneficiaries", value: "beneficiaries" },
        ],
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
  computed: {
    allSelectType () {
      return this.notice.user_type.length === this.user_types.length
    },
    selectType () {
      return this.notice.user_type.length > 0 && !this.allSelectType
    },
    icon () {
      if (this.allSelectType) return 'mdi-close-box'
      if (this.selectType) return 'mdi-minus-box'
      return 'mdi-checkbox-blank-outline'
    },
  },
  methods:{
    closeDialog() {
      this.dialog = false;
      this.errors = [];
      this.resetForm();
    },
    createNotice() {
      this.title = 'Add';
      this.dialog = true;
      this.edit = false;
      this.resetForm();
    },
    editNotice(notice) {
      this.title = 'Edit';
      this.dialog = true;
      this.edit = true;
      this.notice = notice;
    },
    allSelect () {
      this.$nextTick(() => {
        if (this.allSelectType) {
          this.notice.user_type = []
        } else {
          this.notice.user_type = [];
          this.user_types.forEach(type => {
            this.notice.user_type.push(type.value);
          });
        }
      })
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
        if (!this.edit) this._create();
        else this.update();
      }
    },
    _create: function () {

      noticeService
          .create(this.notice)
          .then(response => {
            this.$snotify.success("Notice created successfully");
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
    update: function () {
      noticeService
          .update(this.notice.id, this.notice)
          .then((response) => {
            this.$snotify.success("Notice Updated successfully");
            this.notice = {};
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
      this.notice = {
        name: '',
        description: '',
        position: '',
        user_type: [],
        visible_from_date: '',
        is_active: true
      };
    },
  }
}
</script>
