
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Skyward API-to-Database Components
Vue.component('sync-status', require('./components/SyncStatus.vue'));
Vue.component('sync-tables', require('./components/SyncTables.vue'));

// Page Components
Vue.component('locations', require('./components/Locations.vue'));

const app = new Vue({
    el: '#app'
});
