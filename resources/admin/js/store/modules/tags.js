const state = {
    tags: [],
    activeTags : [],
};

const getters = {
    getTags(state) {
        return state.tags;
    },
    getActiveTags(state) {
        return state.activeTags;
    }
};

const mutations = {
    setTags(state, payload) {
        state.tags = payload;
    },
    setActiveTags(state, payload) {
        state.activeTags = payload;
    },
};

const actions = {
    fetchActiveTags(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'tags' },
            success_callback: function success_callback(response) {
                context.commit("setActiveTags", response.data.data);
            }
        })
    },
    fetchTags(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "tags?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setTags", response.data.tags);
            }
        })
    },
    dispatchCreateTag(context, payload) {
        let _this = this;
        _this.dispatch("dispatch_request", {
            method: "POST",
            url: "tags",
            data : payload.tag,
            success_callback: function success_callback(response) {
                context.dispatch('fetchTags', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteTag(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "tags/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchTags', {search: {name: ""}});
                console.log('success');
            },
            error_callback: function error_callback(error) {
                console.log('error');
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
