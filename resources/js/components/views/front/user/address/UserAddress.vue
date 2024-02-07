<template>
    <v-dialog max-width="800" v-model="dialog" persistent>
        <v-card>
            <v-toolbar  elevation="0">
                <v-card-title>
                    <h1> {{ `${edit ?  'Update' : 'Add' } address` }}</h1>
                </v-card-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-spacer></v-spacer>
                    <v-btn icon  @click="closeDialog">
                        <i class="fas fa-times"></i>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-card-text>
                <v-row v-if="field == 'temporary' || field == 'both'">
                    <v-col cols="12">
                        <h1>Temporary address</h1>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                            outlined
                            label="Address line 1 *"
                            v-model="temporary_address.address_line_1"
                        >
                        <template v-slot:label>
                            Address line 1 <span class="text-danger"> *</span>
                        </template>
                        </v-text-field>
                        <span class="text-danger" v-if="$v.temporary_address.address_line_1.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field outlined label="Address line 2" v-model="temporary_address.address_line_2"></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-autocomplete
                            :items="provinces"
                            item-text="title"
                            item-value="id"
                            outlined
                            v-model="temporary_address.province_id"
                            @blur="tempDistrictsByProvince"
                        >
                        <template v-slot:label>
                            Province <span class="text-danger"> *</span>
                        </template>
                        </v-autocomplete>

                        <span class="text-danger" v-if="$v.temporary_address.province_id.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">

                        <v-autocomplete
                            :items="tempDistricts"
                            item-text="title"
                            item-value="id"
                            outlined
                            v-model="temporary_address.district_id"
                            @blur="tempMunicipalitiesByDistrict"
                        >
                            <template v-slot:label>
                                District <span class="text-danger"> *</span>
                            </template>
                        </v-autocomplete>
                        <span class="text-danger" v-if="$v.temporary_address.district_id.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">

                        <v-autocomplete
                            :items="tempMunicipalities"
                            item-text="title"
                            item-value="id"
                            outlined
                            v-model="temporary_address.municipality_id"
                        >
                        <template v-slot:label>
                            Municipality <span class="text-danger"> *</span>
                        </template>
                        </v-autocomplete>

                        <span class="text-danger" v-if="$v.temporary_address.municipality_id.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field outlined  label="Ward no" v-model="temporary_address.ward_no"></v-text-field>
                        <span class="text-danger" v-if="$v.temporary_address.ward_no.$error">This information is required</span>
                    </v-col>

                    <!-- <v-col cols="6">
                        <v-text-field outlined :label="trans.get('general.ward_no_placeholder')+trans.get('general.required_field_symbol')" v-model="temporary_address.ward_no"></v-text-field>
                        <span class="text-danger" v-if="$v.temporary_address.ward_no.$error">This information is required</span>
                    </v-col> -->

                </v-row>

                <v-row v-if="field == 'permanent' || field == 'both'">
                    <v-col cols="12">
                        <v-row>
                            <v-col cols="12" md="6">
                                <h1>Permanent address</h1>
                            </v-col>
                            <v-col cols="12" md="6" class="text-right">
                                <v-btn @click="copyTemporary" dark>Same as temporary</v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                   <v-col cols="6">
                        <v-text-field outlined label="Address line 1 *" v-model="permanent_address.address_line_1">
                        </v-text-field>
                        <span class="text-danger" v-if="$v.permanent_address.address_line_1.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field outlined label="Address line 2" v-model="permanent_address.address_line_2"></v-text-field>
                    </v-col>

                    <v-col cols="6">

                        <v-autocomplete
                            :items="provinces"
                            item-text="title"
                            item-value="id"
                            outlined
                            v-model="permanent_address.province_id"
                            @blur="perDistrictsByProvince"
                        >
                        <template v-slot:label>
                            Province <span class="text-danger"> *</span>
                        </template>
                        </v-autocomplete>

                        <span class="text-danger" v-if="$v.permanent_address.province_id.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">

                        <v-autocomplete
                            :items="perDistricts"
                            item-text="title"
                            item-value="id"
                            outlined
                            @blur="perMunicipalitiesByDistrict"
                            v-model="permanent_address.district_id"
                        >
                        <template v-slot:label>
                                District <span class="text-danger"> *</span>
                            </template>
                        </v-autocomplete>

                        <span class="text-danger" v-if="$v.permanent_address.district_id.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">

                        <v-autocomplete
                            :items="perMunicipalities"
                            item-text="title"
                            item-value="id"
                            outlined
                            v-model="permanent_address.municipality_id"
                        >
                        <template v-slot:label>
                            Municipality <span class="text-danger"> *</span>
                        </template>
                        </v-autocomplete>

                        <span class="text-danger" v-if="$v.permanent_address.municipality_id.$error">This information is required</span>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field outlined  label="Ward no" v-model="permanent_address.ward_no"></v-text-field>
                        <span class="text-danger" v-if="$v.permanent_address.ward_no.$error">This information is required</span>
                    </v-col>

