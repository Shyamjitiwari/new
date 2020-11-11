const state = {
    comments: [],
};

const getters = {
    getComments(state) {
        return state.comments;
    }
};

const mutations = {
    setComments(state, payload) {
        state.comments = payload;
    },
};

const actions = {
    fetchComments(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "comments?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setComments", response.data.comments);
            }
        })
    },
    deleteComment(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "comments/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchComments', {search: {name: ""}});
            }
        })
    },
    changeStatus(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "comments/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchComments', {search: {name: ""}});
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
