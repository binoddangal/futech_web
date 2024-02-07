<template>
    <v-app>
        <h2 >Contact Form</h2> <br>

        <div class="row cont-row">
            <div  class="col-sm-3"><label>Enter first name</label><span>:</span></div>
            <div class="col-sm-8">
                <v-text-field
                    label="Enter first name"
                    clearable
                    :error="$v.contactus.first_name.$error"
                    v-model="contactus.first_name"
                    outlined
                    required
                    dense
                >
                </v-text-field>
            </div>
        </div>

        <div class="row cont-row">
            <div  class="col-sm-3"><label>Enter last name </label><span>:</span></div>
            <div class="col-sm-8">
                <v-text-field
                    label="Enter last name"
                    clearable
                    :error="$v.contactus.last_name.$error"
                    v-model="contactus.last_name"
                    outlined
                    required
                    dense
                >
                </v-text-field>
            </div>
        </div>

        <div class="row cont-row">
            <div  class="col-sm-3"><label>Enter email </label><span>:</span></div>
            <div class="col-sm-8">
                <v-text-field
                    label="Enter email"
                    clearable
                    type="email"
                    :error="$v.contactus.email.$error"
                    v-model="contactus.email"
                    outlined
                    required
                    dense
                >
                </v-text-field>
            </div>
        </div>

        <div  class="row cont-row">
            <div  class="col-sm-3"><label>Mobile number</label><span>:</span></div>
            <div class="col-sm-8">
                <v-text-field
                    label="Mobile number"
                    type="number"
                    clearable
                    :error="$v.contactus.phone.$error"
                    v-model="contactus.phone"
                    outlined
                    required
                    dense
                >
                </v-text-field>
            </div>
        </div>
        <div  class="row cont-row">
            <div  class="col-sm-3"><label>Subject</label><span>:</span></div>
            <div class="col-sm-8">
                <v-text-field
                    label="Subject"
                    clearable
                    :error="$v.contactus.subject.$error"
                    v-model="contactus.subject"
                    outlined
                    required
                    dense
                >
                </v-text-field>
            </div>
        </div>
        <div  class="row cont-row">
            <div  class="col-sm-3"><label>Enter message</label><span>:</span></div>
            <div class="col-sm-8">
                <v-textarea rows="5" v-model="contactus.message" placeholder="Enter your message" outlined dense></v-textarea>
            </div>
        </div>
        <div style="margin-top:10px;" class="row">
            <div style="padding-top:10px;" class="col-sm-3"><label></label></div>
            <div class="col-sm-8">
                <v-btn
                    class="float-right"
                    dark
                    x-large
                    rounded
                    :loading="loading"
                    @click="submit"
                >
                    Send Message
                </v-btn>
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
import { required } from "vuelidate/lib/validators";
import VueRecaptcha from "vue-recaptcha";
import ContactService from '@/services/front/contact/ContactService';

const contactUs = new ContactService();
export default {
    name: "ContactUs",
    components: {
        VueRecaptcha
    },
    validations:{
        contactus: {
            first_name: { required },
            last_name: { required },
            email: { required },
            phone: { required },
            subject: { required },
            message: { required },
        }
    },
    data() {
        return {
            loading: false,
            site_key: process.env.MIX_SITE_KEY,
            contactus: {
                first_name: '',
                last_name: '',
                phone: '',
                subject: '',
                message: '',
            },
        }
    },
    methods: {
        submit() {
            this.$refs.invisibleRecaptcha.execute();
        },

        onCaptchaVerified: function () {
            this.$v.contactus.$touch()
            if (this.$v.contactus.$error) {
                setTimeout(() => {
                    this.$v.$reset();
                }, 1000);
            } else {
                contactUs.store(this.contactus).then(response => {
                    if (response.data.status == "OK") {
                        this.$snotify.success("Form Submitted Successfully ");
                        this.$v.$reset();
                        this.contactus = {
                            first_name: '',
                            last_name: '',
                            phone: '',
                            subject: '',
                            message: '',
                        };
                    }
                }).catch(() => {
                    this.$snotify.error("Problem occurred");
                });
            }
        },

    }
}
</script>
