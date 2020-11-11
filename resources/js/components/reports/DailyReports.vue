<template>
    <div>
        
        <div class="row" v-if="hasPermission['read-reports']"> 
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#dailyReports">
                            <h5 class="cursor-pointer">Daily Reports</h5>
                        </span>
                        <div class="row">
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="start_date" >
                            </div>
                            TO
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="end_date" >
                            </div>
                            SOURCE -
                            <div class="col-2">
                                <select class="form-control" v-model="source">
                                    <option value="" disabled selected>--Source--</option>
                                    <option v-for="(lead_source,index) in getLeadSourcesActive" :value="lead_source.id" :key="index">{{lead_source.name}}</option>
                                </select>
                             </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary" type="button" @click="filterDailyReports">Filter</button>
                                <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="dailyReports">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>User Name</th>
                                                <th>Calls Done</th>
                                                <th>Lead Received</th>
                                                <th>Lead Qualified</th> &nbsp;
                                                <th v-for="(lead_status,index) in getDailyReports.lead_statuses" :key="index">{{lead_status.name}}</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center" v-for="(user,index) in getDailyReports.users" :key="index">
                                                    <td>{{user.name}}</td>
                                                    <td>
                                                        <span v-if="user.leads_done_count">{{user.leads_done_count}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="user.received_leads_count"> {{user.received_leads_count}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="user.qualified_leads_count"> {{user.qualified_leads_count}}</span>
                                                        <span v-else>-</span>
                                                    </td>&nbsp;
                                                    <td v-for="(lead_status,index) in getDailyReports.lead_statuses" :key="index">
                                                        <span v-if="user.lead_statuses[lead_status.name]">{{user.lead_statuses[lead_status.name]}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{user.sum}}</td>
                                                </tr>
                                                <tr class="text-center font-weight-bold">
                                                    <td>Total</td>
                                                    <td>
                                                        <span v-if="getDailyReports.total_leads_done">{{getDailyReports.total_leads_done}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="getDailyReports.total_received_leads">{{getDailyReports.total_received_leads}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="getDailyReports.total_qualified_leads">{{getDailyReports.total_qualified_leads}}</span>
                                                        <span v-else>-</span>
                                                    </td>&nbsp;
                                                    <td v-for="(lead_status,index) in getDailyReports.lead_status_sum" :key="index">
                                                        <span v-if="lead_status">{{lead_status}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{getDailyReports.total_leads}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data(){
            return {
                start_date : '',
                end_date : '',                
                source : "",
            }
        },
        computed : {
          ...mapGetters(['getDailyReports','getLeadSourcesActive','hasPermission'])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchDailyReports');
            this.$store.dispatch('fetchAllActiveSources');
        },
        methods:{
            filterDailyReports(){
                this.$store.dispatch('fetchDailyReports', {
                    start_date : this.start_date,
                    end_date:this.end_date,
                    source : this.source                    
                });
            },
            resetFilter() {
                this.start_date = {};
                this.end_date = {};
                this.source ="";
                this.filterDailyReports();
            }
        }
    }
</script>