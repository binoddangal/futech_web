<template>
  <v-app>
    <div class="pt-5 p-3">
      <div class="row">
        <div class="col-md-4">
          <VueNestable
            v-if="nestableHeaderItems"
            @change="sortNow(nestableHeaderItems)"
            v-model="nestableHeaderItems"
            :max-depth="2"
            key-prop="id"
            children-prop="nested"
          >
            <template slot-scope="{ item }">
              <!-- Handler -->
              <VueNestableHandle :item="item">
                <i class="fas fa-bars"></i>
              </VueNestableHandle>

              <!-- Content -->
              <span>{{ item.title }}</span>
              <span class="btn-group">
                <a @click.prevent="edit(item)">
                  <i class="fas fa-edit"></i>
                </a>
                <a @click.prevent="deleteMenu(item.id)">
                  <i class="ml-2 fas fa-trash"></i>
                </a>
              </span>
            </template>
          </VueNestable>
        </div>
        <div class="col-md-8">
          <v-app>
            <v-card raised v-if="selectedMenu != null">
              <v-card-title>Edit Menu</v-card-title>
              <v-card-text>
                <v-row>
                  <v-col cols="4">
                    <v-list two-line>
                      <v-list-item-group
                        v-model="editSelected"
                        active-class="green--text"
                      >
                        <template>
                          <v-list-item
                            v-for="(item, index) in options"
                            :key="index"
                            @click="changeSelectedType(item.value)"
                          >
                            <template v-slot:default="{}">
                              <v-list-item-content>
                                <v-list-item-title
                                  v-text="item.title"
                                ></v-list-item-title>
                              </v-list-item-content>
                            </template>
                          </v-list-item>
                        </template>
                      </v-list-item-group>
                    </v-list>
                  </v-col>
                  <v-col cols="8">
                    <v-select
                      v-if="editSelected == 0"
                      :items="pages"
                      item-text="title"
                      item-value="id"
                      v-model="selectedMenu.page_id"
                      label="Select Page to add"
                      outlined
                      dense
                    ></v-select>
                    <v-select
                      v-if="editSelected == 1"
                      :items="blogs"
                      item-text="title"
                      item-value="id"
                      v-model="selectedMenu.blog_id"
                      label="Select Blog to add"
                      outlined
                      dense
                    ></v-select>
                    <!-- <v-select
                            v-if="editSelected == 2"
                            :items="events"
                            item-text="title"
                            item-value="id"
                            v-model="selectedMenu.event_id"
                            label="Select Events to add"
                            outlined
                            dense
                        ></v-select>
                        <v-select
                            v-if="editSelected == 3"
                            :items="news"
                            item-text="title"
                            item-value="id"
                            v-model="selectedMenu.news_id"
                            label="Select News to add"
                            outlined
                            dense
                        ></v-select>
                        <v-select
                            v-if="editSelected == 4"
                            :items="programs"
                            item-text="title"
                            item-value="id"
                            v-model="selectedMenu.program_id"
                            label="Select Programs to add"
                            outlined
                            dense
                        ></v-select>
                        <v-select
                            v-if="editSelected == 5"
                            :items="downloads"
                            item-text="title"
                            item-value="id"
                            v-model="selectedMenu.download_id"
                            label="Select Download to add"
                            outlined
                            dense
                        ></v-select>
                        <v-select
                            v-if="editSelected == 6"
                            :items="downloads_types"
                            item-text="title"
                            item-value="id"
                            v-model="selectedMenu.download_type_id"
                            label="Select Download Type to add"
                            outlined
                            dense
                        ></v-select> -->
                    <v-text-field
                      v-model="selectedMenu.title"
                      outlined
                      dense
                      label="Menu Title"
                    ></v-text-field>
                    <v-text-field
                      v-if="editSelected == 2"
                      v-model="selectedMenu.link"
                      outlined
                      dense
                      label="Menu Link"
                    ></v-text-field>
                    <v-radio-group
                      v-model="selectedMenu.new_tab"
                      outlined
                      dense
                    >
                      <template v-slot:label>
                        <div>
                          <strong>Tab Control</strong>
                        </div>
                      </template>
                      <v-radio :value="0">
                        <template v-slot:label>
                          <div>Open in same tab</div>
                        </template>
                      </v-radio>
                      <v-radio :value="1">
                        <template v-slot:label>
                          <div>Open in new tab</div>
                        </template>
                      </v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions class="justify-end">
                <v-btn color="purple" @click="reset" class="text-white"
                  >Back</v-btn
                >
                <v-btn color="primary" @click="updateMenuItem"
                  >Update to menu</v-btn
                >
              </v-card-actions>
            </v-card>
            <v-card raised v-else>
              <v-card-title>
                <span class="headline">Add Menu Item</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" md="4" sm="12">
                      <v-list two-line>
                        <v-list-item-group
                          v-model="selected"
                          active-class="green--text"
                        >
                          <template>
                            <v-list-item
                              v-for="(item, index) in options"
                              :key="index"
                              @click="changeType(item.value)"
                            >
                              <template v-slot:default="{}">
                                <v-list-item-content>
                                  <v-list-item-title
                                    v-text="item.title"
                                  ></v-list-item-title>
                                </v-list-item-content>
                              </template>
                            </v-list-item>

                            <!-- <v-divider v-if="index + 1 < options.length" :key="index"></v-divider> -->
                          </template>
                        </v-list-item-group>
                      </v-list>
                    </v-col>
                    <v-col cols="12" md="8" sm="12">
                      <v-select
                        v-if="selected == 0"
                        :items="pages"
                        item-text="title"
                        item-value="id"
                        return-object
                        @change="setNewMenu(newMenuType)"
                        v-model="newMenuType"
                        label="Select Page to add"
                        outlined
                        dense
                      ></v-select>
                      <v-select
                        v-if="selected == 1"
                        :items="blogs"
                        return-object
                        @change="setNewMenu(newMenuType)"
                        item-text="title"
                        item-value="id"
                        v-model="newMenuType"
                        label="Select Blog to add"
                        outlined
                        dense
                      ></v-select>

                      <v-text-field
                        v-model="newMenu.title"
                        outlined
                        dense
                        label="Menu Name"
                      ></v-text-field>
                      <v-text-field
                        v-if="selected == 2"
                        v-model="newMenu.link"
                        outlined
                        dense
                        label="Link"
                      ></v-text-field>
                      <v-radio-group v-model="newMenu.new_tab" outlined dense>
                        <template v-slot:label>
                          <div>
                            <strong>Tab Control</strong>
                          </div>
                        </template>
                        <v-radio :value="0">
                          <template v-slot:label>
                            <div>Open link in same tab</div>
                          </template>
                        </v-radio>
                        <v-radio :value="1">
                          <template v-slot:label>
                            <div>Open link in new tab</div>
                          </template>
                        </v-radio>
                      </v-radio-group>
                    </v-col>
                  </v-row>
                  <div class="form-block">
                    <v-card-text></v-card-text>
                  </div>
                  <!-- <pre>{{attribute_object}}</pre> -->
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="btn-primary" text @click.prevent="addMenu"
                  >Add to menu
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-app>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import draggable from "vuedraggable";
import { VueNestable, VueNestableHandle } from "vue-nestable";
import PageService from "@/services/admin/cms/page/PageService";
import BlogService from "@/services/admin/cms/blog/BlogService";
import MenuService from "@/services/admin/cms/menu/MenuService";
import MenuItemService from "@/services/admin/cms/menu/MenuItemService";

