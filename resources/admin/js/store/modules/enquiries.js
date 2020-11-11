const state = {
    enquiries: [],
};

const getters = {
    getEnquiries(state) {
        return state.enquiries;
    }
};

const mutations = {
    setEnquiries(state, payload) {
        state.enquiries = payload;
    },
};

const actions = {
    fetchEnquiries(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "enquiries?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setEnquiries", response.data.enquiries);
            }
        })
    },
    deleteEnquiry(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "enquiries/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchEnquiries', {search: {name: ""}});
            }
        })
    },
    replyEnquiry(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "enquiry-reply/",
            data: payload,
            success_callback: function success_callback(response) {
                context.dispatch('fetchEnquiries', {search: {name: ""}});
            }
        })
    },
    mark_read_at(context, payload){
        console.log(payload);
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "mark_read_at/",
            data: payload,
            success_callback: function success_callback(response) {
                context.dispatch('fetchEnquiries', {search: {name: ""}});
            }
        })
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}
