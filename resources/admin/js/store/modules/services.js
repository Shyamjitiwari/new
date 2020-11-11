const state = {
    services: [],
};

const getters = {
    getServices(state) {
        return state.services;
    }
};

const mutations = {
    setServices(state, payload) {
        state.services = payload;
    },
};

const actions = {
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-service-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchServices', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchServices(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "services?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setServices", response.data.services);
            }
        })
    },
    dispatchCreateService(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "services",
            data : payload.service,
            success_callback: function success_callback(response) {
                context.dispatch('fetchServices', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteService(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "services/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchServices', {search: {name: ""}});
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
