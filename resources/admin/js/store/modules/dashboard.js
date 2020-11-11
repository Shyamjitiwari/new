const state = {
    userLeadStatusWise : []
};

const getters = {
    getUserLeadStatusWise(state){
        return state.userLeadStatusWise;
    }
};

const mutations = {
    setUserLeadStatusWise(state, payload){
        state.userLeadStatusWise = payload;
    }
};

const actions = {
    fetchUserLeadStatusWise(context, payload) {
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "user-lead-status-wise",
            data : payload,
            success_callback: function success_callback(response) {
                context.commit("setUserLeadStatusWise", response.data.data);
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
