<template>
    <div>
        <v-app>

            <div v-if="!this.mfaAuthenticator && !this.emailAuthenticator">
                <div >
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Enter your email"
                                v-model="login.email"
                                tabindex="1"
                                :error="$v.login.email.$error"
                                clearable
                                v-on:keyup.enter="onEnter"
                                variant="outlined"
                                outlined required class=""></v-text-field>
                            <v-text-field
                                label="Enter your password"
                                clearable
                                tabindex="2"
                                :error="$v.login.password.$error"
                                :type="showPassword ? 'text':'password'"
                                v-model="login.password"
                                :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="passwordToggle"
                                v-on:keyup.enter="onEnter"
                                variant="outlined"
                                outlined required class=""></v-text-field>
                        </v-col>
                    </v-row>
                    <div class=" sm:px-10">
                        <div class="flex items-center mt-1" v-if="showLoginError">
                            <span class="text-danger">Please check your email or password correctly.</span>
                        </div>
                        <div class="flex items-center mt-5">

                            <div class="text-left w-1/2 flex-col justify-content-center">
                            <a href="/forgot-password" class="font-medium futech__text-blue hover:text-indigo-500">
                                Forgot password?
                            </a>
                        </div>


                            <div class="text-right w-1/2 flex-col">
                                <v-btn v-if="!accountNotVerified" type="submit" dark x-large rounded
                                       :loading="loading"
                                       @click="proceedLogin">
                                    Log in
                                </v-btn>

                                <v-btn v-else type="button"
                                       class="w-full"
                                       dark x-large rounded
                                       :loading="loading"
                                       @click="continueVerification"
                                       >
                                    Verify your account
                                </v-btn>

                                <!--                            <v-btn depressed>-->
                                <!--                                Login with Facebook-->
                                <!--                            </v-btn>-->
                                <!--                            <v-btn @click="googleLogin" depressed>-->
                                <!--                                <v-icon small >-->
                                <!--                                    mdi-google-->
                                <!--                                </v-icon> Login with Google-->
                                <!--                            </v-btn>-->

                            </div>
                        </div>

                        <v-alert v-if="showLoginError"
                                 class="mt-2 text-center"
                                 :icon="false"
                                 dense
                                 outlined
                                 type="error"
                        >
                            <b> We are not recognising your username today.Please give it another go.</b>


                        </v-alert>


                        <div class="text-center register-link mt-10 col-md-12">
                         Don't have an account ? <a href="/register">Register</a>
                        </div>
                        <!--                    <div class="text-center mt-4">-->
                        <!--                        Agent registration will require submission of your business document and identification. It may take upto 2-3 business to-->
                        <!--                        verify your account. Please make sure you have them ready before applying.-->
                        <!--                    </div>-->

                    </div>
                </div>
            </div>
            <div class=" " v-if="this.mfaAuthenticator || this.emailAuthenticator">
                <div class="row">
                    <div class="sm:mx-auto sm:w-full sm:max-w-md">
                        <h2 class="text-center text-4xl font-extrabold text-gray-900">
                            Multi factor authentication check
                        </h2>
                    </div>

                    <div class="mt-5">
                        <div class="bg-white text-center">
                            <img src="/assets/image/mfa_verification.png" class="w-64" style="margin: 0 auto"/>
                            <div class="mt-5 mb-5">
                                Since you have enabled multi-factor authentication. Please enter the verification code displayed on your mobile app.
                            </div>

                            <div class="col-md-12">
                                <v-text-field style="max-width: 300px; margin: 0 auto"  placeholder="Verification code" v-model="verificationCode"   :error="$v.verificationCode.$error" variant="outlined"/>
                                <span  v-if="$v.verificationCode.$error" class="text-danger">This information is required</span>

                            </div>

                            <div class="mt-2" v-if="multiAuthenticator && !emailVerificationMailRequested">
                                <v-btn class="ml-2" dark large rounded @click="completeVerification">Verify</v-btn>
                            </div>


                            <div class="mt-8" v-if="multiAuthenticator && !emailVerificationMailRequested">
                                Try Alternative? <p style="cursor: pointer; font-weight: 500" href="#" class="ml-2"  @click="requestEmailVerificationCode">Request email</p>
                            </div>

                            <div class="mt-8" v-if="emailVerificationMailRequested">
                               If you didn't receive a verification code you can request again in a minute.
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <vue-recaptcha
                ref="invisibleRecaptcha"
                :sitekey="site_key"
                @verify="onCaptchaVerified"
                :loadRecaptchaScript="true"
                size="invisible"
            ></vue-recaptcha>
            <vue-snotify />
            <confirm-box ref="confirm"></confirm-box>
        </v-app>
    </div>


</template>

<script>

import { required, email } from 'vuelidate/lib/validators';
import VueRecaptcha from "vue-recaptcha";
import ConfirmBox from "../../../../components/confirm-box/ConfirmBox";
import CodeInput from "vue-verification-code-input";
import UserLoginService from '../../../../services/front/user/UserLoginService';

