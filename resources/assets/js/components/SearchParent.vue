<template>
    <div class="container">
        <br/>
        <h4>Search Parents by : </h4>
        <input class="btn btn-primary" type="button" @click="displaySearchByPhoneNumberForm" value="Phone Number"/>
        <input class="btn btn-primary" type="button" @click="displaySearchByEmailForm" value="Email"/>
        <br/><br/><br/>
        <div v-show="displayError">
            <h6 style="color:red">No Parent exists with this information</h6>
        </div>
    
        <form v-show="showSearchByPhoneNumberForm" @submit.prevent="getParentByPhoneNumber" enctype="multipart/form-data">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" maxlength = "100" class="form-control" id="phone_number" placeholder="Phone Number" v-model="parent.phone_number" required/>
            </div>   
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <form v-show="showSearchByEmailForm" @submit.prevent="getParentByEmail" enctype="multipart/form-data">
            <div class="form-group">
                <label>Email</label>
                <input type="text" maxlength = "100" class="form-control" id="email" placeholder="Email" v-model="parent.email_id" required/>
            </div>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <br/>
         <table class="table" id="table" v-if="showDataTable">
            <thead>
                <tr>
                    <td><h5>Parents </h5></td>
                </tr>
            </thead>
             <tbody>
                <tr v-for="parent in parents" v-bind:key="parent.parent_id">
                    <td><a :href="parent.link_to_profile">{{ parent.parent_name }}</a></td>
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
                showSearchByEmailForm: false,
                
                parent_id : '',
                parent: { parent_id: '', phone_number : '', email_id : ''},
                parents:[],
                selectedValueOfParent : '',
           
                displayError : false,

                parentData : { selectedParentId : ''},
            };
        },
        methods:{
            displaySearchByPhoneNumberForm(){
                this.showDataTable = false;
                this.showSearchByPhoneNumberForm = true;
                this.showSearchByEmailForm = false;
                this.displaySuccess = false;
            },
            displaySearchByEmailForm(){
                this.showDataTable = false;
                this.showSearchByPhoneNumberForm = false;
                this.showSearchByEmailForm = true;
                this.displaySuccess = false;
            },
            getParentByPhoneNumber(e){
                e.preventDefault();
                var _this = this;      
                axios.post('/get_parent_by_phoneNumber',this.parent).then(function(response){
                    if(response.data.response_msg == "No Parent exists with this information"){
                        _this.displayError = true;
                        _this.showDataTable = false;
                        _this.showSearchByPhoneNumberForm = true;
                        _this.showSearchByEmailForm = false;
                    }
                    else{
                        _this.displayError = false;
                        _this.parent = { parent_id: '', phone_number : '', email_id : ''}
                        _this.parents = response.data.parents;
                        _this.showDataTable = true;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByEmailForm = false;
                    }  
                })                  
            },
            getParentByEmail(e){
                e.preventDefault();
                var _this = this;  
                debugger;    
                axios.post('/get_parent_by_emailId',this.parent).then(function(response){
                    if(response.data.response_msg == "No Parent exists with this information"){
                        _this.displayError = true;
                        _this.showDataTable = false;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByEmailForm = true;
                    }
                    else{
                        _this.displayError = false;
                        _this.parent = { parent_id: '', phone_number : '', email_id : ''}
                        _this.parents = response.data.parents;
                        _this.showDataTable = true;
                        _this.showSearchByPhoneNumberForm = false;
                        _this.showSearchByEmailForm = false;
                    }  
                })                  
            },
        },
        created() {
            console.log('VueJS component for searching Parents.');
        }
    }
</script>

