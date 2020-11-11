const state = {
    showForm : false,
    isEditable : false,

};

const getters = {
    showForm(state) {
        return state.showForm;
    },
    isEditable(state) {
        return state.isEditable;
    }
};

const mutations = {
    showForm(state, payload) {
        state.showForm = payload;
    },
    isEditable(state, payload) {
        state.isEditable = payload;
    },
};

const actions = {

};

export default {
    state,
    getters,
    mutations,
    actions
}
