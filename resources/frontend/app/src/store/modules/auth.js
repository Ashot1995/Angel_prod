import axios from "axios";

const AuthModule = {
    state: {
        user: null
    },

    actions: {
        async tryLogin(context, payload) {
            try {
                let response = await axios.post('/login', payload);
                localStorage.setItem('user', JSON.stringify(response.data.user));
                localStorage.setItem('token', `${response.data.token_type} ${response.data.access_token}`);

                return response.data;
            } catch (error) {
                return error.response;
            }
        },
        async tryRegister (context, payload) {
            try {
                let response = await axios.post('/register', payload);
                // localStorage.setItem('token', response.data.token);

                return response.data;
            } catch (error) {
                return error.response;
            }
        }
    },

    getters : {
        user(state) {
            return state.user;
        },
    }

};

export default AuthModule;
