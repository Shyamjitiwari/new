<template>
    <div>
        <blog-create :blog="blog" v-if="showForm" @reset="reset"></blog-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Blogs
                <span @click="addBlog">
                    <add-new-button title="Add New Blog" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(blog, index) in getBlogs.data" :key="blog.id">
                    <td>{{index + getBlogs.from}}</td>
                    <td>
                        {{blog.name}}<br>
                        <small>{{blog.slug}}</small>
                    </td>
                    <td>
                        <span class="label bg-secondary text-white">{{blog.category.name}}</span>
                    </td>
                    <td>
                        <span v-for="tag in blog.tags" :key="tag.id" class="label bg-info text-white">{{tag.name}}</span>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(blog.id, 'blogs')"
                                type="checkbox"
                                :checked="(blog.status === 'active' ? true : false)"
                                class="custom-control-input"
                                :id="blog.id"
                            />
                            <label class="custom-control-label" :for="blog.id"></label>
                        </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editBlog(blog)">edit</i>
                        <i class="material-icons text-danger" @click="deleteBlog(blog)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getBlogs" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import BlogCreate from './create';
    export default {
        components: { BlogCreate },
        data(){
            return {
                blog : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchBlogs", {
                next_page: this.getBlogs.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getBlogs", "isEditable", "showForm"]),
        },
        methods : {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchBlogs", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editBlog(blog){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.blog = blog;
            },
            addBlog(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.blog = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.blog = {};
            },
            deleteBlog(blog){
                if(confirm('Are you sure you want to delete this blog?')){
                    this.$store.dispatch('deleteBlog', blog);
                }
            }
        }
    }
</script>
