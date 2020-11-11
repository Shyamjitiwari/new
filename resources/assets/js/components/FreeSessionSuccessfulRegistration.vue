<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
      
                 <div v-show="thankyouForm">
                    <h4 style="color:black">THANKYOU !</h4>
                    <h6>You have successfully subscribed for a Free Session for {{ studentNameForBookedFreeSession }} at {{ timeslotForBookedFreeSession }}.</h6>
                    <h6>{{ thankyouMessage }}</h6>
                </div>
            
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                props: ['success'],
                thankyouMessage : '',
            };
        },
        created() {
            this.getThankyouMessage();
        },
        methods:{
            getThankyouMessage(){
                var _this = this;
                 axios.get('/get_thankyou_message').then(function(response){         
                    _this.thankyouMessage = response.data.response_msg;
                })
            },
        },
    }
</script>