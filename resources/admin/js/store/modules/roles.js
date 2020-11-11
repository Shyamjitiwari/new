import permissions from "./permissions";

const state = {
    roles: [],
    activeRoles : [],
};

const getters = {
    getRoles(state) {
        return state.roles;
    },
    getActiveRoles(state) {
        return state.activeRoles;
    }
};

const mutations = {
    setRoles(state, payload) {
        state.roles = payload;
    },
    setActiveRoles(state, payload) {
        state.activeRoles = payload;
    },
};

const actions = {
    fetchActiveRoles(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'roles' },
            success_callback: function success_callback(response) {
                context.commit("setActiveRoles", response.data.data);
            }
        })
    },
    fetchRoles(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "roles?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setRoles", response.data.roles);
            }
        })
    },
    dispatchCreateRole(context, payload) {
        let _this = this;
        _this.dispatch("dispatch_request", {
            method: "POST",
            url: "roles",
            data : payload.role,
            success_callback: function success_callback(response) {
                context.dispatch('fetchRoles', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteRole(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "roles/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchRoles', {search: {name: ""}});
            },
            error_callback: function error_callback(error) {
            }
        })
    },
};

export default {
    state,
    getters,
    mutations,
    actions
}
