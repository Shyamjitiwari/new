import Vue from "vue";
import Vuex from "vuex";
import router from "../router/router";
import moment from 'moment';
import settings from "./modules/settings";
import permissions from "./modules/permissions";
import server from "./modules/server";
import users from "./modules/users";
import captions from "./modules/captions";
import lead_sources from "./modules/lead_sources";
import lead_statuses from "./modules/lead_statuses";
import leads from "./modules/leads";
import userAssignedLeads from "./modules/userAssignedLeads";
import comments from "./modules/comments";
import lead_histories from "./modules/lead_histories";
import roles from "./modules/roles";
import projects from "./modules/projects";
import activities from "./modules/activities";
import dashboard from "./modules/dashboard";
import userLeadSourceWise from "./modules/userLeadSourceWise";
import usreLeadStatusWise from "./modules/userLeadStatusWise";
import userLeadProjectWise from "./modules/UserLeadProjectWise";
import leadsForToday from "./modules/leadsForToday";
import userQualifiedLeads from "./modules/userQualifiedLeads";
import userDeadLeads from "./modules/userDeadLeads";
import userDailyReports from "./modules/userDailyReprts";
import unattendedLeads from "./modules/unattendedLeads";
import locations from "./modules/locations";
import project_units from "./modules/project_units";
import builders from "./modules/builders";
import user_groups from "./modules/user_groups";
import attendances from  "./modules/attendances";
import apis from "./modules/apis";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        auth: JSON.parse(localStorage.getItem("auth")) || { name: null },
        token: localStorage.getItem("token") || null,

        base_url: "/",
        api_url: "/api/",
        image_url: "/images/",

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
        attendance_marked : false,
        absent : false,
        checked_out : false,
    },
    getters: {
        getCurrentDate(state) {
            return state.current_date;
        },
        isLoggedIn(state) {
            return (state.token || state.token == "") ? true : false;
        },
        getToken(state) {
            return state.token;
        },
        getAuth(state) {
            return state.auth;
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
        },
        isAttendanceMarked(state){
            return state.attendance_marked ;
        },
        isAbsentToday(state){
             return state.absent ;
        },
        isCheckedOut(state){
             return state.checked_out ;
        }
    },
    mutations: {
        setToken(state, payload) {
            state.token = payload.access_token;
            state.welcome = true;
            localStorage.setItem("token", state.token);
            this.dispatch("fetchAuth", state.token);
        },
        setAuth(state, payload) {
            this.dispatch("fetchPermissions");
            this.dispatch("fetchTeam");
            state.auth = payload;
            localStorage.setItem("auth", JSON.stringify(state.auth));
            this.dispatch("fetchAttendance");
            this.dispatch("fetchCheckout");
            this.dispatch("fetchAbsent");

        },
        setErrors(state, payload) {
            state.errors = payload;
        },
        setMessage(state, payload) {
            state.message = payload;
        },
        unSetAuthToken(state) {
            localStorage.clear();
            state.token = null;
            state.auth = { name: null }
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
        setAttendance(state,payload){
            state.attendance_marked = payload.data.data;
           
          },
          setAbsent(state,payload){
          
            state.absent = payload.data.data;
          },
          setCheckedOut(state,payload){
            state.checked_out = payload.data.data;
          }
    },
    actions: {
        fetchToken(context, payload) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "login",
                data: {
                    email: payload.email,
                    password: payload.password,
                },
                success_callback: function success_callback(response) {
                    context.commit("setToken", response.data);
                }
            })
        },
        impersonateUser(context, payload) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "impersonate",
                data: payload,
                success_callback: function success_callback(response) {
                    console.log(response.data.data);
                    context.commit("setToken", response.data.data);
                }
            })
        },
        fetchAuth(context) {
            this.dispatch("dispatch_request", {
                method: "GET",
                url: "user",
                success_callback: function success_callback(response) {
                    context.commit("setAuth", response.data.data);
                }
            })
        },
        setResetData(context) {
            context.commit("setErrors", {});
            context.commit("setMessage", '');
        },
        getApiLoadingStatus(state) {
            state.apiLoading ? (state.apiLoading = false) : (state.apiLoading = true);
        },
        signOut(context) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "logout",
                success_callback: function success_callback() {
                    context.commit("unSetAuthToken");
                    window.location.href = '/';
                }
            });
        },
        statusChange(context, payload) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "status-change",
                data: {
                    id: payload.id,
                    table: payload.table
                },
                success_callback: function success_callback() {}
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
        fetchAttendance(context,payload){
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "user-attendance",
                success_callback: function success_callback(response) {
                    context.commit("setAttendance", response);
                }
            })
        },
        fetchCheckout(context,payload){
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "user-checkout",
                success_callback: function success_callback(response) {
                    context.commit("setCheckedOut", response);
                }
            })
        },
        fetchAbsent(context,payload){
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "user-absent",
                success_callback: function success_callback(response) {
                    context.commit("setAbsent", response);
                }
            })
        },
        dispatchEditProfile(context, payload) {
            this.dispatch("dispatch_request", {
                method: "POST",
                url: "profile/update",
                data: payload,
                success_callback: function success_callback(response) {
                    context.commit("setAuth", response.data.data);
                    router.go(-1);
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
                    router.go(-1);
                }
            })
        },
        searchFilter(context) {
            context.commit("setSearchFilter");
        }
    },
    modules: {
        settings,
        captions,
        server,
        permissions,
        users,
        lead_sources,
        lead_statuses,
        leads,
        comments,
        lead_histories,
        roles,
        projects,
        activities,
        dashboard,
        userLeadSourceWise,
        usreLeadStatusWise,
        userLeadProjectWise,
        leadsForToday,
        userAssignedLeads,
        userQualifiedLeads,
        userDeadLeads,
        userDailyReports,
        unattendedLeads,
        locations,
        project_units,
        builders,
        user_groups,
        attendances,
        apis,

    }
});
