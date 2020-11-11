<template>
    <div>
        <page-create :page="page" v-if="showForm" @reset="reset"></page-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Pages
                <span @click="addPage">
                    <add-new-button title="Add New Page" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(page, index) in getPages.data" :key="page.id">
                    <td>{{index + getPages.from}}</td>
                    <td>
                        {{page.name}}<br>
                        <small>{{page.slug}}</small>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(page.id, 'pages')"
                                type="checkbox"
                                :checked="(page.status === 'active' ? true : false)"
                                class="custom-control-input"
                                :id="page.id"
                            />
                            <label class="custom-control-label" :for="page.id"></label>
                        </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editPage(page)">edit</i>
                        <i class="material-icons text-danger" @click="deletePage(page)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getPages" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import PageCreate from './create';
    export default {
        components: { PageCreate },
        data(){
            return {
                page : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchPages", {
                next_page: this.getPages.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getPages", "isEditable", "showForm"]),
        },
        methods : {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchPages", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editPage(page){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.page = page;
            },
            addPage(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.page = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.page = {};
            },
            deletePage(page){
                if(confirm('Are you sure you want to delete this page?')){
                    this.$store.dispatch('deletePage', page);
                }
            }
        }
    }
</script>
