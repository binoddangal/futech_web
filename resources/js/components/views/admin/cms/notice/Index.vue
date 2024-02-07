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
                    Manage notices
                </h4>
                <div class="breadcrumb-sub-header">
                    <a href="admin/dashboard">Dashboard </a>\ Notices
                </div>

                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <v-btn @click="createNotice()" dark  class="mt-4 btn-primary  mr-1">
                    <i class="fa fa-plus"></i>
                    Add notice
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
          <div class="card-body">
            <div class="search-wrapper border-outline mb-5 px-3 py-5 d-sm-flex justify-content-start">
                <v-row>
                  <v-col cols="12" md="3">
                    <v-text-field
                        label="Name"
                        v-model="search.name"
                        v-on:keyup.enter="searchNotices"
                        @input="search.name = $event !== null ? $event : ''"
                        clearable
                        outlined
                        dense
                    ></v-text-field>
                  </v-col>

                  <!-- <v-col cols="12" md="3">
                    <v-select
                        label="User Type"
                        item-text="title"
                        item-value="value"
                        :items="user_types"
                        v-model="search.user_type"
                        v-on:keyup.enter="searchNotices"
                        @input="search.user_type = $event !== null ? $event : ''"
                        multiple
                        small-chips
                        deletable-chips
                        outlined
                        dense
                    >
                      <template v-slot:prepend-item>
                        <v-list-item
                            ripple
                            @click="allSelect"
                        >
                          <v-list-item-action>
                            <v-icon :color="search.user_type.length > 0 ? 'indigo darken-4' : ''">
                              {{ icon }}
                            </v-icon>
                          </v-list-item-action>
                          <v-list-item-content>
                            <v-list-item-title>
                              Select All
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mt-1"></v-divider>
                      </template>
                    </v-select>
                  </v-col> -->

                  <v-col cols="12" md="3">
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="search.visible_from_date"
                            v-on:keyup.enter="searchNotices"
                            label="Visible From Date"
                            readonly
                            clearable
                            autofocus
                            outlined
                            dense
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                          v-model="search.visible_from_date"
                          outlined
                          dense
                          no-title
                          @input="menu = false"
                      >
                      </v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-select
                        label="Status"
                        v-model="search.is_active"
                        v-on:keyup.enter="searchNotices"
                        @input="search.is_active = $event !== null ? $event : ''"
                        :items="status"
                        item-text="name"
                        item-value="value"
                        clearable
                        outlined
                        dense
                    ></v-select>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-btn
                        @click="searchNotices"
                        class="mt-1 btn btn-primary float-right"
                        style="color: #fff;"
                        :loading="loading"
                    >
                      <v-icon small  elevation="2" outlined>fas fa-search</v-icon>&nbsp;
                      Search
                    </v-btn>
                  </v-col>
                </v-row>
            </div>
            <!-- table -->
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
                  <th class="px-3" :class="sortedClass('name')" @click="sortBy('name')"><strong>Name</strong></th>
                  <!-- <th class="px-3"><strong>User Type</strong></th> -->
                  <th class="px-3"><strong>Visible From Date</strong></th>
                  <th class="px-3"><strong>Status</strong></th>
                  <th class="pr-3 text-center"><strong>Action</strong></th>
                </tr>
                </thead>

                <tbody>
                    <tr v-for="(item, index) in notices" :key="index" >
                      <td class="px-3">
                        <a @click="editNotice(item)" class="text-primary font-weight-bolder text-hover-primary mb-1 font-size-lg">
                          {{ item.name }}
                        </a>
                      </td>
                      <!-- <td class="px-3">
                        <ul v-if="item.user_types">
                          <li v-for="(user,index) in item.user_types" :key="index">
                            {{ user }}
                          </li>
                        </ul>
                        <span class="font-weight-bolder text-dark-65" v-else>
                          N/A
                        </span>
                      </td> -->

                      <td class="px-3">
                        {{ item.formatted_date != null ? item.formatted_date : '--' }}
                      </td>

                      <td class="px-3">
                        <span class="badge badge-success text-lg"
                              v-bind:class="{ 'badge-success': item.is_active, 'badge-danger': !item.is_active }"
                          >{{ item.is_active ? 'Active' : 'Inactive' }}</span>
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
                                    @click="editNotice(item)"
                                >
                                    <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                    <v-list-item-title>Edit</v-list-item-title>
                                </v-list-item>

                                <v-list-item
                                    @click="deleteNotice(item.id)"
                                >
                                    <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                    <v-list-item-title>Delete</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                      </td>
                    </tr>
                    <tr v-if="notices.length == 0">
                      <td class="text-center font-weight-bold px-3" colspan="6">No Data Found</td>
                    </tr>
                </tbody>

              </table>
              <v-pagination
                  v-if="notices.length > 0"
                  class="pull-right mt-7"
                  @input="getAllNotices"
                  v-model="page"
                  :disabled="loading"
                  :total-rows="total"
                  :length="lastPage"
              ></v-pagination>
            </div>
            <!-- table ends -->
          </div>
        </div>
      </div>
      <create-and-update ref="create-and-update" @refresh="getAllNotices"></create-and-update>
    </div>
  </v-app>
