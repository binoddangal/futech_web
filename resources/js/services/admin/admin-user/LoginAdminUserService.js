import apiService from "../../api/api.service";


export default class LoginAdminUserService{
    #api = null;

    constructor() {
        this.#api = 'admin';
    }

    checkUserType(data) {
        let url = `${this.#api}/check/user-type`;
        return apiService.post(url,data)
    }

    show(id) {
        let url = `${this.#api}/${id}/show`;
        return apiService.get(url)
    }


    updateProfile(id, data) {
        let url = `${this.#api}/${id}/update-profile`;
        return apiService.post(url, data)
    }

    store(agentId, data) {
        let url = `${this.#api}/${agentId}/applicant`;
        return apiService.post(url, data);
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

    verifyEmailVerificationCode(data) {
        let url = `${this.#api}/verify/email-verification-code`
        return apiService.post(url, data);
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

    applyForAgent(id, data)
    {
        let url = `${this.#api}/${id}/apply/for-agent`;
        return apiService.post(url,data)
    }

    getAppointments(userId, data = {}, index = null) {
        let url = `${this.#api}/${userId}/appointment`;
        if (index != null)
            url = `${url}?page=${index}`;
        let param = {
            params: data
        }
        return apiService.query(url, param);
    }

    getAppointmentsCount(userId){
        let url = `${this.#api}/${userId}/appointment/get-totals`
        return apiService.get(url)
    }

    getUpcomingAppointment(userId){
        let url = `${this.#api}/${userId}/upcoming-appointment`;
        return apiService.get(url);
    }

    socialiteLogin(socialSite)
    {
        let url = `${this.#api}/oauth/${socialSite}`;
        return apiService.get(url)

    }

    submitAgentVerificationDocument(data)
    {
        let url = `${this.#api}/agent/submit-verification-document`;
        return apiService.post(url,data)
    }

    getUserAgent(userId){
        let url = `api/${this.#api}/${userId}/get-agent`;
        return apiService.get(url);
    }

    removeAgent(userId, data) {
        let url = `api/${this.#api}/${userId}/remove-agent`;
        return apiService.post(url, data)
    }

    sendTransferEmailToUser(data){
        let url = `api/${this.#api}/transfer-email/send`;
        return apiService.post(url, data)
    }

    checkIfSubscriptionExpired(){
        let url = `${this.#api}/check/agent-expired`
        return apiService.get(url)
    }

    getAllLog(id){
        let url = `${this.#api}/${id}/user-logs`;
        return apiService.get(url)
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

    search(data){
        let url = `${this.#api}/search/student`;
        let param = {
            params: data
        }
        return apiService.query(url, param)
    }
}
