import router from "../../router/router";

const state = {
    apis: {},
    api: {},
    apis_active: {},
};

const getters = {
    getApis(state) {
        return state.apis;
    },
    getApi(state) {
        return state.api;
    },
    getApisActive(state){
        return state.apis_active;
    }
};

const mutations = {
    setApis(state, payload) {
        state.apis = payload;
    },
    setApi(state, payload) {
        state.api = payload;
    },
    setApisActive(state, payload) {
        state.apis_active = payload;
    }
};

const actions = {
    fetchApis(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "apis?page=" +
                payload.next_page +
                "&url=" +
                payload.search.url +
                "&type=" +
                payload.search.type +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setApis", response.data.data);
            }
        })
    },
    fetchShowApi(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "apis/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setApi", response.data.data);
            }
        })
    },
    fetchEditApi(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "apis/" + payload + '/edit',
            success_callback: function success_callback(response) {
                context.commit("setApi", response.data.data);
            }
        })
    },

    dispatchCreateApi(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "apis",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditApi(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "apis/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteApi(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "apis/" + payload.id,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    fetchAllActiveApis(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'apis' },
            success_callback: function success_callback(response) {
                context.commit("setApisActive", response.data.data);
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