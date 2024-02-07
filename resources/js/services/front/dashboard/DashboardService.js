import apiService from "@/services/api/api.service";

export default class DashboardService {
    #api = null;

    constructor() {
        this.#api = `user`;
    }

    getStats() {
        let url = `${this.#api}/stats`
        return apiService.post(url);
    }
}
