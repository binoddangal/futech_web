import apiService from "../../../api/api.service";

export default class SliderService {

    #api = null;

    constructor() {
        this.#api = `admin/slider`;
    }

    paginate(data = {}, index=null) {
    let url = `${this.#api}`;
    if (index != null)
        url = `${url}?page=${index}`;
    let param ={
        params: data
    }
    return apiService.query(url,param);
    }

    all() {
        let url = `${this.#api}`;
        return apiService.get(url);
    }

    update(id, data) {
        let url = `${this.#api}/${id}/update`
        return apiService.post(url, data);

    }

    store(data) {
        let url = `${this.#api}`
        return apiService.post(url, data);

    }
    sort( data) {
        let url = `${this.#api}/sort`;
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
