<template>
    <div>
        <button v-if="!pivot.absent" @click="markTaskClassAsAbsent()" class="btn btn-info">Mark As Absent</button>
        <button v-else @click="markTaskClassAsPresent()" class="btn btn-success">Mark As Present</button>
    </div>
</template>

<script>
    export default {
        props : {
            pivot : Object
        },
        methods:{
            markTaskClassAsAbsent()
            {
                if(confirm('Are you sure? Please wait up to 20 minutes after the start of class to mark student absent.'))
                {
                    let _this = this;
                    axios.post('/teacher/mark-task-class-absent', _this.pivot).then(function(response){
                        _this.$emit('postUpdate', _this.pivot.task_class_id);
                    });
                }
            },

            markTaskClassAsPresent()
            {
                if(confirm('Are you sure you want to mark as present?'))
                {
                    let _this = this;
                    axios.post('/teacher/mark-task-class-present', _this.pivot).then(function(response){
                        _this.$emit('postUpdate', _this.pivot.task_class_id);
                    });
                }
            },
        }
    }
</script>