const pageService = new PageService();
const blogService = new BlogService();
const menuService = new MenuService();
const menuItemService = new MenuItemService();

export default {
  name: "MenuItem",
  props: ["menu_id"],
  components: {
    draggable,
    VueNestable,
    VueNestableHandle,
  },
  data() {
    return {
      videos: [],
      pages: [],
      programs: [],
      downloads: [],
      downloads_types: [],
      menus: [],
      tab: 0,
      nestableItems: [
        {
          blog_id: 33,
          depth: null,
          download_id: null,
          event_id: null,
          id: 2,
          is_active: true,
          key: 1,
          link: null,
          menu_id: 2,
          menu_location_type: null,
          menu_type: "blog",
          new_tab: 0,
          news_id: null,
          page_id: null,
          parent_id: null,
          position: null,
          program_id: null,
          title:
            "DNA Barcoding - A Molecular Approach in Forensics and Conservation",
        },
        {
          blog_id: 33,
          depth: null,
          download_id: null,
          event_id: null,
          id: 2,
          is_active: true,
          key: 2,
          link: null,
          menu_id: 2,
          menu_location_type: null,
          menu_type: "blog",
          new_tab: 0,
          news_id: null,
          page_id: null,
          parent_id: null,
          position: null,
          program_id: null,
          title: "DNA ",
        },
      ],
      selected: 0,
      editSelected: 0,
      selectedMenu: null,
      newMenuType: null,
      header_menu: null,
      footer_menu: null,
      blogs: [],
      events: [],
      news: [],
      blogCategories: [],

      options: [
        { title: "Page", value: "page" },
        { title: "Blog Post", value: "blog" },
        // { title: "Events", value: "event" },
        // { title: "News", value: "news" },
        // { title: "Downloads", value: "downloads" },
        // { title: "Downloads Type", value: "downloads_type" },
        { title: "Custom Link", value: "custom_link" },
      ],
      newMenu: {
        parent_id: null,
        page_id: null,
        blog_id: null,
        event_id: null,
        shop_category_id: null,
        product_id: null,
        title: null,
        link: null,
        position: null,
        depth: null,
        is_active: 1,
        new_tab: 0,
        menu_type: "page",
      },
      selectedCatalogId: null,
      selectedBlocCategoryId: null,

      addMenudialog: false,
      menuItem: [
        {
          id: null,
          menu_id: null,
          parent_id: null,
          title: null,
          link: null,
          position: null,
          depth: null,
          type: null,
          is_active: null,
          new_tab: 0,
          menu_type: null,
          created_at: null,
        },
      ],
      sortValueBy: "ORDER_SELECTED",
      valueConsistsOf: "ALL_WITH_INDETERMINATE",
      catalogsOptions: [],
      nestableHeaderItems: [],
      nestableFooterItems: [],
      dragging: false,
      blog_search: {
        category_id: null,
        type: "",
        active: "active",
      },
    };
  },

  mounted() {
    this.newMenu.menu_id = this.menu_id;
    this.getMenu();
    this.getMenuItems();
    this.getPages();
    this.getBlogs();
    // this.getEvents();
    // this.getNews();
    // this.getDownloads();
    // this.getDownloadTypes();
  },
  methods: {
    getMenu() {
      menuService
        .paginate(this.search)
        .then((response) => {
          this.menus = response.data.data;
        })
        .catch((error) => {});
    },
    getMenuItems() {
      menuItemService
        .getMenuItemsByMenuId(this.menu_id)
        .then((res) => {
          this.nestableHeaderItems = res.data.menuItem;
        })
        .catch((error) => {});
    },

    getPages(type) {
      pageService
        .paginate(this.search)
        .then((response) => {
          this.pages = response.data.data;
          this.page = response.data.meta.current_page;
          this.total = response.data.meta.total;
          this.perPage = response.data.meta.per_page;
          this.lastPage = response.data.meta.last_page;
        })
        .catch((error) => {});
    },
    getBlogs() {
      this.blog_search.type = "blog";
      blogService
        .paginate(this.blog_search)
        .then((response) => {
          this.blogs = response.data.data;
        })
        .catch((error) => {
          // console.log(error);
        });
    },
    // getDownloads() {
    //     downloadService
    //         .all()
    //         .then(response => {
    //             this.downloads = response.data.data;
    //         })
    //         .catch(error => {
    //             // console.log(error);
    //         });
    // },
    // getDownloadTypes() {
    //     typeService.paginate().then((response) => {
    //         this.downloads_types = response.data;
    //     });
    // },
    // getEvents() {
    //     this.blog_search.type = 'event'
    //     blogService
    //         .paginate(this.blog_search)
    //         .then(response => {
    //             this.events = response.data.data;
    //         })
    //         .catch(error => {
    //             // console.log(error);
    //         });
    // },
    // getNews() {
    //     this.blog_search.type = 'news'
    //     blogService
    //         .paginate(this.blog_search)
    //         .then(response => {
    //             this.news = response.data.data;
    //         })
    //         .catch(error => {
    //             // console.log(error);
    //         });
    // },
    changeType(type) {
      this.newMenu.menu_type = type;
      this.newMenu.title = "";
    },
    addMenuForm() {
      this.selectedMenu = null;
    },
    opoenDialog() {
      this.addMenudialog = true;
    },
    closeDialog() {
      this.addMenudialog = false;
    },
    edit(item) {
      switch (item.menu_type) {
        case "page":
          this.editSelected = 0;
          break;
        case "blog":
          this.editSelected = 1;
          break;
        case "event":
          this.editSelected = 2;
          break;
        case "news":
          this.editSelected = 3;
          break;
        case "programs":
          this.editSelected = 4;
          break;
        case "downloads":
          this.editSelected = 5;
          break;
        case "custom_link":
          this.editSelected = 6;
          break;
        default:
          this.editSelected = 0;
      }
      this.selectedMenu = item;
    },

    setNewMenu(item) {
      if (this.newMenu.menu_type == "event") {
        this.newMenu.event_id = item.id;
      } else if (this.newMenu.menu_type == "news") {
        this.newMenu.shop_category_id = item.id;
      } else if (this.newMenu.menu_type == "blog") {
        this.newMenu.blog_id = item.id;
      } else if (this.newMenu.menu_type == "programs") {
        this.newMenu.program_id = item.id;
      } else if (this.newMenu.menu_type == "downloads") {
        this.newMenu.download_id = item.id;
      } else if (this.newMenu.menu_type == "downloads_type") {
        this.newMenu.download_type_id = item.id;
      } else {
        this.newMenu.page_id = item.id;
      }
      this.newMenu.title = item.title;
      this.newMenuType = null;
    },
    changeSelectedType(type) {
      this.selectedMenu.menu_type = type;
    },
    updateMenuItem() {
      this.selectedMenu.new_tab = Number(this.selectedMenu.new_tab);
      menuItemService
        .update(this.selectedMenu.id, this.selectedMenu)
        .then((res) => {
          this.$snotify.success("Updated  Successfully!");
          this.resetMenuItem();
          this.getMenu();
          this.getMenuItems();
        });
    },
    addMenu() {
      this.newMenu.new_tab = Number(this.newMenu.new_tab);
      menuItemService.store(this.newMenu).then((res) => {
        this.resetMenuItem();
        this.$snotify.success("Menu added");
        this.getMenu();
        this.getMenuItems();
      });
    },
    resetMenuItem() {
      this.newMenuType = this.newMenu.menu_type;
      this.newMenu = {
        menu_id: this.menu_id,
        parent_id: null,
        page_id: null,
        blog_id: null,
        events_id: null,
        shop_category_id: null,
        product_id: null,
        title: null,
        link: null,
        position: null,
        depth: null,
        is_active: 1,
        new_tab: 0,
        menu_type: this.newMenuType,
      };
    },

    deleteMenu(id) {
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
            menuItemService
              .delete(id)
              .then((response) => {
                this.getMenuItems();
              })
              .catch((error) => {
                //console.log(error);
              });
          }
        },
      });
    },
    reset() {
      this.selectedMenu = null;
    },
    sortNow(nestableItems) {
      menuItemService
        .sort(this.menu_id, nestableItems)
        .then((response) => {
          if (response.data.status === "OK") {
            this.$snotify.success("Sorted");
            this.getMenu();
            this.getMenuItems();
          } else {
            this.$snotify.error("Error");
          }
        })
        .catch((error) => {});
    },
    sort() {
      videoGallery
        .sort(this.videos)
        .then((res) => {
          this.$snotify.success("Sorted");
          this.getVideosGallery();
        })
        .catch((err) => {
          this.$snotify.success("Sorted Error");
        });
    },
  },
};
</script>
<style scoped>
.buttons {
  margin-top: 35px;
}

