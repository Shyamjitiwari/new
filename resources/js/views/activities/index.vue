<template>
    <div>
        <page-title
            title="Activity"
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
                                id="user_id"
                                name="user_id"
                                v-model="search.name"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <select
                                class="form-control form-control-sm"
                                v-model="search.remarks"
                                name="status"
                                id="status"
                            >
                                <option selected value="">Select Status</option>
                                <option value='ActivityLabels::_LOGIN'>Login</option>
                                <option value='ActivityLabels::_LOGOUT'>Logout</option>
                                <option value='ActivityLabels::_LOGOUT_SYSTEM'>System Logout</option>
                                <option value='ActivityLabels::_LEAD_SEARCHED'>Single Lead Vuew</option>
                                <option value='ActivityLabels::_LEAD_INDEX_VIEWED'>All Leads Views</option>
                                <option value='ActivityLabels::_LEAD_TRANSFERRED'>Leads Transferred</option>
                                <option value='ActivityLabels::_LEAD_UPDATED'>Leads Updated</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <input
                                id="created_at"
                                name="created_at"
                                v-model="search.created_at"
                                type="date"
                                class="form-control validate form-control-sm"
                            />
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

                <!-- Listing all activities -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>System Message</th>
                                    <th>Notes</th>
                                    <th width="40">Payload</th>
                                    <th>User</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(activity, index) in getActivities.data" :key="activity.id"
                                >
                                    <td>{{index + getActivities.from}}</td>
                                    <td>{{activity.activity.name}}</td>
                                    <td>{{activity.system_remark}}</td>
                                    <td>{{activity.notes}}</td>
                                    <td width="40">{{activity.payload}}</td>
                                    <td>{{activity.created_at}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br />
                <pagination show=4 :data="getActivities" @updatePagination="updatePagination"> </pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                activity: {},
                pagination: {},
                search : {
                    name: "",
                    remarks: "",
                    created_at : ""
                }
            };
        },

        computed: {
            ...mapGetters(["getActivities", "getErrors", "getAuth", "getSearchFilter"]),

            reload(){
                return {type : 'fetchActivities', payload : {next_page: this.getActivities.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchActivities", {
                next_page: this.getActivities.current_page,
                search: this.search
            });
        },

        methods: {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchActivities", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchActivities", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ path: 'activities' });
                this.search =  {
                    name: "",
                    remarks: "",
                    created_at : ""
                };
                this.$store.dispatch("fetchActivities", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
