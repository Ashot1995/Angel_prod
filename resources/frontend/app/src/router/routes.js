// Layouts
import Layout from '@/components/Layout/Layout';
import LayoutPage from '@/components/Layout/LayoutPage';
import LayoutHorizontal from '@/components/Layout/LayoutHorizontal'

// Pages
import Login from "@/views/Login/Login";
import Register from "@/views/Register/Register";

import Orders from "@/views/Orders/Orders";

export default [
    {
        path: '/',
        component: Layout || LayoutHorizontal,
        children: [
            {
                path: '/',
                name: 'Orders',
                meta: {
                    requiresAuth: true
                },
                component: Orders
            }
        ]
    },
    {
        path: '/',
        component: LayoutPage,
        children: [
            {
                path: '/login',
                name: 'Login',
                component: Login
            },
            {
                path: '/register',
                name: 'Register',
                component: Register
            }
        ]
    }
];
