import axios from "axios";

const YclientsModule = {
    actions: {
        getCompanyList () {

           return axios.get('/companies')
               .then(response => {
                   return response.data;
               });
        },
        getCompanyById ( _, companyId) {
            return axios.get(`/companies/${companyId}`);
        },
        getCompanyBookDate ( _, companyId) {
            return axios.get(`/companies/${companyId}/book_date/`)
                .then(response => response.data);
        },
        getCompanyBookTime (_, {companyId, date}) {
            return axios.get(`/companies/${companyId}/book_date/${date}`)
                .then(response => response.data);
        },
        createOrder (_, payload) {
            return axios.post('/orders', payload);
        }
    }
}

export default YclientsModule;
