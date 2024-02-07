import apiService from "../../api/api.service";

export default class CareerService {
    #api = null;

    constructor() {
        this.#api = 'user/career';
    }

    store(data) {
        let url = `${this.#api}`;
        return apiService.post(url, data);
    }
}
