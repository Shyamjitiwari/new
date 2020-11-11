<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                
                <div class="panel panel-default">               
                    <div class="panel-body">    
                        <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item clearfix">
                                        <h6 v-show="successMessageForReminder" style="color:green">Reminder has been sent.</h6>
                                        <div>
                                            <h5>Send Reminder SMS and Email to Parents for tomorrow's Classes.</h5>
                                            <button type="button" @click="sendReminderSMSAndEmail" class="btn btn-outline-dark">Send</button>
                                        </div>
                                    </li>
                                    <li class="list-group-item clearfix">
                                        <h6 v-show="successMessageForReminderOneHourBeforeClass" style="color:green">Reminder has been sent.</h6>
                                        <div>
                                            <h5>Send Reminder SMS and Email to Parents for Classes in one hour from now.</h5>
                                            <button type="button" @click="sendReminderSMSAndEmailForClassesInOneHour" class="btn btn-outline-dark">Send</button>
                                        </div>
                                    </li>
                                    <li class="list-group-item clearfix">
                                        <h6 v-show="successMessageForRecurringClasses" style="color:green">Classes has been created.</h6>
                                        <div>
                                            <h5>Create Recurring Classes</h5>
                                            <button type="button" @click="createRecurringClasses" class="btn btn-outline-dark">Create</button>
                                        </div>
                                    </li>
                                </ul>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                successMessageForReminder: false,
                successMessageForReminderOneHourBeforeClass : false,
                successMessageForRecurringClasses : false,
                errorMessage : false,
            }
        },
        mounted() {
            console.log('Component mounted and then created.')
        },
        methods:{
            sendReminderSMSAndEmail(){
                var _this = this;
                axios.get('/send_reminder_text_and_email_to_the_parents').then(function(response){
                    _this.successMessageForReminder = true; 
                })
            },
            sendReminderSMSAndEmailForClassesInOneHour(){
                var _this = this;
                axios.get('/send_reminder_to_the_parents_one_hour_before_class').then(function(response){
                    _this.successMessageForReminderOneHourBeforeClass = true; 
                })
            },
            createRecurringClasses(){
                 var _this = this;
                axios.get('/create_recurring_classes').then(function(response){
                    _this.successMessageForRecurringClasses = true; 
                })
            }
        }
        
    }
</script>
