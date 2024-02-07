<template>
  <v-app>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
      <!--begin::Toolbar container-->
      <div
        id="kt_app_toolbar_container"
        class="app-container container-fluid d-flex flex-stack"
      >
        <!--begin::Page title-->
        <div
          class="
            page-title
            d-flex
            flex-column
            justify-content-center
            flex-wrap
            me-3
          "
        >
          <!--begin::Title-->
          <h4>Manage media libraries</h4>
          <div class="breadcrumb-sub-header">
            <a href="admin/dashboard">Dashboard </a>\ Media Libraries
          </div>

          <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

      </div>
      <!--end::Toolbar container-->
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card ">

          <div class="card-body">
            <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">

              <v-row>
                <div class="col-12 col-md-3">
                  <v-text-field outlined dense v-model="search.title"  v-on:keyup.enter="getMedia()" label="Title"></v-text-field>
                </div>
                <div class="col-12 col-md-3">
                  <v-select label="Type" outlined dense :items="file_types" item-text="title" item-value="value"   v-on:keyup.enter="getMedia()"
                            v-model="search.active"></v-select>
                </div>
                <div class="col-12 col-md-3">
                  <v-select label="Status" outlined dense :items="active_statuses" item-text="title" item-value="value"  v-on:keyup.enter="getMedia()"
                            v-model="search.active"></v-select>
                </div>

                <div class="col-12 col-md-3 text-right">

                  <v-btn
                      @click="getMedia()"
                      class="btn btn-primary btn-search ">
                    <v-icon small elevation="2" outlined>mdi-magnify</v-icon>&nbsp;
                    Search
                  </v-btn>



                </div>
              </v-row>
            </div>
            <div
                class="wizard wizard-2"
                id="kt_wizard_v2"
                data-wizard-state="step-first"
                data-wizard-clickable="true"
            >
              <div class="wizard-body py-8 px-8 py-lg-10 px-lg-10">
                <!--begin: Wizard Form-->

                <v-app v-if="error">
                  <v-row>
                    <v-col cols="12 mt-5">
                      <v-alert
                          border="right"
                          dismissible
                          colored-border
                          type="error"
                          elevation="2"
                      >PDF, DOC, JPEG, PNG, PPT, XLS & XLSX files are allowed to upload.
                      </v-alert>
                    </v-col>
                  </v-row>
                </v-app>

                <v-row>
                  <v-col cols="12">
                    <div class="upload-control" v-if="images  && images.length">
                      <div class="row">
                        <div class="col-md-7">
                          <div class="row">
                            <div class="col-md-2 mx-2" v-for="(image, index) in images" :key="index">
                              <img :src="image" style="height: 150px; width: 150px;"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-5 text-right">
                          <span class="text-white text-left">Total Files: {{images.length}}</span><br/>
                          <v-btn
                              type="submit"
                              color="white--text v-btn theme--light elevation-2 v-size--large primary"
                              class="btn-standard"
                              dark
                              @click="upload"
                              :loading="isBusy"
                          >Start Upload
                          </v-btn>
                        </div>
                      </div>
                    </div>

                    <div
                        class="uploader"
                        @dragenter="OnDragEnter"
                        @dragleave="OnDragLeave"
                        @dragover.prevent
                        @drop="onDrop"
                        :class="{ dragging: isDragging }"
                    >

                      <div class="p-5">
                        <i class="fa fa-cloud-upload"></i>
                        <p>Drag  and drop your files here</p>
                        <div>OR</div>
                        <div class="file-input">
                          <label for="file">Select a file</label>
                          <input type="file" id="file" @change="onInputChange" multiple accept="image/*"/>
                        </div>
                      </div>


                    </div>
                      <div class="row" v-show="medias.length">
                        <div class="col-3 m-1 preview-images" v-for="(image, index) in medias" :key="index">
                          <img
                              v-if="checkFileType(image.title)"
                              :src="image.image_path.thumb"
                              :alt="`Image Uploader ${index}`"
                          />
                          <img v-else-if="image.type=='pdf'" src="/media/svg/files/pdf.svg"
                               :alt="`Image Uploader ${index}`"/>
                          <img v-else-if="image.type=='excel'" src="/media/svg/files/csv.svg"
                               :alt="`Image Uploader ${index}`"/>
                          <img v-else-if="image.type=='doc'" src="/media/svg/files/doc.svg"
                               :alt="`Image Uploader ${index}`"/>
                          <img v-else src="/media/svg/files/xml.svg" :alt="`Image Uploader ${index}`"/>
                          <div class="details">
                            <span class="name">{{ image.title }}</span>

                            <span
                                class="action-bar cursor-pointer mt-3 d-flex flex-wrap flex-row justify-content-center"
                            >
                                <a :href="image.image_path.real" target="_blank" class="mr-3">
                                <i class="fas fa-eye blue-grey--text" title="View"></i>
                              </a>

                              <a href="#"
                                 v-clipboard:copy="image.image_path.real"
                                 v-clipboard:success="onCopy"
                                 v-clipboard:error="onError" @click.prevent="showUrl(image)">
                                <i class="fas fa-copy mr-3 light-green--text" title="Copy Url"></i>
                              </a>
                               <a href="#" @click.prevent="deleteImg(image.id)">
                                <i class="fas fa-trash red--text" title="Delete"></i>
                              </a>

                            </span>
                          </div>
                        </div>
                        <!--                    <div class="add-btn-wrapper">-->
                        <!--                      <div class="icon-wrap">-->
                        <!--                        <label for="file">-->
                        <!--                          <i class="fa fa-plus"></i>-->
                        <!--                        </label>-->
                        <!--                      </div>-->
                        <!--                    </div>-->
                      </div>
                  </v-col>
                </v-row>

                <div class="row">
                  <div class="col-12 text-right">
                    <v-pagination
                        v-if="medias.length > 0"
                        @input="getMedia"
                        v-model="page"
                        :total-rows="total"
                        :length="lastPage"
                        class="text-right"
                    ></v-pagination>

                    <!--  -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <v-dialog v-model="dialog" max-width="500">
          <v-card>
            <v-card-title class="headline">Use this URL</v-card-title>

            <v-card-text v-if="url">{{ url }}</v-card-text>

            <v-card-actions></v-card-actions>
          </v-card>
        </v-dialog>
        <v-snackbar v-model="snackbar" :timeout="timeout">
          {{ text }}
          <v-btn color="blue" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
      </div>
    </div>
  </v-app>
