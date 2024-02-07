import apiService from "../../../api/api.service";

export default class CareerService {

    #api;
    constructor() {
        this.#api = `admin/career`;
    }

    paginate(data = null, index = 1) {
        let url = `${this.#api}`;
        if (data != null && data != undefined && data != "") {
            var queryString = Object.keys(data).map((key) => {
                if (data[key] && data[key] != null)
                    return encodeURIComponent(key) + '=' + encodeURIComponent(data[key])
            }).join('&');
            url = url + '?' + queryString;
        }
        if (index != null && !queryString)
            url = url + '?' + "page=" + (index);
        else
            url = url + '&' + "page=" + (index);
        return apiService.get(url);
    }

    all() {
        let url = `${this.#api}-all`;
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