const userLogin = new UserLoginService();


export default {

    name: "Login",
    props: ['_token', '_resend_verification_url'],
    components: {
        ConfirmBox,
        CodeInput,
        VueRecaptcha
    },
    validations: {
        login: {
            email: {required, email},
            password: {required},
        },
        verificationCode:{required},


    },
    data() {
        return {
            loading: false,
            verificationCode: '',
            toggleEnrolmentForm: false,
            showLoginError: false,
            attrs: null,
            showPassword: false,
            accountNotVerified: false,
            multiAuthenticator: false,
            mfaAuthenticator: false,
            emailAuthenticator: false,
            emailVerificationMailRequested: false,
            site_key: process.env.MIX_SITE_KEY,
            login: {
                _token: this._token,
                email: '',
                password: '',
            }
        }
    },
    mounted() {

        // this.checkNotify();
    },
    methods: {
        passwordToggle() {
            this.showPassword = !this.showPassword;
        },

        onEnter() {
            this.proceedLogin();
        },

        continueVerification() {
            window.location.href = this._resend_verification_url;
        },

        proceedLogin() {
            this.$refs.invisibleRecaptcha.execute();
        },

        onCaptchaVerified: function (recaptchaToken) {
            this.$v.login.$touch()
            if (this.$v.login.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                    this.showLoginError = false;
                }, 10000);
            } else {
                userLogin.checkVerificationEnabled(this.login).then(res => {
                    if (res.data.status == "NOT_FOUND") {
                        this.$snotify.error(res.data.errors);
                        this.showLoginError = true;
                    } else if (res.data.status == "NOT_VERIFIED") {
                        this.$snotify.error(res.data.errors);
                        this.accountNotVerified = true;
                    } else if (
                        res.data.data.is_mfa_enabled &&
                        res.data.data.is_email_authentication_enabled
                    ) {
                        this.mfaAuthenticator = true;
                        this.emailAuthenticator = true;
                        this.multiAuthenticator = true;
                    } else if (
                        res.data.data.is_mfa_enabled
                    ) {
                        this.mfaAuthenticator = true;
                    } else if (res.data.data.is_email_authentication_enabled) {
                        this.emailAuthenticator = true;
                    } else {
                        this.setUserLogin();
                    }
                    setTimeout(() => {
                        this.showLoginError = false;
                    }, 10000)
                        }).catch(err => {}).finally(() => {
                            this.loading = false;
                        });

            }
        },

        setUserLogin() {
            userLogin.login(this.login).then(res => {
                if (res.data.url)
                    window.location.href = res.data.url;
            }).catch(err => {
            });
        },
        /*Verification Code Login*/
        onComplete(v) {
            this.login.verification_code = v;
            userLogin.checkMfaVerificationCode(this.login).then(response => {
                if (response.data.status == 'OK') {
                    this.setUserLogin(this.login);
                    this.$refs.code.values = ['', '', '', '', '', ''];

                } else {
                    this.$snotify.error(response.data.errors);
                    this.$refs.code.values = ['', '', '', '', '', ''];
                }
            }).catch(error => {

            });
        },

        completeVerification()
        {
            this.$v.$touch()
            if (this.$v.verificationCode.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                    this.showLoginError = false;
                }, 10000);
            } else {
                userLogin.checkMfaVerificationCode(this.login).then(response => {
                    if (response.data.status == 'OK') {
                        this.setUserLogin(this.login);
                    }
                    else {
                        this.$snotify.error(response.data.errors);
                    }});
            }

        },
       async requestEmailVerificationCode() {

            const confirm = await  this.$refs.confirm.confirm({
                title:'Request email verification',
                message:'You will receive an email with verification code. If you want to continue please press Request Email button.',
                cancel_btn_text:'Cancel',
                ok_btn_text: 'Send'
            });

            if(confirm)
            {
                userLogin.requestEmailVerificationCode(data)
                    .then((res) => {
                        this.emailVerificationMailRequested = true;
                        this.$snotify.success("Verification code has been sent to your registered email. Please allow us 1-3 minutes.");

                        setTimeout(() => {
                            this.emailVerificationMailRequested = false;
                        }, 60000);

                    })
                    .catch(({response}) => {
                        this.emailVerificationMailRequested = false;
                    });
            }


        },
        recoverAccount()
        {
            this.$confirm({
                message: `If you have lost access to your Authenticator APP and not being able to login you can recover your account. You will receive an email with instruction.`,
                button: {
                    no: "Cancel",
                    yes: "Request Email",
                },
                callback: (confirm) => {
                    let data = this.login;
                    if (confirm) {
                       userLogin.recoverAccount(data)
                            .then((res) => {
                                this.$snotify.success("Recovery instruction has been sent your registered email. Please allow us 1-3 minutes.");
                                setTimeout(() => {
                                   window.location.href = res.data.url
                                }, 10000);

                            })
                            .catch(({response}) => {

                            });
                    }
                },
            });
        },
    }
}
</script>

<style scoped>

</style>
