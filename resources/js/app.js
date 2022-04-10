require('./bootstrap');

import Vue from 'vue';

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';

Vue.use(VueAxios, axios);

import App from './App.vue';
import Teams from './components/teams/Teams.vue';
import Fixtures from './components/fixtures/Fixtures.vue';
import Tournament from './components/tournament/Tournament.vue';

const routes = [
    {
        name: 'Teams',
        path: '/',
        component: Teams,
        meta: {transition: false},
    },
    {
        name: 'Fixtures',
        path: '/fixtures',
        component: Fixtures,
        meta: {transition: false},
    },
    {
        name: 'Tournament',
        path: '/tournament/:week',
        component: Tournament,
        meta: {transition: false},
    },
];

const router = new VueRouter({mode: 'history', routes: routes});
new Vue(Vue.util.extend({router}, App)).$mount('#app');


