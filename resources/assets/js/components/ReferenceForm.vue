<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div v-show="referenceSent">
                    <p style="color:green">Reference has been sent.</p>
                </div>
                <div>
                    <form @submit.prevent="addAndSendReference" enctype="multipart/form-data" >
                        <div class="form-group">
                            <input type="text" maxlength = "100" class="form-control" placeholder="Email Id" v-model="reference_data.email" required/>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3"> 
                                <select class="form-control" v-model="reference_data.country_id" required>
                                    <option v-for="countryCallingCode in countriesCallingCodes" :key="countryCallingCode.id" :value="countryCallingCode.id">{{countryCallingCode.calling_code}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="number" maxlength = "100" class="form-control" id="phone_number" placeholder="Phone Number" v-model="reference_data.phone_number" required/>
                            </div>
                        </div>
                        <input v-if="!loading" class="btn btn-primary" type="submit" value="submit" />
                        <loader-button v-else title="Sending..." bg="bg-primary text-white"></loader-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                referenceSent : false,
                countriesCallingCodes : [],
                reference_data : {email:'', country_id:'', phone_number:''},
                loading : false
            }
        },
        methods:{
            getCountryCallingCodes(){
                var _this = this;
                axios.get('/countries-calling-codes').then(function(response){
                    _this.countriesCallingCodes = response.data.countriesCallingCodes;
                })
            },
            addAndSendReference(){
                var _this = this;
                _this.loading = true;
                axios.post('/add-and-send-reference', this.reference_data).then(function(response){
                    _this.loading = false;
                    _this.referenceSent = true;
                    _this.reference_data = {email:'', country_id:'', phone_number:''};
                })
            }
        },
        created() {
            this.getCountryCallingCodes();
            console.log('Component mounted and then created.')
        }  
    }
</script>
