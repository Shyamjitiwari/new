<template>
    <div class="container">
        <div v-show="displayNoUsernameError">
            <h6 style="color:red">No Users exist with this Phone Number</h6>
        </div>
         <div v-show="wrongCredentialsError">
            <h6 style="color:red">Password is incorrect</h6>
        </div>
        <form v-if="showGetUserNameForm" @submit.prevent="getUserName" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-3"> 
                    <select class="form-control" v-model="user.country_id" required>
                        <option v-for="countryCallingCode in countryCallingCodes" :key="countryCallingCode.id" :value="countryCallingCode.id">{{countryCallingCode.calling_code}}</option>
                    </select>
                </div>
                <div class="form-group col-md-9">
                    <input type="number" maxlength = "100" class="form-control" id="phone_number" placeholder="Phone Number" v-model="user.phone_number" required/>
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="submit" />
        </form>

        <table class="table" id="table" v-if="showDataTable">
            <thead>
                <tr>
                    <td><h5>Choose your profile:</h5></td>
                    <td></td>
                </tr>
            </thead>
             <tbody>
                <tr v-for="user in users" v-bind:key="user">
                    <td>{{ user.fullname }}</td>
                    <td><button @click="loginWithThisUserName(user.username,user.fullname, user.is_password_available, user.phone_number)" class="btn btn-warning">Login</button></td>
                </tr>      
            </tbody>
        </table>

        <div v-if="loginForm" >
            
        <form @submit.prevent="login" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" maxlength = "100" class="form-control" id="user_name" v-model="user.name" required/>
                <label>Password</label>
                <input type="password" maxlength = "100" class="form-control" id="password2" placeholder="Password" v-model="user.password" required/>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">  
                    <input v-if="!loading" class="btn btn-primary" type="submit" value="submit" />
                    <loader-button v-else title="Signin" bg="bg-primary text-white"></loader-button>
                </div>
                <div class="form-group col-md-3">
                    <input class="btn btn-primary" @click="forgotPassword" value="Forgot password"/>
                </div>
            </div>
        </form>
        </div>
        <form @submit.prevent="setPassword" v-if="setPasswordForm" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" maxlength = "100" class="form-control" v-model="user.user_name" required/>
                <input type="hidden" maxlength = "100" class="form-control" v-model="user.full_name" required/>
                <input type="hidden" maxlength = "100" class="form-control" v-model="user.phone_number" required/>
                <input type="hidden" maxlength = "100" class="form-control" v-model="user.is_password_available" required/>
                <label>You need to setup a Password*</label>
                <input type="password" maxlength = "100" class="form-control" id="password1" placeholder="Password" v-model="user.password" required/>
            </div>
            <input class="btn btn-primary" type="submit" value="submit" />
        </form>

        
        <div v-show="errorForMisMatchedResetToken">
            <p style="color:red">Password Reset Token does not match.</p>
        </div>
        <form @submit.prevent="resetPasswordToken" v-if="resetPasswordTokenForm" enctype="multipart/form-data">
            <div class="form-group">
                <label>A password reset token has been sent to the phone number {{ user.phone_number }}. Please enter the password reset token.</label>
                <input type="text" maxlength = "100" class="form-control" id="password_reset_token" v-model="user.password_reset_token" required/>
            </div>
            <input class="btn btn-primary" type="submit" value="submit" />
        </form>

        <form @submit.prevent="resetPassword" v-if="resetPasswordForm" enctype="multipart/form-data">
            <div class="form-group">
                <label>Reset Password</label>
                <input type="password" maxlength = "100" class="form-control" v-model="user.resetPassword" required/>
            </div>
            <input class="btn btn-primary" type="submit" value="submit" />
        </form>
    </div>
</template>

