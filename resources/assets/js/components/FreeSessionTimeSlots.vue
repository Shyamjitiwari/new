<template>
    <div class="container">
        <div v-show="displayDuplicateEntryError">
            <h6 style="color:red">A similar Time Slot already exists for the selected Location.</h6>
        </div>  
         <div v-show="displaySuccess">
            <h6 style="color:green">Time Slot has been added.</h6>
        </div>   
        <br/><h3>Add a Free Session Time Slots </h3><br/>    
        <form @submit.prevent="addFreeSessionTimeSlot" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" >Location<span class="text-danger">*</span></label>
                <div class="col-lg-3">      
                    <select  class="option form-control" @change="onChangeOfLocation($event)" v-model="selectedValueOfLocation" required>
                        <option v-for="location in locations" v-bind:key="location.location_id" :value="location.location_id"> {{ location.location_name }}</option>
                    </select>
                </div>
            </div>  
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" >Day<span class="text-danger">*</span></label>
                <div class="col-lg-3">      
                    <select  class="option form-control" @change="onChangeOfDay($event)" v-model="selectedValueOfDay" required>
                        <option v-for="day in days" v-bind:key="day.day_id" :value="day.day_id"> {{ day.day_name }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" >Time<span class="text-danger">*</span></label>
                <div class="col-lg-3">      
                    <select  class="option form-control" @change="onChangeOfTime($event)" v-model="selectedValueOfTime" required>
                        <option v-for="time in times" v-bind:key="time.time_id" :value="time.time_id"> {{ time.time_time }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" >Limit<span class="text-danger">*</span></label>
                <div class="col-lg-3">
                    <input v-model="limit" type="number" value='group' class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <div class="custom-control custom-radio col-md-6">
                        <input v-model="is_private" type="radio" id="customRadio2" value='group' name="customRadio" class="custom-control-input" required>
                        <label class="custom-control-label" for="customRadio2">Group</label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="custom-control custom-radio ">
                        <input v-model="is_private" type="radio" id="customRadio1" value='private' name="customRadio" class="custom-control-input" required>
                        <label class="custom-control-label" for="customRadio1">Private</label>
                    </div>
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="Add Time Slot" />
        </form>
        <br/><br/><br/><h3>Free Session Time Slots </h3><br/>
        <h6 style="color:black"><b>Note: </b>To add a Class, you must select a location first.</h6>
        <div >      
            <select  class="option form-control" @change="onChangeOfLocationSelectionForFetchingTimeSlots($event)" v-model="selectedValueOfLocationForFetchingTimeSlots" required>
                <option v-for="location in locations" v-bind:key="location.location_id" :value="location.location_id"> {{ location.location_name }}</option>
            </select>
        </div>
        <table class="table" id="table" v-if="showDataTable">
            <thead>
                <tr>
                    <td><h5>Location</h5></td>
                    <td><h5>Day</h5></td>
                    <td><h5>Limit</h5></td>
                    <td><h5>Time</h5></td>
                    <td><h5>Type</h5></td>
                    <td></td>
                </tr>
            </thead>
             <tbody>
                <tr v-for="availableTimeSlot in availableTimeSlots" v-bind:key="availableTimeSlot.timeslot_id">
                    <td>{{ availableTimeSlot.location_name}}</td>
                    <td>{{ availableTimeSlot.day_name }}</td>
                    <td>{{ availableTimeSlot.limit }}</td>
                    <td>{{ availableTimeSlot.time_time }}</td>
                    <td>{{ availableTimeSlot.is_private ? 'Private' : 'Group' }}</td>
                    <td><button @click="deleteData(availableTimeSlot.timeslot_id)" class="btn btn-danger">DELETE</button></td>
                </tr>      
            </tbody>
        </table>
    </div>   
</template>
    
<script>
    export default {
        data(){
            return { 
                displayDuplicateEntryError : false,
                displaySuccess : false,
                selected_timeslot : {timeslot_id :''},
                location : {location_id: ''},
                locations :[],
                days : [],
                times : [],
                availableTimeSlots : [],
                timeslot: { location_id : '', day_id : '', time_id:''},
                showDataTable : false,

                selectedValueOfLocationForFetchingTimeSlots : '',
                selectedValueOfLocation :'',
                selectedValueOfDay : '',
                selectedValueOfTime : '',
                is_private : 'group',
                limit : 15
            }
        },
        methods:{
            getAllLocations(){
                var _this = this;
                axios.get('/get_locations_for_free_session').then(function(response){              
                    _this.locations = response.data.locations;  
                })
            },
            getAllDays(){
                var _this = this;
                axios.get('/get_days_for_free_session').then(function(response){              
                    _this.days = response.data.days;  
                })
            },
            getAllTimes(){
                var _this = this;
                axios.get('/get_times_for_free_session').then(function(response){              
                    _this.times = response.data.times;  
                })
            },
            onChangeOfLocationSelectionForFetchingTimeSlots(e){
                this.location.location_id = event.target.value;
                this.getAvailableTimeSlotsForALocation();
            },
            getAvailableTimeSlotsForALocation(){
                var _this = this;
                _this.displayDuplicateEntryError = false;
                _this.displaySuccess = false;
                axios.post('/get_available_timeslots_for_a_location',_this.location).then(function(response){              
                    _this.showDataTable = true;
                    _this.availableTimeSlots = response.data.availableTimeSlots;  
                })
            },
            onChangeOfLocation(e){
                this.timeslot.location_id = event.target.value;
            },
            onChangeOfDay(e){
                this.timeslot.day_id = event.target.value;
            },
            onChangeOfTime(e){
                this.timeslot.time_id = event.target.value;
            },
            addFreeSessionTimeSlot(e){
                var _this = this;
                e.preventDefault();
                this.timeslot.is_private = _this.is_private;
                this.timeslot.limit = _this.limit;
                axios.post('/add_timeslot_to_a_location',_this.timeslot).then(function(response){
                    _this.timeslot = { location_id : '', day_id : '', time_id:''};
                    _this.selectedValueOfLocation = '';
                    _this.selectedValueOfDay = '';
                    _this.selectedValueOfTime = '';
                    if(response.data.response_msg == "Duplicate Entry"){
                        _this.displayDuplicateEntryError = true;
                        _this.displaySuccess = false;
                    }
                    else{
                        _this.availableTimeSlots = [];
                        _this.selectedValueOfLocationForFetchingTimeSlots = '';
                        _this.displaySuccess = true;
                        _this.displayDuplicateEntryError = false;
                        _this.is_private = 'group';
                        _this.limit = 15;
                    }
                })
            },
            deleteData(id){
                var _this = this;
                _this.selected_timeslot.timeslot_id = id;
                axios.post('/delete_timeslot_from_a_location',_this.selected_timeslot).then(function(response){                 
                    if(response.data.reponse_msg == ""){
                       
                    }
                    else{
                        _this.getAvailableTimeSlotsForALocation();
                    }
                })
            }
        },
        created() {
            console.log('VueJS component created.');
            this.getAllLocations();
            this.getAllDays();
            this.getAllTimes();
        } ,
    }
</script>
