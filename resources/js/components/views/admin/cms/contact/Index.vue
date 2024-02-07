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
                      Manage lead & inquires
                  </h4>
                  <div class="breadcrumb-sub-header">
                      <a href="admin/dashboard">Dashboard </a>\ Lead & inquires
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
              <div class="search-wrapper border-outline mb-5 px-3 pt-3 d-sm-flex justify-content-start">
                <v-row>
                    <v-col cols="12" md="3">
                        <v-text-field
                          label="Name, Email, Subject, Phone"
                          type="text"
                          outlined
                          dense
                          v-on:keyup.enter="getMessages()"
                          v-model="search.title"
                          placeholder="Name, Email, Subject, Phone"
                        />
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-menu
                            v-model="menu2"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="search.publish_date_from"
                                label="From Date"
                                v-bind="attrs" v-on:keyup.enter="getMessages()"
                                v-on="on"
                               outlined
                               dense
                            ></v-text-field>
                            </template>
                            <v-date-picker
                              no-title
                              v-model="search.publish_date_from"
                              @input="menu2 = false"
                            ></v-date-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="search.publish_date_to"
                                label="To Date"
                                v-bind="attrs" v-on:keyup.enter="getMessages()"
                                v-on="on"
                                outlined
                                dense
                            ></v-text-field>
                            </template>
                            <v-date-picker
                              no-title
                              v-model="search.publish_date_to"
                              @input="menu = false"
                            ></v-date-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" md="3" >
                        <v-select
                            v-model="search.filter_by"
                            :items="[
                                {text:'Read',value:'read'},
                                {text:'Replied',value:'replied'},
                                {text:'Download',value:'download'},
                                'read','replied','download']"
                            item-value="value"
                            item-text="text"
                            v-on:keyup.enter="getMessages()"
                            label="Filter By"
                           outlined
                           dense
                        >
                        </v-select>
                    </v-col>
                    <v-col cols="12" class="mb-3">
                        <v-btn
                            @click.prevent="getMessages()"
                            class="btn btn-primary btn-block w-35 float-right"
                            :loading="loading"
                            dark
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
                    v-if="isLoading"
                >
                </v-skeleton-loader>

                <v-skeleton-loader
                    v-if="isLoading"
                    type="table-row-divider@25"
                >
                </v-skeleton-loader>
                <table class="table table-responsive">
                  <thead>
                  <th>Date</th>
                  <th>Full name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Replied</th>
                  <th>Action</th>
                  </thead>
                  <tbody v-if="contacts.length > 0">
                    <tr v-for="(message, index) of contacts" :key="index">
                        <td><a href="#" @click="openDialog(message.id)">{{message.date}}</a> </td>

                        <td>{{message.first_name}} {{message.last_name}}</td>

                        <td>{{message.email}}</td>

                        <td>{{message.phone}}</td>

                        <td>
                            <span class="badge badge-info" v-if="message.is_read">READ</span>
                            <span class="badge badge-danger" v-else>NOT READ</span>
                        </td>

                        <td>
                            <span class="badge badge-info" v-if="message.replied">REPLIED</span>
                            <span class="badge badge-danger" v-else>NOT REPLIED</span>
                        </td>

                        <td>
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
                                      @click="openDialog(message.id)"
                                  >
                                      <v-icon class="mx-2" color="blue darken-2" small>fas fa-eye</v-icon>
                                      <v-list-item-title>View</v-list-item-title>
                                  </v-list-item>
                              </v-list>
                          </v-menu>
                        </td>
                    </tr>

                  </tbody>
                  <tbody  v-if="contacts.length == 0">
                    <tr>
                        <td class="px-3 text-center" colspan="7" style="background-color: #8a8a8a17;">Items not found.</td>
                    </tr>
                  </tbody>
                </table>
                <v-pagination
                    :disabled="isLoading"
                    v-if="contacts.length >0"
                    @input="getMessages"
                    v-model="page"
                    :total-rows="total"
                    :length="lastPage"
                ></v-pagination>
              </div>
            </div>
            <Message ref="message" @refresh="getMessages"></Message>
          </div>
      </div>
    </div>
  </v-app>
</template>
<script>
import Message from "./CreateAndUpdate.vue";
import ContactService from '@/services/admin/cms/contact/ContactService';

const contact = new ContactService();

export default {
  name: "Contact",
  components: {
    Message
  },
  data() {
    return {
      isLoading:false,
      menu2:false,
      menu:false,
      contacts: [],
      message_id: null,
      search: {},
      page: null,
      total: null,
      perPage: null,
      lastPage: null,
      loading:false,
    };
  },
  mounted() {
    this.getMessages();
  },
  methods: {
    getMessages() {
      this.isLoading = true;
      contact.paginate(this.search, this.page).then(response => {
        this.contacts = response.data.data;
        this.page = response.data.meta.current_page;
        this.total = response.data.meta.total;
        this.perPage = response.data.meta.per_page;
        this.lastPage = response.data.meta.last_page;
        this.isLoading = false;
      }).catch(()=>{
        this.isLoading = false;
      });
    },

    openDialog(id = null) {
      this.$refs["message"].showModal(id);
    },

    closeDialog(id) {
      this.message_id = id;
      this.$refs["message"].hideModal();
      this.getMessages();
    },

    // exportData() {
    //   let url = API_URL + "user/resources-download-export-csv"

    //   if (this.search) {
    //     let query = new URLSearchParams(this.search).toString();
    //     if (query)
    //       url = url + '?' + query;
    //   }
    //   window.open(url)
    // }

  }
};
</script>
