<template>
    <div class="container">
        <h3>Teacher Profile</h3>
        <div class="row">
            <div class="col-md-12 ">
                <form @submit.prevent="editTeacherProfile" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="form-row">
                            <div class="form-group col-md-3"> 
                                <select class="form-control" v-model="teacherProfile.country_id" required>
                                    <option v-for="countryCallingCode in countryCallingCodes" :key="countryCallingCode.id" :value="countryCallingCode.id">{{countryCallingCode.calling_code}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" maxlength = "100" class="form-control" v-model="teacherProfile.phone_number" required/>
                            </div>
                        </div> 
                    </div>      
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" maxlength = "100" class="form-control" v-model="teacherProfile.email" />
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <input type="text" maxlength = "100" class="form-control" v-model="teacherProfile.notes" />
                    </div>    
                    <input class="btn btn-primary" type="submit" value="Update Profile" />
                </form>
            </div>
        </div>
        <br/><br/>
        <h3>Add new Topic</h3>
        <div v-show="displayTopicAttachmentError">
            <h6 style="color:red">Teacher already has this Topic</h6>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <form @submit.prevent="addTopicToTeacher" enctype="multipart/form-data" >
                    <div class="form-group">
                        <select  class="option form-control" @change="onChangeOfTopic($event)" v-model="selectedValueOfTopic" >
                            <option v-for="topic in topics" v-bind:key="topic.topic_id" :value="topic.topic_id"> {{ topic.topic_name }}</option>
                        </select>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Assign" />
                </form>
            </div>
        </div>
        <br/><br/>
        <h3>Teacher's Topics</h3>
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                   
                    <table class="table" >
                        <thead>
                            <tr>
                                <td>Teacher's Topics</td> 
                                <td></td>      
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="topic in teacherTopics" v-bind:key="topic.topic_id">
                                <td>{{ topic.topic_name }}</td>
                                <td><button @click="removeTopic(topic.topic_id)" class="btn btn-danger">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br/><br/>
        <h3>
            Assigned Classes
            <small class="float-right">
                <a class="btn btn-warning" title="View Completed / Absent Classes" :href="'/completed-task-classes-teacher/'+teacherData.teacher_id">
                    View Completed / Absent Classes
                </a>
            </small>
        </h3>
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                            <tr>
                                <td>Name</td>
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
                                <td>{{ taskClass.starts_at }} - {{ taskClass.ends_at | timeOnly}}</td>
                                <td>
                                    <span v-if="taskClass.pivot.free">
                                        <i class="fa fa-stop-circle-o text-danger"></i>
                                    </span>
                                    <span v-else>-</span>
                                <td> {{taskClass.pivot.recurring ? 'Yes' : 'No'}} </td>
                                <td>{{taskClass.is_free_session ? 'Yes' : 'No'}}</td>
                                <td> {{taskClass.recurring ? 'Yes' : 'No'}} </td>
                                <td><button v-if="!taskClass.pivot.absent" @click="markTaskClassAsCompleted(taskClass.pivot)" class="btn btn-warning">Mark As Complete</button></td>
                                <td><mark-absent :pivot="taskClass.pivot" @postUpdate="postUpdate"></mark-absent></td>
                                <td>
<!--                                    <button title="Remove Task" @click="unAssignStudent(taskClass)" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>-->
                                </td>
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
            <h6 style="color:red">Teacher already has this location</h6>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <form @submit.prevent="addLocationToTeacher" enctype="multipart/form-data" >
                    <div class="form-group">
                        <select class="option form-control" @change="onChangeOfLocationSelection($event)" v-model="selectedValueOfLocation" required>
                            <option v-for="location in allLocations" v-bind:key="location.location_id" :value="location.location_id"> {{ location.location_name }}</option>
                        </select>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Assign" />
                </form>
            </div>
        </div>
        <br/><br/>
        <h3>Assigned Locations</h3>
        <div v-show="displayLocationRemoveError">
            <h6 style="color:red">You cannot delete this location. As Teachers must be attached with atleast one location.</h6>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td>Teacher's Locations</td> 
                                <td></td>      
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="location in teacherLocations" v-bind:key="location.location_id">
                                <td>{{ location.location_name }}</td>
                                <td><button @click="removeLocation(location.location_id)" class="btn btn-danger">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br/><br/>
        <h3>Set Available Time Slots</h3>
        <hr>
        <teacher-available-time-slot :teacher_id="teacher"></teacher-available-time-slot>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                teacherData : {teacher_id : '', selectedTeacherId : '', selectedLocationId : '', selectedTopicId :''},
                teacherRemoveLocation : {teacher_id: '', selectedLocationId : ''},
                teacherRemoveTopic : {teacher_id: '', selectedTopicId: ''},
                locations : [],
                allLocations : [],
                selectedValueOfLocation : '',
                selectedValueOfTopic : '',
                teacherLocations : [],
                teacherTopics : [],
                countryCallingCodes : [],
                displayLocationAttachmentError : false,
                displayTopicAttachmentError : false,
                displayLocationRemoveError : false,
                topics : [],
                teacherProfile : {},
                incompleteTaskClasses : [],
            }
        },
        computed : {
          teacher1(){
              return this.teacherProfile;
          }
        },
        props: ['teacher'],
        methods:{
            getCountryCallingCodes(){
                var _this = this;
                axios.get('/countries/calling_code').then(function(response){
                    _this.countryCallingCodes = response.data.countryCallingCodes;
                })
            },
            postUpdate(){
                this.getIncompleteAssignedClasses();
            },
            markTaskClassAsCompleted(pivot)
            {
                if(confirm('Before marking this as complete, did you write an update for this teacher? If not, press cancel and use the little mailbox icon to write an update for the teacher. If you did write an update, press OK to mark class as complete.'))
                {
                    let _this = this;
                    axios.post('/teacher/mark-task-class-competed', pivot).then(function(response){});
                    _this.getIncompleteAssignedClasses();
                }
            },
            getIncompleteAssignedClasses(){
                var _this = this;
                axios.post('/get-incomplete-assigned-classes-teacher',this.teacherData).then(function(response){
                    _this.incompleteTaskClasses = response.data.incompleteTaskClasses;
                })
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
            getTeacherProfile(){
                var _this = this; 
                axios.post('/get_teacher_profile',this.teacherData).then(function(response){
                    _this.teacherProfile = response.data.profile;
                    _this.displayLocationRemoveError = false;
                })   
            },
            getAssignedTopics(){
                var _this = this; 
                axios.post('/get_teacher_topic',this.teacherData).then(function(response){
                    _this.teacherTopics = response.data.teacher_topics;
                }) 
            },
            getAssignedLocations(){
                var _this = this; 
                axios.post('/get_teacher_location',this.teacherData).then(function(response){
                    _this.teacherLocations = response.data.teacher_locations;
                }) 
            },
            onChangeOfTopic(e){
                this.teacherData.selectedTopicId = event.target.value;
            },
            editTeacherProfile(){
                var _this = this;
                axios.post('/edit_teacher_profile',this.teacherProfile).then(function(response){
                    _this.selectedValueOfTopic = '';
                    _this.getTeacherProfile();
                }) 
            },
            removeTopic(topicId){
                var _this = this;
                if(confirm('Are you sure?')){
                    _this.teacherRemoveTopic.selectedTopicId = topicId;
                   
                    axios.post('/remove_teacher_topic',_this.teacherRemoveTopic).then(function(response){
                        if(response.data.response_msg == "You can not delete this topic."){
                           //
                        }
                        else{
                            _this.getAssignedTopics(); 
                        }
                        _this.teacherRemoveTopic.selectedTopicId = "";
                    })  
                }
            },
            removeLocation(locationId){
                var _this = this;
                if(confirm('Are you sure?')){
                    _this.teacherRemoveLocation.selectedLocationId = locationId;
                   
                    axios.post('/remove_teacher_location',_this.teacherRemoveLocation).then(function(response){
                        if(response.data.response_msg == "You can not delete this location."){
                            _this.displayLocationRemoveError = true;
                        }
                        else{
                            _this.displayLocationRemoveError = false;
                            _this.getAssignedLocations(); 
                        }
                        _this.teacherRemoveLocation.selectedLocationId = "";
                    })  
                }
            },
            onChangeOfLocationSelection(e){
                this.teacherData.selectedLocationId = event.target.value;
            },
            addLocationToTeacher(){
                var _this = this;
                _this.displayLocationRemoveError = false;
                axios.post('/add_teacher_location',this.teacherData).then(function(response){
                    if(response.data.response_msg == "You cannot add duplicate location."){
                        _this.displayLocationAttachmentError = true;
                    }
                    else{
                        _this.displayLocationAttachmentError = false;
                    }
                    _this.selectedValueOfTopic = '';
                    _this.selectedValueOfLocation = '';
                    _this.teacherData.selectedLocationId;
                    _this.getAssignedLocations();
                }) 
            },
            addTopicToTeacher(){
                var _this = this;
                _this.displayLocationRemoveError = false;
                axios.post('/add_teacher_topic',this.teacherData).then(function(response){
                    if(response.data.response_msg == "You cannot add duplicate topic."){
                        _this.displayTopicAttachmentError = true;
                    }
                    else{
                        _this.displayTopicAttachmentError = false;
                    }
                    _this.selectedValueOfTopic = '';
                    _this.teacherData.selectedTopicId;
                    _this.getAssignedTopics();
                }) 
            },
        },
        created(){
            this.teacherData.teacher_id = this.teacher;
            this.teacherData.selectedTeacherId =this.teacher;
            this.teacherRemoveLocation.teacher_id = this.teacher;
            this.getCountryCallingCodes();
            this.getTopics();
            this.getAllLocations();
            this.getTeacherProfile();
            this.getAssignedLocations(); 
            this.getAssignedTopics();
            this.getIncompleteAssignedClasses();
        }
    }
</script>
