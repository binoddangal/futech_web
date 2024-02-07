<template>
  <v-app>
      <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
          <!--begin::Toolbar container-->
          <div
              id="kt_app_toolbar_container"
              class="app-container container-fluid d-flex flex-stack"
          >
              <!--begin::Page title-->
              <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                  <!--begin::Title-->
                  <h4>
                      Manage galleries
                  </h4>
                  <div class="breadcrumb-sub-header">
                      <a href="admin/dashboard">Dashboard </a>\ Galleries
                  </div>

                  <!--end::Breadcrumb-->
              </div>
              <!--end::Page title-->
              <!--begin::Actions-->
              <div class="d-flex align-items-center gap-2 gap-lg-3">


                  <!--begin::Primary button-->
                  <v-btn @click="addAlbum()" dark  class="mt-4 btn-primary  mr-1">
                      <i class="fa fa-plus"></i>
                      Add album
                  </v-btn
                  >
                  <!--end::Primary button-->
              </div>
              <!--end::Actions-->
          </div>
          <!--end::Toolbar container-->
      </div>


    <div class="row">
      <div class="col-12">
        <div class="card">
        <div class="card-body ">
            <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">
                <div class="row">
                    <div class="col-6">
                        <v-text-field
                          label="Title"
                          outlined
                          dense
                          clearable
                          v-on:keyup.enter="getAlbums()"
                          v-model="search.title"/>
                    </div>
                    <div class="col-4">
                        <v-select label="Status" outlined dense :items="status"

                                  item-text="title" v-on:keyup.enter="getAlbums()"
                                  item-value="value"
                                  v-model="search.is_active"></v-select>
                    </div>
                    <div class="col-2">
                        <v-btn
                            @click.prevent="getAlbums()"
                            class="btn btn-search float-right"
                            :loading="loading"
                            dark
                        >
                            <v-icon small elevation="2" outlined>mdi-magnify</v-icon>&nbsp;
                            Search
                        </v-btn>
                    </div>
                </div>
            </div>
          <div class="table-responsive">
            <v-skeleton-loader
                v-if="loading"
                type="table-thead"
            >
            </v-skeleton-loader>

            <v-skeleton-loader
                v-if="loading"
                type="table-row-divider@25"
            >
            </v-skeleton-loader>
              <table class="table" v-if="!loading">
                <thead>
                  <tr class="px-3">
                      <th>Title</th>
                    <th class="pr-3 text-center">Action</th>
                  </tr>
                </thead>
                <tbody v-if="albums.length > 0">
                  <tr v-for="(album, index) of albums" :key="index">
                    <td>
                      <i class="cursor-drag fas fa-sort handle pr-2"></i>
                      <a @click="detail(album.id)" class="mr-2"> {{ album.title }}</a>&nbsp;
                      <i class="fas fa-circle"
                         :class="album.is_active ? 'text-success' : 'text-danger'"></i>
                    </td>

                    <td class="pr-0 text-center">
                      <v-menu offset-y>
                              <template v-slot:activator="{ on, attrs }">
                                  <v-btn
                                      color="primary"
                                      text
                                      icon
                                      v-bind="attrs"
                                      v-on="on"
                                  >
                                      <v-icon>mdi-dots-horizontal</v-icon>
                                  </v-btn>
                              </template>
                              <v-list>
                                  <v-list-item
                                      @click="detail(album.id)"
                                  >
                                      <v-icon class="mx-2" color="blue darken-2" small>fas fa-eye</v-icon>
                                      <v-list-item-title>View</v-list-item-title>
                                  </v-list-item>

                                  <v-list-item
                                      @click="editAlbum(album)"
                                  >
                                      <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                      <v-list-item-title>Edit</v-list-item-title>
                                  </v-list-item>

                                  <v-list-item
                                      @click="deleteAlbum(album.id)"
                                  >
                                      <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                      <v-list-item-title>Delete</v-list-item-title>
                                  </v-list-item>
                              </v-list>
                          </v-menu>
                      <template>
                    </template>
                    </td>
                  </tr>
                </tbody>
                <tbody v-if="albums.length == 0">
                  <tr>
                    <td class="px-3 text-center" colspan="3">Items not found.</td>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
        <create-and-update ref="album" @refresh_album="getAlbums"></create-and-update>
      </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import AlbumService from '@/services/admin/cms/album/AlbumService';
import CreateAndUpdate from "./CreateAndUpdate.vue";

const albumService = new AlbumService();
export default {
  name: "Album",
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      albums: [],
      page: null,
      lastPage: null,
      perPage: null,
      total: null,
      dragging: false,
      loading: false,
      status: [
        { title: "Active", value: "1" },
        { title: "In Active", value: "0" }
      ],
      search: {
        title: "",
        is_active: "",
      }
    };
  },
  mounted() {
    this.getAlbums();
  },
  methods: {
    getAlbums() {
      this.loading=true;
      albumService
          .paginate(this.search, this.page)
          .then(response => {
            this.albums = response.data.data;
            this.page = response.data.meta.current_page;
            this.total = response.data.meta.total;
            this.perPage = response.data.meta.per_page;
            this.lastPage = response.data.meta.last_page;
            this.loading = false;
          })
          .catch(error => {
            this.loading = false;
          });
    },
    addAlbum() {
      this.$refs["album"].showModal();
    },
    editAlbum(album) {
      this.$refs["album"].showModal(album);
    },

    deleteAlbum(id) {
      this.$confirm({
        message: `Are you sure?`,
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
            albumService
                .delete(id)
                .then(response => {
                  this.getAlbums();
                })
                .catch(error => {
                  //console.log(error);
                });
          }
        }
      });
    },
    checkMove: function(evt){
      console.log(evt)
      let futureIndex= (parseInt(evt.draggedContext.futureIndex) +1);
      let item= evt.draggedContext.element;
      let itemId = item.id;
    this.sort(itemId, futureIndex)
    },
    sort(id, index) {
      albumService.sort(id, index).then((res) => {
        this.$snotify.success("Sorted");
        this.getAlbums()
      }).catch(err => {
        this.$snotify.success("Sorted Error");
      })
    },
    detail(id) {
        window.location.href = window.location.origin + "/admin/album/" + id + "/photos";
    }
  }
};
</script>
<style scoped>
.buttons {
  margin-top: 35px;
}
</style>
