<template>
    <div>
        <v-app>
            <div class="center-login-wrapper mx-auto text-center">
                <div class="sm:mx-auto sm:w-full futech__max-w-650">
                    <div class="bg-white sm:px-10">
                        <v-row>

                            <v-col cols="12">
                                <v-select
                                    label="Membership type *"
                                    :items="membership_types"
                                    item-text="title"
                                    item-value="value"
                                    v-model="user.account_type"
                                    :error="$v.user.organisation_name.$error"
                                    outlined
                                >
                                <template v-slot:label>
                                    Membership type <span class="text-danger">*</span>
                                </template>
                                </v-select>
                            </v-col>

                            <v-col cols="12" v-if="requireOrganisationName">
                                <v-text-field
                                    :label="`Name of organisation *`"
                                    v-model="user.organisation_name"
                                    tabindex="1"
                                    :error="$v.user.organisation_name.$error"
                                    clearable
                                    v-on:keyup.enter="onEnter"
                                    outlined required
                                >
                                <template v-slot:label>
                                    Name of organisation <span class="text-danger">*</span>
                                </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    :label="requireOrganisationName?`Focal person's first name *`:`First name *`"
                                    v-model="user.first_name"
                                    tabindex="1"
                                    :error="$v.user.first_name.$error"
                                    clearable
                                    v-on:keyup.enter="onEnter"
                                    outlined required
                                >
                                <template v-slot:label>
                                    {{ requireOrganisationName ? `Focal person's first name`:`First name` }} <span class="text-danger">*</span>
                                </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    :label="requireOrganisationName?`Focal person's last name *`:`Last name *`"
                                    v-model="user.last_name"
                                    tabindex="1"
                                    :error="$v.user.last_name.$error"
                                    clearable
                                    v-on:keyup.enter="onEnter"
                                    outlined required
                                >
                                <template v-slot:label>
                                    {{ requireOrganisationName ? `Focal person's last name` : `Last name` }} <span class="text-danger">*</span>
                                </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12">
                                <v-text-field
                                    :label="requireOrganisationName?`Focal person's contact number *`:`Contact number *`"
                                    v-model="user.mobile"
                                    tabindex="1"
                                    clearable
                                    v-on:keyup.enter="onEnter"
                                    :error="$v.user.mobile.$error"
                                    outlined required
                                >
                                <template v-slot:label>
                                    {{ requireOrganisationName ? `Focal person's contact number` : `Contact number` }} <span class="text-danger">*</span>
                                </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    label="Email *"
                                    v-model="user.email"
                                    tabindex="1"
                                    clearable
                                    v-on:keyup.enter="onEnter"
                                    :error="$v.user.email.$error"
                                    ref="email"
                                    outlined required
                                >
                                <template v-slot:label>
                                    Email <span class="text-danger">*</span>
                                </template>
                                </v-text-field>
                                <span class="text-danger"
                              v-if="!$v.user.email.isUnique && !$v.user.email.$pending">Email already taken.</span>
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    label="Confirm email *"
                                    v-model="user.confirm_email"
                                    tabindex="1"
                                    :error="$v.user.confirm_email.$error"
                                    clearable
                                    v-on:keyup.enter="onEnter"
                                    outlined required
                                >
                                <template v-slot:label>
                                    Confirm email <span class="text-danger">*</span>
                                </template>
                                </v-text-field>
                                <span class="text-danger"
                              v-if="!$v.user.confirm_email.isConfirmUnique && !$v.user.confirm_email.$pending">Email already taken.</span>
                              <span class="text-danger"
                              v-if="!$v.user.confirm_email.sameAsEmail">This Field should be same as Email.</span>
                            </v-col>

                           <v-col cols="6">
                               <v-text-field
                                   label="Password *"
                                   clearable
                                   tabindex="2"
                                   :error="$v.user.password.$error"
                                   :type="showPassword?'text':'password'"
                                   v-model="user.password"
                                   :append-icon="showPassword?'mdi-eye-off':'mdi-eye'"
                                   @click:append="passwordToggle"
                                   v-on:keyup.enter="onEnter"
                                   outlined required
                                >
                                <template v-slot:label>
                                    Password <span class="text-danger">*</span>
                                </template>
                            </v-text-field>
                           </v-col>

                           <v-col cols="6">
                               <v-text-field
                                   label="Confirm password *"
                                   clearable
                                   tabindex="2"
                                   :error="$v.user.confirm_password.$error"
                                   :type="showConfirmPassword?'text':'password'"
                                   v-model="user.confirm_password"
                                   :append-icon="showConfirmPassword?'mdi-eye-off':'mdi-eye'"
                                   @click:append="showConfirmPassword = !showConfirmPassword"
                                   v-on:keyup.enter="onEnter"
                                   outlined required
                                >
                                <template v-slot:label>
                                    Confirm password <span class="text-danger">*</span>
                                </template>
                                </v-text-field>
                                <span class="mb-3 text-danger"
                              v-if="!$v.user.confirm_password.sameAsPassword">Your password don't match.</span>
                           </v-col>

                            <v-col cols="12">
                                <div class="flex items-center mt-1" v-if="showLoginError">
                                    <span class="text-danger">Please check your email or password correctly.</span>
                                </div>
                                <div class="flex items-center mt-5">
                                    <div class="text-right w-1/2 flex-col">
                                        <v-btn type="submit" x-large dark rounded
                                               :loading="loading"
                                               @click="proceedRegister">
                                            Register
                                        </v-btn>
                                    </div>
                                </div>

                                <v-alert v-if="showLoginError"
                                         class="mt-2 text-center"
                                         :icon="false"
                                         outlined
                                         type="error"
                                >
                                    <b> We are not recognising your username today.Please give it another go.</b>


                                </v-alert>
                            </v-col>
                            <v-col cols="12">
                                   <div class="mb-10">Already have an account? <a href="/login">Login</a></div>
                            </v-col>
                        </v-row>

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
        </v-app>
    </div>


