<template>
    <v-app>
        <div class="card card-custom">
            <div class="card-body p-0">
                <div
                    class="wizard wizard-2"
                    id="kt_wizard_v2"
                    data-wizard-state="step-first"
                    data-wizard-clickable="true"
                >
                    <div class="wizard-body py-8 px-8 py-lg-10 px-lg-10">
                        <div class="row mb-3">
                            <div class="col-6">
                                <h4>
                                    <a href="/admin/careers">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    {{ `${id ? "Update" : "Add"} career` }}
                                </h4>
                                <a href="/admin/dashboard"> Dashboard </a>
                                \ Careers
                            </div>
                            <!--                            <div class="col-2 ">-->
                            <!--                                <router-link :to="{name:'career-process'}" class="btn btn-primary">-->
                            <!--                                    <i class="fas fa-arrow-left"></i>-->
                            <!--                                    Back-->
                            <!--                                </router-link>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-4">-->
                            <!--                                <h4>Add Admission Process</h4>-->
                            <!--                            </div>-->
                            <div class="col-6 text-right"></div>
                        </div>
                        <div class="row">
                            <div class="col-6 ">
                                <v-text-field outlined dense v-model="career.title" :error="$v.career.title.$error" label="Job title"></v-text-field>
                                <span class="text-danger" v-if="$v.career.title.$error">This information is required</span>
                            </div>

                            <div class="col-3 ">
                                <v-select :items="employmentTypes" item-text="name" item-value="name" outlined dense v-model="career.employment_type" label="Employment type"></v-select>
                            </div>

                            <div class="col-3 ">
                                <v-text-field outlined dense v-model="career.min_qualification"
                                              label="Minimum qualification"></v-text-field>
                            </div>

                            <div class="col-3 ">
                                <v-text-field outlined dense v-model="career.salary_offer" label="Salary offering"></v-text-field>
                            </div>
                            <div class="col-3 ">
                                <v-text-field type="number" outlined dense v-model="career.no_of_vacancies" label="No. of vacancies"></v-text-field>

                            </div>
                            <div class="col-6">
                                <v-menu
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            outlined v-bind="attrs"
                                            v-on="on"
                                            readonly
                                            dense v-model="career.opened_at" label="Application open date"></v-text-field>
                                    </template>
                                    <v-date-picker
                                        no-title
                                        :min="currentDate"
                                        v-model="career.opened_at"
                                        @input="menu2 = false"
                                    ></v-date-picker>
                                </v-menu>
                            </div>
                            <div class="col-6">
                                <v-menu
                                    v-model="menu3"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field outlined v-bind="attrs"
                                                      v-on="on"
                                                      readonly
                                                      dense v-model="career.expiry_date" label="Application closing date"></v-text-field>
                                    </template>
                                    <v-date-picker
                                        no-title
                                        :min="career.opened_at || currentDate"
                                        v-model="career.expiry_date"
                                        @input="menu3 = false"
                                    ></v-date-picker>
                                </v-menu>
                            </div>
                            <div class="col-12 ">
                                <label for class>Job description</label>

                                <ckeditor v-model="career.description"></ckeditor>
                            </div>

                            <div class="col-2 ">
                                Status
                                <v-switch v-model="career.is_active" name="check-button"   :label="career.is_active ? 'Active' : 'Inactive'"></v-switch>
                                <span class="text-danger" v-if="$v.career.is_active.$error">This information is required</span>
                            </div>
                            <div class="col-12 mt-5">
                                <div class="float-right">
                                    <v-btn
                                        @click="closeDialog"
                                        class="mr-2 cancel-btn"
                                        text
                                        x-large
                                    >Cancel</v-btn>
                                    <v-btn
                                           class="btn btn-primary"
                                           dark
                                           x-large
                                           @click="createOrUpdate"
                                           :loading="isBusy"
                                    >{{ edit  ? 'Update' : 'Save' }}</v-btn>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </v-app>
</template>
<script>
import {required} from "vuelidate/lib/validators";

import CareerService from "@/services/admin/cms/career/CareerService";

const career = new CareerService();

export default {
    name: "Careers-new",
    props: ['id','homeRoute'],
    validations: {
        career: {
            title: {required},
            is_active: {required}
        }
    },
    data() {
        return {
            isBusy: false,
            edit: false,
            menu2: false,
            menu3: false,
            currentDate: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            employmentTypes: [
                {name : "Casual"},
                {name : "Part time"},
                {name : "Full time"},
            ],
            career: {
                id: null,
                title: null,
                position: null,
                description: null,
                type: null,
                is_active: true
            }
        };
    },
    mounted() {
        if (this.id) {
            this.getCareers();
            this.edit = true;
        }
    },

    methods: {
        createJob() {
            this.dialog = true;
        },

        editCareer() {
            this.edit = true;
            this.dialog = true;
            this.career = career;

        },

        closeDialog() {
            this.dialog = false;
        },
        redirectTo() {
            window.location.href = `${this.homeRoute}/admin/careers`;
        },

        createOrUpdate() {
            this.$v.career.$touch();
            if (this.$v.career.$error) {
                setTimeout(() => {
                    this.$v.career.$reset();
                }, 3000);
            } else {

                if (this.edit) {
                    this.update();
                } else {
                    this.create();
                }
            }
        },
        update(id) {
            this.loading = true;
            career
                .update(this.career.id, this.career)
                .then(response => {
                    this.loading = false;
                    this.$snotify.success("Updated successfully");
                    setTimeout(() => {
                        this.redirectTo();
                    }, 1000);

                })
                .catch((error) => {
                    this.loading = false;
                    this.$snotify.error("Something Went Wrong");
                    this.loading = false;
                    // console.log(error);
                });
        },

        getCareers() {
            this.loading = true;
            career
                .show(this.id)
                .then(response => {
                    this.career=response.data.career;

                })
                .catch((error) => {
                    // console.log(error);
                });
        },

        create() {
            this.loading = true;
            career
                .store(this.career)
                .then(response => {
                    this.loading = false;
                    this.$snotify.success("Created successfully");
                    setTimeout(() => {
                        this.redirectTo();
                    }, 1000);

                })
                .catch(error => {
                    this.$snotify.error("Something Went Wrong");
                    this.loading = false;
                    // console.log(error);
                });
        },


    }
};
</script>
