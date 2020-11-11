const state = {
    activities: [],
};

const getters = {
    getActivities(state) {
        return state.activities;
    },
};

const mutations = {
    setActivities(state, payload) {
        state.activities = payload;
    },
};

const actions = {
    fetchActivities(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "activities?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&remarks=" +
                payload.search.remarks +
                "&created_at=" +
                payload.search.created_at,
            success_callback: function success_callback(response) {
                context.commit("setActivities", response.data.activities);
            }
        })
    },
};

export default {
    state,
    getters,
    mutations,
    actions
};
