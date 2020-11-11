const state = {
    products: [],
};

const getters = {
    getProducts(state) {
        return state.products;
    }
};

const mutations = {
    setProducts(state, payload) {
        state.products = payload;
    },
};

const actions = {
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-product-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchProductss', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchProducts(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "products?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setProducts", response.data.products);
            }
        })
    },
    dispatchCreateProduct(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "products",
            data : payload.product,
            success_callback: function success_callback(response) {
                context.dispatch('fetchProducts', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteProduct(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "products/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchProducts', {search: {name: ""}});
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
