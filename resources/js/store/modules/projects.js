import router from "../../router/router";

const state = {
    projects: {},
    project: {},
    activeFilteredProjects: {}
};

const getters = {
    getProjects(state) {
        return state.projects;
    },
    getProject(state) {
        return state.project;
    },
    getActiveFilteredProjects(state) {
        return state.activeFilteredProjects;
    }
};

const mutations = {
    setProjects(state, payload) {
        state.projects = payload;
    },
    setProject(state, payload) {
        state.project = payload;
    },
    setAllActiveFilteredProjects(state, payload) {
        state.activeFilteredProjects = payload;
    }
};

const actions = {
    fetchAllActiveProjects(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active",
            data: { 'table': 'projects' },
            success_callback: function success_callback(response) {
                context.commit("setProjects", response.data.data);
            }
        })
    },
    fetchAllActiveFilteredProjects(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "get-all-active-filtered",
            data: payload,
            success_callback: function success_callback(response) {
                context.commit("setAllActiveFilteredProjects", response.data.data);
            }
        })
    },
    fetchProjects(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "projects?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&builder=" +
                payload.search.builder_id +
                "&city=" +
                payload.search.city +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setProjects", response.data.data);
            }
        })
    },
    fetchShowProject(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "projects/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setProject", response.data.data);
            }
        })
    },
    fetchEditProject(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "projects/" + payload + "/edit/",
            success_callback: function success_callback(response) {
                context.commit("setProject", response.data.data);
            }
        })
    },

    dispatchCreateProject(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "projects",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditProject(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "projects/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteProject(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "projects/" + payload.id,
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
