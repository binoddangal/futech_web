<template>
    <v-app>
        <div>
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="text-center text-4xl font-extrabold text-gray-900">
                   Check your email for the verification code
                </h2>
            </div>

            <div class="mt-5">
                <div class="bg-white text-center ">
                    <img class="w-64" src="/assets/image/email_sent.png" style="margin: 0 auto; max-width: 150px"/>
                    <div class="mt-5 mb-5">
                        We have emailed you a verification code on your email. Please enter the code below to continue.
                    </div>

                    <v-row>
                        <v-col cols="12">
                            <v-text-field dense outlined style="max-width: 300px; margin: 0 auto"  placeholder="Verification code" v-model="verification.verification_code"   :error="$v.verification.verification_code.$error" variant="outlined"/>
                        </v-col>

                        <div class="flex items-center mt-5">
                            <div class="w-1/2 flex-col">
                                <v-btn type="submit" x-large dark rounded
                                       :loading="loading"
                                       @click="onComplete"
                                      >
                                    Verify
                                </v-btn>
                            </div>
                        </div>

                    </v-row>
                    <div class="mt-8">
                        Did not receive your code? <a :href="_resend_verification_url">Resend</a>
                    </div>

                </div>
            </div>
        </div>

        <vue-recaptcha
            :loadRecaptchaScript="true"
            :sitekey="site_key"
            @verify="onCaptchaVerified"
            ref="invisibleRecaptcha"
            size="invisible"
        ></vue-recaptcha>
        <vue-snotify/>
        <v-dialog
            persistent
            v-model="loadDialog"
            width="300"
        >
            <v-card
                color="primary"
                dark
            >
                <v-card-text>
                    Please standby while we verify your detail
                    <v-progress-linear
                        class="mb-0"
                        color="white"
                        indeterminate
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import CodeInput from "vue-verification-code-input";
import VueRecaptcha from "vue-recaptcha";
import UserLoginService from '../../../../services/front/user/UserLoginService';

const userLogin = new UserLoginService();

export default {
    name: "RegistrationEmailVerification",
    props: ['_token', "_email_token", "_verification_code", "_resend_verification_url"],
    components: {
        CodeInput,
        VueRecaptcha
    },
    validations: {
        verification: {
            verification_code: {required},
        }
    },
    data() {
        return {
            site_key: process.env.MIX_SITE_KEY,
            loading: false,
            loadDialog: false,
            verification_code_raw: this._verification_code ? Array.from(this._verification_code) : [],
            verification: {
                _token: this._token,
                token: this._email_token ? this._email_token : '',
                verification_code: '',
                is_used: 0
            }
        }
    },
    mounted() {
        //this.$refs.code.values = this.verification_code_raw.length > 5 ? this.verification_code_raw : ['', '', '', '', '', ''];
        this.verification.verification_code = this._verification_code;
        if (this.verification.verification_code.length > 5)
            this.verifyUser();
    },
    methods: {
        goToEmailVerification() {
            window.location.href = process.env.APP_URL + '/register/email-verification';
        },

        onComplete(v) {
            this.$refs.invisibleRecaptcha.execute();
        },

        onCaptchaVerified: function () {
            this.$v.$touch()
            if (this.$v.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                }, 10000);
            } else {
                this.verifyUser();
            }
        },

        verifyUser() {
            this.loadDialog = true;
            userLogin.verifyUser(this.verification).then(response => {
                if (response.data.status == 'OK' && response.data.url) {
                    this.$snotify.success('Account verified');
                    this.loadDialog = false
                    window.location.href = response.data.url;
                } else {
                    this.loadDialog = false;
                    this.$snotify.error(response.data.message);
                }
            }).catch(error => {
                this.loadDialog = false;
            }).finally(()=>{
            });
        }

    }
}
</script>