<!--                    <v-col cols="6">
                        <v-text-field outlined label="Postal code *" v-model="permanent_address.post_code"></v-text-field>
                        <span class="text-danger" v-if="$v.permanent_address.post_code.$error">This information is required</span>
                    </v-col>-->

                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    class="btn text-gray btn-standard"
                    depressed
                    @click="closeDialog"
                >Cancel
                </v-btn>
                <v-btn
                    class="text-white ml-2 btn btn-primary"
                    depressed
                    @click="createOrUpdate"
                    :loading="loading"
                >Update
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import AddressService from '../../../../../services/front/address/AddressService';
import UserAddressService from '../../../../../services/front/user/address/UserAddressService';

const userAddress = new UserAddressService();
const address = new AddressService();

export default {
    name: "UserAddress",
    props: ["userId"],
    data() {
        return {
            edit: false,
            loading: false,
            dialog: false,
            field: '',
            provinces: [],
            perDistricts: [],
            tempDistricts: [],
            perMunicipalities: [],
            tempMunicipalities: [],
            permanent_address: {
                'address_line_1': '',
                'address_line_2': '',
                'type': 'permanent',
                'province_id': '',
                'district_id': '',
                'municipality_id': '',
                'ward_no': '',
                'post_code': '',
            },
            temporary_address: {
                'address_line_1': '',
                'address_line_2': '',
                'type': 'temporary',
                'province_id': '',
                'district_id': '',
                'municipality_id': '',
                'ward_no': '',
                'post_code': '',
            }
        };
    },
    validations: {
        permanent_address: {
            'address_line_1': { required },
            'province_id': { required },
            'district_id': { required },
            'municipality_id': { required },
            'ward_no': { required },
        },
        temporary_address: {
            'address_line_1': { required },
            'province_id': { required },
            'district_id': { required },
            'municipality_id': { required },
            'ward_no': { required },
        }
    },

    mounted() {
        this.getAllProvince();
    },
    methods: {
        getAllAddress() {

            userAddress.paginate(this.userId).then(response => {
                this.addresses = response.data.data;

                if(this.addresses.length > 0) {
                    this.addresses.forEach(address => {
                        if(this.field == 'permanent' && address.type == 'permanent') {
                            this.permanent_address = address;
                            this.perDistrictsByProvince();
                            this.perMunicipalitiesByDistrict();
                            this.edit = true;
                        }
                        if(this.field == 'temporary' && address.type == 'temporary') {
                            this.temporary_address = address;
                            this.tempDistrictsByProvince();
                            this.tempMunicipalitiesByDistrict();
                            this.edit = true;
                        }
                    });
                } else {
                    this.edit = false;
                }

            }).catch(() => {})
        },

        openDialog(field) {
            this.dialog = true;
            this.resetForm();
            this.field = field;
            this.getAllAddress();
        },

        addOrEdit(permanent_address = null, temporary_address = null) {
            this.dialog = true;
            this.resetForm();
            this.field = 'both';
            if(permanent_address && temporary_address) {
                this.edit = true;
                this.permanent_address = permanent_address;
                this.temporary_address = temporary_address;``
            } else {
                this.edit = false;
            }
        },

        closeDialog() {
            this.dialog = false;
            this.edit = false;
            this.resetForm();
        },

        getAllProvince() {
            address.provinces().then(response => {
                this.provinces = response.data.data;
            }).catch(() => {});
        },

        perDistrictsByProvince() {
            address.districtsByProvince(this.permanent_address.province_id).then(response => {
                this.perDistricts = response.data.data;
            }).catch(() => {});
        },

        tempDistrictsByProvince() {
            address.districtsByProvince(this.temporary_address.province_id).then(response => {
                this.tempDistricts = response.data.data;
            }).catch(() => {});
        },

        perMunicipalitiesByDistrict() {
            address.municipalitiesByDistrict(this.permanent_address.district_id).then(response => {
                this.perMunicipalities = response.data.data;
            }).catch(() => {});
        },

        tempMunicipalitiesByDistrict() {
            address.municipalitiesByDistrict(this.temporary_address.district_id).then(response => {
                this.tempMunicipalities = response.data.data;
            }).catch(() => {});
        },

        copyTemporary() {
            let tempAddress = {};
            this.addresses.forEach(address => {
                if(address.type == 'temporary') {
                    this.temporary_address = address;
                }
            });
            tempAddress = this.temporary_address;
            if(tempAddress && tempAddress.id) {
                tempAddress = _.omit(tempAddress, ['id', 'type', 'type_text']);
                tempAddress.type = 'permanent';
                this.permanent_address = Object.assign(this.permanent_address, tempAddress);
                this.perDistrictsByProvince();
                this.perMunicipalitiesByDistrict();
            }
        },

        createOrUpdate() {
            this.$v.$touch();
            if (this.field=='temporary')
            {
                if (this.$v.temporary_address.$error) {
                    setTimeout(() => {
                        this.$v.temporary_address.$reset();
                    }, 3000);
                } else {

                    if (this.edit) {
                        this.updateAddress(this.temporary_address);
                    } else {
                        this.createAddress(this.temporary_address);
                    }
                }
            }

            if (this.field=='permanent')
            {
                if (this.$v.permanent_address.$error) {
                    setTimeout(() => {
                        this.$v.permanent_address.$reset();
                    }, 3000);
                } else {
                    if (this.edit) {
                        this.updateAddress(this.permanent_address);
                    } else {
                        this.createAddress(this.permanent_address);
                    }
                }
            }

        },

        createAddress(address) {
            this.loading = true;
            userAddress.createOrUpdate(this.userId, address).then(response => {
                this.loading = false;
                this.closeDialog();
                this.$emit('refresh');
                setTimeout(() => {
                    this.$emit('update-profile');
                }, 2000);
            }).catch((err) => {
                this.$snotify.error("Something Went Wrong");
                this.loading = false;
            });
        },

        updateAddress(address) {
            this.loading = true;
            userAddress.createOrUpdate(this.userId, address).then(response => {
                this.loading = false;
                this.closeDialog();
                this.$emit('refresh');
                setTimeout(() => {
                    this.$emit('update-profile');
                }, 2000);
            }).catch((err) => {
                this.$snotify.error("Something Went Wrong");
                this.loading = false;
            });
            ;
        },

        resetForm() {
            this.field = '';
            this.$v.permanent_address.$reset();
            this.$v.temporary_address.$reset();
            this.permanent_address = {
                'address_line_1': '',
                'address_line_2': '',
                'type': 'permanent',
                'province_id': '',
                'district_id': '',
                'municipality_id': '',
                'ward_no': '',
                'post_code': '',
            },
            this.temporary_address  = {
                'address_line_1': '',
                'address_line_2': '',
                'type': 'temporary',
                'province_id': '',
                'district_id': '',
                'municipality_id': '',
                'ward_no': '',
                'post_code': '',
            }
        }
    }
};
</script>
