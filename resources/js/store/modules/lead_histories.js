import router from "../../router/router";

const state = {
    lead_history: {},
};

const getters = {
    getLeadHistory(state) {
        return state.lead_history;
    }
};

const mutations = {
    setLeadHistory(state, payload) {
        state.lead_history = payload;
    }
};

const actions = {
    dispatchCreateHistory(context, payload) {
        let self = this;
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "lead-histories",
            data: payload,
            success_callback: function success_callback() {
                if(!payload.snooze && !payload.modal) {
                    router.push({name:'leads.show.histories'});
                    this.dispatch("fetchShowLead", this.getLeadHistory.payload.lead_id);
                }
            }
        })
    },
    dispatchCreateHistoryProjects(context, payload) {
        let self = this;
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "lead-histories-projects",
            data: payload,
            success_callback: function success_callback() {
                if(!payload.modal) {
                    router.push({name:'leads.show.histories'});
                    this.dispatch("fetchShowLead", this.getLeadHistory.payload.lead_id);
                }
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
