<template>
    <v-app>
        <section style="background-color: #eee;">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <h1>My Profile</h1>
                                    </v-col>
                                    <v-col cols="12" md="6" class="text-right">
                                        <v-btn color="primary" large dark v-if="!edit" @click="edit = !edit" :loading="isLoading">Edit</v-btn>
                                        <v-btn color="red" large dark v-if="edit" @click="edit = !edit" :loading="isLoading">Cancel</v-btn>
                                        <v-btn color="primary" large dark v-if="edit" @click="updateProfile" :loading="isLoading">Update</v-btn>
                                    </v-col>
                                </v-row>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">First Name</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p v-if="!edit" class="text-muted mb-0">{{ admin_user.first_name }}</p>
                                            <v-text-field
                                                v-else
                                                label="First name *"
                                                v-model="admin_user.first_name"
                                                :error="$v.admin_user.first_name.$error"
                                                variant="outlined"
                                            >
                                            </v-text-field>
                                            <span class="text-danger" v-if="$v.admin_user.first_name.$error"
                                            >This information is required</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="mb-0">Middle Name</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p v-if="!edit" class="text-muted mb-0">{{ admin_user.middle_name }}</p>
                                            <v-text-field
                                                v-else
                                                label="Middle name "
                                                v-model="admin_user.middle_name"
                                                variant="outlined"
                                            >
                                            </v-text-field>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="mb-0">Last Name</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p v-if="!edit" class="text-muted mb-0">{{ admin_user.last_name }}</p>
                                            <v-text-field
                                                v-else
                                                label="Last name *"
                                                v-model="admin_user.last_name"
                                                :error="$v.admin_user.last_name.$error"
                                                variant="outlined"
                                            >
                                            </v-text-field>
                                            <span class="text-danger" v-if="$v.admin_user.last_name.$error"
                                            >This information is required</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="text-muted mb-0">{{ admin_user.email }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Mobile number</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p v-if="!edit" class="text-muted mb-0">{{ admin_user.mobile || 'N/A' }}</p>
                                            <v-text-field
                                                v-else
                                                label="Mobile *"
                                                v-model="admin_user.mobile"
                                                :error="$v.admin_user.mobile.$error"
                                                variant="outlined"
                                            >
                                            </v-text-field>
                                            <span class="text-danger" v-if="$v.admin_user.mobile.$error"
                                            >This information is required</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="mb-0">Phone number</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p v-if="!edit" class="text-muted mb-0">{{ admin_user.phone || 'N/A' }}</p>
                                            <v-text-field
                                                v-else
                                                label="Phone "
                                                v-model="admin_user.phone"
                                                variant="outlined"
                                            >
                                            </v-text-field>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Address</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p v-if="!edit" class="text-muted mb-0">{{ admin_user.address || 'N/A' }}</p>
                                            <v-text-field
                                                v-else
                                                label="Address *"
                                                v-model="admin_user.address"
                                                :error="$v.admin_user.address.$error"
                                                variant="outlined"
                                            >
                                            </v-text-field>
                                            <span class="text-danger" v-if="$v.admin_user.address.$error"
                                            >This information is required</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="mb-0">User type</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p v-if="!edit" class="text-muted mb-0">{{ admin_user.user_type_text }}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="card mb-4">
                            <div class="card-body">
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <h1> Account Security</h1>
                                    </v-col>

                                </v-row>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="card mt-5 col-md-4 col-12">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h3>Setup MFA - Authenticator App</h3>
                                                <p>Use multi-factor authentication (MFA) to add an extra layer of security to your account.</p>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <p><img src="https://cdn2.iconfinder.com/data/icons/plex-for-android/96/authenticator.png" style="max-width: 64px;"></p>
                                            </div>
                                            <v-btn color="primary" dark class="text-center text-uppercase" v-if="!this.admin_user.is_mfa_enabled" @click="getMfaAuthenticatorCode" >
                                                Setup Authenticator App
                                            </v-btn>
                                            <v-btn color="red" dark class="text-center text-uppercase"  v-else @click="deActivateMfaAuthenticator">
                                                Deactivate MFA Authenticator
                                            </v-btn>
                                            </div>
                                    </div>
                                </div>
                                <div class="card mt-5 col-md-4 col-12">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h3>Setup MFA - Email Verification</h3>
                                                <p>Use multi-factor authentication (MFA) to add an extra layer of security to your account.</p>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <p><img src="https://img.icons8.com/plasticine/100/000000/important-mail.png" style="max-width: 64px;"></p>
                                            </div>
                                            <v-btn color="primary" dark v-if="!this.admin_user.is_email_authentication_enabled" @click="getEmailAuthenticator" class="text-center">
                                                <span class="v-btn__content ">Setup Email Authenticator</span>
                                            </v-btn>
                                            <v-btn color="red" dark  @click="deactivateEmailAuthenticator" v-else class="text-center">
                                                <span  class="v-btn__content">Deactivate Email Authenticator</span>
                                            </v-btn>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-5 col-md-4 col-12">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h3>Password</h3>
                                                <p>Setup secure password to access and manage your account.</p>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <p><img src="https://img.icons8.com/plasticine/100/000000/password.png" style="max-width: 64px;"></p>
                                            </div>
                                            <v-btn color="primary" dark @click="changePassword">
                                                <span class="">Change Password</span>
                                            </v-btn>
                                        </div>
                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <v-dialog
            v-model="mfaAuthenticatorSetup"
            :loading="isMfaAuthLoading"
            persistent
            max-width="800px"
        >
            <v-card class="relative pt-4">
                <v-toolbar elevation="0">
                    <v-card-title>
                        <span class="headline">Setup MFA Authenticator</span>
                    </v-card-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="closeMfaAuthenticatorSetup">
                        <i class="fas fa-times"></i>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-card-text>
                    <v-container>
                        <div class="form-block">
                            <v-row>
                                <v-col cols="12">
                                    <ul class="mfa-instructions">
                                        <li>Get any MFA Authenticator App from the Apple AppStore or Google PlayStore</li>
                                        <li>In the app, select account setup</li>
                                        <li>Choose to Scan Barcode, then scan code below</li>
                                    </ul>
                                </v-col>

                                <v-col cols="12" class="text-center">
                                        <v-row align="center" justify="center">
                                            <v-img
                                                :src="authenticator.mfa.image_url"
                                                :lazy-src="`https://picsum.photos/200/200?random`"
                                                min-width="200"
                                                max-width="200"
                                                min-height="200"
                                                max-height="200"
                                                aspect-ratio="1"
                                                class="grey lighten-2"
                                            >
                                                <template v-slot:placeholder>
                                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                                    </v-row>
                                                </template>
                                            </v-img>
                                        </v-row>
                                </v-col>
                                <v-col cols="12" class="text-center">
                                    <a class="cursor-pointer" @click="mfaSecret= !mfaSecret">or add your key manully</a>
                                    <v-row class="mfa-secret-key  mt-1" v-if="mfaSecret">
                                        <v-col cols="12">
                                            <p>
                                                <b>Account:</b>
                                                {{authenticator.mfa.account}}
                                            </p>
                                            <p>
                                                <b>Secret Key:</b>
                                                {{authenticator.mfa.secret_key}}
                                            </p>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        label="Enter Verification Code Displayed"
                                        v-model="authenticator.mfa.verification_code"
                                        required
                                        dense
                                        variant="outlined"
                                    ></v-text-field>
                                    <p
                                        class="text-red-500 font-weight-bold"
                                        v-if="$v.authenticator.mfa.verification_code.$error"
                                    >Please Enter a verification code</p>
                                </v-col>
                            </v-row>
                        </div>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        large
                        dark
                        @click.prevent="activateMfaAuthenticator"
                    >Save & Activate</v-btn>

                    <v-btn
                           dark
                           large
                           @click="closeMfaAuthenticatorSetup">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="emailAuthenticationSetup" persistent max-width="800px">
            <v-card class="relative pt-4">
                <v-toolbar elevation="0">
                    <v-card-title>
                        <span class="headline">Setup Email Authenticator</span>
                    </v-card-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="closeEmailAuthenticatorDialog">
                        <i class="fas fa-times"></i>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-card-text>
                    <v-container>
                        <div class="form-block">
                            <v-row>
                                <v-col cols="12">
                                    <span class="font-weight-medium subtitle-1">
                                Enabling an email authenticator will add extra layer of security for your account.
                                <br>
                               After enabling email authentication you will receive a verification code in your registered email. You have to enter the received verification code to login into your account.</span>
                                </v-col>
                            </v-row>
                        </div>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        large
                        dark
                        :loading="isEmailAuthLoading" v-if="!this.admin_user.is_email_authentication_enabled"
                        @click.once="activateEmailAuthenticator"
                    >Activate
                    </v-btn>
                    <v-btn
                        dark
                        large
                        @click="closeEmailAuthenticatorDialog"
                    >Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        </section>
        <admin-change-password ref="admin-change-password" :userId="userId"></admin-change-password>
    </v-app>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import AdminChangePassword from './change-password/AdminChangePassword.vue';
import AdminUserService from '../../../../../services/admin/admin-user/AdminUserService';

const adminUser = new AdminUserService();
export default {
  components: { AdminChangePassword },
    name: "AccountSecurity",
    props: ['userId','_token'],
    validations: {
        authenticator: {
            mfa: {
                verification_code: { required }
            }
        }
    },

    data() {
        return {
            loading: false,
            isLoading: false,
            edit: false,
            mfaSecret: false,
            mfaAuthenticatorSetup: false,
            emailAuthenticationSetup: false,
            isEmailAuthLoading: false,
            isMfaAuthLoading: false,
            admin_user: {},
            userTypes: [
                { title: "Admin", value: "admin" },
                { title: "Judge", value: "judge" },
            ],
            authenticator: {
                mfa: {
                    verification_code: "",
                    image_url: "",
                    account: "",
                    secret_key: ""
                }
            },
        }
    },

    validations: {
        admin_user: {
            first_name: { required },
            last_name: { required },
            address: { required },
            mobile: { required },
        },
        authenticator: {
            mfa: {
                verification_code: "",
            }
        }
    },

    mounted() {
        this.getAdminUser();
    },

    methods: {
        changePassword() {
            this.$refs['admin-change-password'].openDialog();
        },
        updateProfile() {
            this.isLoading = true;
            this.$v.admin_user.$touch();
            if (this.$v.admin_user.$error) {
                setTimeout(() => {
                    this.$v.admin_user.$reset();
                }, 3000);
            } else {
                adminUser
                    .update(this.admin_user.id, this.admin_user).then(res => {
                        this.isLoading = false;
                        if (res.data.status == "OK") {
                            this.isLoading = false;
                            this.edit = false;
                            this.$snotify.success("Update successfully !!");
                        } else {
                            this.isLoading = false;
                            this.$snotify.error("Problem occurred");
                        }
                    }
                );
            }
        },
        getAdminUser() {
            adminUser.show(this.userId).then(response => {
                this.admin_user = response.data.adminUser;
            });
        },
        getMfaAuthenticatorCode() {
            this.isMfaAuthLoading = true;

            adminUser
                .requestMfaAuthenticator()
                .then(res => {
                   if(res.data.account) {
                    this.authenticator.mfa.account = res.data.account;
                    this.authenticator.mfa.secret_key = res.data.secret_key;
                    this.authenticator.mfa.image_url = res.data.image_url;
                    this.mfaAuthenticatorSetup = true;
                   }
                   this.isMfaAuthLoading = false;

                });
        },
        closeMfaAuthenticatorSetup(){
            this.mfaAuthenticatorSetup = false;
            this.authenticator.mfa.account = "";
            this.authenticator.mfa.secret_key = "";
            this.authenticator.mfa.image_url = "";
        },
        activateMfaAuthenticator()
        {
            this.loading = true;
            this.$v.authenticator.$touch();
            if (this.$v.authenticator.mfa.$error) {
                setTimeout(() => {
                    this.$v.$reset();
                }, 3000);
            } else {
                adminUser
                    .activateMfaAuthenticator(this.authenticator.mfa).then(
                    res => {
                        this.isMfaAuthLoading = false;
                        this.loading = false;
                        if (res.data.status == "OK") {
                            this.mfaAuthenticatorSetup = false;
                            this.admin_user.is_mfa_enabled = true;
                            this.$snotify.success("MFA authenticator Activated");
                            this.authenticator.mfa = {
                                verification_code: "",
                                image_url: "",
                                account: "",
                                secret_key: ""
                            };
                        } else {
                            this.$snotify.error("Problem occurred");
                        }
                    }
                );
            }
        },
        deActivateMfaAuthenticator() {
            this.isMfaAuthLoading = true;
            adminUser
                .deActivateMfaAuthenticator().then(res => {
                this.isMfaAuthLoading = false;
                if (res.data.status == "OK") {
                    this.admin_user.is_mfa_enabled = false;
                    this.$snotify.success("Google authenticator Deactivated");

                }
            });
        },
        getEmailAuthenticator() {
            this.emailAuthenticationSetup = true;
        },
        deactivateEmailAuthenticator() {
            this.isEmailAuthLoading = true;
            this.emailAuthenticationSetup = false;
            this.admin_user.is_email_authentication_enabled = false;
            adminUser
                .deActivateEmailVerificationCode().then(response => {
                this.$snotify.success("Email authenticator deactivated");
                this.isEmailAuthLoading = false;
                this.emailAuthenticationSetup = false;
                this.admin_user.is_email_authentication_enabled=false;

            });

        },
        activateEmailAuthenticator() {
            this.isEmailAuthLoading = true;
            this.emailAuthenticationSetup = false;
            this.admin_user.is_email_authentication_enabled = true;
            adminUser
                .activateEmailVerificationCode().then(response => {
                this.$snotify.success("Email authenticator activated");
                this.isEmailAuthLoading = false;
                this.emailAuthenticationSetup = false;

            });

        },
        closeEmailAuthenticatorDialog() {
            this.emailAuthenticationSetup = false;
        },
        goBackButton() {
            window.location.href = '/user/profile';
        },
    }
}
</script>

<style scoped>

</style>
