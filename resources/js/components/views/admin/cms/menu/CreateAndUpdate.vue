<template>
    <v-dialog v-model="dialog" max-width="600">
        <v-card>
            <v-toolbar elevation="0">
            <v-card-title>
                {{ edit ? 'Edit' : 'Add'}} menu category
            </v-card-title>
                <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-spacer></v-spacer>
                <v-btn icon  @click="closeDialog">
                    <i class="fas fa-times"></i>
                </v-btn>
            </v-toolbar-items>
            </v-toolbar>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field label="Title" v-model="menu.title" outlined dense          :error="$v.menu.title.$error">

                        </v-text-field>
                        <span class="text-danger" v-if="$v.menu.title.$error">Title is required</span>

                    </v-col>
                    <v-col cols="12">

                        <v-switch v-model="menu.header" label=" Set as header menu">

                        </v-switch>

                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    text
                    @click="closeDialog"
                >
                    Cancel
                </v-btn>
                <v-btn dark
                        @click="createOrUpdate"
                        class="text-white btn btn-primary">
                    {{ edit ? 'Update' : 'Add'}}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import MenuService from '@/services/admin/cms/menu/MenuService';
import {required} from "vuelidate/lib/validators";

const menuService = new MenuService();
export default {
    validations: {
        menu: {
            title: {required}
        }
    },
    data() {
        return {
            dialog: false,
            edit: false,
            loading: false,
            menu: {
                title: null,
                header: 1,
                is_active: true
            },
        };
    },
    methods: {
        editMenu(menu) {
            this.dialog = true;
            this.edit = true;
            this.resetForm();
            this.menu = menu;
        },

        createMenu() {
            this.dialog = true;
            this.edit = false;
            this.resetForm();
        },

        closeDialog() {
            this.dialog = false;
            this.resetForm();
        },

        createOrUpdate() {
            this.$v.menu.$touch();
            if (this.$v.menu.$error) {
                setTimeout(() => {
                    this.$v.menu.$reset();
                }, 3000);
            } else {
                let fd = this.menu;
                if (this.edit) {
                    this.update(fd);
                } else {
                    this.create(fd);
                }
            }
        },
        update(fd) {
            this.loading = true;
            menuService
                .update(this.menu.id, fd)
                .then(response => {
                    this.loading = false;
                    this.$snotify.success("Updated successfully");
                    this.$emit("refresh");
                    this.closeDialog();
                })
                .catch(error => {
                    this.loading = false;
                    this.$snotify.error("Something Went Wrong");
                });
        },

        create(fd) {
            this.loading = true;
            menuService
                .store(fd)
                .then(response => {
                    this.loading = false;
                    this.$emit("refresh");
                    this.closeDialog();
                    this.$snotify.success("Created successfully");

                })
                .catch(error => {
                    this.loading = false;
                    this.$snotify.error("Something Went Wrong");
                });
        },

        resetForm() {
            this.$v.menu.$reset();
            this.menu = {
                title: null,
                header: 1,
                is_active: true
            };

        }
    }
};
</script>
