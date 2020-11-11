<template>
    <div class="container">
        <h3>Add Student Form</h3><br/>
        <div class="row">
            <div class="col-md-12 ">
                <div v-show="successMessage">
                   <h5 style="color:green">Student has been added.</h5>
                </div>
                <form @submit.prevent="addStudent" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label>Student's Name</label>
                        <input type="text" maxlength = "100" class="form-control" v-model="student.full_name" />
                    </div>
                    <div v-show="isParentPhoneNumberAvailable" class="form-group">
                        <label>Phone Number</label>
                        <input type="text" maxlength = "100" class="form-control" v-model="student.phone_number" value="student.phone_number" readonly/>
                    </div>
                    <div v-show="isParentPhoneNumberNotAvailable" class="form-group">
                        <label>Phone Number</label>
                        <div class="form-row">
                            <div class="form-group col-md-3"> 
                                <select class="form-control" v-model="student.country_id" required>
                                    <option v-for="countryCallingCode in countryCallingCodes" :key="countryCallingCode.id" :value="countryCallingCode.id">{{countryCallingCode.calling_code}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="number" maxlength = "100" class="form-control" id="phone_number" placeholder="Phone Number" v-model="student.phone_number" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" class="form-control" v-model="student.dob" />
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <select class="option form-control" @change="onChangeOfLocationSelection($event)" v-model="selectedValueOfLocation" required>
                            <option v-for="location in locations" v-bind:key="location.location_id" :value="location.location_id"> {{ location.location_name }}</option>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" maxlength = "100" class="form-control" v-model="student.email" />
                    </div>
                    <div class="form-group">
                        <label>Student's Main Topic :</label>
                        <select  class="option form-control" @change="onChangeOfTopic($event)" v-model="selectedValueOfTopic" >
                            <option v-for="topic in topics" v-bind:key="topic.topic_id" :value="topic.topic_id"> {{ topic.topic_name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Timezone</label>
                        <select class="option form-control" @change="onChangeOfTimezoneSelection($event)" required>
                            <option  v-for="timezone in timezones" v-bind:key="timezone.id" :value="timezone.id" :selected="timezone.time_zone === 'America/Los_Angeles'" > {{ timezone.time_zone }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Referral</label>
                        <input type="text" class="form-control" v-model="student.referral" />
                    </div>
                    <div class="form-group">
                        <label>Goal</label>
                        <input type="text" class="form-control" v-model="student.goal" />
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea type="text" class="form-control" v-model="student.notes"></textarea>
                    </div>
                    <div v-show="isLocationSelected">
                        <h3>Assign class</h3>
                        <div v-show="displayNoClassError">
                            <h6 style="color:red">No Classes exist on this date</h6>
                        </div>
                        <div class="form-group">
                            <label>Date/Day</label>    
                            <input type="date" class="form-control" id="class_date" name="class_date" v-model="student.selectedDate" @change="dateChanged($event)" />
                        </div>
                        <div class="form-group">
                            <select class="option form-control" @change="onChangeOfTaskClass($event)" v-model="selectedValueOfTaskClass">
                                <option v-for="taskclass in allTaskClasses" v-bind:key="taskclass.taskclass_id" :value="taskclass.taskclass_id"> {{ taskclass.taskclass_name }}</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Free: </label>
                            <div class="col-lg-1">
                                <input type="radio" name="freeorfirst" value="free" v-model="student.freeorfirst" class="form-control" style="font-size: 4px;">
                            </div>
                            <label class="col-lg-2 col-form-label">First: </label>
                            <div class="col-lg-1">
                                <input type="radio" name='freeorfirst' value="first" v-model="student.freeorfirst" class="form-control" style="font-size: 4px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Recurring: </label>
                            <div class="col-lg-1">
                                <input type="checkbox" v-model="student.recurring" class="form-control" style="font-size: 4px;">
                            </div>
                        </div>
                    </div>
                     <input class="btn btn-primary" type="submit" value="Add Student" />
                    <p class="text-danger" v-if="errorMessage">{{errorMessage}}</p>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
        data(){
            return {
                errorMessage : '',
                isParentPhoneNumberAvailable : false,
                isParentPhoneNumberNotAvailable : false,
                successMessage : false,
                displayNoClassError : false,
                isLocationSelected : false,
                topics : [],
                locations : [],
                timezones : [],
                taskClasses : [],
                allTaskClasses : [],
                countryCallingCodes : [],
                selectedValueOfTopic : '',
                selectedValueOfLocation : '',
                selectedValueOfTaskClass : '',
                selectedValueOfTimezone : '',
                byDefaultSelectedCountryId : '',
                student : {
                    user_name:'', full_name:'', phone_number:'', dob:'', email:'', location_id:'',
                    topic_id:'',notes:'',selectedDate:'',selectedClassId:'', selectedTopicId:'',
                    timezone_id: '' , referral : '', goal : '', task_class_id:'', freeorfirst : false,
                    recurring : true,country_id :''
                },
            };
        },
        methods:{
            getCountryCallingCodes(){
                var _this = this;
                axios.get('/country/callingCodes').then(function(response){
                    _this.countryCallingCodes = response.data.countryCallingCodes;
                    _this.student.country_id = response.data.selectedCountry;
                    _this.byDefaultSelectedCountryId = response.data.selectedCountry;
                })
            },
            getParentsPhoneNumber(){
                var _this = this;      
                axios.get('/get_parents_phoneNumber').then(function(response){   
                    if(response.data.response_msg == "Not a Parent"){
                        _this.isParentPhoneNumberAvailable = false;
                        _this.isParentPhoneNumberNotAvailable = true;
                    }
                    else{
                        _this.student.phone_number = response.data.phoneNumber;
                        _this.student.country_id = response.data.countryId;
                        _this.isParentPhoneNumberAvailable = true;
                        _this.isParentPhoneNumberNotAvailable = false;
                    }  
                })                  
            },
            getTopics(){
                var _this = this;
                axios.get('/get_topics').then(function(response){             
                    _this.topics = response.data.topics; 
                })
            },
            getLocations(){
                var _this = this;
                axios.get('/get_locations_for_adding_students').then(function(response){     
                    _this.locations = response.data.locations; 
                }) 
            },
            getTimezones(){
                var _this = this;
                axios.get('/get_timezones_for_adding_students').then(function(response){     
                    _this.timezones = response.data.timezones; 
                }) 
                this.student.timezone_id = 398;
            },
            onChangeOfTopic(e){
                this.student.topic_id = event.target.value;
                this.student.selectedTopicId = event.target.value;
            },
            onChangeOfLocationSelection(e){
                this.successMessage = false;
                this.displayNoClassError = false;
                this.isLocationSelected = true;
                this.student.selectedDate = '';
                this.allTaskClasses = [];
                this.student.location_id = event.target.value;
            },
            dateChanged(event){
                this.student.selectedDate = event.target.value;
                this.getAllAvailableClasses();
            },
            onChangeOfTaskClass(event){
                this.student.selectedClassId  = event.target.value;
                this.student.task_class_id = event.target.value;
            },
            onChangeOfTimezoneSelection(event){
                this.student.timezone_id  = event.target.value;
            },
            getAllAvailableClasses(){
                var _this = this;   
                axios.post('/get_classes_for_new_student',this.student).then(function(response){
                    if(response.data.response_msg == "No Classes exist for this Information"){
                        _this.allTaskClasses = [];
                        _this.displayNoClassError = true;
                    }
                    else{
                        _this.displayNoClassError = false;
                        _this.allTaskClasses = response.data.classes;
                    }  
                }) 
            },
            addStudent(e){
                var _this = this;
                e.preventDefault();
                axios.post('/add_student_by_user', this.student).then(function(response){     
                    if(response.data.response_msg == "Student Added"){
                        _this.student = {user_name:'', full_name:'', phone_number:'', dob:'', email:'', location_id:'',topic_id:'',notes:'',selectedDate:'',selectedClassId:'', selectedTopicId:'', task_class_id:'', freeorfirst : false, recurring : true, country_id :'', referral : '', goal : ''};
                        _this.student.country_id = _this.byDefaultSelectedCountryId;
                        _this.selectedValueOfLocation = '';
                        _this.selectedValueOfTopic = '',
                        _this.selectedValueOfTaskClass = '',
                        _this.selectedValueOfTimezone = '',
                        _this.isLocationSelected = false;
                        _this.successMessage = true;
                        _this.errorMessage = '';
                    }
                }).catch((error) => {
                    _this.successMessage = false
                    _this.errorMessage = error.response.data.response_msg;
                })
            }
        },
        created() {
            this.getCountryCallingCodes();
            this.getParentsPhoneNumber();
            this.getLocations();
            this.getTopics();
            this.getTimezones();
            console.log('VueJS component created now.');
        }
    }
</script>
