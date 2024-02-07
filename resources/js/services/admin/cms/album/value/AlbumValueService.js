import apiService from "../../../../api/api.service";

export default class AlbumValueService {

    #api = null;

    constructor() {
        this.#api = `admin/album`;
    }

    paginate(id, data = {} , index = null) {
        let url = `${this.#api}/${id}/value`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param ={
            params: data
        }
        return apiService.query(url,param);
    }

    update(id,valueId,  data) {
        let url = `${this.#api}/${id}/value/${valueId}/update`
        return apiService.post(url, data);

    }

    store(id, data) {
        let url = `${this.#api}/${id}/value`;
        return apiService.post(url, data);

    }
    sort(id, data) {
        let url = `${this.#api}/${id}/value/sort`;
        return apiService.post(url, data);
    }

    show(id) {
        let url = `${this.#api}/${id}/value/${id}`
        return apiService.get(url);
    }

    delete(albumId, id) {
        let url = `${this.#api}/${albumId}/value/${id}`
        return apiService.delete(url);
    }
}
