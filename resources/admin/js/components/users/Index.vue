<template>
    <div>
        <user-create :user="user" :isEditable="isEditable" v-if="showForm" @reset="reset"></user-create>
        <br v-if="showForm">
        <span v-else >
            <h3>
                Users
                <span @click="addUser">
                    <add-new-button title="Add New User" ></add-new-button>
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
                <tr v-for="(user, index) in getUsers.data" :key="user.id">
                    <td>{{index + getUsers.from}}</td>
                    <td>{{user.name}}</td>
                    <td>
                        <span v-for="user in user.users" :key="user.id" class="label bg-primary text-white">
                            {{user.name}}
                        </span>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                            @click="statusChange(user.id, 'users')"
                            type="checkbox"
                            :checked="(user.status === 'active' ? true : false)"
                            class="custom-control-input "
                            :id="user.id"
                            />
                            <label class="custom-control-label" :for="user.id"></label>
                            </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editUser(user)">edit</i>
                        <i class="material-icons text-danger" @click="deleteUser(user)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getUsers" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import UserCreate from './create';
    export default {
        components: { UserCreate },
        data(){
            return {
                user : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchUsers", {
                next_page: this.getUsers.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getUsers", "isEditable", "showForm"]),
        },
        methods : {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchUsers", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editUser(user){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.user = user;
            },
            addUser(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.user = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.user = {};
            },
            deleteUser(user){
                let _this = this;
                if(confirm('Are you sure you want to delete this user?')){
                 _this.$store.dispatch('deleteUser', user);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
