<template>
    <div class="row">
        <div v-show="displayError">
            <h6 style="color:red">No Credits data found for the students of this Location.</h6>
        </div><br/>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <form @submit.prevent="getUsersCredits">
                    <div class="row">
                        <div class="form-group col">
                            <label>Location</label>
                            <select class="form-control" @change="onChangeOfLocation($event)" v-model="inputFormData.location_id" required>
                                <option disabled selected value="">Select Location</option>
                                <option
                                        v-for="location in locations"
                                        :key="location.location_id"
                                        :value="location.location_id">{{location.location_name}}</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label>Start Date</label>
                            <input type="date" class="form-control" v-model="inputFormData.starting_date" required/>
                        </div>
                            <div class="form-group col">
                            <label>End Date</label>
                            <input type="date" class="form-control" v-model="inputFormData.ending_date" required/>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Get Users' Credits" />
                    <input class="btn btn-danger" type="button" value="Reset" @click="reset" />
                </form>   
            </div>
        </div>
        <div v-show="ifCreditsDataAvailable">
            <div class="table-responsive">
            <table class="table table-striped table-bordered" id="table">
                <thead>
                    <tr>
                        <td><b>User Id</b></td> 
                        <td><b>User Name</b></td>
                        <td><b>User Email</b></td>  
                        <td><b>Class Type</b></td>     
                        <td><b>Credits Given</b></td> 
                        <td><b>Credits Used</b></td> 
                        <td><b>Remaining Credits</b></td> 
                        <td><b>Last credits used</b></td>          
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="userCredit in userCredits" v-bind:key="userCredit.user_id">
                        <td>{{ userCredit.user_id }}</td>
                        <td>{{ userCredit.user_name }}</td>
                        <td>{{ userCredit.user_email }}</td>
                        <td>{{ userCredit.task_class_type }}</td>
                        <td>{{ userCredit.credits_given }}</td>
                        <td>{{ userCredit.credits_used }}</td>
                        <td>{{ userCredit.remaining_credits }}</td>
                        <td>{{ userCredit.last_credits_used }}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() 
        {
            return {
                ifCreditsDataAvailable : false,
                displayError : false,
                location : {location_id : ''},
                userCredits : [],
                locations:[],
                selectedValueOfLocation : '',
                inputFormData : {location_id : '', starting_date : '', ending_date : ''},
            }
        },
        created() {
            console.log('VueJS component created.');
            this.getLocations();
        },
        mounted(){
           
        },
        methods:{
            reset(){
                this.inputFormData = {location_id : '', starting_date : '', ending_date : ''};
                this.errorMessage = '';
                this.userCredits = [];
                this.ifCreditsDataAvailable = false;
            },
            getLocations(){
                var _this = this;
                axios.get('/credit_calculation/get_locations').then(function(response){         
                    if(response.data.response_msg == "No Locations found."){
                        _this.displayError = true;
                    }else{
                        _this.locations = response.data.locations; 
                    }
                })
            },
            onChangeOfLocation(e){
                this.location.location_id = event.target.value;
                this.inputFormData.location_id = event.target.value;
            },
            getUsersCredits(){
                var _this = this;
                axios.post('/credit_calculation/get_users_credits_within_a_date_range',this.inputFormData).then(function(response){
                    debugger;                   
                    if(response.data.response_msg == "No Credits data found for the students of this Location."){
                        _this.displayError = true;
                        _this.ifCreditsDataAvailable = false;
                        _this.userCredits = [];
                    }
                    else{
                        _this.displayError = false;
                        _this.ifCreditsDataAvailable = true;
                        _this.userCredits = response.data.userCredits; 
                    }
                })
            }, // End of Get Data Method
        },
        
    }
</script>

<style>

</style>