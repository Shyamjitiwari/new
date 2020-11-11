import router from "../../router/router";

const state = {
    roles: {},
    role: {
        name : '',
        permissions : []
    },
    editRole:{},
    activeFilteredRoles: {}
};

const getters = {
    editRole(state) {
        return state.editRole;
    },
    getRoles(state) {
        return state.roles;
    },
    getRole(state) {
        return state.role;
    },
    getActiveFilteredRoles(state) {
        return state.activeFilteredRoles;
    }
};

const mutations = {
    setRoles(state, payload) {
        state.roles = payload;
    },
    setEditRole(state, payload) {
        state.editRole = payload;
    },
    setRole(state, payload) {
        state.role = payload;
    },
    setAllActiveFilteredRoles(state, payload) {
        state.activeFilteredRoles = payload;
    },
    setAllActiveRoles(state, payload) {
        state.roles = payload;
    }
};

const actions = {
    fetchAllActiveRoles(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'roles' },
            success_callback: function success_callback(response) {
                context.commit("setAllActiveRoles", response.data.data);
            }
        })
    },
    fetchAllActiveFilteredRoles(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active-filtered",
            data: payload,
            success_callback: function success_callback(response) {
                context.commit("setAllActiveFilteredRoles", response.data.data);
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
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setRoles", response.data.data);
            }
        })
    },
    fetchShowRole(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "roles/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setRole", response.data.data);
            }
        })
    },
    fetchEditRole(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "roles/" + payload + "/edit/",
            success_callback: function success_callback(response) {
                console.log('setEditRole', response);
                context.commit("setEditRole", response.data.data);
            }
        })
    },
    fetchCreateRole(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "roles/create",
            data: payload,
            success_callback: function success_callback(response) {
                context.commit("setRole", response.data.data);
            }
        })
    },
    dispatchCreateRole(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "roles",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditRole(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "roles/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteRole(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "roles/" + payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
