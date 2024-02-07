<template>
    <v-dialog max-width="900" v-model="dialog">
        <v-card>
            <v-toolbar elevation="0">
            <v-card-title>
                {{ `${download.id ? 'Update' : 'Add'} ` }} download
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
                        <v-text-field
                            outlined
                            dense
                            label="Title"
                            v-model="download.title"
                            :error="$v.download.title.$error"
                        ></v-text-field>
                        <span class="text-danger" v-if="$v.download.title.$error">This information is required</span>
                    </v-col>

                    <v-col cols="12">
                        <v-textarea
                            outlined
                            dense
                            label="Description"
                            v-model="download.description"
                        ></v-textarea>
                    </v-col>

                    <v-col cols="12">

                        <v-select
                            :items="types"
                            item-text="title"
                            item-value="id"
                            outlined
                            dense
                            label="Type"
                            v-model="download.download_type_id"
                            :error="$v.download.download_type_id.$error"
                        >
                        </v-select>

                        <span class="text-danger" v-if="$v.download.download_type_id.$error">This information is required</span>
                    </v-col>

                    <v-col cols="12">
                        <v-file-input
                            outlined
                            dense
                            label="File"
                            @change="checkFileSize($event)"
                            accept="application/msword, application/pdf, image/*, application/vnd/*"
                            placeholder="File"
                            prepend-icon=""
                            prepend-inner-icon="mdi-link"
                            v-model="download.file"
                            :error="$v.download.file.$error"
                            >
                        </v-file-input>
                        <span class="text-danger" v-if="$v.download.file.$error">This information is required</span>
                        <span class="text-danger" v-if="sizeExceed">Please upload a file upt 20MB</span>
                    </v-col>

                    <v-col cols="12">
                        <v-file-input
                            outlined
                            dense label="File"
                            @change="checkImageSize($event)"
                            placeholder="File"
                            prepend-icon=""
                            prepend-inner-icon="mdi-image"
                            v-model="download.image"
                        ></v-file-input>
                        <img v-if="download.preview_image_path" :src="download.preview_image_path.real" alt="">
                        <span class="text-danger" v-if="sizeExceed">Please upload a file upt 20MB</span>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-switch v-model="download.is_private" label="Private File">Private file
                        </v-switch>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-switch v-model="download.public_hidden"  label="Hide From Public">Hide from public
                        </v-switch>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-switch v-model="download.is_active"  label="Status">Status
                        </v-switch>
                    </v-col>

                    <v-col cols="12" class="col-12 text-right">
                        <v-btn
                                class="btn text-gray btn-standard"
                                depressed
                                @click="closeDialog"
                        >Cancel
                        </v-btn>
                        <v-btn
                                class="text-white ml-2 btn btn-primary"
                                depressed
                                @click="createOrUpdate"
                                :loading="isBusy"
                        >Save
                        </v-btn>

                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
import { required } from 'vuelidate/lib/validators';
import DownloadTypeService from '@/services/admin/cms/download/type/DownloadTypeService';
import DownloadService from '@/services/admin/cms/download/DownloadService';

const typeService = new DownloadTypeService();
const download = new DownloadService();

export default {
    name: "CreateAndUpdate",
    data() {
        return {
            types: [],
            sizeExceed: false,
            edit: false,
            isBusy: false,
            dialog: false,
            download: {
                title: '',
                description: '',
                file: null,
                image: null,
                download_type_id: '',
                is_private: false,
                public_hidden: false,
                is_active: true,
            }
        };
    },
    validations: {
        download: {
            title: { required },
            file: { required },
            download_type_id: { required }
        }
    },

    mounted() {
        this.getTypes()
    },
    methods: {
        checkImageSize(file) {
            if(file && file.size){
                let size = file.size / 1024 / 1024;
                let mbSize = size.toFixed(2);
                if (mbSize > 20) {
                    this.sizeExceed = true;
                } else {
                    this.sizeExceed = false;
                }
            }
        },
        checkFileSize(file) {
            if(file && file.size){
                let size = file.size / 1024 / 1024;
                let mbSize = size.toFixed(2);
                if (mbSize > 20) {
                    this.sizeExceed = true;
                } else {
                    this.sizeExceed = false;
                }
            }
        },

        createDownload() {
            this.dialog = true;
            this.edit = false;
            this.resetForm();
        },

        editDownload(download) {
            this.dialog = true;
            this.edit = true;
            this.resetForm();
            this.download = download;
        },

        closeDialog() {
            this.dialog = false;
            this.resetForm();
        },

        getTypes() {
            typeService.allActive().then(response => {
                this.types = response.data;
            });
        },

        // getDownload(id) {
        //     download.show(id).then(response => {
        //         this.edit = true
        //         this.download = response.data.download;
        //         this.download.download_type_id = parseInt(response.data.download.download_type_id);

        //     });
        // },

        generateFd() {
            let fd = new FormData();
            for (let key in this.download) {
                if (
                    key == "file" &&
                    this.download["file"] &&
                    this.download["file"] != null
                ) {
                    if (typeof (this.download['file']) == 'object') {
                        fd.append("file", this.download[key]);

                    }

                } else if (
                    key == "image" &&
                    this.download["image"] &&
                    this.download["image"] != null
                ) {
                    if (typeof (this.download['image']) == 'object') {
                        fd.append("image", this.download[key]);

                    }

                } else if (key == "is_active" && this.download["is_active"]) {
                    fd.append("is_active", this.download["is_active"] ? 1 : 0);
                } else if (key == "is_private" && this.download["is_private"]) {
                    fd.append("is_private", this.download["is_private"] ? 1 : 0);
                } else if (key == "public_hidden" && this.download["public_hidden"]) {
                    fd.append("public_hidden", this.download["public_hidden"] ? 1 : 0);
                } else {
                    if (this.download[key] != null) {
                        fd.append(key, this.download[key]);
                    }
                }
            }
            return fd;
        },

        createOrUpdate() {
            this.$v.download.$touch();
            if (this.$v.download.$error) {
                setTimeout(() => {
                    this.$v.download.$reset();
                }, 3000);
            } else {
                let fd = this.generateFd();
                if (this.edit) {
                    this.update(fd);
                } else {
                    this.create(fd);
                }
            }
        },

        create(fd) {
            this.isBusy = true;
            download.store(fd).then(response => {
                this.isBusy = false;
                this.$snotify.success("Created successfully");
                this.closeDialog();
                this.$emit("refresh");
            }).catch((err) => {
                this.$snotify.error("Something Went Wrong");
                this.isBusy = false;
            });
        },

        update(fd) {
            this.isBusy = true;
            download.update(this.download.id, fd).then(response => {
                this.isBusy = false;
                this.closeDialog();
                this.$emit("refresh");
            }).catch((err) => {
                this.$snotify.error("Something Went Wrong");
                this.isBusy = false;
            });
            ;
        },

        resetForm() {
            this.$v.$reset();
            this.download = {
                title: '',
                description: '',
                file: null,
                image: null,
                download_type_id: '',
                is_private: false,
                public_hidden: false,
                is_active: true,
            };
        }
    }
};
</script>
