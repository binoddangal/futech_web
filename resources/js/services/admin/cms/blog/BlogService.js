import apiService from "../../../api/api.service";

export default class BlogService {

    #api = null;

    constructor() {
        this.#api = `admin/blog`;
    }
    paginate(data, index = null) {
        let url = `${this.#api}`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param ={
            params: data
        }
        return apiService.query(url, param);
  }

  update(id, data) {
        let url = `${this.#api}/${id}/update`
        return apiService.post(url, data);

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


