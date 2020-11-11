<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <br/>
                        <div v-show="displayError">
                            <h6 style="color:red">No Teachers exist for this location.</h6>
                        </div>
                        <div v-show="displaySuccess">
                            <h6 style="color:green">A Class has been added.</h6>
                        </div>
                        <form @submit.prevent="addClass" enctype="multipart/form-data">
                            <h6 style="color:black"><b>Note: </b>To add a Class, you must select a location first.</h6>
                            <br/>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Location<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select  class="option form-control" @change="onChangeOfLocation($event)" v-model="selectedValueOfLocation" required>
                                        <option v-for="location in locations" v-bind:key="location.location_id" :value="location.location_id"> {{ location.location_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Class Name <span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <input class="form-control" type="text" v-model="taskClassData.taskclass_name" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Class Limit <span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" v-model="taskClassData.student_limit" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Class Type<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select  class="option form-control" v-model="taskClassData.task_class_type_id" required>
                                        <option v-for="type in task_class_types" v-bind:key="type.id" :value="type.id"> {{ type.type_name }}</option>
                                    </select>
                                </div>
                            </div>
<!--                            <div class="form-group row">-->
<!--                                <label class="col-lg-3 col-form-label" >Select Camp <small>(Optional)</small></label>-->
<!--                                <div class="col-lg-5">-->
<!--                                    <select  class="option form-control" v-model="taskClassData.camp">-->
<!--                                        <option v-for="camp in camps" v-bind:key="camp.id" :value="camp"> {{ camp.name }}</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="form-group row" v-if="taskClassData.camp">
                                <label class="col-lg-3 col-form-label" >Camp Period</label>
                                <div class="col-lg-5">
                                    {{taskClassData.camp.starts_at}} to {{taskClassData.camp.ends_at}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Teacher<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select  class="option form-control" @change="onChangeOfTeacher($event)" v-model="selectedValueOfTeacher" required>
                                        <option v-for="teacher in teachers" v-bind:key="teacher.teacher_id" :value="teacher.teacher_id"> {{ teacher.teacher_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Starts at: <span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <input class="form-control" type="datetime-local" v-model="taskClassData.startingDatetime"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Ends at: <span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <input class="form-control" type="datetime-local" v-model="taskClassData.endingDatetime"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Topics<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select class="form-control" v-model="selectedTopics" multiple="multiple">
                                        <option v-for="topic in topics" v-bind:key="topic.topic_id" :value="topic.topic_id"> {{ topic.topic_name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Select Age Groups:<span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select class="form-control" v-model="selectedAgeGroups" multiple="multiple">
                                        <option v-for="age in ages" v-bind:key="age" :value="age"> {{ age }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Free Session Class: </label>
                                <div class="col-lg-5">
                                    <input type="checkbox" class="form-control" style="font-size: 4px;" id="customCheck1" v-model="taskClassData.isFreeSessionClass">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Recurring Class: </label>
                                <div class="col-lg-5">
                                    <input type="checkbox" class="form-control" style="font-size: 4px;" id="customCheck2" v-model="taskClassData.recurring">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" >Repeat Class: </label>
                                <div class="col-lg-5">
                                    <input @change="addDate(repeats)" type="date" class="form-control mb-1" v-model="repeats">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <span v-for="date in taskClassData.repeats" class="m-1 mb-1">
                                        <button type="button" class="btn btn-success">{{date}}  <span @click="removeDate(date)" class="badge badge-dark">x</span></button>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label"></label>
                                <div class="col-lg-8">
                                    <input class="btn btn-primary" type="submit" value="Add New Class" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
    </div>
</template>

<script>
    export default {
        data(){
            return {
                displayError : false,
                displaySuccess : false,

                taskclass : {taskclass_name: ''},

                location_id : '',
                location: { location_id: '', location_name : ''},
                locations:[],
                selectedValueOfLocation : '',

                teacher_id : '',
                teacher: { teacher_id: '', teacher_name : ''},
                teachers:[],
                selectedValueOfTeacher : '',

                taskClassData: {
                    location_id: '', teacher_id: '',
                    taskclass_name: '', startingDatetime: '',
                    endingDatetime: '', isFreeSessionClass:false, repeats: [], recurring:true,
                    student_limit : 3
                },

                repeats : '',

                ages : [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],
                selectedAgeGroups : [],
                topics : [],
                selectedTopics : [],
                taskClasses : [],
                selectedTaskClass: {},
                task_class_types : [],
                camps:[]
            };
        },
        created() {
            this.getLocations();
            this.getTopics();
            this.getTaskClassTypes();
            this.getCamps();
        },
        methods:{
            getCamps(){
                let _this = this;
                axios.get('/get-all-camps', _this.camp).then(function(response)
                {
                    _this.camps = response.data.data;
                })
            },
            isDuplicate(data, dataArray) {
                for(let i = 0; i < dataArray.length; i++){
                    if(data == dataArray[i]) {
                        alert('Date already selected');
                        return true;
                    }
                    //check if date is less then today, if yes then don't append to array
                    let today = new Date();
                    if (new Date(data).getTime() <= today.getTime()) {
                        alert('Choose date from today!')
                        return true;
                    }
                }
                return false;
            },
            removeDate(date){
                this.taskClassData.repeats.splice(this.taskClassData.repeats.indexOf(date), 1);
            },
            addDate(date){
                if(!this.isDuplicate(date,  this.taskClassData.repeats)) {
                    this.taskClassData.repeats.push(date);
                }
                this.repeats = '';
            },
            getLocations(){
                var _this = this;
                axios.get('/calendar/get_locations').then(function(response){             
                    _this.locations = response.data.locations; 
                })
            },
            getTaskClassTypes(){
                var _this = this;
                axios.get('/get-task-class-types').then(function(response){
                    _this.task_class_types = response.data.task_class_types;
                })
            },
            getTopics(){
                var _this = this;
                axios.get('/get_topics').then(function(response){
                    _this.topics = response.data.topics;
                })
            },
            onChangeOfLocation(e)
            {
                this.displaySuccess = false;
                this.location.location_id = event.target.value;
                this.taskClassData.location_id = event.target.value;
                var _this = this;

                axios.post('/getTeachers',this.location).then(function(response)
                {
                    if(response.data.response_msg === "No teachers found for this location.")
                    {
                        _this.displayError = true;
                    }
                    else{
                        _this.displayError = false;
                        _this.teachers = response.data.teachers; 
                    }      
                })
            },
            onChangeOfTeacher(e){
                this.taskClassData.teacher_id = event.target.value;
            },
            addClass(e){
                e.preventDefault();
                var _this = this;
                _this.taskClassData.topics = _this.selectedTopics;
                _this.taskClassData.ages = _this.selectedAgeGroups;
                axios.post('/add_task_class',_this.taskClassData).then(function(response){
                    _this.taskClassData = { location_id: '', teacher_id: '', taskclass_name: '', startingDatetime: '', endingDatetime: '', isFreeSessionClass:false, repeats : [], recurring:true, student_limit : 3};
                    _this.displaySuccess = true;
                    _this.selectedValueOfTeacher = '';
                    _this.selectedValueOfLocation = '';
                    _this.selectedAgeGroups = [];
                    _this.selectedTopics = [];
                    _this.taskClasses = [];
                    _this.selectedTaskClass = {};
                })
            },
        }
    }
</script>