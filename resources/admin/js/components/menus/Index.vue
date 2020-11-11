<template>
    <div>
        <menu-create :menu="menu" v-if="showForm" @reset="reset"></menu-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Menus
                <span @click="addMenu">
                    <add-new-button title="Add New Menu" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Target</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(menu, index) in getMenus.data" :key="menu.id">
                    <td>{{index + getMenus.from}}</td>
                    <td>
                        {{menu.name}}<br>
                        <small>{{menu.slug}}</small>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(menu.id, 'menus')"
                                type="checkbox"
                                :checked="(menu.status === 'active' ? true : false)"
                                class="custom-control-input"
                                :id="menu.id"
                            />
                            <label class="custom-control-label" :for="menu.id"></label>
                        </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editPage(menu)">edit</i>
                        <i class="material-icons text-danger" @click="deletePage(menu)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getMenus" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import MenuCreate from './create';
    export default {
        components: { MenuCreate },
        data(){
            return {
                menu : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchMenus", {
                next_page: this.getMenus.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getMenus", "isEditable", "showForm"]),
        },
        methods : {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchMenus", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editPage(menu){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.menu = menu;
            },
            addMenu(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.menu = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.menu = {};
            },
            deletePage(menu){
                if(confirm('Are you sure you want to delete this menu?')){
                    this.$store.dispatch('deletePage', menu);
                }
            }
        }
    }
</script>
