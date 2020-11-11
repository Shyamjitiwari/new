<template>
    <div>
        <tag-create :tag="tag" v-if="showForm" @reset="reset"></tag-create>
        <br v-if="showForm">
        <span v-else >
            <h3>
                Tags
                <span @click="addTag">
                    <add-new-button title="Add New Tag" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Blogs</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(tag, index) in getTags.data" :key="tag.id">
                    <td>{{index + getTags.from}}</td>
                    <td>{{tag.name}}</td>
                    <td><span class="label bg-primary text-white">{{tag.blogs_count}}</span></td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                            @click="statusChange(tag.id, 'tags')"
                            type="checkbox"
                            :checked="(tag.status === 'active' ? true : false)"
                            class="custom-control-input "
                            :id="tag.id"
                            />
                            <label class="custom-control-label" :for="tag.id"></label>
                            </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editTag(tag)">edit</i>
                        <i class="material-icons text-danger" @click="deleteTag(tag)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getTags" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import TagCreate from './create';
    export default {
        components: { TagCreate },
        data(){
            return {
                tag : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchTags", {
                next_page: this.getTags.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getTags", "isEditable", "showForm"]),
        },
        methods : {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchTags", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editTag(tag){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.tag = tag;
            },
            addTag(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.tag = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.tag = {};
            },
            deleteTag(tag){
                let _this = this;
                if(confirm('Are you sure you want to delete this tag?')){
                 _this.$store.dispatch('deleteTag', tag);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
