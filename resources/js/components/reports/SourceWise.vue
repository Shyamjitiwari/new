<template>
    <div>
      
        <div class="row" v-if="hasPermission['read-reports']">
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#multiCollapseExample3">
                            <h5 class="cursor-pointer">User-Lead Source-Wise</h5>
                        </span>
                        <div class="row">
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="start_date" >
                            </div>
                            TO
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="end_date" >
                            </div>
                            PROJECT -
                            <div class="col-2">
                                <select class="form-control" v-model="project">
                                    <option value="" disabled selected>--Project--</option>
                                    <option v-for="(project,index) in getProjects" :value="project.id" :key="index">{{project.name}}</option>
                                </select>
                             </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary" type="button" @click="filterUserLeadWiseSource">Filter</button>
                                <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample3">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>User Name</th>
                                                <th v-for="(lead_source,index) in getUserLeadSourceWise.lead_sources" :key="index">{{lead_source.name}}</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center" v-for="(user,index) in getUserLeadSourceWise.users" :key="index">
                                                    <td>{{user.name}}</td>
                                                    <td v-for="(lead_source,index) in getUserLeadSourceWise.lead_sources" :key="index">
                                                        <span v-if="user.lead_sources[lead_source.name]">{{user.lead_sources[lead_source.name]}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{user.sum}}</td>
                                                </tr>
                                                <tr class="text-center font-weight-bold">
                                                    <td>Total</td>
                                                    <td v-for="(lead_source,index) in getUserLeadSourceWise.lead_source_sum" :key="index">
                                                        <span v-if="lead_source">{{lead_source}}</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>{{getUserLeadSourceWise.total_leads}}</td>
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
                project : "",
            }
        },
        computed : {
          ...mapGetters(['getUserLeadSourceWise','getProjects', 'hasPermission'])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchUserLeadSourceWise');
            this.$store.dispatch('fetchAllActiveProjects');
        },
        methods:{
            filterUserLeadWiseSource(){
                this.$store.dispatch('fetchUserLeadSourceWise', {
                    start_date : this.start_date,
                    end_date:this.end_date,
                    project : this.project
                    });
            },
            resetFilter() {
                this.start_date = {};
                this.end_date = {};
                this.project = "";
                this.filterUserLeadWiseSource();
            }
        }
    }
</script>
