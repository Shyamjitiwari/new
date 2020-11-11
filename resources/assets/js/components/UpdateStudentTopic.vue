<template>
    <select class="form-control form-control-sm" @change="updateTopic()" v-model="topic">
        <option v-for="topic in topics" :value="topic">{{topic.topic_name}}</option>
    </select>
</template>

<script>
    export default {
        props : ['student'],
        data(){
            return {
                topic : {},
                topics: []
            }
        },
        created(){
            this.getTopics();
        },
        methods : {
            updateTopic(){
                var _this = this;
                axios.post('/update_student_topic', {'topic_id' : _this.topic.topic_id, 'student_id' : _this.student.id}).then(function(response){
                    _this.$emit('postTopicUpdate');
                })
            },
            getTopics(){
                var _this = this;
                axios.get('/get_topics').then(function(response){
                    _this.topics = response.data.topics;
                })
            },
        }
    }
</script>

<style scoped>
    .form-control {
        background-color: #9ab1f5;
        font-size: 10px;
        color: #000000;
        border: none;
        border-radius: 0px;
    }
</style>