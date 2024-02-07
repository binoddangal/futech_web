import apiService from "../../api/api.service";

export default class AddressService {
    #api = null;

    constructor() {
        this.#api = 'user/address';
    }

    provinces() {
        let url = `${this.#api}/province`;
        return apiService.get(url)
    }

    districtsByProvince(provinceId) {
        let url = `${this.#api}/${provinceId}/district`;
        return apiService.get(url)
    }

    municipalitiesByDistrict(districtId) {
        let url = `${this.#api}/${districtId}/municipality`;
        return apiService.get(url)
    }
}
