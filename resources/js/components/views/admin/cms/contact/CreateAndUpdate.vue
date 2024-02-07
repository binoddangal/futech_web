<template>
  <v-app>
      <v-dialog v-model="dialog" max-width="800" persistent>
          <v-card>
              <v-card-title>
                  Online Inquiry
              </v-card-title>
              <v-card-text>
                  <v-row>
                      <v-col
                              md="12"
                              sm="12"
                              lg="12"
                              xs="12"
                              cols="12"
                      ><b>Full Name:</b> {{message.first_name}} {{message.last_name}}</v-col>
                      <v-col md="12" sm="12" lg="12" xs="12" cols="12"><b>Phone:</b> {{message.phone}}</v-col>
                      <v-col md="12" sm="12" lg="12" xs="12" cols="12"><b>Email:</b> {{message.email}}</v-col>
                      <v-col md="12" sm="12" lg="12" xs="12" cols="12"><b>Subject:</b> {{message.subject}}</v-col>
                      <v-col cols="12">
                          Message:
                          <p v-html="message.message"></p>
                      </v-col>
                  </v-row>
                  <hr />
                  <div class="row">
                      <!--        <div class="col-12 mt-3">-->
                      <!--          <h3>Actions</h3>-->
                      <!--          <hr />-->
                      <!--        </div>-->
                      <div class="col-3">
                          <v-switch
                                  v-model="message.is_read"
                                  label="Marked as Read">
                          </v-switch>
                      </div>
                      <div class="col-3">
                          <v-switch
                                  v-model="message.replied"
                                  label="Marked as Replied">
                          </v-switch>

                      </div>
                      <div class="col-12 text-right">
                          <v-btn class="btn btn-primary text-white" @click="updateContactus">Save</v-btn>
                          <v-btn class="btn btn-standard mr-2" @click="hideModal">Cancel</v-btn>

                      </div>
                  </div>
              </v-card-text>
          </v-card>
      </v-dialog>

  </v-app>
</template>
<script>
import ContactService from "../../../../../services/admin/cms/contact/ContactService";

const contact = new ContactService();

export default {
  name: "CreateAndUpdate",
  data() {
    return {
        dialog: false,
        levels: [],
        message: {}
    };
  },
  methods: {
    getMessage(id) {
      contact.show(id).then(response => {
        this.message = response.data.contact;
        this.message.is_active ? (this.message.is_active = true) : false;
      });
    },

    showModal(id) {
        this.getMessage(id);
        this.dialog = true;
    },

    hideModal() {
      this.dialog = false;
      this.message = {};
    },

    updateContactus() {
      contact.update(this.message.id, this.message).then(response => {
        this.hideModal();
        this.$emit("refresh");
      });
    }
  }
};
</script>
