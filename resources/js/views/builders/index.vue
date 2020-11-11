<template>
    <div>
        <page-title
            title="Builders"
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
                                placeholder="Name..."
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

                <!-- Listing all builders -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th></th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    
                                <tr
                                    v-for="(builder, index) in getBuilders.data" :key="builder.id"
                                    :class="{'bg-warning inactive' : !builder.status}"
                                >
                                    <td>{{index + getBuilders.from}}</td>
                                    <td>
                                        {{builder.name}}
                                    </td>
                                    <td><span class="badge badge-primary" title="Projects Count">{{builder.projects_count}}</span></td>
                                    <td>

                                        <div class="custom-control custom-switch">
                                            <input
                                                @click="statusChange(builder.id, 'builders')"
                                                type="checkbox"
                                                :checked="(builder.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="builder.id"
                                            />
                                            <label class="custom-control-label" :for="builder.id"></label>
                                        </div>
                                    </td>
                                    <td>{{builder.created_at}}</td>
                                    <td>
                                        <router-link
                                             v-if="hasPermission['read-builders']"
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'builders.show', params: { id: builder.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link>
                                        <router-link
                                             v-if="hasPermission['update-builders']"
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'builders.edit', params: { id: builder.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            v-if="hasPermission['delete-builders']"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'builders.delete', params: { id: builder.id }}"
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
                <pagination show=4 :data="getBuilders" @updatePagination="updatePagination"> </pagination>
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
                    {router_name : 'builders.create', router_hover : 'Add Builder', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                builder: {},
                pagination: {},
                search : {
                    name: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getBuilders", "getErrors", "getAuth", "getSearchFilter", "hasPermission"]),

            reload(){
                return {type : 'fetchBuilders', payload : {next_page: this.getBuilders.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchBuilders", {
                next_page: this.getBuilders.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchBuilders", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchBuilders", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ name: 'builders.index' });
                this.search =  {
                    name: "",
                    status: ""
                };
                this.$store.dispatch("fetchBuilders", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
