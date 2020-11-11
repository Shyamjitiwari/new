const state = {
    userLeadSourceWise : [],
};

const getters = {
    getUserLeadSourceWise(state){
        return state.userLeadSourceWise;
    }
};

const mutations = {
    setUserLeadSourceWise(state, payload){
        state.userLeadSourceWise = payload;
    }
};

const actions = {
    fetchUserLeadSourceWise(context, payload) {
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "user-lead-source-wise",
            data : payload,
            success_callback: function success_callback(response) {
                context.commit("setUserLeadSourceWise", response.data.data);
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
