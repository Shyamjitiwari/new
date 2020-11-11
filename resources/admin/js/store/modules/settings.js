const state = {
    settings: {},
};

const getters = {
    getSettings(state) {
        return state.settings;
    }
};

const mutations = {
    setSettings(state, payload) {
        state.settings = payload;
    }
};

const actions = {
    fetchSettings(context) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "settings",
            success_callback: function success_callback(response) {
                context.commit("setSettings", response.data.settings);
            }
        })
    },
    updateSetting(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "settings/edit/" + payload.id,
            data: payload,
            success_callback: function success_callback(response) {
                context.dispatch('fetchSettings');
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
