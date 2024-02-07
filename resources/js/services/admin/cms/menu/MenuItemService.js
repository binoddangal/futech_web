import apiService from "../../../api/api.service";

export default class MenuItemService {

    #api = null;

    constructor() {
        this.#api = `admin/menu-item`;
    }

    paginate(data = {}, index = null) {
        let url = `${this.#api}`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param ={
            params: data
        }
        return apiService.query(url,param);
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
    getMenuItemsByMenuId(id) {
        let url = `${this.#api}/${id}/menu`
        return apiService.get(url);
    }

    sort(menuId, data) {
        let url = `${this.#api}/${menuId}/sort`
        return apiService.post(url, data);

    }



    delete(id) {
        let url = `${this.#api}/${id}`
        return apiService.delete(url);
    }
}
