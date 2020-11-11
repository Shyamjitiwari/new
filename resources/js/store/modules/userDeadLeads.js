const state = {
    deadLeadSUserWise : [],
};

const getters = {
    getDeadLeadsUserWise(state){
        return state.deadLeadSUserWise;
    }
};

const mutations = {
    setDeadLeadsUserWise(state, payload){
        state.deadLeadSUserWise = payload;
    }
};

const actions = {
    fetchDeadLeads(context, payload) {
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "dead-leads-user-wise",
            data : payload,
            success_callback: function success_callback(response) {
                context.commit("setDeadLeadsUserWise", response.data.data);
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
