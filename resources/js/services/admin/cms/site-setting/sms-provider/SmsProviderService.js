import apiService from "../../../../api/api.service";

export default class SmsProviderService {

    #api = null;

    constructor() {
        this.#api = `admin/sms-provider/setting`;
    }

    paginate() {
        let url = `${this.#api}`;
        return apiService.get(url);
    }

    all() {
        let url = `${this.#api}`;
        return apiService.get(url);
    }

    update(id, data) {
        let url = `${this.#api}/${id}`
        return apiService.put(url, data);

    }

    store(data) {
        let url = `${this.#api}`
        return apiService.post(url, data);

    }

    show(id) {
        let url = `${this.#api}/${id}`
        return apiService.get(url);
    }

    delete(id) {
        let url = `${this.#api}/${id}`
        return apiService.delete(url);
    }
}
