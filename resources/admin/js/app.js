window.Vue = require('vue');
import Notifications from 'vue-notification';
window._ = require('lodash');
window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');

require('bootstrap');
import axios from 'axios';
Vue.use(Notifications)
require('material-design-icons');

import store from "./store/store";

//common components
Vue.component("pagination", require('./components/pagination').default);
Vue.component("AddNewButton", require('./components/buttons/AddNewButton').default);
Vue.component("SubmitButton", require('./components/buttons/SubmitButton').default);
Vue.component("UpdateButton", require('./components/buttons/UpdateButton').default);
Vue.component("ResetButton", require('./components/buttons/ResetButton').default);
Vue.component("apiloader", require('./components/ApiLoader').default);
Vue.component("activityReport", require('./components/reports/ActivityReport').default);

// major components
Vue.component('BlogsIndex', require('./components/blogs/Index').default);
Vue.component('CategoriesIndex', require('./components/categories/Index').default);
Vue.component('TagsIndex', require('./components/tags/Index').default);
Vue.component('ServicesIndex', require('./components/services/Index').default);
Vue.component('ProductsIndex', require('./components/products/Index').default);
Vue.component('TestimonialsIndex', require('./components/testimonials/Index').default);
Vue.component('GalleriesIndex', require('./components/galleries/Index').default);
Vue.component('PagesIndex', require('./components/pages/Index').default);
Vue.component('MenusIndex', require('./components/menus/Index').default);
Vue.component('SlidersIndex', require('./components/sliders/Index').default);
Vue.component('BrandsIndex', require('./components/brands/Index').default);
Vue.component('AttributesIndex', require('./components/attributes/Index').default);
Vue.component('AttributegroupsIndex', require('./components/attributeGroups/Index').default);
Vue.component('RolesIndex', require('./components/roles/Index').default);
Vue.component('UsersIndex', require('./components/users/Index').default);
Vue.component('Settings', require('./components/Settings').default);
Vue.component('Activities', require('./components/Activities').default);
Vue.component("enquiry-table",require('./components/enquiries/enquiryTable').default);
Vue.component("comment-section",require('./components/comments/Index').default);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const app = new Vue({
    el: '#admin',
    store
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