<script>
export default {
        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                user_id : '',
                user: { _token :'', phone_number : '',user_name :'', full_name : '', is_password_available : '', 
                        password:'', newPassword : '', password_reset_token:'', resetPassword : '', country_id : ''},
                users:[],
                countryCallingCodes : [],
                showGetUserNameForm: true,
                showDataTable : false,
                loginForm : false,
                wrongCredentialsError : false,
                displayNoUsernameError : false,
                setPasswordForm : false,
                errorForMisMatchedResetToken : false,
                resetPasswordTokenForm : false,
                resetPasswordForm : false,
                loading : false
            };
        },
        methods:{
            getCountryCallingCodes(){
                var _this = this;
                axios.get('/country/callingCodes').then(function(response){
                    _this.countryCallingCodes = response.data.countryCallingCodes;
                    _this.user.country_id = response.data.selectedCountry;
                })
            },
            getUserName(e){
                e.preventDefault();
                var _this = this; 
                _this.user._token = _this.csrf;      
                axios.post('/usernamesUsingPhoneNumber',this.user).then(function(response){
                    if(response.data.response_msg == "No Usernames exists with this information"){
                        _this.showGetUserNameForm = true;
                        _this.showDataTable = false;
                        _this.loginForm = false;
                        _this.displayNoUsernameError = true;
                    }
                    else{
                        _this.displayNoUsernameError = false;
                        _this.user = { phone_number : '',user_name :'', full_name : '', is_password_available : '', password:'', newPassword : ''}
                        _this.users = response.data;
                        _this.showGetUserNameForm = false;
                        _this.showDataTable = true;
                        _this.loginForm = false;
                    }  
                })                  
            },
            loginWithThisUserName(userName, fullName, isPasswordAvailable, phoneNumber){
                var _this = this;
                if(isPasswordAvailable == "Yes"){
                    _this.user.user_name = userName;
                    _this.user.full_name = fullName;
                    _this.user.is_password_available = isPasswordAvailable;
                    _this.user.phone_number = phoneNumber;
                    _this.showGetUserNameForm = false;
                    _this.showDataTable = false;
                    _this.loginForm = true;
                    _this.setPasswordForm = false;
                }
                else if(isPasswordAvailable == "No"){
                    _this.user.user_name = userName;
                    _this.user.full_name = fullName;
                    _this.user.is_password_available = isPasswordAvailable;
                    _this.user.phone_number = phoneNumber;
                    _this.showGetUserNameForm = false;
                    _this.showDataTable = false;
                    _this.loginForm = false;
                    _this.setPasswordForm = true;
                }
               
            }, 
            login(e){
                e.preventDefault(); 
                var _this = this;
                _this.user._token = _this.csrf;
                _this.loading = true;
                axios.post('/login',_this.user).then(function(response){
                    if(response.data.user_name == "These credentials do not match our records."){
                        _this.wrongCredentialsError = true;
                        _this.loading = false;
                    }
                    else{
                        window.location.href = "/";
                        _this.wrongCredentialsError = false;
                        _this.loading = false;
                    }
                })
            },
            setPassword(e){
                e.preventDefault();    
                var _this = this;
                _this.user._token = _this.csrf;
                axios.post('/setPassword',_this.user).then(function(response){
                    axios.post('/login',_this.user).then(function(response){
                        if(response.data.user_name == "These credentials do not match our records."){
                            _this.wrongCredentialsError = true;
                        }
                        else{
                            window.location.href = "/";
                            _this.wrongCredentialsError = false;
                        }
                    })
                })
            },
            ///
            forgotPassword(){
                var _this = this;
                _this.user._token = _this.csrf;
                _this.loginForm = false;
                _this.resetPasswordTokenForm = true;
                _this.wrongCredentialsError = false;
                debugger;
                axios.post('/sendPasswordResetToken',_this.user).then(function(response){
                    _this.passwordResetToken = response.data.password_reset_token; 
                })
            },
            resetPasswordToken(e){
                e.preventDefault();
                var _this = this;
                if(_this.user.password_reset_token == _this.passwordResetToken){
                    _this.errorForMisMatchedResetToken = false;
                    _this.resetPasswordTokenForm = false;
                    _this.resetPasswordForm = true;
                }else{
                    _this.errorForMisMatchedResetToken = true;
                    _this.resetPasswordTokenForm = true;
                }
            },
            resetPassword(e){
                e.preventDefault(); 
                var _this = this;
                _this.user._token = _this.csrf;    
                axios.post('/resetPassword',_this.user).then(function(response){
                    _this.user.password = _this.user.resetPassword;
                    axios.post('/login',_this.user).then(function(response){
                        if(response.data.user_name == "These credentials do not match our records."){
                            //
                        }
                        else{
                            window.location.href = "/";
                        }
                    })
                })
            }
        },
        created() {
            this.getCountryCallingCodes();
            console.log('VueJS component created now.');
        }
    }
</script>
