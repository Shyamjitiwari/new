<template>
    <form @submit.prevent="saveUpdate">
        <div class="form-group">
            <label for="update">Update</label>
            <textarea v-model="message" class="form-control" id="update" rows="10" required></textarea>
            <small id="emailHelp" class="form-text text-muted"></small>
        </div>
        <button type="submit" class="btn btn-primary" v-if="!loading" >Send</button>
        <loader-button v-else title="Sending..." bg="btn-primary"></loader-button>

        <button type="submit" class="btn btn-danger" @click="closeModal">Close</button>
    </form>
</template>

<script>
    export default {
        props: ['student'],
        data(){
            return {
                message : '',
                loading: false
            }
        },
        methods: {
            closeModal()
            {
                this.$emit('closeModal');
            },
            saveUpdate()
            {
                let _this = this;
                _this.loading = true;
                let data = {
                    'student_id' : _this.student.student_id,
                    'message' : _this.message,
                };
                axios.post('/teacher/store-students-update', data).then(function(response) {
                    _this.reset();
                    _this.loading = false;
                    _this.$emit('closeModal');
                });
            },
            reset(){
                this.message = '';
            }
        }
    }
</script>