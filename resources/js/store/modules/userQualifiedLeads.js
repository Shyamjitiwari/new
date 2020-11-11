const state = {
    qualifiedLeads : [],
};

const getters = {
    getQualifiedLeads(state){
        return state.qualifiedLeads;
    }
};

const mutations = {
    setQualifiedLeads(state, payload){
        state.qualifiedLeads = payload;
    }
};

const actions = {
    fetchQualifiedLeadsUserWise(context, payload) {
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "qualified-leads-user-wise",
            data : payload,
            success_callback: function success_callback(response) {
                context.commit("setQualifiedLeads", response.data.data);
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
