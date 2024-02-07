import apiService from "../../api/api.service";

export default class ResponseService {

    #api = null;

    constructor() {
        this.#api = `user/response`;
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
        return apiService.put(url,data);

    }

    store(data) {
        let url = `${this.#api}`
        return apiService.post(url, data);

    }

    show(requestId) {
        let url = `${this.#api}/${requestId}`
        return apiService.get(url);
    }

    delete(id) {
        let url = `${this.#api}/${id}`
        return apiService.delete(url);
    }
}
