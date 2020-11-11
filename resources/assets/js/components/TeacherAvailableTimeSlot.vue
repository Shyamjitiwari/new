<template>
    <div>
        <form @submit.prevent="addTeacherTimeSliot">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Location</label>
                        <select class="form-control" v-model="time_slot.location_id">
                            <option v-for="location in locations" :value="location.id">{{location.location_name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Day</label>
                        <select class="form-control" v-model="time_slot.day_id">
                            <option v-for="day in days" :value="day.day_id">{{day.day_name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Time</label>
                        <select class="form-control" v-model="time_slot.time_id">
                            <option v-for="time in times" :value="time.time_id">{{time.time_time}}</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Limit</label>
                        <input type="number" v-model="time_slot.limit" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group text-success" v-if="message">
                {{message}}
            </div>

            <div class="form-group text-danger" v-if="errorMessage">
                {{errorMessage}}
            </div>

            <div class="row">
                <div class="col">
                    <button v-if="!loading" type="submit" class="btn btn-primary">Save</button>
                    <loader-button v-else title="Saving..." bg="btn-primary"></loader-button>
                </div>
            </div>
        </form>
        <br><br>
        <div class="form-group">
            <label>Location</label>
            <select class="form-control" v-model="selectedLocation" @change="fetchTeachersAvailableTimeSlots">
                <option v-for="location in locations" :value="location.id">{{location.location_name}}</option>
            </select>
        </div>
        <br>
        <div v-if="selectedLocation">
            <table class="table table-sm table-borderless table-striped">
                <thead>
                <tr>
                    <th>Weekly Availability</th>
                    <th>Limit</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="t in availableTimeSlots">
                    <td>{{t.time_string}}</td>
                    <td>{{t.limit}}</td>
                    <td>
                        <button type="button" @click="deleteTimeSlot(t)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['teacher_id'],
        data(){
            return {
                locations : [],
                days : [],
                times : [],
                time_slot : {
                    limit: 15
                },
                selectedLocation : '',
                availableTimeSlots : [],
                loading : false,
                errorMessage : '',
                message : '',
            }
        },
        created(){
            this.getLocations();
            this.getDays();
            this.getTimes();
        },
        methods:{
            fetchTeachersAvailableTimeSlots(){
                let _this = this;
                axios.post('/get-teacher-time-slots', {'location_id' : _this.selectedLocation, 'teacher_id' : _this.teacher_id}).then(function(response)
                {
                    _this.availableTimeSlots = response.data.availableTimeSlots;
                })
            },
            addTeacherTimeSliot(){
                let _this = this;
                _this.loading = true;
                _this.message = '';
                _this.errorMessage = '';
                _this.time_slot['teacher_id'] = _this.teacher_id;
                axios.post('/save-teacher-time-slot', _this.time_slot).then(function(response)
                {
                    _this.message = response.data.message;
                    _this.loading = false;
                    _this.reset();
                }).catch(function(error){
                    _this.errorMessage = error.response.data.error;
                    _this.loading = false;
                });
            },
            getLocations()
            {
                let _this = this;
                axios.get('/get-locations', _this.location).then(function(response)
                {
                    _this.locations = response.data.locations;
                })
            },
            getDays()
            {
                var _this = this;
                axios.get('/get_days_for_free_session').then(function(response){
                    _this.days = response.data.days;
                })
            },
            getTimes()
            {
                var _this = this;
                axios.get('/get_times_for_free_session').then(function(response){
                    _this.times = response.data.times;
                })
            },
            deleteTimeSlot(time_slot)
            {
                if(confirm('Are you sure you want to delete this time slot?')){
                    let _this = this;
                    axios.delete('/delete-teacher-time-slot/'+time_slot.id).then(function(response)
                    {
                        _this.fetchTeachersAvailableTimeSlots();
                    })
                }
            },
            reset(){
                this.selectedLocation = '';
                this.time_slot = {limit: 15}
            }
        }

    }
</script>