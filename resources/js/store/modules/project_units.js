import router from "../../router/router";

const state = {
    projectUnits: {},
    projectUnit: {},
    activeFilteredProjectUnits: {}
};

const getters = {
    getProjectUnits(state) {
        
        return state.projectUnits;
    },
    getProjectUnit(state) {
        return state.projectUnit;
    },
    getActiveFilteredProjectUnits(state) {
        return state.activeFilteredProjectUnits;
    }
};

const mutations = {
    setProjectUnits(state, payload) {
      
        state.projectUnits = payload;
    },
    setProjectUnit(state, payload) {
        state.projectUnit = payload;
    },
    setAllActiveFilteredProjectUnits(state, payload) {
        state.activeFilteredProjectUnits = payload;
    }
};

const actions = {
    fetchAllActiveProjectUnits(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'project_units' },
            success_callback: function success_callback(response) {
                context.commit("setProjectUnits", response.data.data);
            }
        })
    },
    fetchAllActiveFilteredProjectUnits(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active-filtered",
            data: payload,
            success_callback: function success_callback(response) {
                context.commit("setAllActiveFilteredProjectUnits", response.data.data);
            }
        })
    },
    fetchProjectUnits(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "projectUnits?page=" +
                payload.next_page +
                "&type=" +
                payload.search.type +
                "&size=" +
                payload.search.size +
                "&startPrice=" +
                payload.search.startPrice +
                "&endPrice=" +
                payload.search.endPrice +
                "&location=" +
                payload.search.location +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setProjectUnits", response.data.data);
            }
        })
    },
    fetchShowProjectUnit(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "projectUnits/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setProjectUnit", response.data.data);
            }
        })
    },
    fetchEditProjectUnit(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "projectUnits/" + payload + "/edit/",
            success_callback: function success_callback(response) {
                context.commit("setProjectUnit", response.data.data);
            }
        })
    },

    dispatchCreateProjectUnit(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "projectUnits",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditProjectUnit(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "projectUnits/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteProjectUnit(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "projectUnits/" + payload.id,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
