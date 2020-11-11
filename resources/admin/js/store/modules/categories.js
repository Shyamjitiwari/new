const state = {
    categories: [],
    activeCategories : [],

};

const getters = {
    getCategories(state) {
        return state.categories;
    },
    getActiveCategories(state) {
        return state.activeCategories;
    }
};

const mutations = {
    setCategories(state, payload) {
        state.categories = payload;
    },
    setActiveCategories(state, payload) {
        state.activeCategories = payload;
    },
};

const actions = {
    fetchActiveCategories(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'categories' },
            success_callback: function success_callback(response) {
                context.commit("setActiveCategories", response.data.data);
            }
        })
    },
    fetchCategories(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "categories?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setCategories", response.data.categories);
            }
        })
    },
    dispatchCreateCategory(context, payload) {
        let _this = this;
        _this.dispatch("dispatch_request", {
            method: "POST",
            url: "categories",
            data : payload.category,
            success_callback: function success_callback(response) {
                context.dispatch('fetchCategories', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteCategory(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "categories/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchCategories', {search: {name: ""}});
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
