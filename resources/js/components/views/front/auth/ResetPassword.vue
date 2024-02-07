<template>
    <v-app>
        <div class="center-login-warpper mx-auto">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="text-center text-4xl font-extrabold text-gray-900">
                    Reset Password
                </h2>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full yelko__max-w-450">
                <div class="bg-white sm:px-10">
                    <div>
                            <v-text-field
                                label="Enter a New Password"
                                clearable
                                tabindex="2"
                                :error="$v.login.password.$error"
                                :type="showCurrentPassword ? 'text' : 'password'"
                                v-model="login.password"
                                :append-icon="showCurrentPassword?'mdi-eye-off':'mdi-eye'"
                                @click:append="passwordToggle"
                                outlined required></v-text-field>


                            <v-text-field
                                label="Enter a Confirm Password"
                                clearable
                                tabindex="2"
                                :error="$v.login.confirm_password.$error"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                v-model="login.confirm_password"
                                :append-icon="showConfirmPassword?'mdi-eye-off':'mdi-eye'"
                                @click:append="passwordToggle"
                                outlined required></v-text-field>

                            <v-alert v-if="$v.login.confirm_password.$error"
                                dense
                                outlined
                                type="error"
                            >
                              Password and confirm password must be same.
                            </v-alert>
                    </div>
                        <div class="flex">

                            <div class="text-left w-1/2 flex-col justify-content-center">
                                <a  :href="getSignInPageUrl()" class="font-medium yelko__text-blue hover:text-indigo-500">
                                    Remember Password? Sign in
                                </a>
                            </div>
                            <div class="text-right w-1/2 flex-col">
                                <v-btn type="button"
                                       rounded
                                       :loading="loading"
                                       color="primary"
                                       x-large
                                       @click="resetPassword"
                                       dark>
                                    Reset Password
                                </v-btn>
                            </div>
                        </div>
                    </div>

                    <div class="register-link text-center mt-10">
                        New to us ? <a :href="getRegisterPageUrl()">Create a new account</a>
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
import {required, sameAs} from "vuelidate/lib/validators";
import VueRecaptcha from "vue-recaptcha";
import UserLoginService from '../../../../services/front/user/UserLoginService';


const userLogin = new UserLoginService();

export default {
    name: "Login",
    props: ['_token'],
    components: {
        VueRecaptcha
    },
    validations: {
        login: {
            password: {required},
            confirm_password: {
                required,
                sameAsPassword: sameAs("password")
            }
        }
    },
    data() {
        return {
            showPassword: false,
            showConfirmPassword: false,
            loading: false,
            toggleEnrolmentForm: false,
            attrs: null,
            site_key: process.env.MIX_SITE_KEY,
            login: {
                _token:this._token,
                password: '',
                confirm_password: '',
                token:'',
                email:'',
            }
        }
    },
    methods: {
        getSignInPageUrl(){
            return 'login';
        },

        getRegisterPageUrl(){
            return 'register';
        },

        passwordToggle() {
            this.showPassword = !this.showPassword;
        },

        resetPassword() {
            this.$refs.invisibleRecaptcha.execute();
        },

        onCaptchaVerified: function () {
            this.$v.$touch()
            if (this.$v.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                }, 5000);
            } else {
                this.loading = true;
                userLogin.doPasswordReset(this.login).then(response => {
                    this.$snotify.success(response.data.message);
                    setTimeout(() => {
                        this.loading = false;
                        window.location.href = response.data.url;
                    }, 5000);
                }).catch(() => {
                    this.loading = false;
                });
            }
        }
    },
    created: function() {
        this.login.token = this.$route.query.token ? this.$route.query.token : "";
        this.login.email = this.$route.query.email ? this.$route.query.email : "";

        userLogin.checkPasswordReset(this.login)
            .then(response=>{
                if(response.data.status=='EXPIRED')
                {
                    this.$snotify.error(response.data.message);
                    setTimeout(() => {
                        window.location.href = response.data.url;
                    }, 5000);
                }

            })
            .catch(({ response }) => {

            });
    }
}
</script>

<style scoped>

</style>
