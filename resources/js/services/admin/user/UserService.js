import apiService from "../../api/api.service";

export default class UserService{
    #api = null;

    constructor() {
        this.#api = 'admin/user';
    }

    paginate(data = {} , index = null) {
        let url = `${this.#api}`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param ={
            params: data
        }
        return apiService.query(url,param);
    }
    show(id) {
        let url = `${this.#api}/${id}/show`;
        return apiService.get(url)
    }

    update(id, data) {
        let url = `${this.#api}/${id}`;
        return apiService.put(url, data)
    }

    store(data) {
        let url = `${this.#api}`;
        return apiService.post(url, data);
    }

    delete(id) {
        let url = `${this.#api}/${id}`;
        return apiService.delete(url)
    }

    approvedOrRejectedUser(id, data) {
        let url = `${this.#api}/${id}/approved-or-rejected`;
        return apiService.post(url, data);
    }

    exportVolunteer(data){
        let url = `${this.#api}/export/volunteer`;
        if (data != null && data != "") {
            let queryString = Object.keys(data).map((key) => {
                return encodeURIComponent(key) + '=' + encodeURIComponent(data[key])
            }).join('&');
            url = url + '?' + queryString;

        }
        window.open(url, "_blank");
    }
}
