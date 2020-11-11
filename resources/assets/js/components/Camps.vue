<template>
    <div>
        <div class="row mb-2" v-if="showAddCamp">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <form @submit.prevent="addCamp">
                            <br/>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Name</label>
                                    <input v-model="camp.name" type="text" class="form-control" @blur="message=''" required placeholder="Camp Name...">
                                </div>
                                <div class="form-group col" v-if="!isEditable">
                                    <label>Location</label>
                                    <select class="form-control" @change="onChangeOfLocation($event)" v-model="camp.location_id" required>
                                        <option disabled selected value="">Select Location</option>
                                        <option v-for="location in locations" :key="location.location_id" :value="location.location_id">{{location.location_name}}</option>
                                    </select>
                                </div>
                                <div class="form-group col" v-if="!isEditable">
                                    <label>Teacher<span class="text-danger">*</span></label>
                                    <select  class="option form-control" v-model="camp.teacher_id" required>
                                        <option v-for="teacher in teachers" v-bind:key="teacher.teacher_id" :value="teacher.teacher_id"> {{ teacher.teacher_name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label>Camp Limit</label>
                                    <input v-model="camp.camp_limit" type="number" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label :style="{'background-color': camp.bg_color}" style="color:white;padding:1px">Background Color</label>
                                    <input v-model="camp.bg_color" type="text" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label>Start Date</label>
                                    <input v-model="camp.starts_at" type="date" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>End Date</label>
                                    <input v-model="camp.ends_at" type="date" class="form-control">
                                </div>
                            </div>

                            <h4>Camp Pricing</h4>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Half Day ($)</label>
                                    <input v-model="camp.hd" type="number" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>Full Day Day ($)</label>
                                    <input v-model="camp.fd" type="number" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>Friday Half Day ($)</label>
                                    <input v-model="camp.fhd" type="number" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>Friday Full Day ($)</label>
                                    <input v-model="camp.ffd" type="number" class="form-control" required>
                                </div>
                            </div>

                            <h4>Stripe Product ID</h4>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Half Day ${{camp.hd}}</label>
                                    <input v-model="camp.hd_p_id" type="text" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>Full Day Day ${{camp.fd}}</label>
                                    <input v-model="camp.fd_p_id" type="text" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>Friday Half Day + Half Day ${{parseInt(this.camp.fhd) + parseInt(this.camp.hd)}}</label>
                                    <input v-model="camp.fhd_hd_p_id" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label>Friday Half Day + Full Day  ${{parseInt(camp.fhd) + parseInt(camp.fd)}}</label>
                                    <input v-model="camp.fhd_fd_p_id" type="text" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>Friday Full Day + Half Day ${{parseInt(camp.ffd) + parseInt(camp.hd)}}</label>
                                    <input v-model="camp.ffd_hd_p_id" type="text" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>Friday Full Day + Full Day ${{parseInt(camp.ffd) + parseInt(camp.fd)}}</label>
                                    <input v-model="camp.ffd_fd_p_id" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input v-if="!loading && !isEditable" class="btn btn-primary" type="submit" value="Save" />
                                        <input v-else-if="!loading && isEditable" class="btn btn-warning" type="submit" value="Update" />
                                        <loader-button v-else-if="loading" title="Processing..." bg="btn-dark"></loader-button>
                                        <input class="btn btn-danger" type="button" value="Close" @click="hideCampForm" />
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="message">
                                <div class="col">
                                    <span>{{message}}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span v-if="message" class="text-success p-2">{{message}}</span>
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary" v-if="!showAddCamp" @click="showCampForm">Add Camp</button>
                        <button class="btn btn-danger" v-else @click="hideCampForm">Hide Form</button>
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th><h5>Name</h5></th>
                                <th><h5>Location</h5></th>
                                <th><h5>Period</h5></th>
                                <th><h5>BG</h5></th>
                                <th><h5>Camp Limit</h5></th>
                                <th><h5>Class Count</h5></th>
                                <th><h5>Action</h5></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="camp in camps">
                                <td>{{camp.name}}</td>
                                <td>{{camp.location.location_name}}</td>
                                <td> {{camp.starts_at | toDayDateString}} to {{camp.ends_at | toDayDateString}}</td>
                                <td>
                                    <span :style="{'background-color': camp.bg_color}" style="color: white; padding:5px;">
                                    {{camp.bg_color}}
                                    </span>
                                </td>
                                <td>{{camp.camp_limit}}</td>
                                <td>{{camp.taskclasses_count}}</td>
                                <td>
                                    <button class="btn btn-warning" @click="editCamp(camp)">Edit</button>
                                    <button class="btn btn-danger" @click="deleteCamp(camp)">Delete</button>
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
                showAddCamp : false,
                camps : [],
                loading: false,
                camp:{
                    id : '',
                    bg_color: 'blue',
                    location_id: '',
                    dates : [],
                    camp_limit : 0,
                    hd:235,
                    fd:395,
                    fhd:60,
                    ffd:75,
                    hd_p_id :'prod_HNnRQf8XskCyhf', //235
                    fd_p_id : 'prod_HNnSMxNVjfVCKC', //395
                    fhd_hd_p_id :'prod_HNmVeozJYil326', //295
                    fhd_fd_p_id : 'prod_HNnO4KY1teKDCJ', // 455
                    ffd_hd_p_id : 'prod_HNnNzUD7iDtsoI', // 310
                    ffd_fd_p_id : 'prod_HNnQjgcbT82bKe' // 470
                },
                repeats : '',
                message: '',
                locations : [],
                location : {},
                teachers : []
            }
        },
        computed:{
            isEditable(){
              return this.camp.id
            }
        },
        created(){
            this.getCamps();
            this.getLocations();
        },
        methods:{
            onChangeOfLocation(e)
            {
                this.message = '';
                this.location.location_id = event.target.value;
                var _this = this;

                axios.post('/getTeachers',this.location).then(function(response)
                {
                    if(response.data.response_msg === "No teachers found for this location.")
                    {
                        _this.message = true;
                    } else {
                        _this.message = false;
                        _this.teachers = response.data.teachers;
                    }
                })
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
            showCampForm(){
                this.message = '';
                this.showAddCamp = true;
            },
            hideCampForm(){
                this.camp = {
                    id : '',
                    location_id: '',
                    bg_color: 'blue',
                    dates : [],
                    camp_limit : 0,
                    hd:235,
                    fd:395,
                    fhd:60,
                    ffd:75,
                    hd_p_id :'prod_HNnRQf8XskCyhf', //235
                    fd_p_id : 'prod_HNnSMxNVjfVCKC', //395
                    fhd_hd_p_id :'prod_HNmVeozJYil326', //295
                    fhd_fd_p_id : 'prod_HNnO4KY1teKDCJ', // 455
                    ffd_hd_p_id : 'prod_HNnNzUD7iDtsoI', // 310
                    ffd_fd_p_id : 'prod_HNnQjgcbT82bKe' // 470
                };
                this.showAddCamp = false;
            },
            getCamps(){
                let _this = this;
                _this.message = '';
                axios.get('/get-all-camps', _this.camp).then(function(response)
                {
                    _this.camps = response.data.data;
                    _this.message = '';
                })
            },
            deleteCamp(camp){
                let _this = this;
                _this.message = '';
               if(confirm('Are you sure you want to delete this camp?')){
                   axios.post('/delete-camp', {id: camp.id}).then(function(response)
                   {
                       _this.message = response.data.message;
                       _this.getCamps();
                   })
               }
            },
            editCamp(camp){
                let _this = this;
                _this.showAddCamp = true;
                axios.post('/get-camp', {'id':camp.id}).then(function(response)
                {
                    _this.camp = response.data.data;
                })
            },
            reset(){
                this.camp = {
                    id : '',
                    location_id: '',
                    bg_color: 'blue',
                    dates : [],
                    camp_limit : 0,
                    hd:235,
                    fd:395,
                    fhd:60,
                    ffd:75,
                    hd_p_id :'prod_HNnRQf8XskCyhf', //235
                    fd_p_id : 'prod_HNnSMxNVjfVCKC', //395
                    fhd_hd_p_id :'prod_HNmVeozJYil326', //295
                    fhd_fd_p_id : 'prod_HNnO4KY1teKDCJ', // 455
                    ffd_hd_p_id : 'prod_HNnNzUD7iDtsoI', // 310
                    ffd_fd_p_id : 'prod_HNnQjgcbT82bKe' // 470
                }
                this.repeats = '';
            },
            addCamp(){
                let _this = this;
                _this.message = '';
                _this.loading = true;
                axios.post('/camps', _this.camp).then(function(response)
                {
                    _this.message = response.data.message;
                    _this.loading = false;
                    _this.reset();
                    _this.showAddCamp = false;
                    _this.getCamps();
                })
            },
            removeDate(date){
                this.camp.dates.splice(this.camp.dates.indexOf(date), 1);
            },
            addDate(date){
                if(!this.isDuplicate(date, this.camp.dates)) {
                    this.camp.dates.push({'name':date});
                }
                this.repeats = '';
            },
            isDuplicate(data, dataArray) {
                for(let i = 0; i < dataArray.length; i++){
                    if(data == dataArray[i].name) {
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
        }
    }
</script>