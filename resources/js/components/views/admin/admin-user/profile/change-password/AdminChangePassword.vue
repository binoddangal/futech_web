<template>
    <v-dialog max-width="800" v-model="dialog">
        <v-card>
            <v-card-title>
                <v-toolbar elevation="0">
                    <v-card-title>
                        <h1>Change Password</h1>
                    </v-card-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="closeDialog">
                            <i class="fas fa-times"></i>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>

            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            :append-inner-icon="showCurrentPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            :error="$v.admin_user.current_password.$error"
                            :type="showCurrentPassword ? 'text' : 'password'"
                            @click:append-inner="showCurrentPassword = !showCurrentPassword"
                            dense
                            class="mt-2"
                            label="Current Password"
                            variant="outlined"
                            v-model="admin_user.current_password"
                        >
                            <template v-slot:label>
                                Current password <span class="text-danger"> *</span>
                            </template>
                        </v-text-field>
                        <span class="text-danger" v-if="$v.admin_user.current_password.$error"
                        >This field information is required</span
                        >
                        <span class="text-danger" v-if="message">{{message}}</span>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            :append-inner-icon="showNewPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            :error="$v.admin_user.new_password.$error || $v.admin_user.samePassword"
                            :type="showNewPassword ? 'text' : 'password'"
                            @click:append-inner="showNewPassword = !showNewPassword"
                            class="mt-2"
                            dense
                            variant="outlined"
                            v-model="admin_user.new_password"
                        >
                            <template v-slot:label>
                                New password <span class="text-danger"> *</span>
                            </template>
                        </v-text-field>
                        <span class="text-danger" v-if="$v.admin_user.new_password.$error && !$v.admin_user.new_password.samePassword.$invalid"
                        >This field information is required</span
                        ><br>
                        <span class="text-danger" v-if="$v.admin_user.new_password.samePassword.$invalid"
                        >New password is the same as current password</span
                        >
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            :append-inner-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            :error="$v.admin_user.confirm_password.$error || $v.admin_user.confirm_password.changePassword"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            @click:append-inner="showConfirmPassword = !showConfirmPassword"
                            dense
                            class="mt-2"
                            label="Confirm Password"
                            variant="outlined"
                            v-model="admin_user.confirm_password"
                        >
                            <template v-slot:label>
                                Confirm password <span class="text-danger"> *</span>
                            </template>
                        </v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    class="btn text-gray btn-standard"
                    depressed
                    @click="closeDialog"
                >Cancel
                </v-btn>
                <v-btn
                    class="text-white ml-2 btn btn-primary"
                    depressed
                    @click="changePassword"
                    :loading="loading"
                >Update
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { required } from 'vuelidate/lib/validators';
import AdminUserService from '../../../../../../services/admin/admin-user/AdminUserService';

const adminUser = new AdminUserService();
export default {
    name: "AdminChangePassword" ,
    props: ['userId'],
    data() {
        return {
            dialog: false,
            loading: false,
            message: null,
            showCurrentPassword: false,
            showNewPassword: false,
            showConfirmPassword: false,
            admin_user: {
                current_password: '',
                new_password: '',
                confirm_password: '',
            }
        }
    },
    validations: {
        admin_user: {
            current_password: {required},
            new_password: {
                required,
                samePassword: function (){
                    return this.admin_user.new_password != this.admin_user.current_password
                }
            },
            confirm_password: {
                required,
                confirmPassword: function (){
                    return this.admin_user.new_password === this.admin_user.confirm_password
                }
            }
        }
    },
    methods: {
        openDialog() {
            this.dialog = true;
            this.resetForm();
        },
        closeDialog() {
            this.dialog = false;
            this.resetForm();
        },
        changePassword() {
            this.$v.admin_user.$touch()
            if (this.$v.admin_user.$error) {
                setTimeout(() => {
                    this.$v.admin_user.$reset()
                }, 3000);
            } else {
                adminUser.changePassword(this.userId, this.admin_user).then(response => {
                    if (response.data.message == 'InvalidPassword') {
                        this.message = 'Incorrect password';
                    } else {
                        this.closeDialog();
                        this.$snotify.success("Change Password Successfully !!");
                        setTimeout(() => {
                                window.location.href = response.data.url;
                        }, 3000);
                    }
                }).catch((error) => {
                    this.$snotify.error(error.errors);
                });
            }
        },
        resetForm() {
            this.message = null;
            this.$v.admin_user.$reset();
            this.admin_user = {
                current_password: '',
                new_password: '',
                confirm_password: '',
            }
        }
    }
}
</script>
