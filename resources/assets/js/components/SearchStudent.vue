<template>
    <div>
        <br/>
        <h4>Search Students by : </h4>
        <input class="btn btn-primary" type="button" @click="displaySearchByPhoneNumberForm" value="Phone Number"/>
        <input class="btn btn-primary" type="button" @click="displaySearchByFullNameForm" value="Name"/>
        <input class="btn btn-primary" type="button" @click="displaySearchByEmailIdForm" value="Email Address"/>
        <br/><br/><br/>
        <div v-show="displayError">
            <h6 style="color:red">No Student exists with this record</h6>
        </div>
        <div v-show="displaySuccess">
            <h6 style="color:green">Student are assigned to classes</h6>
        </div>
        
        <form v-show="showSearchByPhoneNumberForm" @submit.prevent="getStudentByPhoneNumber" enctype="multipart/form-data">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" maxlength = "100" class="form-control" id="phone_number" placeholder="Phone Number" v-model="student.phone_number" required/>
            </div>   
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <form v-show="showSearchByFullNameForm" @submit.prevent="getStudentByFullName" enctype="multipart/form-data">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" maxlength = "100" class="form-control" id="Name" placeholder="Full Name" v-model="student.full_name" required/>
            </div>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <form v-show="showSearchByEmailIdForm" @submit.prevent="getStudentByEmailId" enctype="multipart/form-data">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" maxlength = "100" class="form-control" id="Email" placeholder="example@example.com" v-model="student.email_id" required/>
            </div>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <br/><br/>
         <table class="table" id="table" v-if="showDataTable">
            <thead>
                <tr>
                    <td><h5>Students </h5></td>
                    <td><h5>Action </h5></td>
                </tr>
            </thead>
             <tbody>
                <tr v-for="student in students" v-bind:key="student.student_id">
                    <td><a :href="student.link_to_profile">{{ student.student_name }}</a></td>
                    <td><archive-student :student_id="student.student_id" @onUpdate="removeRow(student)"> </archive-student></td>
                </tr>
            </tbody>
        </table>
       
        </div>
</template>

<script>
export default {
        data(){
            return {
                showDataTable : false,
                showSearchByPhoneNumberForm : false,
                showSearchByFullNameForm: false,
                showSearchByEmailIdForm: false,
                
                student_id : '',
                student: { selectedDate: '', student_id: '', phone_number : '', full_name : '',email_id :''},
                students:[],

                selectedValueOfStudent : '',
           
                displayError : false,
                displaySuccess : false,

                studentData : { selectedStudentId : '', selectedClassId : ''},

                loading: false
            };
        },
        methods:{
            removeRow(student){
              this.students.splice(this.students.indexOf(student), 1);
            },
            displaySearchByPhoneNumberForm(){
                this.showDataTable = false;
                this.showSearchByPhoneNumberForm = true;
                this.showSearchByFullNameForm = false;
                this.showSearchByEmailIdForm = false;
                this.displaySuccess = false;
            },
            displaySearchByFullNameForm(){
                this.showDataTable = false;
                this.showSearchByPhoneNumberForm = false;
                this.showSearchByFullNameForm = true;
                this.showSearchByEmailIdForm = false;
                this.displaySuccess = false;
            },
            displaySearchByEmailIdForm(){
                this.showDataTable = false;
                this.showSearchByPhoneNumberForm = false;
                this.showSearchByFullNameForm = false;
                this.showSearchByEmailIdForm = true;
                this.displaySuccess = false;
            },
            getStudentByFullName(e){
                e.preventDefault();
                var _this = this;      
                axios.post('/get_student_by_fullName',this.student).then(function(response){
                    if(response.data.response_msg === "No Student exists with this information"){
                        _this.displayError = true;
                        _this.showDataTable = false;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByFullNameForm = true;
                        _this.showSearchByEmailIdForm = false;
                    }
                    else{
                        _this.displayError = false;
                        _this.student = { student_id: '', phone_number : '', full_name : '',email_id :''}
                        _this.students = response.data.students;
                        _this.showDataTable = true;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByFullNameForm = false;
                        _this.showSearchByEmailIdForm = false;
                    }  
                })                  
            },
            getStudentByPhoneNumber(e){
                e.preventDefault();
                var _this = this;      
                axios.post('/get_student_by_phoneNumber',this.student).then(function(response){
                    if(response.data.response_msg == "No Student exists with this information"){
                        _this.displayError = true;
                        _this.showDataTable = false;
                        _this.showSearchByPhoneNumberForm = true;
                        _this.showSearchByFullNameForm = false;
                        _this.showSearchByEmailIdForm = false;
                    }
                    else{
                        _this.displayError = false;
                        _this.student = { student_id: '', phone_number : '', full_name : '',email_id :''}
                         _this.students = response.data.students;
                        _this.showDataTable = true;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByFullNameForm = false;
                        _this.showSearchByEmailIdForm = false;
                    }  
                })                  
            },
            getStudentByEmailId(e){
                e.preventDefault();
                var _this = this;      
                axios.post('/get_student_by_emailId',this.student).then(function(response){
                    if(response.data.response_msg == "No Student exists with this information"){
                        _this.displayError = true;
                        _this.showDataTable = false;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByFullNameForm = false;
                        _this.showSearchByEmailIdForm = true;
                    }
                    else{
                        _this.displayError = false;
                        _this.student = { student_id: '', phone_number : '', full_name : '',email_id :''}
                         _this.students = response.data.students;
                        _this.showDataTable = true;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByFullNameForm = false;
                        _this.showSearchByEmailIdForm = false;
                    }  
                })      
            }
        },
        created() {
            console.log('VueJS component for adding students.');
        }
    }
</script>

