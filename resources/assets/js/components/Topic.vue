<template>
    <div class="container">
        <br/><h3>Add a new topic</h3><br/>
        <form @submit.prevent="addData" enctype="multipart/form-data">
           <div class="row">
               <div class="col">
                   <label for="free_session">Name</label>
                   <div class="form-group">
                       <input type="text" maxlength = "253" class="form-control" placeholder="Topic Name" v-model="topic.topic_name" required/>
                   </div>
               </div>
               <div class="col">
                   <label for="free_session">Image</label>
                   <div class="form-group">
                       <input type="file" @change="getImage" class="form-control">
                   </div>
               </div>
           </div>
            <div class="row">
                <div class="col">
                    <label for="description">Description</label>
                    <textarea class="form-control" type="checkbox" id="description" v-model="topic.topic_description" ></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="free_session">Show In Free Session Form</label>
                    <input type="checkbox" id="free_session" v-model="topic.free_session" >
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="free_session">Show In Camps Form</label>
                    <input type="checkbox" id="in_camps" v-model="topic.in_camps" >
                </div>
            </div>
            <br>
            <input v-if="!edit && !loading" class="btn btn-primary" type="submit" value="Add Topic" />
            <input v-else-if="edit && !loading" class="btn btn-warning" type="submit" value="Update Topic" />
            <loader-button v-else-if="loading" bg="btn btn-btn-primary" title="Processing..."> </loader-button>
        </form>
        <br/><br/>
          <table class="table">
            <thead>
                <tr>
                    <td width="10%"></td>
                    <td><h5>Topics</h5></td>
                    <td><h5>Description</h5></td>
                    <td><h5>Free Session</h5></td>
                    <td><h5>Camps</h5></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
             <tbody>
                <tr v-for="topic in topics" v-bind:key="topic.topic_id">
                    <td>
                        <img :src="'/images/topics/'+topic.image" class="img-thumbnail img-responsive" width="50" height="auto">
                    </td>
                    <td>{{ topic.topic_name }}</td>
                    <td>{{ topic.topic_description }}</td>
                    <td>{{topic.free_session ? 'Yes' : 'No'}}</td>
                    <td>{{topic.in_camps ? 'Yes' : 'No'}}</td>
                    <td><button @click="editData(topic)" class="btn btn-warning">EDIT</button></td>
                    <td><button @click="deleteData(topic.topic_id)" class="btn btn-danger">DELETE</button></td>
                </tr>      
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                topic_id : '',
                topic: { topic_id : '',topic_name : '', topic_description : '', free_session : true, in_camps : true},
                topics:[],
                edit : false,
                loading : false,
            }
        },
        methods:{
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.topic.image_name = e.target.result;
                }
            },
             getData(){
                var _this = this;
                axios.get('/get_topics').then(function(response){              
                    _this.topics = response.data.topics;  
                })
            }, // End of Get Data Method
            addData(e){
                e.preventDefault();
                var _this = this;
                _this.loading = true;
                if(_this.edit == false){ 
                    axios.post('/add_topic',this.topic).then(function(response){
                        if(response.data.reponse_msg == "Topic cannot be added."){
                            alert("Topic could not be added.");
                            _this.loading = false;
                        }
                        else{
                            _this.topic = { topic_id : '',topic_name : '', free_session : true},
                            _this.getData();
                            _this.loading = false;
                        }
                    })  
                } 
                else{
                    axios.put('/topic/edit/'+_this.topic_id,this.topic).then(function(response){
                        _this.topic = { topic_id : '',topic_name : '', topic_description : '', free_session : true, in_camps : true};
                        _this.edit = false;
                        _this.loading = false;
                        _this.getData(); 
                    })
                }
            },
            editData(topic){
                var _this = this;
                _this.edit = true;
                _this.topic_id = topic.topic_id;
                _this.topic.topic_id = topic.topic_id;
                _this.topic.topic_name = topic.topic_name;
                _this.topic.free_session = topic.free_session;
                _this.topic.topic_description = topic.topic_description;
                _this.topic.in_camps = topic.in_camps;
            }, // End of Edit Data Method
            deleteData(id){
                var _this = this;
                if(confirm('Are you sure?')){
                    axios.delete('/topic/delete/'+id).then(function(response){
                    _this.getData();
                 })
                }
            }, // End of Delete Data Method
        },
        created() {
            this.getData();
        }  
    }
</script>
