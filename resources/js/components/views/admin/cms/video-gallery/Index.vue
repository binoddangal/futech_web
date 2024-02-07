<template>
  <v-app>
    <div class="row">
      <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title pt-3 px-3 d-flex justify-content-between">
                <div class="breadcrumb-left">
                  <h4> Manage video galleries</h4>
                  <div class="breadcrumb-sub-header">
                    <router-link to="/dashboard">Dashboard </router-link>\   video galleries
                  </div>
                </div>
                <div class="breadcrumb-right">
                  <div class="card-toolbar">
                    <v-btn v-if="checkIsAccessible('video-gallery','create')"
                        @click="viewCategories()"
                        text
                        x-large
                    >
                      Video gallery category
                    </v-btn>
                    <v-btn v-if="checkIsAccessible('video-gallery','create')"
                        @click="addVideo()"
                        class="mt-1 btn btn-primary"
                        style="color:#fff;"
                    >
                      <v-icon small elevation="2" outlined>fas fa-plus</v-icon>&nbsp;
                      Add video gallery
                    </v-btn>

                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">
                <v-row>
                  <div class="col-3">
                    <v-text-field label="Title"
                                  type="text"
                                  dense  v-on:keyup.enter="getVideosGallery"
                                  outlined
                                  v-model="search.title"></v-text-field>
                  </div>
                  <div class="col-2">
                    <v-select label="Status" outlined dense :items="status" item-text="title"  v-on:keyup.enter="getVideosGallery"
                              item-value="value"
                              v-model="search.active"></v-select>
                  </div>

                  <v-col cols="12" md="12" class="text-right">
                    <v-btn    v-on:keyup.enter="getVideosGallery"
                        @click="getVideosGallery()"
                        class="btn btn-primary btn-search "
                        :loading="loading"
                    >
                      <v-icon small elevation="2" outlined>mdi-magnify</v-icon>&nbsp;
                      Search
                    </v-btn>
                  </v-col>
                </v-row>
              </div>
              <div class="table-responsive">
                <v-skeleton-loader
                    type="table-thead"
                    v-if="loading"
                >
                </v-skeleton-loader>

                <v-skeleton-loader
                    v-if="loading"
                    type="table-row-divider@25"
                >
                </v-skeleton-loader>
                <table class="table">
                  <thead>
                  <tr class="px-3">
                    <th>Title</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <draggable v-show="videos.length > 0" @change="sort" v-model="videos" class="text-left" tag="tbody" handle=".handle">
                    <tr v-for="(video, index) of videos" :key="index">
                      <td scope="row">
                        <i class="cursor-drag fas fa-sort handle pr-2"></i>
                        <a href="#" @click="detail(video)" class="mr-2"> {{ video.title }}</a>&nbsp;&nbsp;
                        <i class="fas fa-circle" :class="video.is_active?'text-success':'text-danger'"></i>
                      </td>
                      <td>{{ video.category?video.category.title:"-" }}</td>

                      <td>
                        <b-dropdown
                            size="sm"
                            variant="link"
                            toggle-class="custom-v-dropdown btn btn-clean btn-hover-light-primary btn-sm btn-icon"
                            no-caret
                            right
                            no-flip
                        >
                          <template v-slot:button-content>
                            <slot>
                            <span>
                                <i class="flaticon-more-1"></i>
                            </span>
                            </slot>
                          </template>
                          <!--begin::Navigation-->
                          <div class="navi navi-hover ">

                            <b-dropdown-text tag="div" class="navi-item">
                              <a href="#" class="navi-link" @click="detail(video)" v-if="checkIsAccessible('video-gallery', 'show')">
                                <span class="navi-icon">
                                    <i class="fas fa-eye"></i>
                                </span>
                                <span class="navi-text"> View </span>
                              </a>
                            </b-dropdown-text>
                            <b-dropdown-text tag="div" class="navi-item" v-if="checkIsAccessible('video-gallery', 'edit')">
                              <a href="#" class="navi-link" @click="editVideo(video.id)">
                                <span class="navi-icon">
                                    <i class="flaticon-edit"></i>
                                </span>
                                <span class="navi-text"> Edit </span>
                              </a>
                            </b-dropdown-text>

                            <b-dropdown-text tag="div" class="navi-item" v-if="checkIsAccessible('video-gallery', 'delete')">
                              <a href="#" class="navi-link"
                                 @click="deleteVideo(video.id)">
                                    <span class="navi-icon">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                <span class="navi-text">  Delete</span>
                              </a>
                            </b-dropdown-text>

                          </div>
                          <!--end::Navigation-->
                        </b-dropdown>

                      </td>
                    </tr>
                  </draggable>
                  <tr v-if="videos.length == 0">
                    <td colspan="3" class="text-center">
                      No items added
                    </td>
                  </tr>
                </table>
                <v-pagination
                    @input="getVideosGallery" v-if="videos.length > 0"
                    v-model="page"   class="pull-right mt-7"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>
              </div>
              <div
                  class="wizard wizard-2"
                  id="kt_wizard_v2"
                  data-wizard-state="step-first"
                  data-wizard-clickable="true"
              >
                <div class="wizard-body py-8 px-8 py-lg-10 px-lg-10">
                  <!--begin: Wizard Form-->
                  <div class="row">

                  </div>
                  <div class="row">
                    <div class="col-12" v-if="total>perPage">
                      <v-pagination
                          @input="getVideosGallery"
                          v-model="page"
                          :total-rows="total"
                          :length="lastPage"
                      ></v-pagination>
                      <!--  -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <create-and-update ref="video" @refresh="getVideosGallery"></create-and-update>
            <v-dialog v-model="videoModel" max-width="600">
              <v-card>
                <v-card-title>
                  {{ video.title }}
                </v-card-title>
                <v-card-text>
                  <div v-html="video.video_html">
                  </div>
                </v-card-text>
              </v-card>
            </v-dialog>
          </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import VideoGalleryService from "../../../../../services/admin/cms/video-gallery/VideoGalleryService";
