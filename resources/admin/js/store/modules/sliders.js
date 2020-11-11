const state = {
    sliders: [],
};

const getters = {
    getSliders(state) {
        return state.sliders;
    }
};

const mutations = {
    setSliders(state, payload) {
        state.sliders = payload;
    },
};

const actions = {
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-slider-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchSliders', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchSliders(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "sliders?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setSliders", response.data.sliders);
            }
        })
    },
    dispatchCreateSlider(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "sliders",
            data : payload.slider,
            success_callback: function success_callback(response) {
                context.dispatch('fetchSliders', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteSlider(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "sliders/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchSlider', {search: {name: ""}});
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
