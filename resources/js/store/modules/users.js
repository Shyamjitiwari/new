import router from "../../router/router";

const state = {
    users: {},
    user: {},
    activeFilteredUsers: {},
    activeUsers : [],
    usersForTeamSelection : [],
    team : []
};

const getters = {
    getTeam(state) {
        return state.team;
    },
    getUsers(state) {
        return state.users;
    },
    getUser(state) {
        return state.user;
    },
    getActiveFilteredUsers(state) {
        return state.activeFilteredUsers;
    },
    getActiveUsers(state) {
        return state.activeUsers;
    },
    getUsersForTeamSelection(state) {
        return state.usersForTeamSelection;
    }
};

const mutations = {
    setUsers(state, payload) {
        state.users = payload;
    },
    setUser(state, payload) {
        state.user = payload;
    },
    setAllActiveFilteredUsers(state, payload) {
        state.activeFilteredUsers = payload;
    },
    setActiveUsers(state, payload) {
        state.activeUsers = payload;
    },
    setUsersForTeamSelection(state, payload) {
        state.usersForTeamSelection = payload;
    },
    setTeam(state, payload) {
        state.team = payload;
    }
};

const actions = {
    fetchTeam(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-team",
            success_callback: function success_callback(response) {
                context.commit("setTeam", response.data.data);
            }
        })
    },
    fetchUsersForTeamSelection(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "users/get-users-for-team-selection",
            success_callback: function success_callback(response) {
                context.commit("setUsersForTeamSelection", response.data.data);
            }
        })
    },
    fetchAllActiveUsers(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'users' },
            success_callback: function success_callback(response) {
                context.commit("setActiveUsers", response.data.data);
            }
        })
    },
    fetchAllActiveFilteredUsers(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active-filtered",
            data: payload,
            success_callback: function success_callback(response) {
                context.commit("setAllActiveFilteredUsers", response.data.data);
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
                "&email=" +
                payload.search.email +
                "&group=" +
                payload.search.group_id +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setUsers", response.data.data);
            }
        })
    },
    fetchShowUser(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "users/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setUser", response.data.data);
            }
        })
    },
    fetchEditUser(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "users/" + payload + "/edit/",
            success_callback: function success_callback(response) {
                context.commit("setUser", response.data.data);
            }
        })
    },

    dispatchCreateUser(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "users",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditUser(context, payload) {
        let _this = this;
        _this.dispatch("dispatch_request", {
            method: "PUT",
            url: "users/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
                _this.dispatch('fetchTeam');
            }
        });
    },
    changePassword(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "users/change-password/" + payload.id,
            data: { password: payload.password },
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteUser(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "users/" + payload.id,
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