</template>
<script>
import MediaService from "../../../../../services/admin/cms/media/MediaService";

const mediaService = new MediaService();
export default {
  name: "media",
  components: {},
  data() {
    return {
      active_statuses: [
        {title: 'Active', value: "active"},
        {title: 'In Active', value: "in_active"}
      ],
      file_types: [
        {value: "ppt", title: 'pptx/ppt'},
        {value: "doc", title: 'docx/doc'},
        {value: "csv", title: 'csv/xlsx'},
        {value: "mp3", title: 'mp3'},
        {value: "mp4", title: 'mp4'},
        {value: "pdf", title: 'pdf'},
        {value: "png", title: 'png'},
        {value: "jpeg", title: 'jpg/jpeg'},
      ],
      url: null,
      menu2: false,
      isBusy: false,
      isDragging: false,
      imageFiles: ["jpg", "jpeg", "png", "gif"],
      dragCount: 0,
      files: [],
      images: [],
      dialog: false,
      error: false,
      absolute: true,
      overlay: false,
      medias: [],
      totalSize: null,
      total: null,
      lastPage: null,
      perPage: null,
      page: null,
      snackbar: false,
      text: "My timeout is set to 2000.",
      timeout: 2000,
      search: {
        title: "",
        active: 'active',
        type: "all"
      }
    };
  },
  mounted() {
    this.getMedia();
  },
  methods: {
    checkType(type) {
      if (type.includes("image")) {
        return true;
      } else return false;
    },
    showUrl(image) {
      this.url = image.image_path.real;
      this.dialog = true;
    },
    checkFileType(file) {
      let fileExtension = file.split(".")[file.split(".").length-1];
      let image = this.imageFiles.indexOf(fileExtension) > -1;
      return image;
      // let filePath = file
      // let extension = null
      // if (file) {
      //   if (filePath.includes('aws')) {
      //     filePath = file.split("thumb/")[1];
      //     filePath = filePath.split("?")[0];
      //     extension = filePath.split(".")[1];
      //   } else {
      //     filePath = file.split("thumb/")[1];
      //     extension = filePath.split(".")[1];
      //   }
      //   let image = (this.imageFiles.indexOf(extension) > -1)
      //   return image;
      // }

    },
    OnDragEnter(e) {
      e.preventDefault();

      this.dragCount++;
      this.isDragging = true;

      return false;
    },
    OnDragLeave(e) {
      e.preventDefault();
      this.dragCount--;

      if (this.dragCount <= 0) this.isDragging = false;
    },
    onInputChange(e) {
      const files = e.target.files;

      Array.from(files).forEach(file => this.addImage(file));
    },
    onDrop(e) {
      e.preventDefault();
      e.stopPropagation();

      this.isDragging = false;

      const files = e.dataTransfer.files;

      Array.from(files).forEach(file => this.addImage(file));
    },
    addImage(file) {
      const type = file.name.split(".")[1];
      if (file.type.match("image.*")) {
        this.addFiles(file);
      } else if (type == "pdf") {
        this.addFiles(file);
      } else if (type == "pptx") {
        this.addFiles(file);
      } else if (type == "doc") {
        this.addFiles(file);
      } else if (type == "docx") {
        this.addFiles(file);
      } else if (type == "csv") {
        this.addFiles(file);
      } else if (type == "xlsx") {
        this.addFiles(file);
      } else if (type == "mp3") {
        this.addFiles(file);
      } else if (type == "mp4") {
        this.addFiles(file);
      } else {
        // alert(`${file.name} is not an image`);
        this.error = true;
        // file.type.split('/')[1]
        return;
      }
    },

    onCopy: function (e) {
      this.text = "You just copied URL ";
      this.snackbar = true;
    },
    onError: function (e) {
      this.text = "Failed to copy URL";
      this.snackbar = true;
    },
    addFiles(file) {
      this.error = false;
      this.files.push(file);

      const img = new Image(),
          reader = new FileReader();

      reader.onload = e => this.images.push(e.target.result);

      reader.readAsDataURL(file);
    },
    deleteImg(id) {
      this.$confirm({
        message: `Confirm delete file ?`,
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
            mediaService.delete(id).then(res => {
              this.$snotify.success("Deleted");
              this.getMedia();
            });
          }
        }
      });
    },
    getFileSize(size) {
      const fSExt = ["Bytes", "KB", "MB", "GB"];
      let i = 0;

      while (size > 900) {
        size /= 1024;
        i++;
      }

      return `${Math.round(size * 100) / 100} ${fSExt[i]}`;
    },
    upload() {
      const formData = new FormData();
      this.isBusy = true;
      this.files.forEach(file => {
        if (file) {
          formData.append("file[]", file);
          formData.append("size[]", file.size);
          formData.append("name[]", file.name);
          formData.append("type[]", file.name.split(".")[1]);
        }
      });

      // alert("the total size uploaded is " + this.getFileSize(this.totalSize));
      mediaService.store(formData).then(res => {
        this.isBusy = false;
        this.$snotify.success("Uploaded");
        this.images = [];
        this.files = [];
        this.getMedia();
      });
    },
    getMedia(index = null) {
      mediaService
          .paginate(this.search, this.page)
          .then(response => {
            this.medias = response.data.data;
            this.page = response.data.meta.current_page;
            this.total = response.data.meta.total;
            this.perPage = response.data.meta.per_page;
            this.lastPage = response.data.meta.last_page;
          })
          .catch((err) => {
            // console.log(err)
          }).finally(() => {
      });
    },
    resetFilter(index = null) {
      this.search = {
        title: "",
        type: "all"
      };
      this.getMedia();
    }
  }
};
</script>

