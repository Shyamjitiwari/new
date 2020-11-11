<template>
    <div>
        <page-title
            title="Role"
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
                                placeholder="Role Name..."
                                id="name"
                                name="name"
                                v-model="search.name"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
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

                <!-- Listing all roles -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(role, index) in getRoles.data" :key="role.id"
                                    :class="{'bg-warning inactive' : !role.status}"
                                >
                                    <td>{{index + getRoles.from}}</td>
                                    <td>{{role.name}}</td>
                                    <td>
                                        <span v-for="user in role.users" :key="user.id">
                                            <span class="label-status bg-primary text-white">
                                                {{user.name}}
                                            </span>
                                        </span>
                                    </td>
                                    <td>

                                        <div class="custom-control custom-switch" v-if="getAuth.email != role.email">
                                            <input
                                                @click="statusChange(role.id, 'roles')"
                                                type="checkbox"
                                                :checked="(role.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="role.id"
                                            />
                                            <label class="custom-control-label" :for="role.id"></label>
                                        </div>
                                    </td>
                                    <td>{{role.created_at}}</td>
                                    <td>
                                        <router-link
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'roles.show', params: { id: role.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link>
                                        <router-link
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'roles.edit', params: { id: role.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            v-if="getAuth.email != role.email"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'roles.delete', params: { id: role.id }}"
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
                <pagination show=4 :data="getRoles" @updatePagination="updatePagination"> </pagination>
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
                    {router_name : 'roles.create', router_hover : 'Add Role', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                role: {},
                pagination: {},
                search : {
                    name: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getRoles", "getErrors", "getAuth", "getSearchFilter"]),

            reload(){
                return {type : 'fetchRoles', payload : {next_page: this.getRoles.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchRoles", {
                next_page: this.getRoles.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchRoles", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchRoles", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ path: 'roles' });
                this.search =  {
                    name: "",
                    status: ""
                };
                this.$store.dispatch("fetchRoles", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
