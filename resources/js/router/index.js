import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/finance',
        name: 'dashboard',
        component: () => import('../views/Dashboard.vue'),
    },
    {
        path: '/finance/movements',
        name: 'movements',
        component: () => import('../views/movements/MovementIndex.vue'),
    },
    {
        path: '/equipment-inventory',
        name: 'equipment-inventory',
        component: () => import('../views/equipment-inventory/Index.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