<style lang="scss" scoped>
.uploader {
  width: 100%;
  background: #eef5ff;
  color: #777;
  //padding: 40px 15px 102px - 30px;
  text-align: center;
  border-radius: 10px;
  //border: 1px dashed #696969 !important;
  font-size: 17px;
  position: relative;

  &.dragging {
    background: #fff;
    color: #2196f3;
    border: 1px dashed #696969 !important;

    .file-input label {
      background: #2196f3;
      color: #fff;
    }
  }

  i {
    font-size: 20px;
  }

  .file-input {
    width: 175px;
    margin: auto;
    height: 65px;
    position: relative;

    label,
    input {
      background: #2196f3;
      color: #fff;
      width: 100%;
      position: absolute;
      left: 0;
      top: 0;
      padding: 10px;
      border-radius: 4px;
      margin-top: 7px;
      cursor: pointer;
    }

    input {
      opacity: 0;
      z-index: -2;
    }
  }

  .images-preview {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    margin-top: 20px;
    margin-left: -10px;
    margin-right: -10px;
    padding: 0 10px;



    .add-btn-wrapper {
      width: 100% !important;
      border: 1px dashed;
      display: flex;
      flex-flow: column wrap;
      align-items: center;
      justify-content: center;
      order: 0 !important;
    }

    .details {
      font-size: 12px;
      background: #fff;
      color: #000;
      display: flex;
      flex-direction: column;
      align-items: self-start;
      padding: 3px 6px;

      .name {
        overflow: hidden;
        height: 18px;
        width: 100%;
      }
    }
  }

  .action-bar {
    width: 100%;
  }

  .action-bar i {
    font-size: 15px;
  }

  .upload-control {
    position: relative;
    width: 88%;
    background: #3cbd81;
    bottom: 0;
    left: 0;
    padding: 10px;
    padding-bottom: 10px;
    padding-bottom: 4px;
    top: 10px;
    margin: 0 auto;

    button,
    label {
      background: #fff;
      border: 1px solid #7b7b7b;
      border-radius: 3px;
      color: #111;
      font-size: 13px;
      cursor: pointer;
    }

    label {
      padding: 2px 5px;
      margin-right: 10px;
    }
  }
}
</style>
