import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes.js';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    let currentUser
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    currentUser = localStorage.getItem('token') ? localStorage.getItem('token') : null

    if (!currentUser && requiresAuth) {
        next('/login')
    }else {
        next()
    }
});

export default router
