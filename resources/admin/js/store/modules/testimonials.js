const state = {
    testimonials: [],
};

const getters = {
    getTestimonials(state) {
        return state.testimonials;

    }
};

const mutations = {
    setTestimonials(state, payload) {
        state.testimonials = payload;
    },
};

const actions = {
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-testimonial-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchTestimonials', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchTestimonials(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "testimonials?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setTestimonials", response.data.testimonials);
            }
        })
    },
    dispatchCreateTestimonial(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "testimonials",
            data : payload.testimonial,
            success_callback: function success_callback(response) {
                context.dispatch('fetchTestimonials', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteTestimonial(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "testimonials/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchTestimonials', {search: {name: ""}});
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
