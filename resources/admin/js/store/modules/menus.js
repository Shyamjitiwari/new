const state = {
    menus: [],
};

const getters = {
    getMenus(state) {
        return state.menus;
    }
};

const mutations = {
    setMenus(state, payload) {
        state.menus = payload;
    },
};

const actions = {
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-menu-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchMenus', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchMenus(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "menus?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setMenus", response.data.menus);
            }
        })
    },
    dispatchCreateMenu(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "menus",
            data : payload.menu,
            success_callback: function success_callback(response) {
                context.dispatch('fetchMenus', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteMenu(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "menus/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchMenus', {search: {name: ""}});
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
