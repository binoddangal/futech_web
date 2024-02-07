import apiService from "../../../../api/api.service";

export default class ItemService {

    #api = null;

    constructor() {
        this.#api = `user/item`;
    }

    search(data = {}) {
        let url = `${this.#api}`;
        let params = {
            params: data
        }
        return apiService.query(url, params);
    }

    getAllItem(data = {}) {
        let url = `${this.#api}`;
        let params = {
            params: data
        }
        return apiService.query(url, params);
    }
}
