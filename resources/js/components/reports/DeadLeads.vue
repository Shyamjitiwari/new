<template>
    <div>
       
        <div class="row" v-if="hasPermission['read-reports']"> 
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#deadLeads">
                            <h5 class="cursor-pointer">Dead-Leads User-Wise</h5>
                        </span>
                        <div class="row">
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="start_date" >
                            </div>
                            TO
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="end_date" >
                            </div>
                            Status 
                            <div class="col-2">
                                    <select class="form-control" v-model="status">
                                    <option value="" disabled selected>--Status--</option>
                                    <option v-for="(lead_status,index) in getParentLeadStatuses" :value="lead_status.id" :key="index">{{lead_status.name}}</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary" type="button" @click="filterDeadLeadsUserWise">Filter</button>
                                <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="deadLeads">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>User Name</th>
                                                <th v-for="(lead_status,index) in getDeadLeadsUserWise.lead_statuses" :key="index">{{lead_status.name}}</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center" v-for="(user,index) in getDeadLeadsUserWise.users" :key="index">
                                                    <td>{{user.name}}</td>
                                                    <td v-for="(lead_status,index) in getDeadLeadsUserWise.lead_statuses" :key="index">
                                                        <span v-if="user.lead_statuses[lead_status.name]">{{user.lead_statuses[lead_status.name]}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{user.sum}}</td>
                                                </tr>
                                                <tr class="text-center font-weight-bold">
                                                    <td>Total</td>
                                                    <td v-for="(lead_status,index) in getDeadLeadsUserWise.lead_status_sum" :key="index">
                                                        <span v-if="lead_status">{{lead_status}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{getDeadLeadsUserWise.total_leads}}</td>
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
                status  : '' 
            }
        },
        computed : {
          ...mapGetters(['getDeadLeadsUserWise','getParentLeadStatuses','hasPermission'])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchDeadLeads');
            this.$store.dispatch('fetchParentLeadStatuses');
        },
        methods:{
            filterDeadLeadsUserWise(){
                this.$store.dispatch('fetchDeadLeads', {
                     start_date : this.start_date,
                    end_date:this.end_date,
                    status : this.status
                });
            },
            resetFilter() {
                this.start_date = {};
                this.end_date = {};
                this.status = "";
                this.filterDeadLeadsUserWise();
            }
        }
    }
</script>