import router from "../../router/router";

const state = {
    lead_sources: {},
    lead_source: {},
    lead_sources_active: {},
};

const getters = {
    getLeadSources(state) {
        return state.lead_sources;
    },
    getLeadSource(state) {
        return state.lead_source;
    },
    getLeadSourcesActive(state){
        return state.lead_sources_active;
    }
};

const mutations = {
    setLeadSources(state, payload) {
        state.lead_sources = payload;
    },
    setLeadSource(state, payload) {
        state.lead_source = payload;
    },
    setLeadSourcesActive(state, payload) {
        state.lead_sources_active = payload;
    }
};

const actions = {
    fetchLeadSources(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "lead-sources?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setLeadSources", response.data.data);
            }
        })
    },
    fetchShowLeadSource(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "lead-sources/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setLeadSource", response.data.data);
            }
        })
    },
    fetchEditLeadSource(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "lead-sources/" + payload + '/edit',
            success_callback: function success_callback(response) {
                context.commit("setLeadSource", response.data.data);
            }
        })
    },

    dispatchCreateLeadSource(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "lead-sources",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditLeadSource(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "lead-sources/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteLeadSource(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "lead-sources/" + payload.id,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    fetchAllActiveSources(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'lead_sources' },
            success_callback: function success_callback(response) {
                context.commit("setLeadSourcesActive", response.data.data);
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