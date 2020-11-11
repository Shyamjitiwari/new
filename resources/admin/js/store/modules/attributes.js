const state = {
    attributes: [],
    activAettributes: [],

};

const getters = {
    getAttributes(state) {
        return state.attributes;
    },
    getActiveAttributes(state) {
        return state.activAettributes;
    }
};

const mutations = {
    setAttributes(state, payload) {
        state.attributes = payload;
    },
    setActiveAttributes(state, payload) {
        state.activAettributes = payload;
    },
};

const actions = {
    fetchActiveAttributes(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'attributes' },
            success_callback: function success_callback(response) {
                context.commit("setActiveAttributes", response.data.data);
            }
        })
    },
    fetchAttributes(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "attributes?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setAttributes", response.data.attribute);
            }
        })
    },
    dispatchCreateAttribute(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "attributes",
            data : payload.attribute,
            success_callback: function success_callback(response) {
                context.dispatch('fetchAttributes', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteAttribute(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "attributes/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchAttributes', {search: {name: ""}});
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
