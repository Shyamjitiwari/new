<template>
    <div>
        <form v-show="cancelSub" @submit.prevent="cancelSubscription" enctype="multipart/form-data">
            <div class="form-group">
                <label style="color:black">Please tell us a reason for the cancellation of this Subscription : <b>{{ subscription.subscriptionName }}</b></label>
                <textarea v-model="subscription.cancellation_reason" class="form-control" id="update" rows="3" required></textarea>
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" />
            <br/><br/><br/><br/><br/>
        </form>
         
        <div class="row">
        <div class="col-md-12 "> 
            <p v-if="noActiveSubscriptions">No Active Subscriptions for this User</p>
            <div v-if="!noActiveSubscriptions" class="table-responsive">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <td><h3>Active Subscriptions</h3></td> 
                            <td></td>    
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="activeSubscription in activeSubscriptions" v-bind:key="activeSubscription.subscription_id">
                            <td>{{ activeSubscription.product_name }}</td>
                            <!-- <td><button @click="freezeSubscription(activeSubscription.subscription_id,activeSubscription.product_name)" class="btn btn-danger">Freeze</button></td> -->
                            <td><button @click="cancelThisSubscription(activeSubscription.subscription_id, activeSubscription.product_name)" class="btn btn-danger">Cancel</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br/><br/><br/>

        <!-- <div class="row">
            <div class="col-md-12 ">
               <h3>Freezed Subscriptions</h3>
                <p v-if="noFreezedSubscriptions">No Freezed Subscriptions for this User</p>
               <div v-if="!noFreezedSubscriptions" class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td><b>Subscription</b></td> 
                                <td></td>    
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="freezedSubscription in freezedSubscriptions" v-bind:key="freezedSubscription.subscription_id">
                               <td>{{ freezedSubscription.product_name }}</td>
                               <td><button @click="reActivateSubscription(activeSubscription.subscription_id)" class="btn btn-danger">Re Activate</button></td>
                            </tr>
                        </tbody>
                    </table>
               </div>
            </div>
        </div> -->

        
        <div class="row">
            <div class="col-md-12 ">
                <p v-if="noCancelledSubscriptions">No Cancelled Subscriptions for this User</p>
               <div v-if="!noCancelledSubscriptions" class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td><h3>Cancelled Subscriptions</h3></td> 
                                <td></td>    
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cancelledSubscription in cancelledSubscriptions" v-bind:key="cancelledSubscription.subscription_id">
                               <td>{{ cancelledSubscription.product_name }}</td>
                               <td></td>
                            </tr>
                        </tbody>
                    </table>
               </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                activeSubscriptions : [],
                freezedSubscriptions : [],
                cancelledSubscriptions : [],
                subscriptionId : '',
                noActiveSubscriptions : false,
                noFreezedSubscriptions : false,
                noCancelledSubscriptions : false,
                cancelSub : false,
                subscription : { subscriptionId : '', subscriptionName: '', productName : '', cancellation_reason: ''},
            }
        },
        methods:{
            getData(){
                var _this = this;
                _this.getAllActiveSubscriptions();
                //_this.getAllFreezedSubscriptions();
                _this.getAllCancelledSubscriptions();
            },
            getAllActiveSubscriptions(){
               
                var _this = this;
                axios.get('/all_active_subscriptions_of_a_user').then(function(response){
                    if(response.data.response_msg == "No Active Subscriptions"){
                        _this.noActiveSubscriptions = true;
                    }
                    else{
                        _this.noActiveSubscriptions = false;
                        _this.activeSubscriptions = response.data.activeSubscriptions;
                    }
                })
            },  
            getAllFreezedSubscriptions(){
                var _this = this;
                axios.get('/all_freezed_subscriptions_of_a_user').then(function(response){
                    if(response.data.response_msg == "No Freezed Subscriptions"){
                        _this.noFreezedSubscriptions = true;
                    }
                    else{
                        _this.noFreezedSubscriptions = false;
                        _this.freezedSubscriptions = response.data.freezedSubscriptions;
                    }
                })
            },
            getAllCancelledSubscriptions(){
                var _this = this;
                axios.get('/all_cancelled_subscriptions_of_a_user').then(function(response){
                    if(response.data.response_msg == "No Cancelled Subscriptions"){
                        _this.noCancelledSubscriptions = true;
                    }
                    else{
                        _this.noCancelledSubscriptions = false;
                        _this.cancelledSubscriptions = response.data.cancelledSubscriptions;
                    }
                })
            },
            freezeSubscription(sub_id,prod_name){
                var _this = this;
                _this.subscription.subscriptionId = sub_id;
                _this.subscription.productName = prod_name;
                              
                axios.post('/add_billing_product',_this.subscription).then(function(response){
                    
                })                             
            },    
            cancelSubscription(){
                var _this = this;
                axios.post('/cancel_a_subscription',_this.subscription).then(function(response){
                    _this.getData();
                    _this.cancelSub = false;
                    _this.subscription.subscriptionName = "";
                    _this.subscription.cancellation_reason = "";
                })   
            }, 
            cancelThisSubscription(sub_id, prod_name){
                 var _this = this;
                _this.subscription.subscriptionId = sub_id;
                _this.subscription.subscriptionName = prod_name;
                _this.cancelSub = true;
            },
            reActivateSubscription(sub_id){
                var _this = this;
                _this.subscription.subscriptionId = sub_id;
                            
                axios.post('/reactivate_a_subscription',_this.subscription).then(function(response){
                    
                })   
            },
        },
        created() {
             this.getData();
        }
        
    }
</script>
