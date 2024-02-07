<template>
  <div>
    <b-modal id="modal-scrollable" size="md" ref="my-modal" hide-footer title="Add/Edit Media">
      <div class="row">
        <div class="col-8 form-group">
          <!-- <label for="">Title</label> -->
          <input type="text" class="form-control" v-model="album.title" placeholder="Title" />
          <span class="text-danger" v-if="$v.album.title.$error">Title is required</span>
        </div>
        <div class="col-4 form-group mt-5">
          <b-form-checkbox
            v-model="album.is_active"
            name="check-button"
            class
            switch
          >Status</b-form-checkbox>
        </div>
        <div class="col-12 form-group">
          <b-form-file
            v-model="album.cover_image"
            :state="Boolean(album.cover_image)"
            placeholder="Cover Image"
          ></b-form-file>
        </div>
        <div class="col-12 mt-4" v-if="album.cover_image_path">
          <img :src="album.cover_image_path['thumb']" alt />
        </div>
          <div class="col-12 form-group">
              <label for class="float-left">Description</label>
              <textarea class="form-control" name id cols="30" rows="10" v-model="album.description"></textarea>
              <!-- <span class="text-danger" v-if="$v.page.content.$error">Content is required</span> -->
            </div>
      </div>
      <div class="row">
        <div class="col-6">
          <b-button size="sm" class="mt-3 text-primary" variant="default" block @click="hideModal">Cancel</b-button>
        </div>
        <div class="col-6">
          <b-button size="sm" class="mt-2" variant="primary" block @click="createOrUpdate">Save</b-button>
        </div>
      </div>
    </b-modal>
  </div>
</template>
<script>
import { required } from 'vuelidate/lib/validators';
import MediaService from "../../../../../services/admin/cms/media/MediaService";

const mediaService = new MediaService();
export default {
    name: "CreateAndUpdate",
    data() {
        return {
        edit:false,
        album: {
            title: null,
            is_active: true
        }
        };
    },

    validations: {
        album: {
            title: { required }
        }
    },
    methods: {
        showModal(id = null) {
        if(id){
            this.edit = true
            this.getAlbum(id)
        }
        this.$refs["my-modal"].show();
        },
        hideModal() {
            this.$refs["my-modal"].hide();
        },
        toggleModal() {
            this.$refs["my-modal"].toggle("#toggle-btn");
        },
        getAlbum(id){
            mediaService.show(id).then(response=>{
                this.album = response.data.album
            })
        },
        generateFd() {
            let fd = new FormData();
            for (let key in this.album) {
                if (
                key == "cover_image" &&
                this.album["cover_image"] &&
                this.album["cover_image"] != null
                ) {
                    fd.append("cover_image", this.album[key]);
                } else if (key == "is_active" && this.album["is_active"]) {
                    fd.append("is_active", this.album ? 1 : 0);
                } else {
                    fd.append(key, this.album[key]);
                }
            }
            return fd;
        },
        createOrUpdate() {
            this.$v.album.$touch();
            if (this.$v.album.$error) {
                setTimeout(() => {
                this.$v.album.$reset();
                }, 3000);
            } else {
                let fd = this.generateFd();
                if (this.edit) {
                this.updateAlbum(fd);
                } else {
                this.createAlbum(fd);
                }
            }
        },
        updateAlbum(fd) {
            mediaService
                .update(this.album.id, fd)
                .then(response => {
                this.resetForm();
                })
                .catch(error => {
                // console.log(error);
                });
        },
        createAlbum(fd) {
            mediaService
                .store(fd)
                .then(response => {
                this.resetForm();
                })
                .catch(error => {
                // console.log(error);
                });
        },
        resetForm() {
            this.edit = false;
            this.album = {
                title: null,
                is_active: null
            };
            this.hideModal();
            this.$emit("refresh_album");
        }
    }
};
</script>
