<template>
  <div>
    <v-dialog v-model="dialog" max-width="700" scrollable>
      <v-card>
        <v-toolbar elevation="0">
          <v-card-title class="">
            {{ `${edit ? "Update" : "Add"} ${user_type} user` }}
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
                  v-model="admin_user.first_name"
                  :error="$v.admin_user.first_name.$error"
                  clearable
                  dense
                  outlined
                  required
                ></v-text-field>
                <v-text-field
                  label="Middle name "
                  v-model="admin_user.middle_name"
                  clearable
                  dense
                  outlined
                  required
                ></v-text-field>
                  <v-text-field
                      label="Mobile *"
                      v-model="admin_user.mobile"
                      :error="$v.admin_user.mobile.$error"
                      clearable
                      dense
                      outlined
                      required
                  ></v-text-field>
                  <v-text-field
                      label="Email *"
                      v-model="admin_user.email"
                      clearable
                      dense
                      :error="$v.admin_user.email.$error"
                      outlined
                      required
                  ></v-text-field>
                  <v-switch
                      :label="admin_user.is_active ? 'Active' : 'InActive'"
                      v-model="admin_user.is_active"
                      class="input-group--focused"
                      color="blue"
                      dense
                      outlined
                      required
                  ></v-switch>
              </v-col>

              <v-col cols="6">
                <v-text-field
                  label="Last name *"
                  v-model="admin_user.last_name"
                  :error="$v.admin_user.last_name.$error"
                  clearable
                  dense
                  outlined
                  required
                ></v-text-field>
                  <v-text-field
                      label="Address *"
                      v-model="admin_user.address"
                      dense
                      :error="$v.admin_user.address.$error"
                      outlined
                      required
                  ></v-text-field>
                  <v-text-field
                      label="Phone"
                      v-model="admin_user.phone"
                      clearable
                      dense
                      outlined
                      required
                  ></v-text-field>
                  <v-text-field v-if="!edit"
                                :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                :type="showPassword ? 'text' : 'password'"
                                label="Password *"
                                class="input-group--focused"
                                v-model="admin_user.password"
                                @click:append-inner="showPassword = !showPassword"
                                :error="$v.admin_user.password.$error"
                                dense
                                outlined
                                required
                  ></v-text-field>
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
            class="text-white btn-primary"
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
import { required, email, requiredIf} from 'vuelidate/lib/validators'
import AdminUserService from '../../../../services/admin/admin-user/AdminUserService';

const adminUser = new AdminUserService();

export default {
    name: "CreateAndUpdate",
    props: ['user_type'],
    validations: {
        admin_user: {
            first_name: { required },
            last_name: { required },
            address: { required },
            mobile: { required },
            email: { required, email },
            password: { required: requiredIf(function() {
                return !this.edit;
            }),
            },
        }
    },
    data() {
        return {
            loading: false,
            edit: false,
            dialog: false,
            showPassword: false,
            admin_user:{
                first_name: '',
                middle_name: '',
                last_name: '',
                address: '',
                mobile: '',
                user_type: '',
                email: '',
                password: '',
                is_mfa_enabled: 0,
                is_email_authentication_enabled: 0,
                is_active: true,
            }
        }
    },

    computed: {
        capitalizedUserType() {
            if(this.user_type) {
                return this.user_type[0].toUpperCase() + this.user_type.slice(1);
            }
        }
    },
    methods: {
        // keyPress(e) {
        //     // console.log(e.keyCode);
        //     const keys = {}
        //     if(e.keyCode === 38 || e.keyCode === 40) {
        //         keys[e.keyCode] = false;

        //     }
        // },

        passwordToggle() {
            this.showPassword = !this.showPassword;
        },

        closeDialog() {
            this.edit = false;
            this.dialog = false;
            this.resetForm();
        },

        createAdminUser(userType) {
            this.edit = false;
            this.dialog = true;
            this.resetForm();
            this.admin_user.user_type = userType;
        },

        editAdminUser(admin_user) {
            this.edit = true;
            this.dialog = true;
            this.resetForm();
            this.admin_user = admin_user;
            this.admin_user.is_active = admin_user.is_active ? true : false;
        },

        createOrUpdate() {
            this.$v.admin_user.$touch()
            if (this.$v.admin_user.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                }, 10000);
            } else {
                this.loading = true;
                if(this.edit) this.update();
                else this.create();
            }
        },

        create() {
            adminUser.store(this.admin_user).then(response => {
                this.loading = false;
                this.$snotify.success(`${this.capitalizedUserType} created succesffully`);
                this.closeDialog();
                this.$emit('refresh');
            }).catch(() => {
                this.loading = false;
                this.$snotify.error('Oops Something went wrong');
            });
        },

        update() {
            adminUser.update(this.admin_user.id, this.admin_user).then(response => {
                this.loading = false;
                this.$snotify.success(`${this.capitalizedUserType} update succesffully`);
                this.closeDialog();
                this.$emit('refresh');

            }).catch(() => {
                this.loading = false;
                this.$snotify.error('Oops Something went wrong');
            });
        },
        resetForm() {
            this.$v.admin_user.$reset();
            this.admin_user = {
                first_name: '',
                middle_name: '',
                last_name: '',
                address: '',
                mobile: '',
                user_type: '',
                email: '',
                password: '',
                is_mfa_enabled: 0,
                is_email_authentication_enabled: 0,
                is_active: true,
            };
        }
    }
}
</script>

