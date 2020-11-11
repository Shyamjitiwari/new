const state = {
    galleries: [],

};

const getters = {
    getGalleries(state) {
        return state.galleries;
    }
};

const mutations = {
    setGalleries(state, payload) {
        state.galleries = payload;
    }
};

const actions = {
    fetchGalleries(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "galleries",
            success_callback: function success_callback(response) {
                context.commit("setGalleries", response.data.galleries);
            }
        })
    },
    dispatchAddImage(context, payload) {
        let _this = this;
        _this.dispatch("dispatch_request", {
            method: "POST",
            url: "galleries",
            data : payload.image,
            success_callback: function success_callback(response) {
                context.dispatch('fetchGalleries');
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
