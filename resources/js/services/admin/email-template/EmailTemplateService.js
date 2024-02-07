import apiService from "@/services/api/api.service";

export default class EmailTemplateService {
    #api = null;

    constructor() {
        this.#api = `admin/email-template`;
    }

    paginate(data, index = null) {
        let url = `${this.#api}`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param = {
            params: data
        }
        return apiService.query(url, param);
    }

    emailTemplateRoles() {
        let url = `${this.#api}-roles`
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

    clone(data){
        let url = `${this.#api}/clone`
        return apiService.post(url, data);
    }
}
