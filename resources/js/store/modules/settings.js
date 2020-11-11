const state = {
    settings: {},
    app: JSON.parse(localStorage.getItem("app")) || null
};

const getters = {
    getSettings(state) {
        return state.settings;
    },
    getAppSettings(state) {
        return state.app;
    }
};

const mutations = {
    setSettings(state, payload) {
        state.settings = payload;
    },
    setAppSetting(state, payload) {
        state.app = payload;
        localStorage.setItem("app", JSON.stringify(payload));
    }
};

const actions = {
    fetchAppSettings(context) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-app-settings",
            success_callback: function success_callback(response) {
                context.commit("setAppSetting", response.data.data);
            }
        })
    },
    fetchSettings(context) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "settings",
            success_callback: function success_callback(response) {
                context.commit("setSettings", response.data.data);
            }
        })
    },
    updateSetting(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "settings/edit/" + payload.id,
            data: payload,
            success_callback: function success_callback(response) {
                context.commit("setAppSetting", response.data.data);
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