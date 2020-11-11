<template>
    <div>
        <h3 v-if="!isEditable">Add Slider</h3>
        <h3 v-else>Edit Slider</h3>
        <form id="createUser" @submit.prevent="createSlider()" enctype="multipart/form-data">
           <div class="row">
               <div class="col-md-8">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Upload Image</label>
                               <input type="file" @change="getImage" multiple class="form-control">
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Image Alt Text</label>
                               <input type="text" v-model="slider.alt" class="form-control" placeholder="Image Alt Text..."/>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Heading</label>
                               <input type="text" v-model="slider.heading" class="form-control" placeholder="Heading..."/>
                               <span v-if="getErrors.heading" class="text-danger">{{getErrors.heading[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Hyper-link</label>
                               <input type="text" v-model="slider.hyper_link" class="form-control" placeholder="Hyper-link..."/>
                               <span v-if="getErrors.hyper_link" class="text-danger">{{getErrors.hyper_link[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Created By</label>
                               <select class="form-control" v-model="slider.created_id" required>
                                   <option disabled value="">Select User</option>
                                   <option v-for="user in getActiveUsers" :value="user.id" :key="user.id">{{user.name}}</option>
                               </select>
                               <span v-if="getErrors.created_id" class="text-danger">{{getErrors.created_id[0]}}</span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Description Line 1</label>
                               <input type="text" v-model="slider.description_line1" class="form-control" placeholder="Description-line1..."/>
                               <span v-if="getErrors.description_line1" class="text-danger">{{getErrors.description_line1[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Description Line 2</label>
                               <input type="text" v-model="slider.description_line2" class="form-control" placeholder="Description-line2..."/>
                               <span v-if="getErrors.description_line2" class="text-danger">{{getErrors.description_line2[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Description Line 3</label>
                               <input type="text" v-model="slider.description_line3" class="form-control" placeholder="Description-line3..."/>
                               <span v-if="getErrors.description_line3" class="text-danger">{{getErrors.description_line3[0]}}</span>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                 <div class="row" v-for="image in slider.images" :key="image.id">

                        <div class="col-md-4"></div>
                        <div class="col-md-4" v-if="image">
                            <img :src="'/images2/'+image.folder+'/'+image.name" :alt="image.alt" style="width:100%">
                            <button @click="removeImage()" class="btn btn-sm btn-danger" type="button">Delete Image</button>
                        </div>
                        <div class="col-md-4" v-else>
                            <img src="/images2/default_blog.png" style="width:100%">
                        </div>
                        <div class="col-md-4"></div>
                    </div>
               </div>
           </div>
            <submit-button v-if="!isEditable" label="Add"> </submit-button>
            <update-button v-else label="Update"> </update-button>
            <span @click="reset()">
                <reset-button label="Close"></reset-button>
            </span>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    

    export default {
        props : ['slider'],
        data(){
            return {
                
            }
        },
        created() {
            this.$store.dispatch("fetchActiveUsers");
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveUsers', "isEditable"]),
        },
        methods : {
           getImage(e){
               console.log(this.slider);
               for (let file of e.target.files) {
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(file);
                    fileReader.onload = (file) => {
                        this.slider.image_name.push(file.target.result);
                    }
                }
            },
            removeImage(){
                if(confirm('Are you sure you want to delete this image?')){
                    this.$store.dispatch('removeImage', this.slider);
                }
            },
            createSlider() {
                this.$store.dispatch("dispatchCreateSlider", {
                    'slider': this.slider,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
