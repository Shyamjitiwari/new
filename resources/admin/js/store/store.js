import Vue from "vue";
import Vuex from "vuex";
import moment from 'moment';
import settings from "./modules/settings";
import permissions from "./modules/permissions";
import server from "./modules/server";
import users from "./modules/users";
import roles from "./modules/roles";
import activities from "./modules/activities";
import dashboard from "./modules/dashboard";
import blogs from "./modules/blogs";
import categories from "./modules/categories";
import tags from "./modules/tags";
import testmonials from "./modules/testimonials";
import common from "./modules/common";
import enquiries from "./modules/enquiries";
import comments from "./modules/comments";
import services from "./modules/services";
import galleries from "./modules/galleries";
import pages from "./modules/pages";
import menus from "./modules/menus";
import sliders from "./modules/sliders";
import brands from "./modules/brands";
import activityReport from "./modules/reports/activityReport.js";
import attributes from "./modules/attributes";
import attributeGroups from "./modules/attributeGroups";
import products from "./modules/products";


Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        base_url: process.env.MIX_APP_URL+"/",
        api_url: process.env.MIX_APP_URL+"/api/",
        image_url: process.env.MIX_APP_URL+"/images/",

        pagination: {},
        errors: {},
        processedErrors: {},
        message: '',
        apiLoading: false,
        year: moment().year(),
        current_date: moment().format('YYYY-MM-DD'),
        showSearchFilter: false,
        showReloadIcon: false,
        showSearchIcon: false,
    },
    getters: {
        getCurrentDate(state) {
            return state.current_date;
        },
        getErrors(state) {
            return state.errors;
        },
        getMessage(state) {
            return state.message;
        },
        getApiLoadingStatus(state) {
            return state.apiLoading;
        },
        getYear(state) {
            return state.year;
        },
        getImageUrl(state) {
            return state.image_url;
        },
        getBaseUrl(state) {
            return state.base_url;
        },
        getSearchFilter(state) {
            return state.showSearchFilter;
        }
    },
    mutations: {
        setErrors(state, payload) {
            state.errors = payload;
        },
        setMessage(state, payload) {
            state.message = payload;
        },
        getApiLoadingStatus(state) {
            state.apiLoading ?
                (state.apiLoading = false) :
                (state.apiLoading = true);
        },
        setSearchFilter(state) {
            state.showSearchFilter = !state.showSearchFilter;
        },
        setSearchFilterShowAlways(state) {
            state.showSearchFilter = true;
        },
    },
    actions: {
        setResetData(context) {
            context.commit("setErrors", {});
            context.commit("setMessage", '');
        },
        getApiLoadingStatus(state) {
            state.apiLoading ? (state.apiLoading = false) : (state.apiLoading = true);
        },
        statusChange(context, payload) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "status-change",
                data: {
                    id: payload.id,
                    table: payload.table
                },
                success_callback: function success_callback(response) {}
            })
        },
        fetchProfile(context) {
            this.dispatch("dispatch_request", {
                method: "GET",
                url: "profile/edit",
                success_callback: function success_callback(response) {
                    context.commit("setAuth", response.data.data);
                }
            })
        },
        dispatchEditProfile(context, payload) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "profile/update",
                data: payload,
                success_callback: function success_callback(response) {
                   //
                }
            })
        },
        dispatchUpdateProfilePassword(context, payload) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "profile/change-password",
                data: payload,
                success_callback: function success_callback(response) {
                    if (response.data.old_password) {
                        this.state.errors.old_password = response.data.old_password;
                    }
                }
            })
        },
        searchFilter(context) {
            context.commit("setSearchFilter");
        }
    },
    modules: {
        settings,
        server,
        common,
        permissions,
        users,
        roles,
        activities,
        dashboard,
        blogs,
        categories,
        tags,
        testmonials,
        enquiries,
        comments,
        services,
        galleries,
        activityReport,
        pages,
        menus,
        sliders,
        brands,
        attributes,
        attributeGroups,
        products

    }
});