.v-application ul,
.v-application ol,
.b-dropdown-text {
}
</style>

    <style lang="scss" scope>
/*
    * Style for nestable
    */

.nestable {
  position: relative;
}

.nestable-rtl {
  direction: rtl;
}

.nestable .nestable-list {
  margin: 0;
  padding: 0 0 0 40px !important;
  list-style-type: none;
}

.nestable-rtl .nestable-list {
  padding: 0 40px 0 0;
}

.nestable > .nestable-list {
  padding: 0;
}

.nestable-item,
.nestable-item-copy {
  margin: 10px 0 0;
}

.nestable-item:first-child,
.nestable-item-copy:first-child {
  margin-top: 0;
}

.nestable-item .nestable-list,
.nestable-item-copy .nestable-list {
  margin-top: 10px;
}

.nestable-item {
  position: relative;
}

.nestable-item.is-dragging .nestable-list {
  pointer-events: none;
}

.nestable-item.is-dragging * {
  opacity: 0;
  filter: alpha(opacity=0);
}

.nestable-item.is-dragging:before {
  content: " ";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(106, 127, 233, 0.274);
  border: 1px dashed rgb(73, 100, 241);
  -webkit-border-radius: 5px;
  border-radius: 5px;
}

.nestable-drag-layer {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  pointer-events: none;
}

.nestable-rtl .nestable-drag-layer {
  left: auto;
  right: 0;
}

.nestable-drag-layer > .nestable-list {
  position: absolute;
  top: 0;
  left: 0;
  padding: 0;
  background-color: rgba(106, 127, 233, 0.274);
}

.nestable-rtl .nestable-drag-layer > .nestable-list {
  padding: 0;
}

.nestable [draggable="true"] {
  cursor: move;
}

.nestable-handle {
  display: inline;
}

.nestable-item .btn-group {
  float: right;
}

.nestable-item .nestable-item-content,
.kt-portlet__body ol.nestable-list .nestable-item-content {
  color: black;
  font-weight: bold;
  padding: 1rem 2rem;
  border-radius: 5px;
  background: #eceff0;
}

.nestable-handle {
  margin-right: 10px;
  cursor: grabbing !important;
}

.nestable-handle span {
  font-weight: bold !important;
}
</style>
