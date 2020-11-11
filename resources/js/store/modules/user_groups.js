import router from "../../router/router";

const state = {
    userGroups: {},
    userGroup: {},
    userGroups_active: {},
};

const getters = {
    getUserGroups(state) {
        return state.userGroups;
    },
    getUserGroup(state) {
        return state.userGroup;
    },
    getUserGroupsActive(state){
        return state.userGroups_active;
    }
};

const mutations = {
    setUserGroups(state, payload) {
        state.userGroups = payload;
    },
    setUserGroup(state, payload) {
        state.userGroup = payload;
    },
    setUserGroupsActive(state, payload) {
        state.userGroups_active = payload;
    }
};

const actions = {
    fetchUserGroups(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "user-groups?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setUserGroups", response.data.data);
            }
        })
    },
    fetchShowUserGroup(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "user-groups/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setUserGroup", response.data.data);
            }
        })
    },
    fetchEditUserGroup(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "user-groups/" + payload + '/edit',
            success_callback: function success_callback(response) {
                context.commit("setUserGroup", response.data.data);
            }
        })
    },

    dispatchCreateUserGroup(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "user-groups",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditUserGroup(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "user-groups/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteUserGroup(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "user-groups/" + payload.id,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    fetchAllActiveUserGroups(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'user_groups' },
            success_callback: function success_callback(response) {
                context.commit("setUserGroupsActive", response.data.data);
            }
        })
    },
    
};

export default {
    state,
    getters,
    mutations,
    actions
};