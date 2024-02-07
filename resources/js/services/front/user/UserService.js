import apiService from "../../api/api.service";

export default class UserService{
    #api = null;

    constructor() {
        this.#api = 'user/users';
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
        let url = `${this.#api}/${id}`;
        return apiService.get(url)
    }

    update(id, data) {
        let url = `${this.#api}/${id}`;
        return apiService.post(url, data)
    }

    store(data) {
        let url = `${this.#api}`;
        return apiService.post(url, data);
    }

    delete(id) {
        let url = `${this.#api}/${id}`;
        return apiService.delete(url)
    }

    changePassword(id, data) {
        let url = `${this.#api}/${id}/change-password`;
        return apiService.post(url, data)
    }

    requestMfaAuthenticator() {
        let url = `${this.#api}/get/mfa-authenticator`
        return apiService.post(url);
    }

    activateMfaAuthenticator(data) {
        let url = `${this.#api}/activate/mfa-authenticator`
        return apiService.post(url, data);
    }

    deActivateMfaAuthenticator() {
        let url = `${this.#api}/deactivate/mfa-authenticator`
        return apiService.post(url);
    }

    activateEmailVerificationCode() {
        let url = `${this.#api}/activate/email-authenticator`
        return apiService.post(url);
    }

    deActivateEmailVerificationCode(data) {
        let url = `${this.#api}/deactivate/email-authenticator`
        return apiService.post(url, data);
    }
}
