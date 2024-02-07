<template>
  <v-app>
    <v-card flat>
      <v-card-text>
        <v-card-text>

          <v-tabs vertical class="justify-start">
            <v-tab class="justify-start" v-if="available_gateways.includes('esewa')">
              Esewa
            </v-tab>
            <v-tab class="justify-start" v-if="available_gateways.includes('khalti')">
              Khalti
            </v-tab>
            <v-tab class="justify-start" v-if="available_gateways.includes('connect_ips')">
              Connect IPS
            </v-tab>
            <v-tab class="justify-start" v-if="available_gateways.includes('offline')">
              Offline Payment
            </v-tab>

            <v-tab-item v-if="available_gateways.includes('esewa')">
              <v-card>
                <v-card-text>
                  <div class="col-12 ">
                    <h3>Esewa</h3>
                  </div>
                  <v-row>
                    <v-col cols="12">
                      <v-text-field v-model="esewa.merchant_id" label="Merchant Id" outlined
                                    dense></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-switch
                          v-model="esewa.is_active"
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
                      @click="createOrUpdate(esewa, 'esewa')"
                      :loading="isBusy"
                  >Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-tab-item>
            <v-tab-item v-if="available_gateways.includes('khalti')">
              <v-card>
                <v-card-text>
                  <div class="col-12 ">
                    <h3>Khalti</h3>
                  </div>
                  <v-row>
                    <v-col cols="12">
                      <v-text-field v-model="khalti.public_key" label="Public key" outlined
                                    dense></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field v-model="khalti.private_key" label="Private key" outlined
                                    dense></v-text-field>
                    </v-col>

                    <v-col cols="12">
                      <v-switch
                          v-model="khalti.is_active"
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
                      @click="createOrUpdate(khalti, 'khalti')"
                      :loading="isBusy"
                  >Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-tab-item>
            <v-tab-item v-if="available_gateways.includes('connect_ips')">
              <v-card>
                <v-card-text>
                  <div class="col-12 ">
                    <h3>Connect IPS</h3>
                  </div>
                  <v-row>
                    <v-col cols="12">
                      <v-text-field v-model="connect_ips.app_id" label="App ID" outlined dense></v-text-field>

                    </v-col>

                    <v-col cols="12">
                      <v-text-field v-model="connect_ips.app_name" label="App name" outlined dense></v-text-field>


                    </v-col>
                    <v-col cols="12">
                      <v-text-field v-model="connect_ips.user_name" label="Username" outlined
                                    dense></v-text-field>

                    </v-col>
                    <v-col cols="12">
                      <v-text-field type="password" v-model="connect_ips.password" label="Password" outlined
                                    dense></v-text-field>


                    </v-col>
                    <v-col cols="12">
                      <v-text-field type="password" v-model="connect_ips.pfx_password"
                                    label="Certificate password" outlined
                                    dense></v-text-field>


                    </v-col>

                    <v-col cols="12">
                      <v-switch
                          v-model="connect_ips.is_active"
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
                      @click="createOrUpdate(connect_ips,'connect_ips')"
                      :loading="isBusy"
                  >Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-tab-item>

            <v-tab-item v-if="available_gateways.includes('offline')">
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

      </v-card-text>

    </v-card>
  </v-app>
</template>

<script>
import PaymentGatewaySettingService from "@/services/admin/cms/site-setting/payment-gateway/PaymentGatewaySettingService";
import OptionService from "@/services/admin/option/OptionService";

const paymentGatewayService = new PaymentGatewaySettingService();
const optionService = new OptionService();
export default {
  name: "PaymentGateway",
  data() {
    return {
      isBusy: false,
      payment_gateways: [],
      available_gateways: [],
      esewa: {},
      khalti: {},
      connect_ips: {},
      offline: {},
    }
  },
  mounted() {
    this.getAll()
    this.getAvailableGateways()
  },
  methods: {
    getAvailableGateways() {
      optionService.getByKey('AVAILABLE_GATEWAYS').then(response => {
        let value = response.data
        if (value)
          this.available_gateways = value.split(",")
      })
    },
    createNew() {
      this.dialog = true
    }, closeDialog() {
      this.dialog = false
      this.isBusy = false
      this.getAll()
    },
    getAll() {
      paymentGatewayService.all().then(response => {
        this.payment_gateways = response.data
        this.payment_gateways.forEach(ele => {
          switch (ele.type) {
            case 'esewa':
              this.esewa = ele
              break;
            case 'khalti':
              this.khalti = ele
              break;
            case 'connect_ips':
              this.connect_ips = ele
              break;
            case 'offline':
              this.offline = ele
              break;
          }
        })
      })
    },
    createOrUpdate(payment_gateway, type) {
      if (payment_gateway.id)
        this.update(payment_gateway);
      else {
        payment_gateway.type = type
        this.create(payment_gateway);
      }
    },
    create(payment_gateway) {
      this.isBusy = true
      paymentGatewayService.store(payment_gateway).then(response => {
        this.$snotify.success("Payment Gateway cred")
        this.getAll()
      }).catch(error => {
        // console.log(error)
      }).finally(this.isBusy = false);
    }, update(payment_gateway) {
      this.isBusy = true
      paymentGatewayService.update(payment_gateway.id, payment_gateway).then(response => {
        this.$snotify.success("Payment Gateway updated")
        this.getAll()
      }).catch(error => {
        // console.log(error)
      }).finally(this.isBusy = false);
    },
  }
}
</script>
