<template>
    <div>
        <v-dialog
            v-model="mfaAuthenticatorSetup"
            :loading="isMfaAuthLoading"
            persistent
            max-width="800px"
        >
            <v-card class="relative pt-4">
                <v-card-title>
                    <v-toolbar elevation="0">
                        <v-card-title>
                            <h1>Setup MFA - authenticator App</h1>
                        </v-card-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-spacer></v-spacer>
                            <v-btn icon  @click="closeMfaAuthenticatorSetup">
                                <i class="fas fa-times"></i>
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>

                </v-card-title>

                <!-- <v-btn color="btn btn-standard" style="top: 10px; right: 15px; z-index: 1; position: absolute;" icon right @click="closeMfaAuthenticatorSetup">
                    <v-icon class="mdi mdi-close" style="color: #000;"></v-icon>
                </v-btn> -->
                <v-card-text>
                    <v-container>
                        <div class="form-block">
                            <v-row>
                                <v-col cols="12">
                                    <ul class="mfa-instructions">
                                        <li>
                                            Download any MFA Authenticator App from the Apple AppStore or Google PlayStore
                                        </li>
                                        <li>
                                            In the app, select account setup
                                        </li>
                                        <li>
                                            Choose to Scan Barcode, then scan code below
                                        </li>
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
                                                class="grey lighten-2 my-5"
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
                                    <a class="cursor-pointer mb-3" @click="mfaSecret = !mfaSecret"> or add your key manually</a>
                                    <v-row class="mt-3 mfa-secret-key" v-if="mfaSecret">
                                        <v-col cols="12">
                                            <p>
                                                <b>Account:</b>
                                                {{authenticator.mfa.account}}
                                            </p>
                                            <p>
                                                <b>Secret key:</b>
                                                {{authenticator.mfa.secret_key}}
                                            </p>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        label="Verification code"
                                        v-model="authenticator.mfa.verification_code"
                                        required
                                        dense
                                        outlined
                                    ></v-text-field>
                                    <p
                                        class="text-red-500 font-weight-bold"
                                        v-if="$v.authenticator.mfa.verification_code.$error"
                                    >This information is required</p>
                                </v-col>
                            </v-row>
                        </div>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red"
                        dark
                        @click="closeMfaAuthenticatorSetup"
                    >Cancel</v-btn>
                    <v-btn
                        class="text-white ml-2 btn btn-primary"
                        dark
                        :loading="loading"
                        @click.prevent="activateMfaAuthenticator"
                    >
                    Activate
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="emailAuthenticationSetup" persistent max-width="800px">
            <v-card class="relative pt-4">
                <v-card-title>
                    <v-toolbar elevation="0">
                        <v-card-title>
                            <h1>Setup Email - authenticator</h1>
                        </v-card-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-spacer></v-spacer>
                            <v-btn icon  @click="closeEmailAuthenticatorDialog">
                                <i class="fas fa-times"></i>
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>

                </v-card-title>

                <v-card-text>
                    <v-container>
                        <div class="form-block">
                            <v-row>
                                <v-col cols="12">
                                    <span class="font-weight-medium subtitle-1">
                                        Enabling an email authenticator will add extra layer of security for your account. After enabling email authentication you will receive a verification code in your registered email. You have to enter the received verification code to login into your account.
                                    </span>
                                </v-col>
                            </v-row>
                        </div>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red"
                        dark
                        large
                        @click="closeEmailAuthenticatorDialog"
                    >Cancel</v-btn>
                    <v-btn
                        class="text-white ml-2 btn-primary"
                        dark
                        :loading="isEmailAuthLoading"
                        @click.once="activateEmailAuthenticator"
                    >
                    Activate
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>

</template>

<script>
import { required } from "vuelidate/lib/validators";
import UserService from '../../../../services/front/user/UserService';

const user = new UserService();
export default {
    name: "UserAccountSecurity",
    validations:{
        authenticator: {
            mfa: {
                verification_code: { required }
            }
        }
    },
    data() {
        return {
            loading: false,
            userInfo: {},
            mfaAuthenticatorSetup: false,
            emailAuthenticationSetup: false,
            isEmailAuthLoading: false,
            isMfaAuthLoading: false,
            mfaSecret: false,
            user_info: {},
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
    methods: {
        openMfaAuthenticator() {
            this.getMfaAuthenticatorCode();
        },
        getMfaAuthenticatorCode() {
            this.isMfaAuthLoading = true;
            user
                .requestMfaAuthenticator()
                .then(res => {
                this.authenticator.mfa.account = res.data.account;
                this.authenticator.mfa.secret_key = res.data.secret_key;
                this.authenticator.mfa.image_url = res.data.image_url;
                this.mfaAuthenticatorSetup = true;
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
                    this.$v.authenticator.$reset();
                }, 3000);
            } else {
                user
                    .activateMfaAuthenticator(this.authenticator.mfa).then(
                    res => {
                        this.authenticator.mfa = {
                            verification_code: "",
                            image_url: "",
                            account: "",
                            secret_key: ""
                        };
                        this.isMfaAuthLoading = false;
                        this.loading = false;
                        if (res.data.status == "OK") {
                            this.mfaAuthenticatorSetup = false;
                            this.user_info.is_mfa_enabled = true;
                            this.$snotify.success("MFA Authenticator Activated");
                            this.$emit('refresh');
                        } else {
                            this.$snotify.error("Problem occurred");
                        }

                    }
                );
            }
        },
        deActivateMfaAuthenticator() {
            this.isMfaAuthLoading = true;
            user
                .deActivateMfaAuthenticator().then(res => {
                this.isMfaAuthLoading = false;
                if (res.data.status == "OK") {
                    this.user_info.is_mfa_enabled = false;
                    this.$snotify.success("Google Authenticator Deactivated");
                    this.$emit('refresh');
                }
            });
        },
        getEmailAuthenticator() {
            this.emailAuthenticationSetup = true;
        },

        deactivateEmailAuthenticator() {
            this.isEmailAuthLoading = true;
            user
                .deActivateEmailVerificationCode().then(response => {
                this.user_info.is_email_authentication_enabled = false;
                this.$snotify.success("Email Authenticator Deactivated");
                this.isEmailAuthLoading = false;
                this.emailAuthenticationSetup = false;
                this.$emit('refresh');
            });
        },

        activateEmailAuthenticator() {
            this.isEmailAuthLoading = true;
            user
                .activateEmailVerificationCode().then(response => {
                this.$snotify.success("Email Authenticator Activated");
                this.user_info.is_email_authentication_enabled = true;
                this.isEmailAuthLoading = false;
                this.emailAuthenticationSetup = false;
                this.$emit('refresh');
            });

        },

        closeEmailAuthenticatorDialog() {
            this.emailAuthenticationSetup = false;
        },

    }
}
</script>
