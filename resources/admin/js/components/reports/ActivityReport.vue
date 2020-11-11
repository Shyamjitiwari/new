<template>
    <div>
        <div class="row" >
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#activityChart">
                            
                            <h5 class="cursor-pointer">Activity Report</h5>
                        </span>
                        <div class="row">
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="start_date" >
                            </div>
                            TO
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="end_date" >
                            </div>
                            Activactivitiable Type -
                            <div class="col-2">
                                <select class="form-control" v-model="activitiable_type">
                                    <option value="" disabled selected>--Activactivitiable Type--</option>
                                    <option value="App\Category" >Category</option>
                                    <option value="App\Tag" > Tag</option>
                                    <option value="App\Blog" > Blog</option>
                                    <option value="App\Testimonial" > Testimonial</option>
                                    <option value="App\Service" > Service</option>
                                    <option value="App\Role" > Role</option>
                                    <option value="App\User" > User</option>
                                    <option value="App\Comment" > Comment</option>
                                    <option value="App\Enquiry" > Enquiry</option>
                                </select>
                            </div>
                            System Remark
                            <div class="col-2">
                                <select class="form-control" v-model="system_remark">
                                    <option value="" disabled selected>--System Remark--</option>
                                    <option value="ActivityLabels::_LOGIN" > _LOGIN </option>
                                    <option value="ActivityLabels::_LOGOUT" > _LOGOUT</option>
                                   </select>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary" type="button" @click="filterActivityReport">Filter</button>
                                <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="container">
                                <div class="Chart" v-if="show">
                                    <h1 style="text-align:center;">Activity Chart</h1>
                                    <line-example  :chartData="dataChart" />
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
import LineExample from './Chart'
import { mapGetters } from "vuex";

export default {
     components: {
      LineExample,     
    },
    data(){
        return{
            start_date :"",
            end_date :"",
            activitiable_type : "",
            system_remark : "",
            show : false, 

            dataChart: {
                labels: [],
                datasets: [
                {
                    label: "Data One",
                    backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
                    data: []
                }
                ]
            },

        }
    },
    computed : {
        ...mapGetters(['getActivityReports','hasPermission']),

    },

    created() {
            this.$store.dispatch('fetchActivityReports');
            
        },

    methods:{
        showActivityChart(){
            this.dataChart.labels  = this.getActivityReports.labels;
            this.dataChart.datasets[0].data  = this.getActivityReports.data;
            this.show  = true;

        },
        filterActivityReport(){
            
            this.$store.dispatch('fetchActivityReports',{
                start_date : this.start_date,
                end_date : this.end_date,
                activitiable_type : this.activitiable_type,
                system_remark : this.system_remark,
            });
            this.showActivityChart();

        },
        resetFilter() {
                this.start_date = {};
                this.end_date = {};
                this.activitiable_type ="";
                this.system_remark ="";
                this.filterActivityReport();
                this.show = false;
            }

    }
}
</script>
<style>
  .container {
    max-width: 800px;
    margin: 0 auto;
  }
  h1 {
    font-family: 'Helvetica', Arial;
    color: #464646;
    text-transform: uppercase;
    border-bottom: 1px solid #f1f1f1;
    padding-bottom: 15px;
    font-size: 28px;
    margin-top: 0;
  }
  .Chart {
    padding: 20px;
    box-shadow: 0px 0px 20px 2px rgba(0, 0, 0, .4);
    border-radius: 20px;
    margin: 50px 0;
  }
</style>