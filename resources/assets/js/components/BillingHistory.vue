<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
               
                <div v-show="subscriptionsRecordPresent">
                    <h3>Subscriptions</h3>
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td><b>Plan</b></td> 
                                <td><b>Amount</b></td>
                                <td><b>Currency</b></td>  
                                <td><b>Frequency</b></td>     
                                <td><b>Invoice</b></td>      
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="subscription in subscriptions" v-bind:key="subscription.plan_id">
                               <td>{{ subscription.subscription_name }}</td>
                               <td>{{ subscription.amount }}</td>
                               <td>{{ subscription.currency }}</td>
                               <td>{{ subscription.frequency }}</td>
                               <td><a :href="subscription.invoice_url" target="_blank">Invoice</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
<br/><br/>
                <div v-show="oneTimePaymentsRecordPresent">
                    <h3>One Time Payments</h3>
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td><b>Plan</b></td> 
                                <td><b>Amount</b></td>
                                <td><b>Currency</b></td>      
                                <td><b>Paid at</b></td>      
                                <td><b>Receipt</b></td>      
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="oneTimePayment in oneTimePayments" v-bind:key="oneTimePayment.product_name">
                               <td>{{ oneTimePayment.product_name }}</td>
                               <td>{{ oneTimePayment.amount }}</td>
                               <td>{{ oneTimePayment.currency }}</td>
                               <td>{{ oneTimePayment.paid_at }}</td>
                               <td><a :href="oneTimePayment.receipt_url" target="_blank">Receipt</a></td>
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
                subscriptions : [],
                oneTimePayments : [],
                subscriptionsRecordPresent : false,
                oneTimePaymentsRecordPresent : false,
            }
        },
        methods:{
            getSubscriptions(){
                var _this = this;
                axios.get('/billing_history_of_subscriptions').then(function(response){
                    if(response.data.response_msg == "No history of Subscriptions."){
                        _this.subscriptionsRecordPresent = false;
                    }
                    else{
                        _this.subscriptions = response.data.subscriptions;
                        _this.subscriptionsRecordPresent = true;
                    }
                })
            },
            getOneTimePayments(){
                var _this = this;
                axios.get('/billing_history_of_one_time_payments').then(function(response){
                    if(response.data.response_msg == "No history of One time payments."){
                        _this.oneTimePaymentsRecordPresent = false;
                    }
                    else{
                        _this.oneTimePayments = response.data.oneTimePayments;
                        _this.oneTimePaymentsRecordPresent = true;
                    }
                })
            }
        },
        created() {
            this.getSubscriptions();
            this.getOneTimePayments();
            console.log('Component mounted and then created.')
        }  
    }
</script>
