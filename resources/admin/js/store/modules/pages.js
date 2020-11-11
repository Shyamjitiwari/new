const state = {
    pages: [],
    activePages : [],

};

const getters = {
    getPages(state) {
        return state.pages;
    },
    getActivePages(state) {
        return state.activePages;
    }
};

const mutations = {
    setPages(state, payload) {
        state.pages = payload;
    },
    setActivePages(state, payload) {
        state.activePages = payload;
    }
};

const actions = {
    fetchActivePages(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'pages' },
            success_callback: function success_callback(response) {
                context.commit("setActivePages", response.data.data);
            }
        })
    },
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-page-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchPages', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchPages(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "pages?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setPages", response.data.pages);
            }
        })
    },
    dispatchCreatePage(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "pages",
            data : payload.page,
            success_callback: function success_callback(response) {
                context.dispatch('fetchPages', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deletePage(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "pages/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchPages', {search: {name: ""}});
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
