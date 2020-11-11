const state = {
    attributeGroups: [],
    activeAttributeGroups : [],
};

const getters = {
    getAttributeGroups(state) {
        return state.attributeGroups;
    },
    getActiveAttributeGroups(state){
        return state.activeAttributeGroups;
    }
};

const mutations = {
    setAttributeGroups(state, payload) {
        state.attributeGroups = payload;
    },
    setActiveAttributeGroups(state, payload){
        state.activeAttributeGroups = payload;
    }
};

const actions = {
    fetchActiveAttributeGroups(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'attribute_groups' },
            success_callback: function success_callback(response) {
                context.commit("setActiveAttributeGroups", response.data.data);
            }
        })
    },
    fetchAttributeGroups(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "attributeGroups?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setAttributeGroups", response.data.attributeGroup);
            }
        })
    },
    dispatchCreateAttributeGroup(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "attributeGroups",
            data : payload.attributeGroup,
            success_callback: function success_callback(response) {
                context.dispatch('fetchAttributeGroups', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteAttributeGroup(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "attributeGroups/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchAttributeGroups', {search: {name: ""}});
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