</template>

<script>
import { required, email, requiredIf, sameAs } from 'vuelidate/lib/validators';
import VueRecaptcha from "vue-recaptcha";
import CodeInput from "vue-verification-code-input";
import UserLoginService from "../../../../services/front/user/UserLoginService";
const userLogin = new UserLoginService();
export default {
    name: "Login",
    props: ['_token', '_resend_verification_url'],
    components: {
        CodeInput,
        VueRecaptcha
    },
    validations: {
        user: {
            account_type: {required},
            first_name: {required},
            last_name: {required},
            mobile: {required},
            email: {required,email, async isUnique(value) {
                    if (value === "") return true;
                    let isUnique = true
                    if (value.length > 8) {
                        await userLogin.checkUniqueEmail({"email": this.user.email}).then(response => {
                            if (response.data.status == 'ERROR')
                                isUnique = false;
                            else
                                isUnique = true;

                        });
                    }
                    return Boolean(isUnique);
                }},
            confirm_email: {
                required, sameAsEmail: sameAs('email'), async isConfirmUnique(value) {
                    if (value === "") return true;
                    let isConfirmUnique = true
                    if (value.length > 8) {

                        await userLogin.checkUniqueEmail({"email": this.user.confirm_email}).then(response => {
                            if (response.data.status == 'ERROR')
                                isConfirmUnique = false;
                            else
                                isConfirmUnique = true;

                        });
                    }
                    return Boolean(isConfirmUnique);
                }
            },
            password: {required},
            confirm_password: {
                required,
                sameAsPassword: sameAs('password')
            },
            organisation_name: { required: requiredIf(function () {
                    return this.requireOrganisationName;
                }) },

        },

    },
    data() {
        return {
            loading: false,
            membership_types:[
                {value: "beneficiary", title: "Beneficiary"},
                {value: "pharmaceutical_company", title: "Pharmaceutical company"},
                {value: "funding_organisation", title: "Funding organisation"},
                {value: "volunteer", title: "Volunteer"},
            ],
            user:{
                account_type:'',
                organisation_name:'',
                first_name:'',
                middle_name:'',
                last_name:'',
                gender:'',
                mobile:'',
                email:'',
                confirm_email:'',
                password:'',
                confirm_password:'',
            },
            verificationCode: '',
            showLoginError: false,
            attrs: null,
            showPassword: false,
            showConfirmPassword: false,
            site_key: process.env.MIX_SITE_KEY,
            login: {
                _token: this._token,
                email: '',
                password: '',
            }
        }
    },
    methods: {

        checkEqual(firstValue,secondValue)
        {
           return firstValue===secondValue;
        },
        passwordToggle() {
            this.showPassword = !this.showPassword;
        },

        numberRange (start, end) {
            return new Array(end - start).fill().map((d, i) => i + start);
        },

        onEnter() {
            this.proceedRegister();
        },

        continueVerification() {
            window.location.href = this._resend_verification_url;
        },

        proceedRegister() {
            this.$refs.invisibleRecaptcha.execute();
        },

        onCaptchaVerified: function () {
            this.$v.$touch();
            if (this.$v.$error) {
                setTimeout(() => {
                    this.$v.$reset()
                    this.showLoginError = false;
                }, 10000);
            } else {
                this.loading = true;
                let fd = this.convertFormData();
                userLogin.register(fd).then(response => {
                        this.$snotify.success('Your request has been sent');
                        this.loading = false;
                        window.location.href = response.data.url;

                    }).catch(() => {
                        this.loading = false;
                        this.$snotify.error('Oops Something went wrong');
                    });
                console.log("hello");
            }
        },

        convertFormData() {
            let fd = new FormData();
            for (let key in this.user) {
                if (
                    key == "file" &&
                    this.user["file"] &&
                    this.user["file"] != null
                ) {
                    if (typeof (this.user['file']) == 'object') {
                        fd.append("request_file", this.user[key][0]);
                    }
                }
                else {
                    if (this.user[key] != null) {
                        fd.append(key, this.user[key]);
                    }
                }
            }
            return fd;
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
    },
    mounted() {

    },
    computed:{
        requireOrganisationName() {
            return this.user.account_type=='beneficiary' || this.user.account_type=='pharmaceutical_company' || this.user.account_type=='funding_organisation' ? true : false
        }



    }
}
</script>
