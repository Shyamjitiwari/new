import permissions from "./permissions";

const state = {
    users: [],
    activeUsers : [],
};

const getters = {
    getUsers(state) {
        return state.users;
    },
    getActiveUsers(state) {
        return state.activeUsers;
    }
};

const mutations = {
    setUsers(state, payload) {
        state.users = payload;
    },
    setActiveUsers(state, payload) {
        state.activeUsers = payload;
    },
};

const actions = {
    fetchActiveUsers(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'users' },
            success_callback: function success_callback(response) {
                context.commit("setActiveUsers", response.data.data);
            }
        })
    },
    fetchUsers(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "users?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setUsers", response.data.users);
            }
        })
    },
    dispatchCreateUser(context, payload) {
        let _this = this;
        _this.dispatch("dispatch_request", {
            method: "POST",
            url: "users",
            data : payload.user,
            success_callback: function success_callback(response) {
                context.dispatch('fetchUsers', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteUser(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "users/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchUsers', {search: {name: ""}});
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
