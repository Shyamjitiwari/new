<template>
    <div>
        <h3 v-if="!isEditable">Add Brand</h3>
        <h3 v-else>Edit Brand</h3>
        <form id="createUser" @submit.prevent="createBrand()" enctype="multipart/form-data">
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
                               <input type="text" v-model="brand.alt" class="form-control" placeholder="Image Alt Text..."/>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Name</label>
                               <input type="text" v-model="brand.name" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                           </div>
                       </div>

                        <div class="col" v-if="isEditable">
                           <div class="form-group">
                               <label>Slug</label>
                               <input type="text" v-model="brand.slug" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.slug" class="text-danger">{{getErrors.slug[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Created By</label>
                               <select class="form-control" v-model="brand.created_id" required>
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
                               <label>Description</label>
                               <div>
                                    <tinymce  id="d1"  v-model="brand.description"></tinymce>
                               </div>
                               <span v-if="getErrors.description" class="text-danger">{{getErrors.description[0]}}</span>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="row">
                        <div class="col-md-12" v-if="brand.image">
                            <img :src="'/images2/'+brand.image.image.folder+'/'+brand.image.image.name" :alt="brand.image.image.alt" style="width:100%">
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
                               <input type="text" v-model="brand.meta_title" class="form-control" placeholder="Meta Title..."/>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Keywords</label>
                               <input type="text" v-model="brand.meta_keywords" class="form-control" placeholder="Meta Keywords..."/>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Meta Description</label>
                               <textarea rows="5" v-model="brand.meta_description" class="form-control" placeholder="Description..."></textarea>
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
</script>
<script>
    import { mapGetters } from "vuex";
    import Vue from 'vue';

    import tinymce from 'vue-tinymce-editor'
    import tinymce1 from 'tinymce/tinymce';

    Vue.component('tinymce', tinymce)

    export default {
        props : ['brand'],
        data(){
            return {
            }
        },
         mounted(){
                tinymce1.get("d1").setContent(this.brand.description);
        },
        created() {
            this.$store.dispatch("fetchActiveUsers");
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveUsers', "isEditable"]),
        },
        methods : {

            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.brand.image_name = e.target.result;
                }
            },
            removeImage(){
                if(confirm('Are you sure you want to delete this image?')){
                    this.$store.dispatch('removeImage', this.brand);
                }
            },
            createBrand() {
                this.$store.dispatch("dispatchCreateBrand", {
                    'brand': this.brand,
                });
            },
            reset(){
                this.$emit('reset');
            }
            
        }
    }
</script>
