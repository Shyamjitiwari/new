<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <h3>
                    Student Profile
                    <small>
                        <a href="#" title="SMS Update" @click="showStudentsModal = !showStudentsModal"><i class="icon-envelope"></i></a>
                        <ping-parents :student_id="studentData.student_id" class="pull-right" style="cursor:pointer"> </ping-parents>
                    </small>
                </h3>
                <div v-if="showStudentsModal">
                    <br>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Updates</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Send Updates</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th width="20%"><h5>Date</h5></th>
                                            <th><h5>Update</h5></th>
                                            <th><h5>Survey Feedbacks</h5></th>
                                            <th width="20%"><h5>Sender</h5></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="update in updates">
                                            <td>{{update.created_at}}</td>
                                            <td class="text-justify">{{update.content}}</td>
                                            <td class="text-justify" width="50%">
                                                <table>
                                                    <tr v-for="survey in update.surveys">
                                                        <td>{{survey.created_at | dateOnly}} :</td>
                                                        <td>{{survey.improvement}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>{{update.teacher_id ? update.teacher.full_name : '-'}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <student-updates :student="studentData" @closeModal="closeModal"> </student-updates>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <form @submit.prevent="editStudentProfile" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" maxlength = "100" class="form-control" v-model="studentProfile.full_name" />
                    </div> 
                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="form-row">
                            <div class="form-group col-md-3"> 
                                <select class="form-control" v-model="studentProfile.country_id" required>
                                    <option v-for="countryCallingCode in countryCallingCodes" :key="countryCallingCode.id" :value="countryCallingCode.id">{{countryCallingCode.calling_code}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" maxlength = "100" class="form-control" v-model="studentProfile.phone_number" required/>
                            </div>
                        </div> 
                    </div>   
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" maxlength = "100" class="form-control" v-model="studentProfile.email" />
                    </div>
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="date" class="form-control" v-model="studentProfile.dob" />
                    </div>
                    <div class="form-group">
                        <label>Student's Main Topic : <b style="color:black">{{studentProfile.topic}}</b></label>
                        <select  class="option form-control" @change="onChangeOfTopic($event)" v-model="selectedValueOfTopic" >
                            <option v-for="topic in topics" :value="topic.topic_id"> {{ topic.topic_name }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Referral</label>
                        <input type="text" class="form-control" v-model="studentProfile.referral" />
                    </div>
                    <div class="form-group">
                        <label>Goal</label>
                        <input type="text" class="form-control" v-model="studentProfile.goal" />
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" v-model="studentProfile.notes"></textarea>
                    </div>
                     <label>Online Meet Link</label>    
                     <div class="form-row">
                        <div class="form-group col-md-6">    
                            <input type="text"  class="form-control" v-model="studentProfile.meet_link" />
                        </div>
                        <div class="form-group col-md-6">
                            <button class="btn btn-warning" title="Generate/Refresh Meet Link" @click="refreshMeetLink()">Generate/Refresh Meet Link</button>
                        </div>
                     </div>
                   
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" v-model="sendEmail">
                            <label class="custom-control-label" for="customCheck1">Email notes to teacher</label>
                        </div>
                    </div>
                    <span class="text-danger" v-if="errorMessageUpdatingStudent">{{errorMessageUpdatingStudent}} <br></span>
                    <span v-if="message" class="text-success">{{message}}</span><br>
                    <input v-if="!profileUpdating" class="btn btn-primary" type="submit" value="Update Profile" />
                    <loading-button v-else title="Updating..." bg="bg-primary text-white"></loading-button>
                </form>
            </div>
        </div>
        <br/><br/>
        <h3>Assign new class</h3>
        <div v-show="displayNoClassError">
            <h6 style="color:red">No Classes exist on this date</h6>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <form @submit.prevent="addStudentToClasses" enctype="multipart/form-data" >
                     <div class="form-group">
                        <label>Date/Day</label>    
                        <input type="date" class="form-control" id="class_date" name="class_date" v-model="studentData.selectedDate" @change="dateChanged($event)" />
                    </div>
                    <div class="form-group">
                        <select class="option form-control" @change="onChangeOfTaskClass($event)" v-model="selectedValueOfTaskClass" required>
                            <option v-for="taskclass in allTaskClasses" :value="taskclass.taskclass_id"> {{ taskclass.taskclass_name }}</option>
                        </select>
                    </div>

                     <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Free: </label>
                        <div class="col-lg-1">
                            <input type="radio" name="freeorfirst" value="free" v-model="studentData.freeorfirst" class="form-control" style="font-size: 4px;">
                        </div>
                        <label class="col-lg-2 col-form-label">First: </label>
                        <div class="col-lg-1">
                            <input type="radio" @change="checkIfFirst(studentData)" name='freeorfirst' value="first" v-model="studentData.freeorfirst" class="form-control" style="font-size: 4px;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Recurring: </label>
                        <div class="col-lg-1">
                            <input type="checkbox" v-model="studentData.recurring" class="form-control" style="font-size: 4px;">
                        </div>
                    </div>

                    <input v-if="!taskAssigning" class="btn btn-primary" type="submit" value="Assign" />
                    <loading-button v-else title="Assigning..." bg="bg-primary text-white"> </loading-button>
                    <div class="form-group" v-if="message || errorMessage">
                        <br>
                        <span v-if="message" class="text-success">{{message}}</span>
                        <span v-if="errorMessage" class="text-danger">{{errorMessage}}</span>
                    </div>
                </form>
            </div>
        </div>
        <br/><br/>

        <h3>
            Assigned Classes
            <small class="float-right"><a class="btn btn-warning" title="View Completed / Absent Classes" :href="'/completed-task-classes/'+studentData.student_id">View Completed / Absent Classes</a></small>
        </h3>
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                            <tr>
                                <td>Name</td>
                                <td>Teacher</td>
                                <td>Schedule</td>
                                <td>Task Free</td>
                                <td>Task Recurring</td>
                                <td>Free Session</td>
                                <td>Class Recurring</td>
                                <td></td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="taskClass in incompleteTaskClasses" v-if="!taskClass.pivot.completed">
                                <td>{{ taskClass.name }}</td>
                                <td class="text-capitalize">
                                    <span v-if="taskClass.teacher.length">{{ taskClass.teacher[0].user_name }}</span>
                                    <span v-else>Un-Assigned</span>
                                </td>
                                <td>{{ taskClass.starts_at }} - {{ taskClass.ends_at | timeOnly}}</td>
                                <td>
                                    <span v-if="taskClass.pivot.free">
                                        <i class='fa fa-circle text-success'></i>
                                    </span>
                                    <span v-else>-</span>
                                <td> {{taskClass.pivot.recurring ? 'Yes' : 'No'}} </td>
                                <td>{{taskClass.is_free_session ? 'Yes' : 'No'}}</td>
                                <td> {{taskClass.recurring ? 'Yes' : 'No'}} </td>
                                <td><button v-if="!taskClass.pivot.absent" @click="markTaskClassAsCompleted(taskClass.pivot)" class="btn btn-warning">Mark As Complete</button></td>
                                <td><mark-absent :pivot="taskClass.pivot" @postUpdate="postUpdate"></mark-absent></td>
                                <td><button title="Remove Task" @click="unAssignStudent(taskClass)" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <br/><br/>
        <h3>Add new Location</h3>
        <div v-show="displayLocationAttachmentError">
            <h6 style="color:red">Student already has this location</h6>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <form @submit.prevent="addLocationToStudent" enctype="multipart/form-data" >
                    <div class="form-group">
                        <select class="option form-control" @change="onChangeOfLocationSelection($event)" v-model="selectedValueOfLocation" required>
                            <option v-for="location in allLocations"  :value="location.location_id"> {{ location.location_name }}</option>
                        </select>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Assign" />
                </form>
            </div>
        </div>
        <br/><br/>
        <h3>Assigned Locations</h3>
        <div v-show="displayLocationRemoveError">
            <h6 style="color:red">You cannot delete this location. As Students must be attached with atleast one location.</h6>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                   
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td>Student's Locations</td> 
                                <td></td>      
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="location in studentLocations">
                                <td>{{ location.location_name }}</td>
                                <td><button @click="removeLocation(location.location_id)" class="btn btn-danger">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingButton from "./LoadingButton";
    export default {
        components: {LoadingButton},
        data(){
            return {
                studentData : {student_id : '', selectedDate: '', selectedStudentId : '', selectedClassId : '', selectedLocationId : '', freeorfirst : false, recurring : false,country_id : ''},
                studentRemoveLocation : {student_id: '', selectedLocationId : ''},
                locations : [],
                allLocations : [],
                selectedValueOfLocation : '',
                studentLocations : [],
                taskClasses : [],
                allTaskClasses : [],
                selectedValueOfTaskClass : '',
                selectedValueOfTopic : '',
                displayNoClassError : false,
                displayLocationAttachmentError : false,
                displayLocationRemoveError : false,
                topics : [],
                studentProfile : {},
                countryCallingCodes : [],

                day:'',
                time:'',
                location_id : '',
                incompleteTaskClasses : [],
                sendEmail : false,
                message : false,
                errorMessage : false,
                errorMessageUpdatingStudent : '',
                showStudentsModal : false,
                taskAssigning : false,
                profileUpdating : false,
                updates : []
            }
        },
        props: ['student'],
        methods:{
            getLastFiveUpdates(){
                let _this = this;
                axios.post('/teacher/show-students-update', _this.studentData).then(function(response){
                    _this.updates = response.data.data;
                })
            },
            getCountryCallingCodes(){
                var _this = this;
                axios.get('/countries/calling_code').then(function(response){
                    _this.countryCallingCodes = response.data.countryCallingCodes;
                    //_this.studentProfile.country_id = response.data.selectedCountry;
                })
            },
            checkIfFirst(){
                var _this = this;
                axios.post('/check-if-first-class', _this.studentData).then(function(response){
                    if(response.data) {
                        alert('Student already has a previously class marked as first')
                        _this.studentData.freeorfirst = false;
                    }
                })
            },
            closeModal(){
                this.getLastFiveUpdates();
                this.showStudentsModal = false
            },
            getTopics(){
                var _this = this;
                axios.get('/get_topics').then(function(response){             
                    _this.topics = response.data.topics; 
                })
            },
            getAllLocations(){
                var _this = this;
                axios.get('/get_all_locations').then(function(response){ 
                    _this.allLocations = response.data.locations; 
                })
            },
            getStudentProfile(){
                var _this = this; 
                axios.post('/get_student_profile',this.studentData).then(function(response){
                    _this.studentProfile = response.data.profile;
                })   
            },
            getAssignedClasses(){
                var _this = this; 
                axios.post('/get_assigned_classes',this.studentData).then(function(response){
                    _this.taskClasses = response.data.taskClasses;
                });
                _this.getIncompleteAssignedClasses();
            },
            getAssignedLocations(){
                var _this = this; 
                axios.post('/get_student_location',this.studentData).then(function(response){
                    _this.studentLocations = response.data.student_locations;
                }) 
            },
            onChangeOfTopic(e){
                this.studentProfile.topic_id = event.target.value;
            },
            editStudentProfile(){
                var _this = this;
                _this.profileUpdating = true;
                _this.errorMessageUpdatingStudent = "";
                if(_this.sendEmail) {
                    _this.studentProfile['sendEmail'] = _this.sendEmail;
                }
                axios.post('/edit_student_profile',_this.studentProfile).then(function(response){
                    _this.selectedValueOfTopic = '';
                    _this.message = response.data.response_msg;
                    _this.getStudentProfile();
                    _this.profileUpdating = false;
                }).catch(function(error){
                    _this.errorMessageUpdatingStudent = error.response.data.response_msg;
                    _this.profileUpdating = false;
                });
            },
            removeLocation(locationId){
                var _this = this;
                if(confirm('Are you sure?')){
                    _this.studentRemoveLocation.selectedLocationId = locationId;
                    axios.post('/remove_student_location',_this.studentRemoveLocation).then(function(response){
                        if(response.data.response_msg == "You can not delete this location."){
                            _this.displayLocationRemoveError = true;
                        }
                        else{
                            _this.displayLocationRemoveError = false;
                            _this.getAssignedLocations(); 
                        }
                        _this.studentRemoveLocation.selectedLocationId = "";
                    })  
                }
            },
            onChangeOfLocationSelection(e){
                this.studentData.selectedLocationId = event.target.value;
            },
            addLocationToStudent(){
                var _this = this;
                _this.displayLocationRemoveError = false;
                axios.post('/add_student_location',this.studentData).then(function(response){
                    if(response.data.response_msg == "You cannot add duplicate location."){
                        _this.displayLocationAttachmentError = true;
                    }
                    else{
                        _this.displayLocationAttachmentError = false;
                    }
                    _this.selectedValueOfTopic = '';
                    _this.selectedValueOfLocation = '';
                    _this.studentData.selectedLocationId;
                    _this.getAssignedLocations();
                }) 
            },
            unAssignStudent(data){
               var _this = this;
                axios.post('/un_assign_student',data).then(function(response){
                    _this.getIncompleteAssignedClasses();
                })  
            },
            onChangeOfTaskClass(event){
                this.studentData.selectedClassId  = event.target.value;
            },
            addStudentToClasses(){
                var _this = this;
                _this.taskAssigning =  true;
                _this.errorMessage = '';
                _this.message = '';
                axios.post('/add_student_to_class',this.studentData).then(function(response){
                   if(response.data.response_msg == "Data saved"){
                        _this.selectedValueOfTaskClass = "";
                        _this.studentData.freeorfirst = false;
                        _this.studentData.recurring = false;
                        _this.message = response.data.response_msg;
                        _this.getAssignedClasses();
                       _this.taskAssigning = false;
                    }
                }).catch(function(error){
                   _this.errorMessage = error.response.data.response_msg;
                    _this.taskAssigning = false;
                });
            },
            getAllAvailableClasses(){
                var _this = this;   
                axios.post('/get_classes',this.studentData).then(function(response){
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
            dateChanged(event){
                this.studentData.selectedDate = event.target.value;
                this.getAllAvailableClasses();
            },

            reset(){
                this.day = '';
                this.time = '';
                this.location_id = '';
            },

            markTaskClassAsCompleted(pivot)
            {
                if(confirm('Before marking this as complete, did you write an update for this student’s parents? If not, press cancel and use the little mailbox icon to write an update for the student’s parent. If you did write an update, press OK to mark class as complete.'))
                {
                    let _this = this;
                    axios.post('/teacher/mark-task-class-competed', pivot).then(function(response){});
                    _this.getIncompleteAssignedClasses();
                }
            },

            postUpdate(){
                this.getIncompleteAssignedClasses();
            },

            getIncompleteAssignedClasses(){
                var _this = this;
                axios.post('/get-incomplete-assigned-classes',this.studentData).then(function(response){
                    _this.incompleteTaskClasses = response.data.incompleteTaskClasses;
                })
            },
            refreshMeetLink(){
                var _this = this;
                axios.post('/create_google_meetlink_for_a_student',_this.studentData).then(function(response){
                    _this.getStudentProfile();
                })
            }
        },
        created()
        {
            this.studentData.student_id = this.student;
            this.studentData.selectedStudentId =this.student;
            this.studentRemoveLocation.student_id = this.student;
            this.getCountryCallingCodes();
            this.getTopics();
            this.getStudentProfile();
            this.getAssignedClasses();
            this.getAllLocations();
            this.getAssignedLocations();
            this.getIncompleteAssignedClasses();
            this.getLastFiveUpdates();
        }
    };
</script>

