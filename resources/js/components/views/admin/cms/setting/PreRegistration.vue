<template>
  <v-app>
    <v-card flat>
      <v-card-text>
        <div class="row">
          <div class="col-12 float-right">
            <h3>Online application</h3>
          </div>
          <!--          <div class="col-12 form-group">-->
          <!--            <v-text-field outlined dense v-model="setting.offline_symbol_no_start_from"-->
          <!--                          label="Offline Symbol No Start From"></v-text-field>-->
          <!--          </div>-->
          <!--          <div class="col-12 form-group">-->
          <!--            <v-text-field outlined dense v-model="setting.offline_symbol_no_end_to"-->
          <!--                          label="Offline Symbol No End To"></v-text-field>-->
          <!--          </div>-->
          <div class="col-12 form-group">
            <v-text-field outlined dense v-model="setting.online_symbol_no_start_from"
                          label="Online symbol no. start from"></v-text-field>
          </div>
          <div class="col-6 form-group">
            <v-switch v-model="setting.enable_pre_registration" label="Show online application open"></v-switch>
          </div>
          <div class="col-6 form-group">
            <v-switch v-model="setting.is_application_otp_enabled" label="Show online application OTP"></v-switch>
          </div>
          <v-col cols="8">
            <strong>
              Online application pass message
            </strong>
            <ckeditor v-model="setting.pass_message"></ckeditor>
          </v-col>
          <v-col cols="4">
            <v-tooltip top>
              <template v-slot:activator="{ on, attrs }">
                <v-btn class="ma-2 text-lowercase" v-for="(input, i) of pass_inputs" :key="i"
                       color="success"
                       outlined
                       label
                       dark
                       v-bind="attrs"
                       v-on="on"
                       v-clipboard:copy="`{{${input}}}`"
                       v-clipboard:success="onCopy"
                       v-clipboard:error="onError">
                  {{input}}
                </v-btn>

              </template>
              <span>Copy</span>
            </v-tooltip>

          </v-col>
          <v-col cols="8">
            <strong>
              Online application fail message
            </strong>
            <ckeditor v-model="setting.fail_message"></ckeditor>
          </v-col>
          <v-col cols="4">
            <v-tooltip top>
              <template v-slot:activator="{ on, attrs }">

                <v-btn class="ma-2 text-lowercase"
                       v-for="(input, i) of fail_inputs" :key="i"
                       color="success"
                       outlined
                       label
                       dark
                       v-bind="attrs"
                       v-on="on"
                       v-clipboard:copy="`{{${input}}}`"
                       v-clipboard:success="onCopy"
                       v-clipboard:error="onError">
                  {{input}}
                </v-btn>


              </template>
              <span>Copy</span>
            </v-tooltip>

          </v-col>
        </div>
      </v-card-text>
    </v-card>
  </v-app>
</template>

<script>
export default {
  name: "pre-registration",
  props: ['setting'],
  data() {
    return {
      snackbar: false,
      pass_inputs: [
        "obtained_marks",
        "exam_status",
        "result_status",
        "interview_date",
        "interview_time",
        "symbol_no",
        "first_name",
        "last_name",
      ], fail_inputs: [
        "exam_status",
        "result_status",
        "symbol_no",
        "first_name",
        "last_name",
      ]
    }
  },
  methods: {
    onCopy: function (e) {
      this.text = "You just copied accepted input ";
      this.snackbar = true;
    },
    onError: function (e) {
      this.text = "Failed to copy accepted input";
      this.snackbar = true;
    },
  }
}
</script>

<style scoped>

</style>