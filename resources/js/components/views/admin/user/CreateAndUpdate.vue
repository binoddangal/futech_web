<template>
  <div>
    <v-dialog v-model="dialog" max-width="700" scrollable>
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="">
            {{ `${edit ? "Update" : "Add"} user` }}
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
          <v-container>
            <v-row>
              <v-col cols="6">
                <v-text-field
                  label="First name *"
                  v-model="user.first_name"
                  :error="$v.user.first_name.$error"
                  clearable
                  outlined
                  dense
                  required
                ></v-text-field>
                <span class="text-danger" v-if="$v.user.first_name.$error">This information is required</span>
              </v-col>

              <v-col cols="6">
                <v-text-field
                  label="Middle name "
                  v-model="user.middle_name"
                  clearable
                  outlined
                  dense
                  required
                ></v-text-field>
              </v-col>

              <v-col cols="6">
                <v-text-field
                  label="Last name *"
                  v-model="user.last_name"
                  :error="$v.user.last_name.$error"
                  clearable
                  outlined
                  dense
                  required
                ></v-text-field>
                <span class="text-danger" v-if="$v.user.first_name.$error">This information is required</span>
              </v-col>

              <v-col cols="6">
                <v-menu
                    v-model="menuDate"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            label="Date of birth *"
                            v-model="user.date_of_birth"
                            :error="$v.user.date_of_birth.$error"
                            clearable
                            outlined
                            readonly
                            dense
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        no-title
                        v-model="user.date_of_birth"
                        @input="menuDate = false"
                    ></v-date-picker>
                </v-menu>

                <span class="text-danger" v-if="$v.user.date_of_birth.$error">This information is required</span>
              </v-col>

              <v-col cols="6">
                <v-select
                  label="Gender *"
                  :items="gender_option"
                  v-model="user.gender"
                  item-text="title"
                  item-value="value"
                  :error="$v.user.gender.$error"
                  outlined
                  dense
                  required
                ></v-select>
                <span class="text-danger" v-if="$v.user.gender.$error">This information is required</span>
              </v-col>

              <v-col cols="6">
                <v-text-field
                  label="Mobile *"
                  v-model="user.mobile"
                  type="number"
                  :error="$v.user.mobile.$error"
                  clearable
                  outlined
                  dense
                  required
                ></v-text-field>
                <span class="text-danger" v-if="$v.user.mobile.$error">This information is required</span>
              </v-col>

              <v-col cols="6">
                <v-text-field
                  label="Email *"
                  v-model="user.email"
                  clearable
                  :error="$v.user.email.$error"
                  outlined
                  dense
                  required
                ></v-text-field>
                <span class="text-danger" v-if="$v.user.email.$error">This information is required</span>
              </v-col>

              <v-col v-if="!edit">
                <v-text-field
                    :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showPassword ? 'text' : 'password'"
                    label="Password *"
                    v-model="user.password"
                    class="input-group--focused"
                    @click:append-inner="showPassword = !showPassword"
                    outlined
                    dense
                    required
                ></v-text-field>
                <span class="text-danger" v-if="$v.user.password.$error">This information is required</span>

              </v-col>

              <v-col cols="6" v-if="status  == 'pending' || status == 'approved' || status == 'rejected'">
                <v-select
                  label="Account type *"
                  :items="accountTypes"
                  v-model="user.account_type"
                  item-text="title"
                  item-value="value"
                  :error="$v.user.account_type.$error"
                  outlined
                  dense
                  required
                ></v-select>
                <span class="text-danger" v-if="$v.user.gender.$error">This information is required</span>
              </v-col>

            </v-row>

          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="btn btn-standard cancel-btn" dark @click="closeDialog"
            >Cancel
          </v-btn>
          <v-btn
            class="text-white btn btn-primary"
            dark
            @click="createOrUpdate"
            :loading="loading"
            >{{ edit ? 'Update' : 'Save' }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>

import { required, email, requiredIf} from 'vuelidate/lib/validators';
import UserService from '@/services/admin/user/UserService';

const user = new UserService();

export default {
    name: "CreateAndUpdate",
    validations: {

        user: {
            first_name: {required},
            last_name: {required},
            gender: {required},
            mobile: {required},
            date_of_birth: {required},
            account_type: {required},
            email: {required,email},
            password: {required: requiredIf(function() {
                return !this.edit;
            })},
        }
    },
    data() {
        return {
            menuDate: false,
            loading: false,
            edit: false,
            dialog: false,
            showPassword: false,
            status: null,
            gender_option:[
                {value: "male", title: "Male"},
                {value: "female", title: "Female"},
            ],
            accountTypes:[
                {value: "volunteer", title: "Volunteer"},
                {value: "pharmaceutical_company", title: "Pharmaceutical company"},
                {value: "funding_organisation", title: "Funding organisation"},
                {value: "beneficiary", title: "Beneficiary"},
            ],
            user:{
                first_name:'',
                middle_name:'',
                last_name:'',
                gender:'',
                mobile:'',
                date_of_birth:'',
                email:'',
                password:'',
            }
        }
    },
    methods: {

        passwordToggle() {
            this.showPassword = !this.showPassword;
        },

        closeDialog() {
            this.edit = false;
            this.dialog = false;
            this.resetForm();
        },

        createUser(status) {
            this.edit = false;
            this.dialog = true;
            this.resetForm();
            this.status = status;
            if(status != 'pending' || status != 'approved' || status != 'rejected') {
                this.user.account_type = status;
            }
            if(status  == 'pending' || status == 'approved' || status == 'rejected') {
                this.user.status = status;
            }
        },

        editUser(user) {
            this.edit = true;
            this.dialog = true;
            this.resetForm();
            this.user = user;
        },

        createOrUpdate() {
            this.$v.user.$touch()
            if (this.$v.user.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                    this.showLoginError = false;
                }, 10000);
            } else {
                this.loading = true;
                if(this.edit) {
                    this.update();
                } else {
                    this.create()
                }
            }
        },

        create() {
            user.store(this.user).then(response => {
                this.$snotify.success('User created succesffully');
                this.closeDialog();
                this.$emit('refresh');
                this.loading = false;

            }).catch(() => {
                this.loading = false;
                this.$snotify.error('Oops Something went wrong');
            });
        },

        update() {
            user.update(this.user.id, this.user).then(response => {
                this.$snotify.success('User Update succesffully');
                this.closeDialog()
                this.$emit('refresh');
                this.loading = false;

            }).catch(() => {
                this.loading = false;
                this.$snotify.error('Oops Something went wrong');
            });
        },

        resetForm() {
            this.$v.$reset();
            this.status = null;
            this.user = {
                first_name:'',
                middle_name:'',
                last_name:'',
                gender:'',
                date_of_birth:'',
                mobile:'',
                email:'',
                password:'',
            };
        }
    }
}
</script>
