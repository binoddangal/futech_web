<template>
  <v-card>
    <v-card-text>
      <div class="row">
        <div class="col-8 float-right">
          <h3>Storage setting</h3>
          <div class=" text-center" v-if="enableTest()">
            <img :src="`${this.homeRoute}/assets/images/lock.png`" alt="lock" height="200">
            <br>
            <v-btn class="btn btn-primary text-white" dark @click="removeStorageSetting">Remove</v-btn>
          </div>
        </div>
        <div class="col-4 border" v-if="enableTest()">
          <h4>Test storage</h4>
          <div class="p-3">
            <img v-if="test_path" class="img-responsive" :src="test_path" alt=""
                 width="250px" height="200px">
          </div>
          <div class="form-group mt-3">
            <v-file-input type="file" v-model="test_file" placeholder="Image" outlined dense></v-file-input>
          </div>
          <div class="text-right mt-3">
            <v-btn :loading="loading" class="btn btn-primary" @click="uploadTestImage()">Upload</v-btn>
          </div>
        </div>
      </div>
      <div class="row" v-if="!setting.display_storage">
        <div class="col-12">
          <v-select
              @change="handleStorageType()"
              :items="storage_types"
              outlined dense
              v-model="setting.storage_type"
              label="Select storage"
              item-text="title"
              item-value="value"></v-select>
        </div>
        <div v-if="setting.storage_type != 'local'">
          <div class="col-12 float-right">
            <v-text-field outlined dense v-model="setting.storage_access_key"
                          label="Storage key"></v-text-field>
          </div>
          <div class="col-12 float-right">
            <v-text-field outlined dense v-model="setting.storage_secret_key"
                          label="Storage secret key"></v-text-field>
          </div>
          <div class="col-12 float-right">
            <v-select :items="regions" outlined dense v-model="setting.storage_region"
                      label="Select region"
                      item-text="title"
                      item-value="value"></v-select>
          </div>
          <div class="col-12 float-right">
            <v-text-field outlined dense v-model="setting.storage_bucket_name"
                          label="Storage bucket"></v-text-field>
          </div>
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>
<script>
import SiteSettingService from "../../../../../services/admin/cms/site-setting/SiteSettingService";

const siteSettingService = new SiteSettingService();
export default {
  name: "Storage",
  props: ["setting", "homeRoute"],
  data() {
    return {
      loading: false,
      test_file: null,
      test_path: null,
      storage_types: [
        {title: "AWS", value: "aws"},
        {title: "Wasabi", value: "wasabi"},
        {title: "Local", value: "local"},
      ],
      aws_regions:
          [
            {title: "US East (Ohio)", value: "us-east-2"},
            {title: "US East (N. Virginia)", value: "us-east-1"},
            {title: "US West (N. California)", value: "us-west-1"},
            {title: "US West (Oregon)", value: "us-west-2"},
            {title: "Africa (Cape Town)", value: "af-south-1"},
            {title: "Asia Pacific (Hong Kong)", value: "p-east-1"},
            {title: "Asia Pacific (Mumbai)", value: "ap-south-1"},
            {title: "Asia Pacific (Osaka)", value: "ap-northeast-3"},
            {title: "Asia Pacific (Seoul)", value: "ap-northeast-2"},
            {title: "Asia Pacific (Singapore)", value: "ap-southeast-1"},
            {title: "Asia Pacific (Sydney)", value: "ap-southeast-2"},
            {title: "Asia Pacific (Tokyo)", value: "ap-northeast-1"},
            {title: "Canada (Central)", value: "ca-central-1"},
            {title: "China (Beijing)", value: "cn-north-1"},
            {title: "China (Ningxia)", value: "cn-northwest-1"},
            {title: "Europe (Frankfurt)", value: "eu-central-1"},
            {title: "Europe (Ireland)", value: "eu-west-1"},
            {title: "Europe (London)", value: "eu-west-3"},
            {title: "Europe (Milan)", value: "eu-south-1"},
            {title: "Europe (Paris)", value: "eu-west-3"},
            {title: "Europe (Stockholm)", value: "eu-north-1"},
            {title: "Middle East (Bahrain)", value: "me-south-1"},
            {title: "South America (São Paulo)", value: "sa-east-1"},
            {title: "AWS GovCloud (US-East)", value: "us-gov-east-1"},
            {title: "AWS GovCloud (US-West)", value: "us-gov-west-1"},
      ],
      wasabi_regions:
      [
          {title: "Tokyo ap-northeast-1", value: "ap-northeast-1"},
          {title: "Osaka ap-northeast-2", value: "ap-northeast-2"},
          {title: "Singapore ap-southeast-1", value: "ap-southeast-1"},
          {title: "Sydney ap-southeast-2", value: "ap-southeast-2"},
          {title: "Toronto ca-central-1", value: "ca-central-1"},
          {title: "Amsterdam eu-central-1", value: "eu-central-1"},
          {title: "Frankfurt eu-central-2", value: "eu-central-2"},
          {title: "London eu-west-1", value: "eu-west-1"},
          {title: "Paris eu-west-1", value: "eu-west-2"},
          {title: "Oregon us-west-1", value: "us-west-1"},
          {title: "Texas us-central-1", value: "us-central-1"},
          {title: "N. Virginia us-east-1", value: "s3"},
          {title: "N. Virginia us-east-2", value: "us-east-2"},

      ],
    }
  },
  methods: {

    handleStorageType()
    {
      if(this.setting.storage_type=='aws')
      {
        this.regions = this.aws_regions;
      }

      if(this.setting.storage_type=='wasabi')
      {
        this.regions = this.wasabi_regions;
      }
    },

    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.test_file = files[0]
    }, uploadTestImage() {
      this.loading = true
      let fd = new FormData();
      fd.append('file', this.test_file)
      siteSettingService.uploadTestImage(fd).then(resposne => {
        this.test_path = resposne.data.path
        this.$snotify.success("Test image has been uploaded to s3")
        this.loading = false
      }).catch(error => {
        console.log(error)
        this.loading = false
      })
    },

    enableTest() {
      return this.setting.display_storage
    },

    removeStorageSetting() {
      this.$confirm({
        message: `Are you sure you want to delete this item permanently?`,
        button: {
          no: "No",
          yes: "Yes"
        },
        /**
         * Callback Function
         * @param {Boolean} confirm
         */
        callback: confirm => {
          if (confirm) {
            this.setting.storage_type = 'local'
            this.setting.storage_bucket_name = null
            this.setting.storage_region = null
            this.setting.storage_secret_key = null
            this.setting.storage_access_key = null
            this.$emit('update_setting')
          }
        }
      });


    }
  }
}
</script>

<style scoped>

</style>
