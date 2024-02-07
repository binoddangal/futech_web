<template>
    <v-app>
        <v-dialog v-model="dialog" max-width="600">
            <v-card>
              <v-toolbar elevation="0">
                <v-card-title class="headline">
                  {{ edit ? 'Update' : 'Add'}} menu category
                  <hr>
                </v-card-title>

                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-spacer></v-spacer>
                  <v-btn icon  @click="resetForm">
                    <i class="fas fa-times"></i>
                  </v-btn>
                </v-toolbar-items>
              </v-toolbar>
                <v-card-text>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field label="Title" v-model="menu.title" outlined dense>

                            </v-text-field>
                            <span class="text-danger" v-if="$v.menu.title.$error">This information is required</span>

                        </v-col>
                        <v-col cols="12">
                            <span class="body-1">Set as header menu</span>
                            <v-switch v-model="menu.header"   color="primary"
                              :label="menu.header?'Yes':'No'">
                            </v-switch>

                        </v-col>

                    </v-row>
                </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    text
                    class="cancel-btn"
                    x-large
                    @click="resetForm">
                  Cancel
                </v-btn>
                <v-btn
                    color="btn btn-primary"
                    dark
                    x-large
                    :loading="isBusy"
                    @click="createOrUpdate()"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>

</template>
<script>
import {required} from 'vuelidate/lib/validators';
import MenuItemService from "../../../../../../services/admin/cms/menu/MenuItemService";

const menuItem = new MenuItemService();
export default {
    name: "CreateAndUpdate",
    data() {
        return {
            search: {
                active: "active",
                is_parent: 1,
            },
            dialog: false,
            edit: false,
            sizeExceed: false,
            isBusy: false,
            menu: {
                title: null,
                header: 1,
                is_active: true
            },
            menus: [],
            loading:false,
        };
    },

    validations: {
        menu: {
            title: {required}
        }
    },
    methods: {
        getMenu() {
            menuItem
                .paginate(this.search)
                .then(response => {
                    this.menus = response.data.data;
                })
                .catch(error => {
                    // console.log(error);
                });
        },
        editMenu(menu) {
            this.edit = true;
            this.menu = menu;
        },
        showModal(menu = null) {
            this.__reset();
            if (menu !== null) {
                this.edit = true;
                this.menu = menu;
            }

            this.dialog = true;
            this.getMenu();
            // this.$refs["my-modal"].show();
        },
        hideModal() {
            this.dialog = false;
        },
        toggleModal() {
            this.$refs["my-modal"].toggle("#toggle-btn");
        },
        getMenus(id) {
            menuItem.show(id).then(response => {
                this.menu = response.data.menu
                if (this.menu.tags) {
                    this.menu.tags = this.menu.tags.split(',');
                }
            })
        },
        // generateFd() {
        //     // console.log(this.menu)
        //     let fd = new FormData();
        //     for (let key in this.menu) {
        //         if (key == "is_active" && this.menu["is_active"]) {
        //             fd.append("is_active", this.menu ? 1 : 0);
        //         } else {
        //             if (this.menu[key] != null) {
        //                 fd.append(key, this.menu[key]);
        //             }
        //         }
        //     }
        //     return fd;
        // },
        createOrUpdate() {
            this.$v.menu.$touch();
            if (this.$v.menu.$error) {
                setTimeout(() => {
                    this.$v.menu.$reset();
                }, 3000);
            } else {
                let fd = this.menu;
                if (this.edit) {
                    this.updateMenu(fd);
                } else {
                    this.createMenu(fd);
                }
            }
        },
        updateMenu(fd) {
            this.isBusy = true;
            menuItem
                .update(this.menu.id, fd)
                .then(response => {
                    this.isBusy = false;
                    this.$snotify.success("Updated successfully");

                    this.resetForm();
                })
                .catch(error => {
                    this.isBusy = false;
                    this.$snotify.error("Something Went Wrong");
                    // console.log(error);
                });
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
        createMenu(fd) {
            this.isBusy = true;
            menuItem
                .store(fd)
                .then(response => {
                    this.isBusy = false;
                    this.resetForm();
                    this.$snotify.success("Created successfully");

                })
                .catch(error => {
                    this.isBusy = false;
                    this.$snotify.error("Something Went Wrong");
                    // console.log(error);
                });
        },
        deleteMenu(id) {
            this.$confirm({
                message: `Are you sure you want to delete this item permanently?`,
                button: {
                    no: "No",
                    yes: "Yes"
                },
                /**
                 * Callback Function
                 * @param {Boolean} confirm
                 */
                callback: confirm => {
                    if (confirm) {
                        menuItem
                            .delete(id)
                            .then(response => {
                                this.getMenu();
                            })
                            .catch(error => {
                                //console.log(error);
                            });
                    }
                }
            });
        },
        __reset(){
            this.$v.menu.$reset();
            this.edit = false;
            this.menu = {
                title: null,
                header: 1,
                is_active: true
            };
        },
        resetForm() {
            this.$v.menu.$reset();
            this.edit = false;
            this.menu = {
                title: null,
                header: 1,
                is_active: true
            };
            this.hideModal();
            this.$emit("refresh_menu");
        }
    }
};
</script>
