<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="generateReport" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Location<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select  class="option form-control" @change="onChangeOfLocation($event)" v-model="selectedValueOfLocation" required>
                                        <option v-for="location in locations" v-bind:key="location.location_id" :value="location.location_id"> {{ location.location_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Period From<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <input class="form-control" type="date" v-model="report_input.period_from" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Period To<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <input class="form-control" type="date" v-model="report_input.period_to" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" v-model="sendEmail">
                                    <label class="custom-control-label" for="customCheck1">Email pay report to teachers</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label"></label>
                                <div class="col-lg-8">
                                    <input class="btn btn-primary" type="submit" value="Get Report" />
                                </div>
                            </div>
                        </form>
                        <p v-html="report_data"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                location_id : '',
                location: { location_id: '', location_name : ''},
                locations:[],
                selectedValueOfLocation : '',
                report_data :'',
                sendEmail : false,
                
                report_input : {location_id : '', period_from : '', period_to : '', send_email : false},
            }
        },
        methods:{
            getLocations(){
                var _this = this;
                axios.get('/report/get_locations').then(function(response){             
                    _this.locations = response.data.locations; 
                })
            },
            onChangeOfLocation(e)
            {
                this.location.location_id = event.target.value;
                this.report_input.location_id = event.target.value;
            },
            generateReport(e){
                e.preventDefault();
                var _this = this;
                if(_this.sendEmail) {
                    _this.report_input.send_email = _this.sendEmail;
                }
                axios.post('/get_teachers_pay_report',_this.report_input).then(function(response){         
                    _this.report_data = response.data.report_data;
                    _this.report_input = {location_id : '', period_from : '', period_to : '', send_email : false};
                    _this.sendEmail = false;
                    _this.selectedValueOfLocation = false;
                })
            }
        },
        created() {
            console.log('Component mounted and then created.')
            this. getLocations(); 
        }
        
    }
</script>
