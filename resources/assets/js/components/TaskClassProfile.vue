<template>
    <div>
        <div class="row" v-if="errorMessage || message">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <span class="text-danger" v-if="errorMessage">{{errorMessage}}</span>
                        <span class="text-success" v-if="message">{{message}}</span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div v-if="bulkMessage" class="mb-2">
                    <bulk-messages :task_class='task_class'> </bulk-messages>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>
                                        <span v-if="!editName">{{task_class.name}}
                                            <i class="fa fa-pencil text-primary" style="cursor:pointer" @click="editName = true"></i>
                                        </span>
                                        <span v-else>
                                            <input class="form-control" @blur="updateName()" type="text" v-model="task_class.name">
                                        </span>
                                    </td>
                                    <td>
                                        <i title="Send reminder to all students of this class"
                                           class="fa fa-send-o fa-2x text-danger"
                                           style="cursor:pointer;"
                                           @click="bulkMessage = !bulkMessage"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td>{{task_class.location.location_name}}</td>
                                </tr>
                                <tr>
                                    <td>Teacher</td>
                                    <td class="text-capitalize">
                                        <span v-if="!editTeacher">
                                            {{task_class.teacher[0] ? task_class.teacher[0].user_name : 'Un Assigned'}}
                                            <i class="fa fa-pencil text-primary" style="cursor:pointer" @click="editTeacher = true"></i>
                                        </span>
                                        <div class="form-group" v-else>
                                            <select @change="updateTeacher()"  class="option form-control" v-model="task_class.teacher_id">
                                                <option v-for="t in teachers" :key="t.teacher_id" :value="t.teacher_id">
                                                    {{ t.teacher_name }}
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Student Limit</td>
                                    <td class="text-capitalize">
                                        <span v-if="!editStudentLimit">
                                            {{task_class.student_limit}}
                                            <i class="fa fa-pencil text-primary" style="cursor:pointer" @click="editStudentLimit = true"></i>
                                        </span>
                                        <div class="form-group" v-else>
                                            <input class="form-control" @blur="updateStudentLimit()" type="number" v-model="task_class.student_limit" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Duration</td>
                                    <td>
                                        <span v-if="!editClassTime">
                                            {{task_class.starts_at}} - {{task_class.ends_at}}
                                            <i class="fa fa-pencil text-primary" style="cursor:pointer" @click="editClassTime = true"></i>
                                        </span>
                                        <span v-else>
                                            <form @submit.prevent="updateClassTime()">
                                                <input class="form-control" type="datetime-local" v-model="task_class.starts_at" required>
                                                <input class="form-control" type="datetime-local" v-model="task_class.ends_at" required>
                                                <input type="submit" class="btn btn-sm btn-primary" value="Update">
                                            </form>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Students</td>
                                    <td>
                                        <span v-for="student in task_class.students" class="text-capitalize m-1 bg-info p-1 text-white">{{student.user_name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Topics</td>
                                    <td>
                                        <span v-for="topic in task_class.topics" class="bg-primary m-1 p-1 text-white">{{topic.name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Age Groups</td>
                                    <td>
                                        <span v-for="age in task_class.ages" class="bg-primary m-1 p-1 text-white">{{age.value}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Recurring</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary">{{task_class.recurring ? 'Yes' : 'No'}}</button>
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" style="cursor:pointer" @click="updateRecurring(1)">Yes</a>
                                                <a class="dropdown-item" style="cursor:pointer" @click="updateRecurring(0)">No</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Free Session</td>
                                    <td>{{task_class.is_free_session ? 'Yes' : 'No'}}</td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>
                                        <span v-if="!editClassType">
                                            {{task_class.task_class_type_id ? task_class.task_class_type.type_name : '-'}}
                                            <i class="fa fa-pencil text-primary" style="cursor:pointer" @click="editClassType = true"></i>
                                        </span>
                                        <div class="form-group" v-else>
                                            <select @change="updateClassType()"  class="option form-control" v-model="task_class.task_class_type_id">
                                                <option v-for="type in task_class_types" v-bind:key="type.id" :value="type.id">
                                                    {{ type.type_name }}
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-danger" type="button" @click="deleteTaskClass(task_class)">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['id'],
        data(){
            return {
                message : '',
                errorMessage : '',
                task_class : {},
                locations : [],
                topics : [],
                ages : [],
                task_class_types : [],
                teachers : [],
                editTaskClass : false,
                editTeacher : false,
                editStudentLimit : false,
                editName: false,
                editRecurring: false,
                editClassTime: false,
                editClassType: false,
                bulkMessage : false
            };
        },
        created() {
            this.getTaskClass();
            this.getLocation();
            this.getTopics();
            this.getAges();
            this.getTaskClassTypes();
            setTimeout(()=>{
                this.getTeachersForLocation();
            }, 2000);
        },
        methods:{
            updateTeacher()
            {
                this.getTeachersForLocation();
                this.editTeacher = false;
                this.message = '';
                this.errorMessage = '';
                this.updateTaskClassData('other','teacher_id',this.task_class.teacher_id, 'Teacher');
                this.getTaskClass();
            },
            updateClassTime()
            {
                this.editClassTime = false;
                this.message = '';
                this.errorMessage = '';
                this.updateTaskClassData('same','starts_at',this.task_class.starts_at, 'Date Time');
                this.updateTaskClassData('same','ends_at',this.task_class.ends_at, 'Date Time');
                this.getTaskClass();
            },
            updateClassType()
            {
                this.editClassType = false;
                this.message = '';
                this.errorMessage = '';
                this.updateTaskClassData('same','task_class_type_id',this.task_class.task_class_type_id, 'Class Type');
                this.getTaskClass();
            },
            updateRecurring(value)
            {
                this.task_class.recurring = value;
                this.editRecurring = false;
                this.message = '';
                this.errorMessage = '';
                this.updateTaskClassData('same','recurring',this.task_class.recurring, 'Recurring');
            },
            updateName()
            {
                this.editName = false;
                this.message = '';
                this.errorMessage = '';
                this.updateTaskClassData('same','name',this.task_class.name, 'Name');
            },
            updateStudentLimit()
            {
                this.editStudentLimit = false;
                this.message = '';
                this.errorMessage = '';
                this.updateTaskClassData('same','student_limit',this.task_class.student_limit, 'Maximum student\'s limit');
            },
            updateTaskClassData(type, key, value, msg)
            {
                let _this = this;
                let data = {
                    'id' : _this.task_class.id,
                    'type' : type,
                    'key' : key,
                    'value' : value,
                    'msg' : msg
                };
                axios.post('/update-task-class-data', data).then(function(response)
                {
                    _this.message = response.data.message;
                })
            },
            getTeachersForLocation()
            {
                let _this = this;
                axios.post('/getTeachers',{'location_id' : _this.task_class.location_id}).then(function(response)
                {
                    if(response.data.response_msg === "No teachers found for this location.")
                    {
                        _this.errorMessage = 'No teachers found for this location';
                    } else {
                        _this.errorMessage = '';
                        _this.teachers = response.data.teachers;
                    }
                })
            },
            getTaskClassTypes(){
                let _this = this;
                axios.get('/get-task-class-types').then(function(response){
                    _this.task_class_types = response.data.task_class_types;
                })
            },
            getAges()
            {
                let _this = this;
                axios.get('/get-ages').then(function(response)
                {
                    _this.ages = response.data.ages;
                })
            },
            getTopics()
            {
                let _this = this;
                axios.get('/get_topics').then(function(response){
                    _this.topics = response.data.topics;
                })
            },
            getLocation()
            {
                let _this = this;
                axios.get('/get-locations').then(function (response)
                {
                    _this.locations = response.data.locations;
                })
            },
            getTaskClass()
            {
                let _this = this;
                axios.get('/get-task-class/' + _this.id).then(function (response)
                {
                    _this.task_class = response.data.task_class;
                })
            },
            deleteTaskClass(task_class)
            {
                let _this = this;
                if(confirm('This will also delete all student tasks associated to this class. Are you sure?'))
                {
                    axios.delete('/task-classes-delete/' + task_class.id).then(function (response)
                    {
                        _this.message = response.data.message;
                        window.location.pathname = '/admin/calendar';
                    }).catch(function (error) {
                        _this.errorMessage = error.response.data.message;
                    })
                }
            },
        }
    }
</script>