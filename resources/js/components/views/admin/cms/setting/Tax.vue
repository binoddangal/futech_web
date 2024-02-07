<template>
  <v-app>
    <v-card flat>
      <v-card-text>
        <div class="row">
          <div class="col-12 float-right">
            <h3>Tax setting</h3>
          </div>
          <div class="col-12 form-group">
            <v-text-field outlined dense v-model="setting.tax_percentage" label="Tax percentage"></v-text-field>
          </div>
          <div class="col-12 form-group">
            <v-text-field outlined dense v-model="setting.vat_no" label="Vat no."></v-text-field>
          </div>
          <div class="col-12 form-group">
            <v-text-field outlined dense v-model="setting.pan_no" label="Pan no."></v-text-field>
          </div>
          <div class="col-12 form-group">
            <v-text-field outlined dense v-model="setting.company_name" label="Company name"></v-text-field>
          </div>
        </div>
      </v-card-text>
    </v-card>
  </v-app>
</template>

<script>
export default {
  name: "Tax",
  props: ['setting']
}
</script>

<style scoped>

</style>