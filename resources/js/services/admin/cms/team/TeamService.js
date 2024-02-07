import apiService from "../../../api/api.service";

export default class TeamService {

    #api = null;

    constructor() {
        this.#api = 'admin/team';
    }

    paginate(data={},index = null) {
        let url = `${this.#api}`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param ={
            params: data
        }
        return apiService.query(url,param);
    }

    sort(data=[]){
        let url = `${this.#api}/get/sort`;
        return apiService.post(url, data);
    }

    show(id){
        let url = `${this.#api}/${id}`
        return apiService.get(url)
    }

    update(id, data) {
        let url = `${this.#api}/${id}`
        return apiService.post(url, data)
    }

    create(data) {
        let url = `${this.#api}`
        return apiService.post(url, data)
    }

    delete(id) {
        let url = `${this.#api}/${id}`
        return apiService.delete(url);
    }
}
