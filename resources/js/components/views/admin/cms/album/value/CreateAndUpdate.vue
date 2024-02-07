<template>
    <v-dialog  v-model="dialog" max-width="600">
    <v-card>
        <v-toolbar elevation="0">
        <v-card-title class="headline">
            {{`${edit?'Update':"Add"} Image`}}
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
        <div class="row">
            <div class="col-12 ">
                <v-file-input
                    prepend-icon=""
                    outlined
                    dense
                    prepend-inner-icon="mdi-file"
                    multiple
                    v-model="files"
                    @change="checkSize($event)"
                    accept=".jpg, .png, .gif"
                    placeholder="Image"
                    label="Image"
                    >
                </v-file-input>
                <span class="text-danger" v-if="$v.files.$error">Image is required.</span>
                <span class="text-danger" v-if="sizeExceed">File Size Exceed.</span>
            </div>
        </div>

        </v-card-text>
        <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
            class="btn btn-standard cancel-btn"
            dark
            text
            @click="closeDialog"
        >Cancel
        </v-btn>
        <v-btn
            class="text-white ml-2 btn btn-primary"
            dark
            :disabled="sizeExceed"
            @click="createOrUpdate"
            :loading="isBusy"
        >Save
        </v-btn>
        </v-card-actions>

    </v-card>
    </v-dialog>
</template>
<script>
import AlbumValueService from '@/services/admin/cms/album/value/AlbumValueService';
import { required } from 'vuelidate/lib/validators';

const valueService = new AlbumValueService();
export default {
    data() {
        return {
            edit: false,
            isBusy: false,
            sizeExceed: false,
            album_id: '',
            files: [],
            value: {
                path: null
            },
        dialog:false,
        };
    },
    validations: {
        files: {required}
    },
    methods: {
        openDialog(){
            this.dialog=true;
        },
        showModal(albumId) {
            this.album_id = albumId;
            this.openDialog();
        },
        closeDialog() {
            this.dialog = false;
            this.resetForm();
        },

        getAlbum(id) {
            albumService.show(id).then(response => {
                this.album = response.data.album;
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
        generateFd() {
            let fd = new FormData();
            for (let key in this.files) {
                fd.append("path[]", this.files[key]);
            }
            return fd;
        },
        createOrUpdate() {
            this.$v.files.$touch();
            if (this.$v.files.$error) {
                setTimeout(() => {
                    this.$v.files.$reset();
                }, 3000);
            } else {
                let fd = this.generateFd();
                this.addPhoto(fd);
            }
        },
        addPhoto(fd) {
            this.isBusy = true;
            valueService
                .store(this.album_id, fd)
                .then(response => {
                    this.isBusy = false;
                    this.$snotify.success("Uploaded successfully");
                    this.$emit("refresh");
                    this.closeDialog();
                })
                .catch(error => {
                    this.isBusy = false;
                    this.$snotify.error("Something Went Wrong");
                });
        },
        resetForm() {
            this.edit = false;
            this.files = [];
        }
    }
};
</script>
