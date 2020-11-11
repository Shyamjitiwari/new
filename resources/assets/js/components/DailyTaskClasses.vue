<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="getDailyClasses">
                        <div class="row">
                            <div class="form-group col">
                                <label>Select Date</label>
                                <input type="date" class="form-control" v-model="date">
                            </div>
                            <div class="form-group col">
                                <label>Location</label>
                                <select class="form-control" v-model="location_id">
                                    <option disabled selected value="">Select Location</option>
                                    <option
                                            v-for="location in locations"
                                            :key="location.location_id"
                                            :value="location.location_id">{{location.location_name}}</option>
                                </select>
                            </div>
                        </div>
                        <input v-if="!loading" class="btn btn-primary" type="submit" value="Get Schedule" />
                        <loader-button v-else title="Fetching..." bg="bg-primary text-white"></loader-button>
                        <input class="btn btn-danger" type="button" value="Reset" @click="reset" />
                    </form>
                    <br>
                    <span class="text-danger" v-if="errorMessage">
                        {{errorMessage}}
                        <br>
                    </span>
                    <div class="table-responsive" v-if="dailyClasses.length != 0">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th v-for="teacher in dailyClasses.teachers" class="text-capitalize">{{teacher}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="slot in dailyClasses.slots">
                                <th width="10%">{{slot}}</th>
                                <td v-for="teacher in dailyClasses.teachers" class="text-capitalize">
                                   <span v-for="(t, parent) in dailyClasses.students" v-if="slot === parent">
                                       <span v-for="(task_class,index) in t" v-if="index === teacher">
                                           <span
                                                   v-for="student in task_class.students"
                                                   class="bg-success p-1 text-white"
                                                   style="margin:2px!important">
                                               <a class="text-white" :href="'/edit_student_profile/'+student.id" target="new">
                                                   {{student.user_name}} - {{task_class.ends_at | timeOnly}}
                                                   {{task_class.task_class_type ? '-' : ''}} {{task_class.task_class_type ? task_class.task_class_type.type_name : ''}}
                                               </a>
                                               <br>
                                           </span>
                                           <span class="bg-warning p-1 text-white" v-if="!dailyClasses.students[slot][index].students.length">No Students</span>
                                       </span>
                                   </span>
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
        data(){
            return {
                date : '',
                dailyClasses : [],
                loading : false,
                errorMessage : '',
                location_id : '',
                locations : [],
            }
        },
        created(){
            this.getDailyClasses();
            this.getLocations();
        },
        methods : {
            reset(){
                this.date = '';
                this.errorMessage = '';
                this.location_id = '';
                this.getDailyClasses();
            },
            getDailyClasses()
            {
                let _this = this;
                _this.loading = true;
                _this.errorMessage = '';
                axios.post('/admin/get-daily-task-classes', {'date' : _this.date, 'location_id' : _this.location_id})
                .then(function(response){
                    _this.dailyClasses = response.data.data;
                    _this.loading = false;
                }).catch( function(error)
                {
                    _this.dailyClasses = [];
                    _this.loading = false;
                    _this.errorMessage = error.response.data.message;
                });
            },
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
        }
    }
</script>