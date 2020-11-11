const state = {
    userLeadProjectWise : [],
};

const getters = {
    getUserLeadProjectWise(state){
        return state.userLeadProjectWise;
    }
};

const mutations = {
    setUserLeadProjectWise(state, payload){
        state.userLeadProjectWise = payload;
    }
};

const actions = {
    fetchUserLeadProjectWise(context, payload) {
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "user-lead-project-wise",
            data : payload,
            success_callback: function success_callback(response) {
                context.commit("setUserLeadProjectWise", response.data.data);
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
