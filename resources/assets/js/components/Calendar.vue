<template>
<div class="container">
  <div v-show="displayError">
    <h6 style="color:red">No scheduled classes are found for this Location.</h6>
  </div><br/>
  <div class="row">
      <div class="col-md-5">
          <div class="form-group row">
              <label class="col-lg-5 col-form-label" >Select a Location<span class="text-danger">*</span></label>
              <div class="col-lg-7">
                  <select  class="option form-control" @change="onChangeOfLocation($event)" v-model="selectedValueOfLocation" required>
                      <option v-for="location in locations"
                              v-bind:key="location.location_id"
                              :value="location.location_id"
                      > {{ location.location_name }}
                      </option>
                  </select>
              </div>
              <div class="col-lg-2" v-if="loading">
                  <i class="fa fa-spinner fa-spin fa-2x text-dark"></i>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-lg-5 col-form-label" >Select Teacher</label>
              <div class="col-lg-7">
                  <select  class="option form-control" @change="onChangeOfTeacher($event)" v-model="selectedValueOfTeacher" required>
                      <option v-for="teacher in teachers"
                              v-bind:key="teacher.teacher_id"
                              :value="teacher.teacher_id"
                      > {{ teacher.teacher_name }}
                      </option>
                  </select>
              </div>
          </div>
      </div>
      <div class="col-md-7">
          <table class="table table-sm">
              <tr>
                  <td><i class='fa fa-circle text-success'></i></td>
                  <td>Free Task</td>
                  <td><i class='fa fa-circle text-info'></i></td>
                  <td>First Task</td>
                  <td><i class='fa fa-circle text-warning'></i></td>
                  <td>Recurring Task</td>
                  <td><i class='fa fa-circle text-primary'></i></td>
                  <td>Private Task</td>
              </tr>
              <tr>
                  <td><span style="background-color: darkgrey; color: transparent" class="p-1">1</span></td>
                  <td>Completed Task</td>
                  <td><span style="background-color: red; color: transparent" class="p-1">1</span></td>
                  <td>Absent Task</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
              </tr>
              <tr>
                  <td><span style="background-color: #fda554; color: transparent" class="p-1">1</span></td>
                  <td>Other Classes</td>
                  <td><span style="background-color: #ff7575; color: transparent" class="p-1">1</span></td>
                  <td>Free Session</td>
                  <td><span style="color: transparent" class="p-1 bg-info">1</span></td>
                  <td>Recurring</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
              </tr>
          </table>
      </div>
  </div>

  <vue-cal :events="events" style="height: 950px" :time="false" active-view="day"
         :disable-views="['years', 'year']"/>
</div>
</template>

<script>
export default {
  name: 'calendar',
  components:{
    'vue-cal': vuecal
  },
  data(){
     return {
        displayError : false,

        location_id : '',
        location: { location_id: '', location_name : ''},
        locations:[],
         teachers:[],
        selectedValueOfLocation : '',
         selectedValueOfTeacher : null,
        events: [],
         loading : false
     };
  },
  methods:{
    getLocations(){
      var _this = this;
      axios.get('/calendar/get_locations').then(function(response){         
           if(response.data.response_msg == "No Locations found."){
              _this.displayError = true;
            }
            else{
              _this.locations = response.data.locations; 
            }
      })
    },
    onChangeOfLocation(e){
        this.location['teacher_id'] = this.selectedValueOfTeacher;
        this.teachers = [];
        this.selectedValueOfTeacher = null;
      this.location.location_id = event.target.value;
      var _this = this;
      _this.getEvents();
      _this.getTeachers();
    },
    getEvents(){
      var _this = this;
      _this.loading = true
      axios.post('/calendar/get_calendar_events',this.location).then(function(response){                   
          if(response.data.response_msg == "No scheduled classes are found for this Location."){
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
    },
      onChangeOfTeacher(e){
          this.location['teacher_id'] = this.selectedValueOfTeacher;
          this.getEvents();
      },
      getTeachers(){
          var _this = this;
          axios.post('/getTeachers',this.location).then(function(response)
          {
              if(response.data.response_msg === "No teachers found for this location.") {}
              else{
                  _this.teachers = response.data.teachers;
              }
          })
      },
      // End of Get Data Method

  },
  created() {
    this.getLocations();
  }
}
</script>
