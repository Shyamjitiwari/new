const state = {
    image_folder: 'users',
};

const getters = {
    getFolder(state) {
        return state.image_folder;
    }
};

const mutations = {
    setFolder(state) {
        return state.image_folder;
    }
};

const actions = {
    fetchFolder(table) {
        if (table === 'users') {
            this.store.commit('setFolder', 'users');
        } else if (table === 'app') {
            this.store.commit('setFolder', 'app');
        } else {
            this.store.commit('setFolder', 'common');
        }
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}