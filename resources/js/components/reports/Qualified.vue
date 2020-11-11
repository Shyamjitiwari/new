<template>
    <div>
       
        <div class="row" v-if="hasPermission['read-reports']">
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#multiCollapseExample">
                            <h5 class="cursor-pointer">Qualified-Leads User-wise</h5>
                        </span>
                        <div class="row">
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="start_date" >
                            </div>
                            TO
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="end_date" >
                            </div>
                            <!-- PROJECT -
                            <div class="col-2">
                                <select class="form-control" v-model="project">
                                    <option value="" disabled selected>--Project--</option>
                                    <option v-for="(project,index) in getProjects" :value="project.id" :key="index">{{project.name}}</option>
                                </select>
                             </div> -->
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary" type="button" @click="filterQualifiedReports">Filter</button>
                                <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>User Name</th>
                                                <th v-for="(users,index) in getQualifiedLeads.users" :key="index">{{users.name}}</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center" v-for="(user,index) in getQualifiedLeads.users" :key="index">
                                                    <td>{{user.name}}</td>
                                                    <td v-for="(qualified_to,index) in user.qualified_leads" :key="index">
                                                        <span v-if="qualified_to">{{qualified_to}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{user.leads_count}}</td>
                                                </tr>
                                                <tr class="text-center font-weight-bold">
                                                    <td>Total</td>
                                                    <td v-for="(qualified_lead,index) in getQualifiedLeads.qualified_leads_sum" :key="index">
                                                        <span v-if="qualified_lead">{{qualified_lead}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{getQualifiedLeads.total_leads}}</td>
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
            }
        },
        computed : {
          ...mapGetters(['getQualifiedLeads', 'hasPermission'])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchQualifiedLeadsUserWise');
        },
        methods:{
            filterQualifiedReports(){
                this.$store.dispatch('fetchQualifiedLeadsUserWise', {
                    start_date : this.start_date,
                    end_date:this.end_date,
                    });
            },
            resetFilter() {
                this.start_date = {};
                this.end_date = {};
                this.filterQualifiedReports();
            }
        }
    }
</script>
