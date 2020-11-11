const state = {};

const getters = {};

const mutations = {};

const actions = {
    dispatchCreateComment(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "comments",
            data: payload,
            success_callback: function success_callback() {}
        })
    },
};

export default {
    state,
    getters,
    mutations,
    actions
}