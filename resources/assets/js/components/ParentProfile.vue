<template>
    <div class="container">
        <div v-show="noStudentsAvailable">
            <h6 style="color:red">No Students exist for this Parent</h6>
        </div>
        <div v-show="!noStudentsAvailable">
            <h3>Students</h3>
        </div>
        <table class="table" id="table" v-if="!noStudentsAvailable">
            <thead>
                <tr>
                    <td><h5>Full Name</h5></td>
                    <td><h5>Location</h5></td>
                    <td><h5>Credits Used</h5></td>
                </tr>
            </thead>
             <tbody>
                <tr v-for="student in studentsList" v-bind:key="student">
                    <td>{{ student.student_name}}</td>
                    <td>{{ student.location }}</td>
                    <td>{{ student.credits_used }}</td>
                </tr>      
            </tbody>
        </table>

        <br/>
        <div v-show="noSubscriptionsAvailable">
            <h6 style="color:red">No Past Subscriptions exist for this Parent</h6>
        </div>
        <div v-show="!noSubscriptionsAvailable">
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
                    <tr v-for="subscription in pastSubscriptions" v-bind:key="subscription.plan_id">
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

        <div v-show="noOneTimePaymentsAvailable">
            <h6 style="color:red">No Past One Time Payments exist for this Parent</h6>
        </div>
        <div v-show="!noOneTimePaymentsAvailable">
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
                    <tr v-for="oneTimePayment in pastOneTimePayments " v-bind:key="oneTimePayment.product_name">
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
</template>

<script>
    export default {
        data(){
            return {
                parentObj : {parent_id:''},
                studentsList : [],
                pastSubscriptions : [],
                pastOneTimePayments : [],
                noStudentsAvailable : false,
                noSubscriptionsAvailable : false,
                noOneTimePaymentsAvailable : false,
            }
        },
        props: ['parent'],
        methods:{
            getStudentsList(){
                let _this = this;
                axios.get('/parent/getStudents/'+_this.parentObj.parent_id).then(function(response){
                    _this.studentsList = response.data.students;
                })
            },
            getPastSubscriptions(){
                var _this = this;
                axios.get('/billing_history_of_subscriptions/'+_this.parentObj.parent_id).then(function(response){
                    if(response.data.response_msg == "No history of Subscriptions."){
                        _this.noSubscriptionsAvailable = true;
                    }else{
                        _this.pastSubscriptions = response.data.subscriptions;
                    }
                })
            },
            getPastOneTimePayments(){
                var _this = this;
                axios.get('/billing_history_of_one_time_payments/'+_this.parentObj.parent_id).then(function(response){
                    if(response.data.response_msg == "No history of One time payments."){
                        _this.noOneTimePaymentsAvailable = true;
                    }else{
                        _this.pastOneTimePayments = response.data.oneTimePayments;
                    }
                })
            },
        },
        created()
        {
            this.parentObj.parent_id = this.parent;
            this.getStudentsList();
            this.getPastSubscriptions();
            this.getPastOneTimePayments();
        }
    };
</script>

