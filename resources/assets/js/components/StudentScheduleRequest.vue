<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div v-show="successfullyRequestSent">
                    <h6 style="color:green">Your request has been sent</h6>
                </div>
                <form @submit.prevent="scheduleForStudent" enctype="multipart/form-data">
                    Please select Student(s)
                    <select class="form-control" @change="onChangeOfStudentSelection($event)" v-model="selectedStudents" multiple="multiple" required>
                        <option v-for="student in students" :key="student.id" :value="student.id">{{ student.full_name }}</option>
                    </select>
                    <br/><br/>
                    <div v-show="isStudentSelected">
                        <div class="form-group">
                            <label>Please describe your schedule request on which day(s) and time(s) you would like.</label>
                            <textarea class="form-control" v-model="student.description" rows="3" required></textarea>
                        </div>
                        <input class="btn btn-primary" type="submit" v-if="!loading" value="Submit" />
                        <loader-button bg="btn-primary text-white" title="Sending..." v-else> </loader-button>
                    </div>
                    <br/><br/><br/><br/><br/>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                successfullyRequestSent: false,
                isStudentSelected : false,
                students : [],
                student : {student_id : '', description:''},
                selectedStudents : [],
                loading : false,
            }
        },
        created() {
            this.getStudentsForThisParent();
        },
        methods:{
            getStudentsForThisParent(){
                var _this = this;
                axios.get('/get-students-of-the-parent').then(function(response){
                    _this.students = response.data.students; 
                })
            },
            onChangeOfStudentSelection($id){
                var _this = this;
                _this.isStudentSelected = true;
            },
            scheduleForStudent(){
                var _this = this;
                _this.loading = true;
                _this.student.selectedStudents = _this.selectedStudents
                axios.post('/send-student-schedule-to-the-cwu-team',_this.student).then(function(response){
                    _this.student = {student_id : '', description:''};
                    _this.isStudentSelected = false;
                    _this.successfullyRequestSent = true;
                    _this.loading = false;
                })
            }
        }
        
    }
</script>
