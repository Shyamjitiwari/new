const state = {
    blogs: [],
};

const getters = {
    getBlogs(state) {
        return state.blogs;
    }
};

const mutations = {
    setBlogs(state, payload) {
        state.blogs = payload;
    },
};

const actions = {
    removeImage(context, payload){
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "delete-blog-image/"+payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchBlogs', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    fetchBlogs(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "blogs?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&status=" +
                payload.search.status,
            success_callback: function success_callback(response) {
                context.commit("setBlogs", response.data.blogs);
            }
        })
    },
    dispatchCreateBlog(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "blogs",
            data : payload.blog,
            success_callback: function success_callback(response) {
                context.dispatch('fetchBlogs', {search: {name: ""}});
                context.commit('showForm', false);
                context.commit('isEditable', false);
            }
        })
    },
    deleteBlog(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "blogs/" + payload.id,
            success_callback: function success_callback(response) {
                context.dispatch('fetchBlogs', {search: {name: ""}});
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
