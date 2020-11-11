const state = {
    activityReports : {},
};

const getters = {
    getActivityReports(state){

        return state.activityReports;
    }
};

const mutations = {
    setActivityReports(state, payload){
        state.activityReports = payload;

    }
};

const actions = {
    fetchActivityReports(context, payload) {
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "activity-reports",
            data : payload,
            success_callback: function success_callback(response) {

                context.commit("setActivityReports", response.data.data);
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
