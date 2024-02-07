<template>
    <v-app>
        <div class="center-login-warpper mx-auto">
            <div>


                <div class="mt-5">
                    <div class="bg-white text-center ">

                        <div class="mt-5 mb-5">
                            Please enter an email you used on registration.
                        </div>

                           <v-col cols="12">
                               <v-text-field
                                   outlined
                                   label="Enter your email address"
                                   v-model="registration.email"
                                   tabindex="1"
                                   :error="$v.registration.email.$error"
                                   @input="email = $event !== null ? $event : ''"
                                   v-on:keyup.enter="proceedResend"
                                   clearable
                                   variant="outlined"
                                   required
                               ></v-text-field>
                           </v-col>

                        <div class="flex items-center">
                            <div class="text-left w-1/2 flex-col justify-content-center">
                                Do you have a code ? <a :href="_verification_url">Verify Now</a>
                            </div>

                            <div class="text-right w-1/2 flex-col">
                                <v-btn
                                       class="btn btn-primary"
                                       rounded
                                       :loading="loading"
                                       @click="proceedResend"
                                       color="black"
                                       x-large
                                       dark>
                                    Send
                                </v-btn>
                            </div>


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
        <vue-snotify></vue-snotify>
    </v-app>
</template>

<script>
import {required, email, sameAs} from "vuelidate/lib/validators";
import VueRecaptcha from "vue-recaptcha";
import UserLoginService from "../../../../services/front/user/UserLoginService";

const userLogin = new UserLoginService();

export default {
    name: "ResendEmailVerification",
    props: ['_token', '_verification_url'],
    components: {
        VueRecaptcha
    },
    validations: {
        registration: {
            email: {required, email},
        }

    },
    data() {
        return {
            site_key: process.env.MIX_SITE_KEY,
            loading: false,
            registration: {
                _token: this._token,
                email: '',
            }
        }
    },
    mounted() {

        // this.checkNotify();
    },
    methods: {
        goToEmailVerification() {
            window.location.href = process.env.APP_URL + '/register/email-verification';
        },

        onCaptchaVerified: function (recaptchaToken) {
            this.resendEmail();
        },

        resendEmail() {
            this.$v.$touch()
            if (this.$v.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                }, 5000);
            } else {
                this.loading = true;

               userLogin.resendVerificationEmail(this.registration).then(response => {
                    if (response.data.status == 'OK' && response.data.url) {
                        this.$snotify.success(response.data.message);
                        setTimeout(function () {
                             window.location.href = response.data.url;
                        }, 4000);

                    } else {
                        this.$snotify.error(response.data.message);
                        this.loading = false;
                    }
                }).catch(error => {

                });
            }
        },

        proceedResend() {
            this.$refs.invisibleRecaptcha.execute();
        }

    }
}
</script>

<style scoped>

</style>
