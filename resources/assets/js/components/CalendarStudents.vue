<template>
    <div class="container">
        <div v-show="displayError">
            <h6 style="color:red">No scheduled classes have been found.</h6>
        </div>
        <br>
        <div class="form-group row" v-if="role_id == 3">
            <label class="col-lg-3 col-form-label" >Select Student<span class="text-danger">*</span></label>
            <div class="col-lg-3">
                <select  class="option form-control" @change="onStudentChange()" v-model="student" required>
                    <option v-for="student in students" v-bind:key="student.id" :value="student"> {{ student.full_name }}</option>
                </select>
            </div>
            <div class="col-lg-2" v-if="loading">
                <i class="fa fa-spinner fa-spin fa-2x text-dark"></i>
            </div>
        </div>
        <br>
        <vue-cal :events="events" style="height: 950px" :time="false" active-view="week" :disable-views="['years', 'year']"/>
    </div>
</template>

<script>
export default {
    name: 'calendar',
    components:{
        'vue-cal': vuecal
    },
    props : ['role_id'],
    data(){
        return {
            displayError : false,
            events: [],
            loading : false,
            students: [],
            student : {
                id : null
            }
        };
    },
    created(){
        console.log(this.user);
        this.getStudents();
        this.getEvents();
    },
    methods:{
        onStudentChange(){
            this.getEvents(this.student.id);
        },
        getStudents(){
            let _this = this;
            axios.post('/get-students-for-parent').then(function(response){
                _this.students = response.data.students;
            });
        },
          getEvents(student_id = null){
              var _this = this;
              _this.loading = true
              axios.post('/student/get-calendar-events', {'student_id' : student_id}).then(function(response){
                  if(response.data.response_msg === "No scheduled classes have been found."){
                      _this.displayError = true;
                      _this.events = [];
                      _this.loading = false;
                  }
                  else{
                    _this.displayError = false;
                    _this.events = response.data.events;
                    _this.loading = false;
                  }
              })
          }
  }
}
</script>
