<template>
    <div>
        <page-title
            title="Lead Status"
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
                                placeholder="Lead Status Name..."
                                id="name"
                                name="name"
                                v-model="search.name"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <input
                                placeholder="Parent Lead Status..."
                                id="parent"
                                name="parent"
                                v-model="search.parent"
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

                <!-- Listing all lead_statuses -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th></th>
                                    <th>Label</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(lead_status, index) in getLeadStatuses.data" :key="lead_status.id"
                                    :class="{'bg-warning inactive' : !lead_status.status}"
                                >
                                    <td>{{index + getLeadStatuses.from}}</td>
                                    <td>
                                        <span class="text-capitalize">{{lead_status.name}}</span>
                                    </td>
                                    <td><span class="badge badge-primary" title="Leads Count">{{lead_status.leads_count}}</span></td>
                                    <td>
                                        <span class="label-status text-uppercase" :style="{ color: lead_status.text, background: lead_status.bg }">
                                            {{lead_status.name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            v-if="lead_status.parent_id"
                                            class="label-status text-uppercase"
                                            :style="{ color: lead_status.parent.text, background: lead_status.parent.bg }">
                                            {{lead_status.parent.name}}
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                    <td>

                                        <div class="custom-control custom-switch">
                                            <input
                                                @click="statusChange(lead_status.id, 'lead_statuses')"
                                                type="checkbox"
                                                :checked="(lead_status.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="lead_status.id"
                                            />
                                            <label class="custom-control-label" :for="lead_status.id"></label>
                                        </div>
                                    </td>
                                    <td>{{lead_status.created_at}}</td>
                                    <td>
                                        <router-link
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'lead.statuses.show', params: { id: lead_status.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link>
                                        <router-link
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'lead.statuses.edit', params: { id: lead_status.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'lead.statuses.delete', params: { id: lead_status.id }}"
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
                <pagination show=4 :data="getLeadStatuses" @updatePagination="updatePagination"> </pagination>
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
                    {router_name : 'lead.statuses.create', router_hover : 'Add Lead Status', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                lead_status: {},
                pagination: {},
                search : {
                    name: "",
                    parent: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getLeadStatuses", "getErrors", "getSearchFilter"]),

            reload(){
                return {type : 'fetchLeadStatuses', payload : {next_page: this.getLeadStatuses.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchLeadStatuses", {
                next_page: this.getLeadStatuses.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchLeadStatuses", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchLeadStatuses", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ name: 'lead.statuses.index' });
                this.search =  {
                    name: "",
                    parent: "",
                    status: ""
                };
                this.$store.dispatch("fetchLeadStatuses", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
