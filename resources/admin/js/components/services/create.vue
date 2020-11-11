<template>
    <div>
        <h3 v-if="!isEditable">Add Service</h3>
        <h3 v-else>Edit Service</h3>
        <form id="createUser" @submit.prevent="createService()" enctype="multipart/form-data">
           <div class="row">
               <div class="col-md-8">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Upload Image</label>
                               <input type="file" @change="getImage" class="form-control">
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Image Alt Text</label>
                               <input type="text" v-model="service.alt" class="form-control" placeholder="Image Alt Text..."/>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Title</label>
                               <input type="text" v-model="service.name" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                           </div>
                       </div>

                        <div class="col" v-if="isEditable">
                           <div class="form-group">
                               <label>Slug</label>
                               <input type="text" v-model="service.slug" class="form-control" placeholder="Slug..."/>
                               <span v-if="getErrors.slug" class="text-danger">{{getErrors.slug[0]}}</span>
                           </div>
                       </div>

                       <!-- <div class="col">
                           <div class="form-group">
                               <label>Category</label>
                               <select class="form-control" v-model="blog.category_id">
                                   <option disabled value="">Select Category</option>
                                   <option v-for="category in getActiveCategories" :value="category.id" :key="category.id">{{category.name}}</option>
                               </select>
                               <span v-if="getErrors.category_id" class="text-danger">{{getErrors.category_id[0]}}</span>
                           </div>
                       </div> -->
                   </div>
                   <!-- <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Created By</label>
                               <select class="form-control" v-model="service.created_id" required>
                                   <option disabled value="">Select User</option>
                                   <option v-for="user in getActiveUsers" :value="user.id" :key="user.id">{{user.name}}</option>
                               </select>
                               <span v-if="getErrors.created_id" class="text-danger">{{getErrors.created_id[0]}}</span>
                           </div>
                       </div>
                       <div class="col" v-if="!isEditable">
                           <div class="form-group">
                               <label>Created Date</label>
                               <input type="date" v-model="service.created_at" class="form-control" placeholder="Date..." required/>
                               <span v-if="getErrors.created_at" class="text-danger">{{getErrors.created_at[0]}}</span>
                           </div>
                       </div>
                   </div> -->
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Description</label>
                               <tinymce id="d1" v-model="service.description"></tinymce>
                               <span v-if="getErrors.description" class="text-danger">{{getErrors.description[0]}}</span>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Add Tags</label>
                               <select @change="updateTags(selectTag)" class="form-control" v-model="selectTag">
                                   <option v-for="tag in getActiveTags" :value="tag" :key="tag.id">{{tag.name}}</option>
                               </select>
                           </div>
                        <span v-if="getErrors.tags" class="text-danger">{{getErrors.tags[0]}}</span>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <button type="button" class="btn btn-sm bg-primary m-1 text-white" v-for="tag in service.tags" :key="tag.id">
                               {{tag.name}}
                               <span @click="removeTags(tag)" class="badge badge-dark">x</span>
                           </button>
                       </div>
                   </div>
                    <div class="row">
                        <div class="col-md-12" v-if="service.image">
                            <img :src="'/images2/'+service.image.image.folder+'/'+service.image.image.name" :alt="service.image.image.alt" style="width:100%">
                            <button @click="removeImage()" class="btn btn-sm btn-danger" type="button">Delete Image</button>
                        </div>
                        <div class="col-md-12" v-else>
                            <img src="/images2/default_blog.png" style="width:100%">
                        </div>
                    </div>

                   <div class="row">
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Title</label>
                               <input type="text" v-model="service.meta_title" class="form-control" placeholder="Meta Title..."/>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Keywords</label>
                               <input type="text" v-model="service.meta_keywords" class="form-control" placeholder="Meta Keywords..."/>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Meta Description</label>
                               <textarea rows="5" v-model="service.meta_description" class="form-control" placeholder="Description..."></textarea>
                           </div>
                       </div>
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
    import Vue from 'vue';
    import tinymce from 'vue-tinymce-editor'
    Vue.component('tinymce', tinymce)

    export default {
        props : ['service'],
        data(){
            return {
                selectTag : {}
            }
        },
        created() {
            this.$store.dispatch("fetchActiveTags");
            this.$store.dispatch("fetchActiveUsers");
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveTags', 'getActiveUsers', "isEditable"]),
        },
        methods : {
            isDuplicate(data, dataArray) {
                for(let i = 0; i < dataArray.length; i++){
                    if(data.name == dataArray[i].name) {
                        alert('Tag already selected');
                        return true;
                    }
                }
                return false;
            },
            updateTags(tag){
                if(this.service.tags == undefined){
                    this.service.tags = [];
                    this.service.tags.push(tag);
                } else if(!this.isDuplicate(tag,  this.service.tags)) {
                    this.service.tags.push(tag);
                }
                this.selectTag = {};
            },
            removeTags(tag){
                this.service.tags.splice(this.service.tags.indexOf(tag), 1);
            },
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.service.image_name = e.target.result;
                }
            },
            removeImage(){
                if(confirm('Are you sure you want to delete this image?')){
                    this.$store.dispatch('removeImage', this.service);
                }
            },
            createService() {
                this.$store.dispatch("dispatchCreateService", {
                    'service': this.service,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
