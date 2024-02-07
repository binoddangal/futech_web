import apiService from "@/services/api/api.service";

export default class DashboardService {
    #api = null;

    constructor() {
        this.#api = `admin/dashboard`;
    }

    getStats() {
        let url = `${this.#api}/stats`
        return apiService.post(url);
    }
}
