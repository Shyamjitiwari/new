<template>
    <div>
        <h3 v-if="!isEditable">Add Testimonial</h3>
        <h3 v-else>Edit Testimonial</h3>
        <form id="createUser" @submit.prevent="createTestimonial()" enctype="multipart/form-data">
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
                               <input type="text" v-model="testimonial.alt" class="form-control" placeholder="Image Alt Text..."/>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Name</label>
                               <input type="text" v-model="testimonial.name" class="form-control"  placeholder="Name..." required />
                               <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Company</label>
                               <input type="text" v-model="testimonial.company" class="form-control" placeholder="Company..." required/>
                               <span v-if="getErrors.company" class="text-danger">{{getErrors.company[0]}}</span>
                           </div>
                       </div>
                   </div>

                   <div class="row">
                        <div class="col">
                           <div class="form-group">
                               <label>Designation</label>
                               <input type="text" v-model="testimonial.designation" class="form-control" placeholder="Designation..." required/>
                               <span v-if="getErrors.designation" class="text-danger">{{getErrors.designation[0]}}</span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Comment</label>
                               <div>
                                <tinymce  id="d1" v-model="testimonial.description"></tinymce>
                               </div>
                               <span v-if="getErrors.description" class="text-danger">{{getErrors.description[0]}}</span>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12" v-if="testimonial.image">
                            <img :src="'/images2/'+testimonial.image.image.folder+'/'+testimonial.image.image.name" :alt="testimonial.image.image.alt" style="width:100%">
                            <button @click="removeImage()" class="btn btn-sm btn-danger" type="button">Delete Image</button>
                        </div>
                        <div class="col-md-12" v-else>
                            <img src="/images2/default_blog.png" style="width:100%">
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
    import tinymce1 from 'tinymce/tinymce';

    import tinymce from 'vue-tinymce-editor'
    
    Vue.component('tinymce', tinymce)

    export default {
        props : ['testimonial'],
        data(){
            return {
            }
        },
        mounted(){
                tinymce1.get("d1").setContent(this.testimonial.description);
        },
        created() {
            this.$store.dispatch("fetchActiveUsers");
        },
        computed: {
            ...mapGetters(["getErrors", "isEditable"]),
        },
        methods : {
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.testimonial.image = e.target.result;
                }
            },
            removeImage(){
                if(confirm('Are you sure you want to delete this image?')){
                    this.$store.dispatch('removeImage', this.testimonial);
                }
            },
            createTestimonial() {
                this.$store.dispatch("dispatchCreateTestimonial", {
                    'testimonial': this.testimonial,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>

