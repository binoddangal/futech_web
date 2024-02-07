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
                    Manage teams
                </h4>
                <div class="breadcrumb-sub-header">
                    <a href="admin/dashboard">Dashboard </a>\ Teams
                </div>

                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <v-btn @click="createTeam" dark  class="mt-4 btn-primary  mr-1">
                    <i class="fa fa-plus"></i>
                    Add teams
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
                  <v-col cols="12" md="4">
                    <v-text-field
                        label="Title"
                        v-model="search.title"
                        v-on:keyup.enter="searchTeams"
                        @input="search.title = $event !== null ? $event : ''"
                        clearable
                        outlined
                        dense
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12" md="4">
                    <v-select
                        label="Status"
                        v-model="search.is_active"
                        v-on:keyup.enter="searchTeams"
                        @input="search.is_active = $event !== null ? $event : ''"
                        :items="status"
                        item-text="title"
                        item-value="value"
                        clearable
                        outlined
                        dense
                    ></v-select>
                  </v-col>

                  <v-col cols="12" md="4">
                    <v-btn
                        @click="searchTeams"
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
                  <th class="px-3"><strong>Title</strong></th>
                  <th class="px-3"><strong>Job title</strong></th>
                  <th class="px-3"><strong>Status</strong></th>
                  <th class="pr-3 text-center"><strong>Action</strong></th>
                </tr>
                </thead>

                <template v-if="teams.length > 0">
                    <draggable @change="sort" @end="drag = false" @start="drag = true" class="w-100"
                             tag="tbody" v-model="teams">

                        <tr v-for="(item, index) in teams" :key="index" >
                            <td class="px-3">
                                <a @click="editTeam(item)" class="text-primary font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                    <i class="fa fa-sort"></i>
                                {{ item.title }}
                                </a>
                            </td>

                            <td class="px-3">
                                {{ item.job_title  || 'N/A'}}
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
                                            @click="editTeam(item)"
                                        >
                                            <v-icon class="mx-2" color="blue darken-2" small>fas fa-edit</v-icon>
                                            <v-list-item-title>Edit</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item
                                            @click="deleteTeam(item.id)"
                                        >
                                            <v-icon class="mx-2" color="red darken-2" small>fas fa-trash</v-icon>
                                            <v-list-item-title>Delete</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>

                            </td>
                        </tr>
                    </draggable>
                </template>
                <template v-if="teams.length == 0">
                    <tr>
                      <td class="text-center font-weight-bold px-3" colspan="6">No Data Found</td>
                    </tr>
                </template>

              </table>

              <v-pagination
                  v-if="teams.length > 0"
                  class="pull-right mt-7"
                  @input="getAllTeams"
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
      <create-and-update ref="create-and-update" @refresh="getAllTeams"></create-and-update>
    </div>
  </v-app>
</template>
<script>
import CreateAndUpdate from './CreateAndUpdate.vue';
import TeamService from '@/services/admin/cms/team/TeamService';

const team = new TeamService();
export default {
  components: {
    CreateAndUpdate
  },
  data() {
    return{
      loading: false,
      isSorting: false,
      drag: false,
      total: null,
      perPage: null,
      lastPage: null,
      page: null,
      teams: [],
      search:{
        title:'',
        user_type: [],
        visible_from_date: '',
        is_active: '',
      },

      status: [
          { title: 'Active', value: '1'  },
          { title: 'Inactive', value: '0' }
      ],
    }
  },
  methods: {

    searchTeams() {
        this.page = 1;
        this.getAllTeams();
    },


    createTeam(){
      this.$refs['create-and-update'].createTeam();
    },

    editTeam(team){
      this.$refs['create-and-update'].editTeam(team);
    },

    getAllTeams(){
      this.loading = true;
        team
        .paginate(this.search, this.page)
        .then(response => {
            this.teams = response.data.data;
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

    sort() {
        this.isSorting = true;
        team
            .sort(this.teams)
            .then(response => {
            this.isSorting = false;
            this.$snotify.success('Sorted Successfully !!');
            this.getAllTeams(this.application_status);

            })
            .catch(err => {
            this.isSorting = false;
            // console.log(err)
            this.$snotify.error("Oops something went wrong");
            });
    },

    deleteTeam(id){
      this.$confirm({
        message: `Are you sure? `,
        button: {
          no: "No",
          yes: "Yes",
        },
        callback: (confirm) => {
          if (confirm) {
            team
              .delete(id)
              .then((response) => {
                this.getAllTeams()
                this.$snotify.success("Team Deleted Successfully ");
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
    this.getAllTeams();
  }
}
</script>
