<template>
  <div>
    <v-app>
      <div
        class="center-login-wrapper mx-auto"
        v-if="!this.mfaAuthenticator && !this.emailAuthenticator"
      >
        <div class="sm:mx-auto sm:w-full">
          <div class="bg-white sm:px-10">
            <div>
              <div class="">
                <v-text-field
                  label="Enter your email"
                  v-model="login.email"
                  tabindex="1"
                  :error="$v.login.email.$error"
                  clearable
                  v-on:keyup.enter="onEnter"
                  outlined
                  required
                  class=""
                ></v-text-field>
              </div>
            </div>

            <div>
              <div class="">
                <v-text-field
                  label="Enter your password"
                  clearable
                  tabindex="2"
                  :error="$v.login.password.$error"
                  type="password"
                  v-model="login.password"
                  v-on:keyup.enter="onEnter"
                  outlined
                  required
                  class=""
                ></v-text-field>
              </div>
            </div>

            <div class="flex items-center mt-1" v-if="showLoginError">
              <span class="text-danger"
                >Please check your email or password correctly.</span
              >
            </div>
            <div class="flex items-center mt-5">
              <div class="text-right w-full flex-col">
                <v-btn
                  v-if="!accountNotVerified"
                  color="primary"
                  :loading="loading"
                  @click="proceedLogin"
                >
                  Log in
                </v-btn>

                <v-btn
                  v-else
                  type="button"
                  class="w-full"
                  rounded
                  :loading="loading"
                  @click="continueVerification"
                  color="black"
                  x-large
                  dark
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

            <v-alert
              v-if="showLoginError"
              class="mt-2 text-center"
              :icon="false"
              dense
              outlined
              type="error"
            >
              <b>We're not recognising your email or password.</b><br />
              Please give it another go.<br /><br />
            </v-alert>
          </div>
        </div>
      </div>

      <div class=" " v-if="this.mfaAuthenticator || this.emailAuthenticator">
        <div class=" ">
          <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-4xl font-extrabold text-gray-900">
              Multi-Factor Authentication Check
            </h2>
          </div>

          <div class="mt-5">
            <div class="bg-white text-center">
              <img
                src="/assets/image/mfa_verification.png"
                class="w-64"
                style="margin: 0 auto"
              />
              <div class="mt-5 mb-5">
                Since you have enabled multi-factor authentication. Please enter
                the verification code displayed on your mobile app.
              </div>
              <CodeInput
                ref="code"
                :loading="loading"
                class="input"
                v-model="verificationCode"
                v-on:complete="onComplete"
                style="margin: 0 auto"
              />

              <div
                class="mt-8"
                v-if="multiAuthenticator && !emailVerificationMailRequested"
              >
                Try Alternative ?<v-btn
                  class="ml-2"
                  dark
                  large
                  rounded
                  @click="requestEmailVerificationCode"
                  >Request Email</v-btn
                >
              </div>

              <div class="mt-8" v-if="emailVerificationMailRequested">
                If you didn't receive a verification code you can request again
                in a minute.
              </div>
              <div class="mt-8">
                Lost your mobile device ?
                <v-btn class="ml-2 link" @click="recoverAccount"
                  >Recover Account</v-btn
                >
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
    </v-app>
  </div>
</template>

<script>
import CodeInput from "vue-verification-code-input";
import { required, email } from "vuelidate/lib/validators";
import VueRecaptcha from "vue-recaptcha";
import LoginAdminUserService from "../../../../services/admin/admin-user/LoginAdminUserService";
import ConfirmBox from "../../../../components/confirm-box/ConfirmBox.vue";

const adminUserService = new LoginAdminUserService();

export default {
  name: "AdminLogin",
  props: ["_token", "_resend_verification_url"],
  components: {
    ConfirmBox,
    CodeInput,
    VueRecaptcha,
  },
  validations: {
    login: {
      email: { required, email },
      password: { required },
    },
    verificationCode: { required },
  },
  data() {
    return {
      loading: false,
      verificationCode: "",
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
        email: "",
        password: "",
      },
    };
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

    onCaptchaVerified: function () {
      this.$v.login.$touch();
      if (this.$v.login.$error) {
        setTimeout(() => {
          this.$v.$reset();
          this.showLoginError = false;
        }, 10000);
      } else {
        this.loading = true;
        adminUserService
          .checkVerificationEnabled(this.login)
          .then((res) => {
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
            } else if (res.data.data.is_mfa_enabled) {
              this.mfaAuthenticator = true;
            } else if (res.data.data.is_email_authentication_enabled) {
              this.emailAuthenticator = true;
            } else {
              this.setUserLogin();
            }
            setTimeout(() => {
              this.showLoginError = false;
            }, 10000);
          })
          .catch((err) => {
            this.loading = false;
          })
          .finally(() => {
            this.loading = false;
          });
      }
    },

    setUserLogin() {
      adminUserService
        .login(this.login)
        .then((res) => {
          this.loading = false;

          if (res.data.url) window.location.href = res.data.url;
        })
        .catch((err) => {
          this.loading = false;
        });
    },
    /*Verification Code Login*/
    onComplete(v) {
      this.login.verification_code = v;
      adminUserService
        .checkMfaVerificationCode(this.login)
        .then((response) => {
          if (response.data.status == "OK") {
            this.setUserLogin(this.login);
            this.$refs.code.values = ["", "", "", "", "", ""];
          } else {
            this.$snotify.error(response.data.errors);
            this.$refs.code.values = ["", "", "", "", "", ""];
          }
        })
        .catch((error) => {});
    },

    completeVerification() {
      this.$v.$touch();
      if (this.$v.verificationCode.$error) {
        setTimeout(() => {
          this.$v.$reset();
          this.showLoginError = false;
        }, 10000);
      } else {
        adminUserService
          .checkMfaVerificationCode(this.login)
          .then((response) => {
            if (response.data.status == "OK") {
              this.setUserLogin(this.login);
            } else {
              this.$snotify.error(response.data.errors);
            }
          });
      }
    },
    async requestEmailVerificationCode() {
      const confirm = await this.$refs.confirm.confirm({
        title: this.trans.get("admin.mfa_request_email_confirm_box_title"),
        message: this.trans.get("admin.mfa_request_email_confirm_box_msg"),
        cancel_btn_text: this.trans.get(
          "admin.mfa_request_email_confirm_box_cancel_text"
        ),
        ok_btn_text: this.trans.get(
          "admin.mfa_request_email_confirm_box_yes_text"
        ),
      });

      if (confirm) {
        adminUserService
          .requestEmailVerificationCode(data)
          .then((res) => {
            this.emailVerificationMailRequested = true;
            this.$snotify.success(
              "Verification code has been sent to your registered email. Please allow us 1-3 minutes."
            );

            setTimeout(() => {
              this.emailVerificationMailRequested = false;
            }, 60000);
          })
          .catch(({ response }) => {
            this.emailVerificationMailRequested = false;
          });
      }
    },
    recoverAccount() {
      this.$confirm({
        message: `If you have lost access to your Authenticator APP and not being able to login you can recover your account. You will receive an email with instruction.`,
        button: {
          no: "Cancel",
          yes: "Request Email",
        },
        callback: (confirm) => {
          let data = this.login;
          if (confirm) {
            adminUserService
              .recoverAccount(data)
              .then((res) => {
                this.$snotify.success(
                  "Recovery instruction has been sent your registered email. Please allow us 1-3 minutes."
                );
                setTimeout(() => {
                  window.location.href = res.data.url;
                }, 10000);
              })
              .catch(({ response }) => {});
          }
        },
      });
    },
  },
};
</script>
