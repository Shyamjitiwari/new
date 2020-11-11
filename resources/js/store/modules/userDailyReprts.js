const state = {
    dailyReports : [],
};

const getters = {
    getDailyReports(state){
        return state.dailyReports;
    }
};

const mutations = {
    setDailyReports(state, payload){
        state.dailyReports = payload;
    }
};

const actions = {
    fetchDailyReports(context, payload) {
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "user-daily-reports",
            data : payload,
            success_callback: function success_callback(response) {
                context.commit("setDailyReports", response.data.data);
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
