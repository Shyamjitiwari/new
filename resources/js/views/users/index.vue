<template>
    <div>
        <page-title
            title="User"
            :title_links='title_links'
            :reload="reload"
        >
        </page-title>
        <div class="col btn-toolbar card text-left">
            <div class=" p-1" v-if="getSearchFilter">
                <form id="search_form" @submit.prevent="withSearch(search)">
                    <div class="row">
                        <div class="input-field">
                            <input
                                placeholder="User Name..."
                                id="name"
                                name="name"
                                v-model="search.name"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                        <div class="input-field">
                            <input
                                placeholder="Email..."
                                id="email"
                                name="email"
                                v-model="search.email"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                         <div class="input-field">
                            <select
                                class="form-control form-control-sm"
                                v-model="search.group_id"
                                name="group"
                                id="group"
                            >
                                <option selected value="">Select User Group</option>
                                <option v-for="group in getUserGroupsActive" :key="group.id" :value="group.id">{{group.name}}</option>

                            </select>
                        </div>
                        <div class="input-field">
                            <select
                                class="form-control form-control-sm"
                                v-model="search.status"
                                name="status"
                                id="status"
                            >
                                <option selected value="">Select Status</option>
                                <option value='active'>Active</option>
                                <option value='inactive'>Inactive</option>
                            </select>
                        </div>

                        <div class="input-field col s12">
                            <button
                                title="Filter"
                                class="btn btn-sm btn-outline-primary"
                                type="submit"
                            >Search</button>
                            <button
                                type="button"
                                @click="reset()"
                                title="Reset Search"
                                class="btn btn-sm btn-outline-danger"
                            >Reset</button>&nbsp;
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <!-- Listing all users -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Team</th>
                                    <th>Role</th>
                                    <th>User Group</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(user, index) in getUsers.data" :key="user.id"
                                    :class="{'bg-warning inactive' : !user.status}"
                                >
                                    <td>{{index + getUsers.from}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.mobile}}</td>
                                    <td>
                                        <span v-if="user.team" v-for="team in user.team" class="label-status bg-success text-white">{{team.name}}</span>
                                        <span v-else>-</span>
                                    </td>
                                    <td class="text-capitalize">
                                        <span v-if="user.role_id" class="badge badge-primary">{{user.role.name}}</span>
                                        <span v-else class="badge badge-warning">None</span>
                                    </td>
                                    <td class="text-capitalize">
                                        <span v-if="user.user_group" class="badge badge-primary">{{user.user_group.name}}</span>
                                        <span v-else class="badge badge-warning">None</span>
                                    </td>
                                    <td>

                                        <div class="custom-control custom-switch" v-if="getAuth.email != user.email">
                                            <input
                                                @click="statusChange(user.id, 'users')"
                                                type="checkbox"
                                                :checked="(user.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="user.id"
                                            />
                                            <label class="custom-control-label" :for="user.id"></label>
                                        </div>
                                    </td>
                                    <td>{{user.created_at}}</td>
                                    <td>
                                        <router-link
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'users.show', params: { id: user.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link>
                                        <router-link
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'users.edit', params: { id: user.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            title="Change Password"
                                            tag="a"
                                            :to="{ name: 'users.change_password', params: { id: user.id }}"
                                        >
                                            <i class="material-icons text-info">sync</i>
                                        </router-link>
                                        <router-link
                                            v-if="getAuth.email != user.email"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'users.delete', params: { id: user.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-danger">delete</i>
                                        </router-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br />
                <pagination show=4 :data="getUsers" @updatePagination="updatePagination"> </pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                title_links : [
                    {router_name : 'users.create', router_hover : 'Add User', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                user: {},
                pagination: {},
                search : {
                    name: "",
                    email: "",
                    group_id: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getUsers", "getErrors", "getImageUrl", "getFolder", "getAuth", "getSearchFilter", "getUserGroupsActive"]),

            reload(){
                return {type : 'fetchUsers', payload : {next_page: this.getUsers.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch('fetchAllActiveUserGroups');
            this.$store.dispatch("fetchUsers", {
                next_page: this.getUsers.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchUsers", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchUsers", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ path: 'users' });
                this.search =  {
                    name: "",
                    email: "",
                    group_id: "",
                    status: ""
                };
                this.$store.dispatch("fetchUsers", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
