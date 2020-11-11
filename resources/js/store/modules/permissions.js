const state = {
    permissions: [],
    activePermissions : []
};

const getters = {
    hasPermission(state) {
        return state.permissions;
    },
    getActivePermission(state) {
        return state.activePermissions;
    }
};

const mutations = {
    setPermissions(state, payload) {
        state.permissions = payload;
    },
    setActivePermissions(state, payload) {
        state.activePermissions = payload;
    }
};

const actions = {
    fetchPermissions(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "permissions",
            success_callback: function success_callback(response) {
                context.commit("setPermissions", response.data.data);
            }
        })
    },
    fetchAllActivePermissions(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'permissions' },
            success_callback: function success_callback(response) {
                context.commit("setActivePermissions", response.data.data);
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
