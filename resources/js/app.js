require('./bootstrap');
import Vue from "vue";
import BootstrapVue from 'bootstrap-vue';
import Notifications from 'vue-notification';

window._ = require('lodash');
window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');
Vue.use(Notifications)

import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vuelidate from "vuelidate";
import moment from 'moment';
require('material-design-icons');
import VueSwal from 'vue-swal'

Vue.use(BootstrapVue);
Vue.use(Vuelidate);
Vue.use(VueSwal)

import Main from './Main';
import store from "./store/store";
import router from "./router/router";

// components
import pagination from "./components/pagination";
import apiloader from "./components/ApiLoader";
import buttonloading from "./components/ButtonLoading";
import PageTitle from "./components/PageTitle";
import SubmitButton from "./components/SubmitButton";
import ShowImage from "./components/ShowImage";

import Multiselect from "vue-multiselect";

Vue.component('multiselect', Multiselect)

Vue.component("buttonloading", buttonloading);
Vue.component("pagination", pagination);
Vue.component("apiloader", apiloader);
Vue.component("PageTitle", PageTitle);
Vue.component("submit-button", SubmitButton);
Vue.component("show-image", ShowImage);

// Date Formatter
Vue.filter('dateFormat', function(value) {
    return moment(value).format(store.getters.getAppSettings.date_format)
});

// String Truncate Filter
Vue.filter('truncate', function(value) {
    return value.slice(0, 10);
});

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('leads-for-today', require('./components/reports/LeadsForToday.vue').default);
Vue.component('status-wise-reports', require('./components/reports/StatusWise.vue').default);
Vue.component('source-wise-reports', require('./components/reports/SourceWise.vue').default);
Vue.component('project-wise-reports', require('./components/reports/ProjectWise.vue').default);
Vue.component('qualified-reports', require('./components/reports/Qualified.vue').default);
Vue.component('dead-leads', require('./components/reports/DeadLeads.vue').default);
Vue.component('daily-reports', require('./components/reports/DailyReports.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Main)
});

// Add a request interceptor
axios.interceptors.request.use(function(config) {
    store.state.apiLoading = true;
    return config;
});

// Add a response interceptor
axios.interceptors.response.use(function(response) {
    store.state.apiLoading = false;
    return response;
});
