import router from "../../router/router";

const state = {
    locations: {},
    location: {},
    activeFilteredLocations: {},
    parentLocations: {},
};

const getters = {
    getLocations(state) {
        return state.locations;
    },
    getLocation(state) {
        return state.location;
    },
    getActiveFilteredLocations(state) {
        return state.activeFilteredLocations;
    },
    getParentLocations(state) {
        return state.parentLocations;
    },
};

const mutations = {
    setLocations(state, payload) {
        state.locations = payload;
    },
    setLocation(state, payload) {
        state.location = payload;
    },
    setAllActiveFilteredLocations(state, payload) {
        state.activeFilteredLocations = payload;
    },
    setParentLocations(state, payload) {
        state.parentLocations = payload;
    },
};

const actions = {
    fetchAllActiveLocations(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'locations' },
            success_callback: function success_callback(response) {
                context.commit("setLocations", response.data.data);
            }
        })
    },
    fetchAllActiveFilteredLocations(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active-filtered",
            data: payload,
            success_callback: function success_callback(response) {
                context.commit("setAllActiveFilteredLocations", response.data.data);
            }
        })
    },
    fetchParentLocations(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-parent-locations",
            success_callback: function success_callback(response) {
                context.commit("setParentLocations", response.data.data);
            }
        })
    },
    fetchLocations(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "locations?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&pincode=" +
                payload.search.pincode +
                "&parent=" +
                payload.search.parent_id +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setLocations", response.data.data);
            }
        })
    },
    fetchShowLocation(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "locations/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setLocation", response.data.data);
            }
        })
    },
    fetchEditLocation(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "locations/" + payload + "/edit/",
            success_callback: function success_callback(response) {
                context.commit("setLocation", response.data.data);
            }
        })
    },

    dispatchCreateLocation(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "locations",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditLocation(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "locations/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteLocation(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "locations/" + payload.id,
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
