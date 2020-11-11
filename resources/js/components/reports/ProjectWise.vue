<template>
    <div>
        <div class="row" v-if="hasPermission['read-reports']">
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#multiCollapseExample4">
                            <h5 class="cursor-pointer">User-Lead Project-Wise</h5>
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
                                <button class="btn btn-sm btn-primary" type="button" @click="filterUserLeadWiseProject">Filter</button>
                                <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample4">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>User Name</th>
                                                <th v-for="(lead_project,index) in getUserLeadProjectWise.lead_projects" :key="index">{{lead_project.name}}</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center" v-for="(user,index) in getUserLeadProjectWise.users" :key="index">
                                                    <td>{{user.name}}</td>
                                                    <td v-for="(lead_project,index) in getUserLeadProjectWise.lead_projects" :key="index">
                                                        <span v-if="user.lead_projects[lead_project.name]">{{user.lead_projects[lead_project.name]}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{user.sum}}</td>
                                                </tr>
                                                <tr class="text-center font-weight-bold">
                                                    <td>Total</td>
                                                    <td v-for="(lead_project,index) in getUserLeadProjectWise.lead_project_sum" :key="index">
                                                        <span v-if="lead_project">{{lead_project}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{getUserLeadProjectWise.total_leads}}</td>
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
          ...mapGetters(['getUserLeadProjectWise', 'getLeadSourcesActive','hasPermission'])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchUserLeadProjectWise');
            this.$store.dispatch('fetchAllActiveSources');
        },
        methods:{
            filterUserLeadWiseProject(){
                this.$store.dispatch('fetchUserLeadProjectWise', {
                    start_date : this.start_date,
                    end_date:this.end_date,
                    source : this.source
                });
            },
            resetFilter() {
                this.start_date = {};
                this.end_date = {};
                this.source = "";
                this.filterUserLeadWiseProject();
            }
        }
    }
</script>
