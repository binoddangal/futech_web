import apiService from "../../../api/api.service";

export default class SiteSettingService {

    #api = null;

    constructor() {
        this.#api = `admin/site-setting`;
    }

    paginate() {
        let url = `${this.#api}`;
        return apiService.get(url);
    }

    all() {
        let url = `${this.#api}/get/all`;
        return apiService.get(url);
    }

    update(id, data) {
        let url = `${this.#api}/${id}/update`
        return apiService.post(url, data);

    }

    store(data) {
        let url = `${this.#api}`
        return apiService.post(url, data);

    }

    show() {
        let url = `${this.#api}`
        return apiService.get(url);
    }
    getColorsVariables() {
        let url = `${this.#api}/get/colors`
        return apiService.get(url);
    }

    delete(id) {
        let url = `${this.#api}/${id}`
        return apiService.delete(url);
    }

    uploadTestImage(data) {
        let url = `${this.#api}/s3/test`
        return apiService.post(url, data);
    }

    sendTestEmail(email){
        let data = {email:email};
        let url = `${this.#api}/test-email`
        return apiService.post(url, data);
    }


}
