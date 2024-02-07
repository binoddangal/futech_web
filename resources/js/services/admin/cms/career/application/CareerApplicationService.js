import apiService from "@/services/api/api.service";




export default class CareerApplicationService {

    #api;
    constructor() {
        this.#api = `admin/career-application`;
    }

    paginate(data,page = 1) {

        let url = `${this.#api}`;
        if (data != null && data != undefined && data != "") {
            var queryString = Object.keys(data).map((key) => {
                return encodeURIComponent(key) + '=' + encodeURIComponent(data[key])
            }).join('&');
            url = url + '?' + queryString;
            if (page)
                url = url + "&page=" + page
        } else {
            url = url + "?page=" + page
        }
        return apiService.get(url);

    }

    all() {
        let url = `${this.#api}/get/all`;
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
