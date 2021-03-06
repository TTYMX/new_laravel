
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import Vue from 'vue';


Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('component-test', require('./components/TestComponent.vue'));

Vue.component('page-card', require('./pages/Card.vue'));

Vue.component('page-index', require('./pages/Index.vue'));

Vue.component('page-detail', require('./pages/Detail.vue'));

Vue.component('page-order', require('./pages/Order.vue'));

const app = new Vue({
    el: '#app',
    data:{
        message:'hello world',
    }
});

