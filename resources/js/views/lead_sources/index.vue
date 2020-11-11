<template>
    <div>
        <page-title
            title="Lead Source"
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
                                placeholder="LeadSource Name..."
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

                <!-- Listing all lead_sources -->
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
                                    v-for="(lead_source, index) in getLeadSources.data" :key="lead_source.id"
                                    :class="{'bg-warning inactive' : !lead_source.status}"
                                >
                                    <td>{{index + getLeadSources.from}}</td>
                                    <td>
                                        {{lead_source.name}}
                                    </td>
                                    <td><span class="badge badge-primary" title="Leads Count">{{lead_source.leads_count}}</span></td>
                                    <td>

                                        <div class="custom-control custom-switch">
                                            <input
                                                @click="statusChange(lead_source.id, 'lead_sources')"
                                                type="checkbox"
                                                :checked="(lead_source.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="lead_source.id"
                                            />
                                            <label class="custom-control-label" :for="lead_source.id"></label>
                                        </div>
                                    </td>
                                    <td>{{lead_source.created_at}}</td>
                                    <td>
                                        <router-link
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'lead.sources.show', params: { id: lead_source.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link>
                                        <router-link
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'lead.sources.edit', params: { id: lead_source.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            v-if="getAuth.email != lead_source.email"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'lead.sources.delete', params: { id: lead_source.id }}"
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
                <pagination show=4 :data="getLeadSources" @updatePagination="updatePagination"> </pagination>
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
                    {router_name : 'lead.sources.create', router_hover : 'Add Lead Source', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                lead_source: {},
                pagination: {},
                search : {
                    name: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getLeadSources", "getErrors", "getAuth", "getSearchFilter"]),

            reload(){
                return {type : 'fetchLeadSources', payload : {next_page: this.getLeadSources.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchLeadSources", {
                next_page: this.getLeadSources.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchLeadSources", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchLeadSources", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ name: 'lead.sources.index' });
                this.search =  {
                    name: "",
                    status: ""
                };
                this.$store.dispatch("fetchLeadSources", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
