<template>
    <div>
        <button type="button" style="cursor: pointer" v-if="!loading" @click="archiveStudent()" class="btn btn-danger">Archive</button>
        <loader-button v-else bg="btn-danger text-white"></loader-button>
    </div>
</template>

<script>
    export default {
        props : ['student_id'],
        data(){
            return {
                loading: false
            }
        },
        methods : {
            archiveStudent()
            {
                let _this = this;
                if(confirm('Are you sure you want to archive this student?'))
                {
                    _this.loading = true;
                    axios.post('/archive-student', {'student_id' : _this.student_id}).then(function(response){
                        _this.loading = false;
                        _this.$emit('onUpdate');
                    });
                }
            },
        }
    }
</script>