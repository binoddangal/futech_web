<template>
    <v-app>
        <h2 >Apply for this position</h2> <br>

        <div class="row cont-row">
            <div  class="col-sm-3"><label>Enter first name</label><span>:</span></div>
            <div class="col-sm-8">
                <v-text-field
                    label="Enter first name"
                    clearable
                    :error="$v.career.first_name.$error"
                    v-model="career.first_name"
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
                    :error="$v.career.last_name.$error"
                    v-model="career.last_name"
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
                    :error="$v.career.email.$error"
                    v-model="career.email"
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
                    :error="$v.career.phone.$error"
                    v-model="career.phone"
                    outlined
                    required
                    dense
                >
                </v-text-field>
            </div>
        </div>
        <div  class="row cont-row">
            <div class="col-sm-3"><label>Resume</label><span>:</span></div>
            <div class="col-sm-8">
            <v-file-input
                outlined
                dense
                clearable
                prepend-inner-icon="fas fa-file"
                prepend-icon=""
                v-model="career.file"
                :error="$v.career.file.$error"
                required
                @change="checkSize($event)"
                label="CV/Resume"
            ></v-file-input>
            <span class="text-danger" v-if="sizeExceed"
            >Please upload a file size upto 20MB</span
            >
        </div>
        </div>
        <div  class="row cont-row" v-if="career.file_path">
            <img :src="career.file_path['thumb']" alt />
        </div>
        <div  class="row cont-row">
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
                    Submit
                </v-btn>
            </div>
        </div>

        <vue-snotify></vue-snotify>
    </v-app>

</template>

<script>
import { required } from "vuelidate/lib/validators";
import CareerApplicationService from '@/services/admin/cms/career/application/CareerApplicationService';

const career = new CareerApplicationService();
export default {
    name: "career",
    props:['slug'],

    validations:{
        career: {
            first_name: { required },
            last_name: { required },
            email: { required },
            phone: { required },
            file: {required}
        }
    },
    data() {
        return {
            loading: false,
            sizeExceed: false,
            career: {
                first_name: '',
                last_name: '',
                phone: '',
                file:'',
                file_path:''
            },
        }
    },
    methods: {
        convertToFormData() {
            let formData = new FormData();
            for (let key in this.career) {
                if (key === "file" && this.career[key] != null && this.career[key] != undefined) {
                    formData.append('file', this.career[key]);
                }else {
                    if(this.career[key]){
                        formData.append(key,this.career[key]);
                    }
                }
            }
            return formData;
        },
        submit() {
            this.$v.career.$touch()
            this.career.slug = this.slug;
            if (this.$v.career.$error) {
                setTimeout(() => {
                    this.$v.$reset();
                }, 1000);
            } else {
                let formData = this.convertToFormData();

                career.store(formData).then(response => {
                    if (response.data.status == "OK") {
                        this.$snotify.success("Form Submitted Successfully ");
                        this.$v.$reset();
                        this.career = {
                            first_name: '',
                            last_name: '',
                            phone: '',
                            file:'',
                            file_path:''
                        };
                    }
                }).catch(() => {
                    this.$snotify.error("Problem occurred");
                });
            }
        },

        checkSize(file) {
            let size = file.target.files[0].size / 1024 / 1024;
            let mbSize = size.toFixed(2);
            if (mbSize > 20) {
                this.sizeExceed = true;
            } else {
                this.sizeExceed = false;
            }
        },
    }
}
</script>
