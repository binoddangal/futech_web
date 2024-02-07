import apiService from "../../api/api.service";

export default class OptionService {
    #api = null;

    constructor() {
        this.#api = `admin/option`;
    }

    getByKey(key) {
        let url = `${this.#api}/${key}`;
        return apiService.get(url);
    }

}
