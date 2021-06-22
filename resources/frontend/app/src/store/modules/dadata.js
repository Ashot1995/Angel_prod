import axios from "axios";

export const dadata = {
        state: {},
        mutations: {},
        actions: {
            async getAddressData(context, payload) {
                try {
                    let response = await axios.get('/address', {params : payload})
                    return response.data;
                } catch (error) {
                    return error.response;
                }
            },

    },

};

