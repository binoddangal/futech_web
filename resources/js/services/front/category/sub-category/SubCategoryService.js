import apiService from "../../../api/api.service";

export default class SubCategoryService {

    #api = null;

    constructor() {
        this.#api = `user/sub-category`;
    }

    getAllSubCategory(categoryId) {
        let url = `${this.#api}/${categoryId}`
        return apiService.get(url);
    }
}
