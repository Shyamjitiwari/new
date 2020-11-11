import router from "../../router/router";

const state = {
    lead_statuses: {},
    lead_status: {},
    parentLeadStatuses: {},
    activeLeadStatuses: {}
};

const getters = {
    getLeadStatuses(state) {
        return state.lead_statuses;
    },
    getLeadStatus(state) {
        return state.lead_status;
    },
    getParentLeadStatuses(state) {
        return state.parentLeadStatuses;
    },
    getActiveLeadStatuses(state) {
        return state.activeLeadStatuses;
    }
};

const mutations = {
    setLeadStatuses(state, payload) {
        state.lead_statuses = payload;
    },
    setLeadStatus(state, payload) {
        state.lead_status = payload;
    },
    setParentLeadStatuses(state, payload) {
        state.parentLeadStatuses = payload;
    },
    setActiveLeadStatuses(state, payload) {
        state.activeLeadStatuses = payload;
    }
};

const actions = {
    fetchActiveLeadStatuses(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-active-lead-statuses",
            success_callback: function success_callback(response) {
                context.commit("setActiveLeadStatuses", response.data.data);
            }
        })
    },
    fetchParentLeadStatuses(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-parent-lead-statuses",
            success_callback: function success_callback(response) {
                context.commit("setParentLeadStatuses", response.data.data);
            }
        })
    },
    fetchLeadStatuses(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "lead-statuses?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&parent=" +
                payload.search.parent +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setLeadStatuses", response.data.data);
            }
        })
    },
    fetchShowLeadStatus(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "lead-statuses/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setLeadStatus", response.data.data);
            }
        })
    },
    fetchEditLeadStatus(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "lead-statuses/" + payload + "/edit",
            success_callback: function success_callback(response) {
                context.commit("setLeadStatus", response.data.data);
            }
        })
    },

    dispatchCreateLeadStatus(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "lead-statuses",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditLeadStatus(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "lead-statuses/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteLeadStatus(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "lead-statuses/" + payload.id,
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
