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
          <h4>
            <a href="admin/albums" class="text-dark"
              ><i class="fas fa-arrow-left mr-3"></i
            ></a>
            Manage Photo
          </h4>
          <!--begin::Breadcrumb-->
          <ul
            class="
              breadcrumb breadcrumb-separatorless
              fw-semibold
              fs-7
              my-0
              pt-1
            "
          >
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
              <a href="admin/dashboard" class="text-primary">Dashboard</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
              <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
              <a href="admin/album" class="text-primary">Gallery</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
              <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">Images</li>
            <!--end::Item-->
          </ul>
          <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
          <!--begin::Primary button-->
          <v-btn @click="addPhoto()" class="fw-bold btn-primary btn-add"
            >Add Photo</v-btn
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
          <div class="card-body" v-if="values.length > 0">
            <draggable @change="sort" v-model="values" tag="div" class="row">
              <div class="col-3" v-for="(value, index) of values" :key="index">
                <div class="album-gallery-card cursor-pointer">
                  <img :src="value.image_path.thumb" class="img-thumbnail" />
                  <button
                    @click="deletePhoto(value.id)"
                    class="album-btn-delete"
                    title="Delete"
                  >
                    <i class="fas fa-trash"></i>
                  </button>

                  <button
                    title="feature image"
                    @click="toogleFeaturedPhoto(value)"
                    class="album-btn-feature"
                  >
                    <i class="fas fa-images"></i>
                  </button>
                  <button
                    title="feature image"
                    v-if="value.is_featured"
                    class="album-btn-feature-alt"
                  >
                    <i class="fas fa-images"></i>
                    <span class="p-3">Featured</span>
                  </button>
                </div>
              </div>
            </draggable>
          </div>

          <div class="card-body text-center" v-else>
            <h1>No photo is not avaliable</h1>
          </div>
        </div>
      </div>
      <create-and-update
        ref="add-photo"
        @refresh="getValues"
      ></create-and-update>
    </div>
  </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate.vue";
import AlbumValueService from "@/services/admin/cms/album/value/AlbumValueService";

const valueService = new AlbumValueService();
export default {
  name: "AlbumValue",
  props: ["album_id"],
  components: {
    CreateAndUpdate,
  },
  data() {
    return {
      values: [],
    };
  },

  mounted() {
    this.getValues();
  },

  methods: {
    getValues() {
      valueService
        .paginate(this.album_id)
        .then((response) => {
          this.values = response.data;
        })
        .catch(() => {});
    },
    addPhoto() {
      this.getValues();
      this.$refs["add-photo"].showModal(this.album_id);
    },
    sort() {
      valueService
        .sort(this.album_id, this.values)
        .then((res) => {
          this.$snotify.success("Sorted");
          this.getValues();
        })
        .catch((err) => {
          this.$snotify.success("Sorted Error");
        });
    },

    async deletePhoto(id) {
      this.$confirm({
        message: `Are you sure?`,
        button: {
          no: "No",
          yes: "Yes",
        },
        /**
         * Callback Function
         * @param {Boolean} confirm
         */
        callback: (confirm) => {
          if (confirm) {
            valueService
              .delete(this.album_id, id)
              .then((response) => {
                this.$snotify.success("Deleted successfully");
                this.getValues();
              })
              .catch(() => {});
          }
        },
      });
    },
    toogleFeaturedPhoto(value) {
      let data = value;
      data.is_featured = !data.is_featured;
      delete data.image_path;
      valueService.update(this.album_id, data.id, data).then((response) => {
        this.getValues();
      });
    },
  },
};
</script>

<style scoped>
.album-gallery-card {
  position: relative;
}

.album-gallery-card .album-btn-delete,
.album-gallery-card .album-btn-feature,
.album-gallery-card .album-btn-feature-alt {
  position: absolute;
  right: 8px;
  display: inline-block;
  padding: 3px 0;
  border-radius: 5px;
  border: none;
  min-width: 28px;
}

.album-gallery-card .album-btn-delete i,
.album-gallery-card .album-btn-feature i,
.album-gallery-card .album-btn-feature-alt * {
  font-size: 12px;
}

.album-gallery-card .album-btn-delete {
  top: 10px;
  background-color: #cc0000;
}

.album-gallery-card .album-btn-delete i {
  color: #fff;
}

.album-gallery-card .album-btn-feature,
.album-gallery-card .album-btn-feature-alt {
  top: 40px;
  background-color: #004c98;
}

.album-gallery-card .album-btn-feature-alt {
  padding: 3px 5px;
  top: 10px;
  left: 8px;
  right: auto;
}

.album-gallery-card .album-btn-feature i,
.album-gallery-card .album-btn-feature-alt * {
  color: #fff;
}
</style>
