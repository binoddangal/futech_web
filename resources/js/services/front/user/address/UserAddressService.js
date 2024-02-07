import apiService from "../../../api/api.service";

export default class UserAddressService {
    #api = null;

    constructor() {
        this.#api = 'user/user';
    }

    paginate(userId, data = {} , index = null) {
        let url = `${this.#api}/${userId}/address`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param ={
            params: data
        }
        return apiService.query(url,param);
    }

    show(userId, id) {
        let url = `${this.#api}/${userId}/address/${id}`;
        return apiService.get(url)
    }

    createOrUpdate(userId, data) {
        let url = `${this.#api}/${userId}/address`;
        return apiService.post(url, data);
    }

    delete(userId, id) {
        let url = `${this.#api}/${userId}/address/${id}`;
        return apiService.delete(url)
    }
}
