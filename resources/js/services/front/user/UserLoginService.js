import apiService from "../../api/api.service";


export default class UserLoginService{
    #api = null;

    constructor() {
        this.#api = 'user';
    }

    checkUserType(data) {
        let url = `${this.#api}/check/user-type`;
        return apiService.post(url,data)
    }

    checkVerificationEnabled(data){
        let url = `${this.#api}/check/verification-enabled`;
        return apiService.post(url,data)
    }

    checkMfaVerificationCode(data)
    {
        let url = `${this.#api}/verify/mfa-verification-code`;
        return apiService.post(url,data)
    }

    checkEmailVerificationCode(data)
    {
        let url = `${this.#api}/verify/email-verification-code`;
        return apiService.post(url,data)
    }

    login(data)
    {
        let url = `${this.#api}/login`;
        return apiService.post(url,data)
    }

    requestPasswordReset(data)
    {
        let url = `${this.#api}/reset-password`;
        return apiService.post(url,data)
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

    doPasswordReset(data)
    {
        let url = `${this.#api}/do-reset/password`;
        return apiService.post(url,data)
    }

    checkUniqueEmail(data)
    {
        let url = `${this.#api}/check/email`;
        return apiService.post(url,data)
    }

    register(data)
    {
        let url = `${this.#api}/do-register`;
        return apiService.post(url,data)
    }

    verifyUser(data)
    {
        let url = `${this.#api}/email/verify`;
        return apiService.post(url,data)
    }

    resendVerificationEmail(data)
    {
        let url = `${this.#api}/resend/email/verification`;
        return apiService.post(url,data)
    }

    requestMfaAuthenticator() {
        let url = `${this.#api}/mfa-authenticator`
        return apiService.get(url);
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

    recoverAccount(data) {
        let url = `${this.#api}/recover-account`
        return apiService.post(url, data);
    }

    getAuthUser(){
        let url = `${this.#api}/auth/user`;
        return apiService.get(url)
    }
}
