import router from "../../router/router";

const state = {
    unattendedLeads: {},
    unattendedLeadsForToday: {},
    leads_count : 0,
    unattendedLead: {},
};

const getters = {
    getUnattendedLeadsCount(state) {
        return state.leads_count;
    },
    getUnattendedLeads(state) {
        return state.unattendedLeads;
    },
    getUnattendedLead(state) {
        return state.unattendedLead;
    },
    getUnattendedLeadsForToday(state) {
        return state.unattendedLeadsForToday;
    }
};

const mutations = {
    setUnattendedLeads(state, payload) {
       console.log(payload);
        state.unattendedLeads = payload;
        state.leads_count = payload.total;
    },
    setUnattendedLead(state, payload) {
        state.unattendedLead = payload;
    },
    setUnattendedLeadsForToday(state, payload) {
        state.unattendedLeadsForToday = payload;
    }
};

const actions = {
    fetchUnattendedLeadsForToday(context){
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "leads-for-today",
            success_callback: function success_callback(response) {
                context.commit("setUnattendedLeadsForToday", response.data.data);
            }
        })
    },
    fetchUnattendedLeads(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "unattended-leads?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&mobile=" +
                payload.search.mobile +
                "&follow_up_at=" +
                payload.search.follow_up_at +
                "&remarks=" +
                payload.search.remarks +
                "&lead_source=" +
                payload.search.lead_source +
                "&lead_status=" +
                payload.search.lead_status +
                "&lead_owner=" +
                payload.search.lead_owner +
                "&created_at=" +
                payload.search.created_at,
            success_callback: function success_callback(response) {
                context.commit("setUnattendedLeads", response.data.data);
            }
        });
        this.dispatch('fetchUnattendedLeadsForToday');
    },
};

export default {
    state,
    getters,
    mutations,
    actions
};
