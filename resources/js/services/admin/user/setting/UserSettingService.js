import apiService from "../../../api/api.service";

export default class UserSettingService{
    #api = null;

    constructor() {
        this.#api = 'admin/user-setting';
    }

    createOrUpdate(userId, data) {
        let url = `${this.#api}/${userId}`;
        return apiService.post(url,data)
    }

    show(userId) {
        let url = `${this.#api}/${userId}`;
        return apiService.get(url)
    }
}
