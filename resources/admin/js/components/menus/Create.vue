<template>
    <div>
        <h3 v-if="!isEditable">Add Menu</h3>
        <h3 v-else>Edit Menu</h3>
        <form id="createUser" @submit.prevent="createMenu()" enctype="multipart/form-data">
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
                               <input type="text" v-model="menu.alt" class="form-control" placeholder="Image Alt Text..."/>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Name</label>
                               <input type="text" v-model="menu.name" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                           </div>
                       </div>

                        <div class="col" v-if="isEditable">
                           <div class="form-group">
                               <label>Slug</label>
                               <input type="text" v-model="menu.slug" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.slug" class="text-danger">{{getErrors.slug[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Created By</label>
                               <select class="form-control" v-model="menu.created_id" required>
                                   <option disabled value="">Select User</option>
                                   <option v-for="user in getActiveUsers" :value="user.id" :key="user.id">{{user.name}}</option>
                               </select>
                               <span v-if="getErrors.created_id" class="text-danger">{{getErrors.created_id[0]}}</span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                           <div class="form-group">
                               <label>Select Page</label>
                               <select class="form-control" v-model="menu.page_id">
                                   <option disabled value="">Select Page</option>
                                   <option v-for="page in getActivePages" :value="page.id" :key="page.id">{{page.name}}</option>
                               </select>
                               <span v-if="getErrors.page_id" class="text-danger">{{getErrors.page_id[0]}}</span>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Target</label>
                               <select class="form-control" v-model="menu.target">
                                   <option disabled value="">Select Target</option>
                                   <option value="_blank" >blank</option>
                                   <option value="_self" >self</option>

                               </select>
                               <span v-if="getErrors.target" class="text-danger">{{getErrors.target[0]}}</span>
                           </div>
                       </div>
                   </div>
                </div>
               <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12" v-if="menu.image">
                            <img :src="'/images2/'+menu.image.image.folder+'/'+menu.image.image.name" :alt="menu.image.image.alt" style="width:100%">
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

    import tinymce from 'vue-tinymce-editor'
    import tinymce1 from 'tinymce/tinymce';

    Vue.component('tinymce', tinymce)

    export default {
        props : ['menu'],
        data(){
            return {
            }
        },
         mounted(){
                tinymce1.get("d1").setContent(this.menu.description);
        },
        created() {
            this.$store.dispatch("fetchActiveUsers");
            this.$store.dispatch("fetchActivePages");
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveUsers','getActivePages', "isEditable"]),
        },
        methods : {

            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.menu.image_name = e.target.result;
                }
            },
            removeImage(){
                if(confirm('Are you sure you want to delete this image?')){
                    this.$store.dispatch('removeImage', this.menu);
                }
            },
            createMenu() {
                this.$store.dispatch("dispatchCreateMenu", {
                    'menu': this.menu,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
