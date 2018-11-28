
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.component('pagination', require('laravel-vue-pagination'));

import ClientsIndex from './components/clients/ClientsIndex.vue';
import ClientsCreate from './components/clients/ClientsCreate.vue';
import ClientsEdit from './components/clients/ClientsEdit.vue';

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))
const routes = [
    {
        path: '/',
        components: {
            clientsIndex: ClientsIndex
        }
    },
    {path: '/admin/clients/create', component: ClientsCreate, name: 'createClient'},
    {path: '/admin/clients/edit/:id', component: ClientsEdit, name: 'editClient'},
]
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')