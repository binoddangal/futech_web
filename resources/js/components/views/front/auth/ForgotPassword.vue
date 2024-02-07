<template>
    <v-app>
        <div class="center-login-warpper mx-auto">
            <div class="mt-8 sm:mx-auto sm:w-full">
                <div class="bg-white sm:px-10">
                    <div>
                        <div class="">
                            <v-text-field
                                :error="$v.login.email.$error"
                                v-model="login.email"
                                label="Enter your email"
                                outlined required class=""></v-text-field>

                            <v-alert v-if="$v.login.email.$error"
                                     outlined
                                     :icon="false"
                                     type="error"
                            >
                                {{ errorMessage }}
                            </v-alert>
                        </div>
                    </div>


                    <div class="flex items-center">



                        <div class="text-right w-1/2 flex-col">
                            <v-btn
                                v-show="!resendWaiting"
                                :loading="loading"
                                @click="resetPassword"
                                color="primary"
                                dark
                            >
                                Reset password

                            </v-btn>
                        </div>
                    </div>
                    <div class="text-left w-1/2 flex-col justify-content-center mt-10">
                        <a :href="getSignInPageUrl()" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Remember password? Log in
                        </a>
                    </div>
                    <div class="register-link text-center mt-10">
                        New to us ? <a :href="getRegisterPageUrl()">Create a new account</a>
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
    </v-app>
</template>

<script>
import {required, email} from "vuelidate/lib/validators";
import VueRecaptcha from "vue-recaptcha";
import UserLoginService from '../../../../services/front/user/UserLoginService';

const userLogin = new UserLoginService();

export default {
    name: "Login",
    components: {
        VueRecaptcha
    },
    props: ['_token'],
    validations: {
        login: {
            email: {required, email},
        }
    },
    data() {
        return {
            loading: false,
            site_key: process.env.MIX_SITE_KEY,
            toggleEnrolmentForm: false,
            resendWaiting: false,
            resendTime:new Date().getTime() + 60000,
            attrs: null,
            login: {
                _token: this._token,
                email: ''
            },
            errorMessage: 'Please enter a valid email'
        }
    },
    created: function(){
        var currentUrl = window.location.pathname;
    },
    methods: {
        resetPassword() {
            this.$refs.invisibleRecaptcha.execute();
        },
        getSignInPageUrl(){
            return 'login';
        },
        getRegisterPageUrl(){
            return 'register';
        },

        onCaptchaVerified: function (recaptchaToken) {
            this.$v.$touch()
            if (this.$v.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                }, 5000);
            } else {
                this.resendWaiting = true;
                userLogin.requestPasswordReset(this.login).then(response => {
                    this.$snotify.success(response.data.message);
                    this.resendTime = new Date().getTime() + 60000;
                    setTimeout(() => {
                        this.resendWaiting = false;
                    }, 56000);

                }).catch(error => {
                    this.resendWaiting = false;
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
