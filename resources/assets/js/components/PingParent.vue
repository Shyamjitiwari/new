<template>
    <div>
        <i v-if="!sending" title="Ping Parent" @click="pingParent" class="fa fa-send-o text-danger"></i>
        <i v-else class="fa fa-spinner fa-spin text-danger"></i>
    </div>
</template>

<script>
    export default {
        props : ['student_id'],
        data(){
            return {
                sending : false
            }
        },
        methods:{
            pingParent(){
                let _this = this;
                if(confirm('Are you sure you want to ping the student? It will send their parent a message letting them know that they are late to class.'))
                {
                    _this.sending = true
                    axios.post('/ping-student',{'student_id':_this.student_id}).then(function(response){
                        alert(response.data.message);
                        _this.sending = false
                    })
                }
            }
        }
    }
</script>