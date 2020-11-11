<template>
    <div>
        <category-create :category="category" v-if="showForm" @reset="reset"></category-create>
        <br v-if="showForm">
        <span v-else >
            <h3>
                Categories
                <span @click="addCategory">
                    <add-new-button title="Add New Category" ></add-new-button>
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
                <tr v-for="(category, index) in getCategories.data" :key="category.id">
                    <td>{{index + getCategories.from}}</td>
                    <td>{{category.name}}</td>
                    <td><span class="label bg-primary text-white">{{category.blogs_count}}</span></td>
                     <td>
                        <div class="custom-control custom-switch">
                            <input
                            @click="statusChange(category.id, 'categories')"
                            type="checkbox"
                            :checked="(category.status === 'active' ? true : false)"
                            class="custom-control-input "
                            :id="category.id"
                            />
                            <label class="custom-control-label" :for="category.id"></label>
                            </div>
                    </td>
                    <td>
                        <i class="fas fa-pen text-warning" @click="editCategory(category)"></i>
                        <i class="fas fa-trash text-danger" @click="deleteCategory(category)"></i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getCategories" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import CategoryCreate from './create';
    export default {
        components: { CategoryCreate },
        data(){
            return {
                category : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchCategories", {
                next_page: this.getCategories.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getCategories", "isEditable", "showForm"]),
        },
        methods : {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchCategories", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editCategory(category){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.category = category;
            },
            addCategory(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.category = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.category = {};
            },
            deleteCategory(category){
                let _this = this;
                if(confirm('Are you sure you want to delete this category?')){
                 _this.$store.dispatch('deleteCategory', category);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
