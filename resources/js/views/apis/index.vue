<template>
    <div>
        <page-title
            title="Api"
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
                                placeholder="URL..."
                                id="url"
                                name="url"
                                v-model="search.url"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                        
                        <div class="input-field">
                            <select
                                class="form-control form-control-sm"
                                v-model="search.type"
                                name="type"
                                id="type"
                            >
                                <option selected value="">Select Type</option>
                                <option value='magic_bricks'>Magic Bricks</option>
                                <option value='acres'>Acres</option>
                                <option value='housing'>Housing</option>
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

                <!-- Listing all apis -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>URL</th>
                                    <th>Type</th>
                                    <th>Key</th>
                                    <th>User Name</th>
                                    <th>Password</th>
                                    <th>Account Id</th>
                                    <th>User Group</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(api, index) in getApis.data" :key="api.id"
                                    :class="{'bg-warning inactive' : !api.status}"
                                >
                                    <td>{{index + getApis.from}}</td>
                                    <td> {{api.url}} </td>
                                    <td>{{api.type}} </td>
                                     <td>  <span v-if="api.key"> {{api.key}}</span>
                                         <span v-else=""> - </span>
                                    </td>
                                    <td>  <span v-if="api.user_name"> {{api.user_name}}</span>
                                         <span v-else=""> - </span>
                                    </td>
                                    <td>  <span v-if="api.password"> {{api.password}}</span>
                                         <span v-else=""> - </span>
                                    </td>
                                    <td>  <span v-if="api.account_id"> {{api.account_id}}</span>
                                         <span v-else=""> - </span>
                                    </td>
                                    <td>  <span v-if="api.user_group"> {{api.user_group.name}}</span>
                                         <span v-else=""> - </span>
                                    </td>
                                    <td>

                                        <div class="custom-control custom-switch">
                                            <input
                                                @click="statusChange(api.id, 'apis')"
                                                type="checkbox"
                                                :checked="(api.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="api.id"
                                            />
                                            <label class="custom-control-label" :for="api.id"></label>
                                        </div>
                                    </td>
                                    <td>{{api.created_at}}</td>
                                    <td>
                                        <!-- <router-link
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'apis.show', params: { id: api.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link> -->
                                        <router-link
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'apis.edit', params: { id: api.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            v-if="getAuth.email != api.email"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'apis.delete', params: { id: api.id }}"
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
                <pagination show=4 :data="getApis" @updatePagination="updatePagination"> </pagination>
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
                    {router_name : 'apis.create', router_hover : 'Add API', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                api: {},
                pagination: {},
                search : {
                    url: "",
                    type: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getApis", "getErrors", "getAuth", "getSearchFilter"]),

            reload(){
                return {type : 'fetchApis', payload : {next_page: this.getApis.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchApis", {
                next_page: this.getApis.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchApis", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchApis", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ name: 'apis.index' });
                this.search =  {
                    url: "",
                    type: "",
                    status: ""
                };
                this.$store.dispatch("fetchApis", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
