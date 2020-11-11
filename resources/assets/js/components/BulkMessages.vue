<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <form @submit.prevent="sendMessage">
                            <br/>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <div class="custom-control custom-radio col-md-6">
                                        <input v-model="bulk.type" type="radio" id="customRadio2" value="email" name="customRadio" class="custom-control-input" required    >
                                        <label class="custom-control-label" for="customRadio2">Email</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="custom-control custom-radio ">
                                        <input v-model="bulk.type" type="radio" id="customRadio1" value="sms" name="customRadio" class="custom-control-input" required>
                                        <label class="custom-control-label" for="customRadio1">SMS</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="bulk.type === 'email'">
                                <div class="form-group col-md-6">
                                    <label>Sender Email</label>
                                    <input v-model="bulk.sender_email" type="email" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sender Password</label>
                                    <input v-model="bulk.sender_password" type="password" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h3>To use bulk email, you must turn on "Less secure app access" in your gmail settings:</h3>
                                        <ol>
                                            <li>Go to the <a href="https://myaccount.google.com/lesssecureapps" target="_blank" rel="noopener">Less secure app access</a> section of your Google Account. You might need to sign in.</li>
                                            <li>Turn <strong>Allow less secure apps</strong> on.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col" v-if="bulk.type === 'email'">
                                    <label>Subject<span class="text-danger">*</span></label>
                                    <input v-model="bulk.subject" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row" v-if="!task_class">
                                <div class="col-md col-sm-12" v-if="students && !bulk.location && !bulk.age">
                                    <div class="form-group">
                                        <label>Date<span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" v-model="bulk.date" required/>
                                    </div>
                                </div>
                                <div class="col-md col-sm-12" v-if="!bulk.date">
                                    <div class="form-group">
                                        <label>Location<span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="bulk.location" required>
                                            <option disabled selected>Select Location</option>
                                            <option v-for="location in locations" :key="location.id" :value="location.id">{{location.location_name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md col-sm-12" v-if="students && !bulk.date">
                                    <div class="form-group">
                                        <label>Age (Separate by comma, ex: 6,7,9)</label>
                                        <input class="form-control" v-model="bulk.age" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Message<span class="text-danger">*</span></label>
                                <vue-editor v-if="bulk.sender_email && bulk.sender_password" v-model="bulk.message"></vue-editor>
                                <textarea v-else class="form-control" rows="5" name="bulk_message" v-model="bulk.message" required></textarea>
                            </div>
                            <div class="form-group text-success" v-if="message">
                                {{message}}
                            </div>
                            <div class="form-group text-danger" v-if="errorMessage">
                                {{errorMessage}}
                            </div>
                            <div class="form-group">
                                <input v-if="!loading" class="btn btn-primary" type="submit" value="Send Message" />
                                <loader-button v-else title="Sending..." bg="btn-primary"></loader-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { VueEditor } from "vue2-editor";
    export default {
        props : ['task_class'],
        data(){
            return {
                bulk : {},
                locations:[],
                // topics:[],
                message : '',
                errorMessage : '',
                loading : false
            }
        },
        computed:{
            students(){
                return window.location.pathname === "/bulk-messages/students";
            }
        },
        created() {
            this.getBulkMessageData();
        },
        methods:{
            sendMessage()
            {
                let _this = this;
                _this.loading = true;
                _this.message = '';
                _this.errorMessage = '';
                _this.bulk['students'] = _this.students;
                _this.bulk['task_class_id'] = _this.task_class ? _this.task_class.id : '';
                axios.post('/bulk-messages/send-message', _this.bulk).then(function(response)
                {
                    console.log(response.data.message);
                    _this.message = response.data.message;
                    _this.loading = false;
                    _this.reset();
                }).catch( function(error)
                {
                    console.log(error.response)
                    _this.errorMessage = error.response.data.message;
                    _this.loading = false;
                });
            },
            getBulkMessageData()
            {
                let _this = this;
                axios.get('/bulk-messages/get-bulk-message-data').then(function(response)
                {
                    _this.locations = response.data.data.locations;
                    // _this.topics = response.data.data.topics;
                })
            },
            reset()
            {
                this.bulk = {};
            }
        }
    }
</script>