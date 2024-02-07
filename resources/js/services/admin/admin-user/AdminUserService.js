import apiService from "../../api/api.service";


export default class AdminUserService{
    #api = null;

    constructor() {
        this.#api = 'admin/admin-user';
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

    store(data) {
        let url = `${this.#api}`;
        return apiService.post(url, data);
    }

    update(id, data) {
        let url = `${this.#api}/${id}`;
        return apiService.put(url, data)
    }

    delete(id) {
        let url = `${this.#api}/${id}`;
        return apiService.delete(url)
    }

    getByUserType(userType, data = {}) {
        let url = `${this.#api}/get/all/${userType}`;
        let param = {
            params: data
        }
        return apiService.query(url, param)
    }

    checkPasswordReset(data)
    {
        let url = `${this.#api}/check/reset/password`;
        return apiService.post(url,data)
    }

    changePassword(id, data)
    {
        let url = `${this.#api}/${id}/change-password`;
        return apiService.post(url,data)
    }

    checkUniqueEmail(data)
    {
        let url = `${this.#api}/check/email`;
        return apiService.post(url,data)
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

    requestEmailVerificationCode(data) {
        let url = `${this.#api}/request/verification-code`
        return apiService.post(url, data);
    }
}