import CreateAndUpdate from "./CreateAndUpdate.vue";
import draggable from "vuedraggable";;

const videoGallery = new VideoGalleryService();
export default {
  name: "VideoGallery",
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      videos: [],
      status: [
        {title: 'Active', value: "1"},
        {title: 'In Active', value: "0"}
      ],
      page: null,
      perPage: null,
      lastPage: null,
      total: null,
      search: {
        active: "active"
      },
      videoModel: false,
      video: {},
      dragging: false,
      loading: false
    };
  },
  mounted() {
    this.getVideosGallery();
  },
  methods: {
    getVideosGallery() {
      this.loading=true;
      videoGallery
          .paginate(this.search)
          .then(response => {
            this.videos = response.data.data;
            this.page = response.data.meta.current_page;
            this.total = response.data.meta.total;
            this.perPage = response.data.meta.per_page;
            this.lastPage = response.data.meta.last_page;
            this.loading=false;
          })
          .catch(error => {
            this.loading=false;
            // console.log(error);
          });
    },
    addVideo() {
      this.$refs["video"].showModal();
    },
    editVideo(id) {
      this.$refs["video"].showModal(id);
    },

    deleteVideo(id) {
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
            videoGallery
                .delete(id)
                .then(response => {
                  this.getVideosGallery();
                })
                .catch(error => {
                  //console.log(error);
                });
          }
        }
      });
    },
    sort() {
      videoGallery.sort(this.videos).then((res) => {
        this.$snotify.success("Sorted");
        this.getVideosGallery()
      }).catch(err => {
        this.$snotify.success("Sorted Error");
      })
    },
    detail(video) {
      this.videoModel = true;
      this.video = video;
    },
    viewCategories() {
      this.$router.push('video-category')
    }
  }
};
</script>
<style scoped>
.buttons {
  margin-top: 35px;
}
</style>
