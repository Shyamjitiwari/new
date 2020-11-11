import router from "../../router/router";

const state = {
    userAssignedLeads: {},
    userAssignedLeadsForToday: {},
    leads_count : 0,
    userAssignedLead: {},
    leadProjects: [],
};

const getters = {
    getUserAssignedLeadsCount(state) {
        return state.leads_count;
    },
    getUserAssignedLeads(state) {
        return state.userAssignedLeads;
    },
    getUserAssignedLead(state) {
        return state.userAssignedLead;
    },
    getUserAssignedLeadsForToday(state) {
        return state.userAssignedLeadsForToday;
    }
};

const mutations = {
    setUserAssignedLeads(state, payload) {
        state.userAssignedLeads = payload;
        state.leads_count = payload.total;
    },
    setUserAssignedLead(state, payload) {
        state.userAssignedLead = payload;
    },
    setUserAssignedLeadsForToday(state, payload) {
        state.userAssignedLeadsForToday = payload;
    }
};

const actions = {
    fetchUserAssignedLeadsForToday(context){
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "leads-for-today",
            success_callback: function success_callback(response) {
                context.commit("setUserAssignedLeadsForToday", response.data.data);
            }
        })
    },
    fetchUserAssignedLeads(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "user-assigned-leads?page=" +
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
                context.commit("setUserAssignedLeads", response.data.data);
            }
        });
        this.dispatch('fetchUserAssignedLeadsForToday');
    },
};

export default {
    state,
    getters,
    mutations,
    actions
};
