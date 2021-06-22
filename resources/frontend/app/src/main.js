import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueI18Next from '@panter/vue-i18next';

import './vendor.js'

import App from './App.vue'
import router from './router'
import i18next from './i18n.js';
import store from './store'
import axios from "axios";
import Vuelidate from 'vuelidate'

Vue.config.productionTip = false

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';
axios.defaults.headers.common = {'Authorization': localStorage.getItem('token')}

Vue.use(BootstrapVue);
Vue.use(VueI18Next);
Vue.use(Vuelidate);

const i18n = new VueI18Next(i18next);

new Vue({
    i18n,
    router,
    store,
    render: h => h(App)
}).$mount('#app')