</template>
<script>
import CreateAndUpdate from "./CreateAndUpdate";
import NoticeService from "@/services/admin/cms/notice/NoticeService";

const notice = new NoticeService();
export default {
  components: {
    CreateAndUpdate,
  },
  data() {
    return{
      loading: false,
      menu: false,
      total: null,
      perPage: null,
      lastPage: null,
      page: null,
      notices:[],
      search:{
        name:'',
        user_type: [],
        visible_from_date: '',
        is_active: '',
      },
      sort: {
        key: '',
        isAsc: false
      },
      user_types: [
          { name: "Home Page", value: "homepage" },
          { name: "Beneficiaries", value: "beneficiaries" },
        ],
      status: [
          { name: 'Active', value: '1'  },
          { name: 'Inactive', value: '0' }
      ],
    }
  },
  computed: {
    sortedItems() {
      const list = this.notices.slice();
      if (!!this.sort.key) {
        list.sort((a, b) => {
          a = a[this.sort.key]
          b = b[this.sort.key]
          return (a === b ? 0 : a > b ? 1 : -1) * (this.sort.isAsc ? 1 : -1)
        });
      }
      return list;
    },
    allSelectType () {
      return this.search.user_type.length === this.user_types.length
    },
    selectType () {
      return this.search.user_type.length > 0 && !this.allSelectType
    },
    icon () {
      if (this.allSelectType) return 'mdi-close-box'
      if (this.selectType) return 'mdi-minus-box'
      return 'mdi-checkbox-blank-outline'
    },
  },
  methods: {
    sortedClass(key) {
      return this.sort.key === key ? `sorted ${this.sort.isAsc ? 'asc' : 'desc'}` : '';
    },
    sortBy(key) {
      this.sort.isAsc = this.sort.key === key ? !this.sort.isAsc : false;
      this.sort.key = key;
    },
    createNotice(){
      this.$refs['create-and-update'].createNotice();
    },
    editNotice(notice){
      this.$refs['create-and-update'].editNotice(notice);
    },
    resetSearch(){
      this.search = {};
      this.getAllNotices();
    },
    allSelect () {
      this.$nextTick(() => {
        if (this.allSelectType) {
          this.search.user_type = []
        } else {
          this.search.user_type = [];
          this.user_types.forEach(type => {
            this.search.user_type.push(type.value);
          });
        }
      })
    },
    getAllNotices(){
      this.loading = true;
        notice
        .paginate(this.search, this.page)
        .then(response => {
            this.notices = response.data.data;
            this.page = response.data.meta.current_page;
            this.total = response.data.meta.total;
            this.perPage = response.data.meta.per_page;
            this.lastPage = response.data.meta.last_page;
            this.loading = false;
        })
        .catch((err) => {
          this.loading = false;
          this.$snotify.error("Oops something went wrong");
        });
    },
    searchNotices(){
      this.getAllNotices();
    },
    deleteNotice(id){
      this.$confirm({
        message: `Are you sure? `,
        button: {
          no: "No",
          yes: "Yes",
        },
        callback: (confirm) => {
          if (confirm) {
            notice
              .delete(id)
              .then((response) => {
                this.getAllNotices()
                this.$snotify.success("Notice Deleted Successfully ");
              })
              .catch((err) => {
                this.$snotify.error("Oops something went wrong");
              });
            }
        }
      });
    }
  },
  mounted() {
    this.getAllNotices();
  }
}
</script>
<style lang="sass">
table
  th.sorted
    &.asc::after
      display: inline-block
      content: '▼'
      color: red

    &.desc::after
      display: inline-block
      content: '▲'
      color: red

</style>
