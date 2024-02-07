<template>
  <v-app>
    <v-card flat>
      <v-card-text>
        <v-tabs vertical class="justify-start">
          <v-tab class="justify-start" v-if="available_providers.includes('sparrow_sms')">
            Sparrow SMS
          </v-tab>
          <v-tab class="justify-start" v-if="available_providers.includes('sms_service_nepal')">
            SMS service nepal
          </v-tab>
          <v-tab class="justify-start" v-if="available_providers.includes('sms_central')">
            The SMS central
          </v-tab>

          <v-tab-item v-if="available_providers.includes('sparrow_sms')">
            <v-card>
              <v-card-text>
                <div class="col-12 ">
                  <h3>Sparrow SMS</h3>
                </div>
                <v-row>
                  <v-col cols="12">
                    <v-text-field v-model="sparrow_sms.token" label="Token" outlined
                                  dense></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="sparrow_sms.sender" label="Sender" outlined
                                  dense></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-switch
                        v-model="sparrow_sms.is_active"
                        label="Status"
                    >Status
                    </v-switch>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    class="text-white float-right btn btn-primary"
                    depressed
                    @click="createOrUpdate(sparrow_sms, 'sparrow_sms')"
                    :loading="isBusy"
                >Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-tab-item>
          <v-tab-item v-if="available_providers.includes('sms_service_nepal')">
            <v-card>
              <v-card-text>
                <div class="col-12 ">
                  <h3>SMS service nepal</h3>
                </div>
                <v-row>
                  <v-col cols="12">
                    <v-text-field v-model="sms_service_nepal.token" label="Token" outlined
                                  dense></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="sms_service_nepal.sender" label="Sender" outlined
                                  dense></v-text-field>
                  </v-col>

                  <v-col cols="12">
                    <v-switch
                        v-model="sms_service_nepal.is_active"
                        label="Status"
                    >Status
                    </v-switch>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    class="text-white float-right btn btn-primary"
                    depressed
                    @click="createOrUpdate(sms_service_nepal, 'sms_service_nepal')"
                    :loading="isBusy"
                >Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-tab-item>
          <v-tab-item v-if="available_providers.includes('sms_central')">
            <v-card>
              <v-card-text>
                <div class="col-12 ">
                  <h3>SMS central</h3>
                </div>
                <v-row>
                  <v-col cols="12">
                    <v-text-field v-model="sms_central.token" label="Token" outlined
                                  dense></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="sms_central.sender" label="Sender" outlined
                                  dense></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-switch
                        v-model="sms_central.is_active"
                        label="Status"
                    >Status
                    </v-switch>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    class="text-white float-right btn btn-primary"
                    depressed
                    @click="createOrUpdate(sms_central,'sms_central')"
                    :loading="isBusy"
                >Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-tab-item>

          <v-tab-item v-if="available_providers.includes('offline')">
            <v-card flat>
              <v-card-text>
                <div class="col-12 ">
                  <h3>Offline Payment Instruction</h3>
                  <p>This will be displayed as payment instruction for offline
                    payment.</p>
                </div>
                <v-col cols="12" xl="12" md="12">
                  <v-text-field v-model="offline.title" label="Title" outlined dense></v-text-field>
                </v-col>
                <v-col cols="12" xl="12" md="12">
                  <v-textarea v-model="offline.description" label="Description" outlined dense></v-textarea>
                </v-col>
                <v-col cols="12">
                  <v-switch
                      v-model="offline.is_active"
                      label="Status"
                  >Status
                  </v-switch>
                </v-col>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    class="text-white float-right btn btn-primary"
                    depressed
                    @click="createOrUpdate(offline, 'offline')"
                    :loading="isBusy"
                >Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-tab-item>
        </v-tabs>
      </v-card-text>
    </v-card>
  </v-app>
</template>

<script>
// import OptionService from "@/core/services/option/OptionService";
import SmsProviderService from "../../../../../services/admin/cms/site-setting/sms-provider/SmsProviderService";

const smsProviderService = new SmsProviderService();
// const optionService = new OptionService();
export default {
  name: "SmsProvider",
  components: {}, data() {
    return {
      dialog: false,
      available_providers: [],
      providers: [],
      sparrow_sms: {},
      sms_service_nepal: {},
      sms_central: {},
    }
  }, mounted() {
    this.getAll()
    this.getAvailableGateways()
  }, methods: {
    // getAvailableGateways() {
    //   optionService.getByKey('AVAILABLE_SMS_PROVIDER').then(response => {
    //     let value = response.data.value
    //     if (value)
    //       this.available_providers = value.split(",")
    //   })
    // },
    getAll() {
      smsProviderService.all().then(response => {
        this.providers = response.data
        this.providers.forEach(ele => {
          switch (ele.type) {
            case 'sparrow_sms':
              this.sparrow_sms = ele
              break;
            case 'sms_service_nepal':
              this.sms_service_nepal = ele
              break;
            case 'sms_central':
              this.sms_central = ele
              break;
          }
        })
      })
    }, createOrUpdate(provider, type) {
      if (provider.id)
        this.update(provider);
      else{
        provider.type = type
        this.create(provider);
      }
    },
    create(provider) {
      this.isBusy = true
      smsProviderService.store(provider).then(response => {
        this.$snotify.success("Payment Gateway cred")
        this.getAll()
      }).catch(error => {
        // console.log(error)
      }).finally(this.isBusy = false);
    }, update(provider) {
      this.isBusy = true
      smsProviderService.update(provider.id, provider).then(response => {
        this.$snotify.success("Payment Gateway updated")
        this.getAll()
      }).catch(error => {
        // console.log(error)
      }).finally(this.isBusy = false);
    },
  }
}
</script>

<style scoped>

</style>
