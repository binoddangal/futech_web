import apiService from "../../api/api.service";

export default class CategoryService {

    #api = null;

    constructor() {
        this.#api = `user/category`;
    }

    all() {
        let url = `${this.#api}`
        return apiService.get(url);
    }

}
