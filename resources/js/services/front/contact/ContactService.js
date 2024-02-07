import apiService from "../../api/api.service";

export default class ContactService {
    #api = null;

    constructor() {
        this.#api = 'user/contact-us';
    }

    store(data) {
        let url = `${this.#api}`;
        return apiService.post(url, data);
    }
}
