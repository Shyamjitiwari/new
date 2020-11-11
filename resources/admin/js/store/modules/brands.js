const state = {
    brands: [],
    activeBrands : [],
};

const getters = {
    getBrands(state) {
        return state.brands;
    },
    getActiveBrands(state){
        return state.activeBrands;
    }
};

const mutations = {
    setBrands(state, payload) {
        state.brands = payload;
    },
    setActiveBrands(state,payload){
        state.activeBrands  = payload;6
    }
};

const actions = {
    fetchActiveBrands(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'brands' },
            success_callback: function success_callback(response) {
                context.commit("setActiveBrands", response.data.data);
            }
        })
    },
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-brand-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchBrands', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchBrands(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "brands?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setBrands", response.data.brands);
            }
        })
    },
    dispatchCreateBrand(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "brands",
            data : payload.brand,
            success_callback: function success_callback(response) {
                context.dispatch('fetchBrands', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteBrand(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "brands/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchBrands', {search: {name: ""}});
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
