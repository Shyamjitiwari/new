<template>
    <div>
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
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>System Message</th>
                                    <th>Request Type</th>
                                    <th>URL</th>
                                    <th>IP</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="activity in getActivities.data" :key="activity.id"
                                >
                                    <td>{{activity.created_at}}</td>
                                    <td>{{activity.activity.name}}</td>
                                    <td>{{activity.system_remark}}</td>
                                    <td>{{activity.type}}</td>
                                    <td>{{activity.url}}</td>
                                    <td>{{activity.ip}}</td>
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
            ...mapGetters(["getActivities", "getErrors", "getSearchFilter"]),

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
