import apiService from "../../../../api/api.service";

export default class BlogCategoryService
{
    #api = null;

    constructor() {
        this.#api = 'admin/blog-category';
    }

    sort(data=[]){
        let url = `${this.#api}/sort`;
        return apiService.post(url, data);
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

    parentCategories() {
        let url = `${this.#api}/get/parent`;
        return apiService.get(url);
    }

    create(data) {
        let url = `${this.#api}`;
        return apiService.post(url, data)
    }
    store(data) {
        let url = `${this.#api}`
        return apiService.post(url, data);
    }

    show(id) {
        let url = `${this.#api}/${id}`
        return apiService.get(url)
    }

    update(id,data) {
        let url = `${this.#api}/${id}`
        return apiService.put(url,data)
    }

    // getParent(){
    //     let url = `${this.#api}/parent/all`;
    //     return apiService.get(url)
    // }

    delete(id){
        let url = `${this.#api}/${id}`
        return apiService.delete(url);
    }
}
