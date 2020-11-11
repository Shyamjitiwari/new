import router from "../../router/router";

const state = {
    builders: {},
    builder: {},
    builders_active: {},
};

const getters = {
    getBuilders(state) {
        return state.builders;
    },
    getBuilder(state) {
        return state.builder;
    },
    getBuildersActive(state){
        return state.builders_active;
    }
};

const mutations = {
    setBuilders(state, payload) {
        state.builders = payload;
    },
    setBuilder(state, payload) {
        state.builder = payload;
    },
    setBuildersActive(state, payload) {
        state.builders_active = payload;
    }
};

const actions = {
    fetchBuilders(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "builders?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setBuilders", response.data.data);
            }
        })
    },
    fetchShowBuilder(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "builders/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setBuilder", response.data.data);
            }
        })
    },
    fetchEditBuilder(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "builders/" + payload + '/edit',
            success_callback: function success_callback(response) {
                context.commit("setBuilder", response.data.data);
            }
        })
    },

    dispatchCreateBuilder(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "builders",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditBuilder(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "builders/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteBuilder(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "builders/" + payload.id,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    fetchAllActiveBuilders(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'builders' },
            success_callback: function success_callback(response) {
                context.commit("setBuildersActive", response.data.data);
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