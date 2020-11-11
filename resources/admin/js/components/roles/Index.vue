<template>
    <div>
        <role-create :role="role" :isEditable="isEditable" v-if="showForm" @reset="reset"></role-create>
        <br v-if="showForm">
        <span v-else >
            <h3>
                Roles
                <span @click="addRole">
                    <add-new-button title="Add New Role" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Users</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(role, index) in getRoles.data" :key="role.id">
                    <td>{{index + getRoles.from}}</td>
                    <td>{{role.name}}</td>
                    <td>
                        <span v-for="user in role.users" :key="user.id" class="label bg-primary text-white">
                            {{user.name}}
                        </span>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                            @click="statusChange(role.id, 'roles')"
                            type="checkbox"
                            :checked="(role.status === 'active' ? true : false)"
                            class="custom-control-input "
                            :id="role.id"
                            />
                            <label class="custom-control-label" :for="role.id"></label>
                            </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editRole(role)">edit</i>
                        <i class="material-icons text-danger" @click="deleteRole(role)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getRoles" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import RoleCreate from './create';
    export default {
        components: { RoleCreate },
        data(){
            return {
                role : {
                    permissions : []
                },
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchRoles", {
                next_page: this.getRoles.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getRoles", "isEditable", "showForm"]),
        },
        methods : {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchRoles", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editRole(role){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.role = role;
            },
            addRole(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.role = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.role = {};
            },
            deleteRole(role){
                let _this = this;
                if(confirm('Are you sure you want to delete this role?')){
                 _this.$store.dispatch('deleteRole', role);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
